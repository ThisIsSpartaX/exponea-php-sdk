<?php

namespace Tauceti\ExponeaApi;

use \GuzzleHttp\Client as HttpClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Tauceti\ExponeaApi\Middleware as OwnMiddleware;
use Tauceti\ExponeaApi\Tracking\Methods as TrackingApi;

/**
 * Main class for API communication with Exponea
 * @package Tauceti\ExponeaApi
 */
class Client
{
    /**
     * @var string
     */
    protected $endpointUri = 'https://api.exponea.com';
    /**
     * @var string|null
     */
    protected $publicKey;
    /**
     * @var string|null
     */
    private $privateKey;
    /**
     * @var string|null
     */
    protected $projectToken;
    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var TrackingApi|null
     */
    protected $tracking = null;

    public function __construct(array $options = null)
    {
        if (isset($options['endpoint_uri'])) {
            $this->setEndpointUri($options['enpoint_uri']);
        }
        if (isset($options['public_key'])) {
            $this->setPublicKey($options['public_key']);
        }
        if (isset($options['private_key'])) {
            $this->setPrivateKey($options['private_key']);
        }
        if (isset($options['project_token'])) {
            $this->setProjectToken($options['project_token']);
        }

        $this->httpClient = new HttpClient(
            [
                'base_uri' => $this->endpointUri,
                'handler' => $this->createHandler(),
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => $this->getAuthHeader(),
                ],
            ] + ($options['http_client'] ?? [])
        );
    }

    protected function createHandler(): HandlerStack
    {
        $handler = HandlerStack::create();

        // Request modification
        $handler->push(Middleware::mapRequest(function (RequestInterface $request) {
            return $request->withUri(
                $request->getUri()
                    ->withPath(str_replace(
                        urlencode('{projectToken}'),
                        urlencode($this->getProjectToken()),
                        $request->getUri()->getPath()
                    ))
            );
        }));

        // Response validation
        $handler->push(OwnMiddleware::verifyPermissions());
        $handler->push(OwnMiddleware::validateJson());
        $handler->push(OwnMiddleware::checkSuccessFlag());

        return $handler;
    }

    /**
     * @return TrackingApi
     */
    public function tracking(): TrackingApi
    {
        if ($this->tracking === null) {
            $this->tracking = new TrackingApi($this);
        }
        return $this->tracking;
    }

    /**
     * Call API and retrieve response with decoded and validated JSON response
     * @param RequestInterface $request
     * @return PromiseInterface
     */
    public function call(RequestInterface $request): PromiseInterface
    {
        return $this->httpClient->sendAsync($request);
    }

    /**
     * Pobierz wartość nagłówka Authorization
     * @return string
     */
    protected function getAuthHeader(): string
    {
        return 'basic ' . base64_encode($this->getPublicKey() . ':' . $this->getPrivateKey());
    }

    /**
     * @param string $endpointUri
     * @return $this
     */
    protected function setEndpointUri(string $endpointUri)
    {
        $this->endpointUri = $endpointUri;
        return $this;
    }

    /**
     * @param string|null $privateKey
     * @return $this
     */
    protected function setPrivateKey(string $privateKey = null)
    {
        $this->privateKey = $privateKey;
        return $this;
    }

    /**
     * @param string|null $publicKey
     * @return $this
     */
    protected function setPublicKey(string $publicKey = null)
    {
        $this->publicKey = $publicKey;
        return $this;
    }

    /**
     * @param string|null $projectToken
     */
    protected function setProjectToken(string $projectToken = null)
    {
        $this->projectToken = $projectToken;
    }

    /**
     * @return string
     */
    public function getEndpointUri(): string
    {
        return $this->endpointUri;
    }

    /**
     * @return string|null
     */
    private function getPrivateKey(): string
    {
        return $this->privateKey;
    }

    /**
     * @return string|null
     */
    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    /**
     * @return string|null
     */
    public function getProjectToken(): string
    {
        return $this->projectToken;
    }
}
