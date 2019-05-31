<?php

namespace Tauceti\ExponeaApi\Tracking;

use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use Tauceti\ExponeaApi\Exception\Internal\MissingResponseFieldException;
use Tauceti\ExponeaApi\Exception\UnexpectedResponseSchemaException;
use Tauceti\ExponeaApi\Tracking\Response\SystemTime;
use Tauceti\ExponeaApi\Traits\ApiContainerTrait;

/**
 * Methods contained inside Tracking API
 * @package Tauceti\ExponeaApi\Tracking
 */
class Methods
{
    use ApiContainerTrait;

    protected function getMethodUri(string $method)
    {
        return '/track/v2/projects/' . $this->getClient()->getProjectToken() . $method;
    }

    /**
     * Get system time
     *
     * Promise resolves to Response\SystemTime object
     * @return PromiseInterface
     */
    public function getSystemTime(): PromiseInterface
    {
        $request = new Request(
            'GET',
            '/track/v2/projects/{projectToken}/system/time'
        );
        return $this->getClient()->call($request)->then(function (ResponseInterface $response) use ($request) {
            try {
                return new SystemTime(json_decode($response->getBody()->getContents(), true));
            } catch (MissingResponseFieldException $e) {
                throw new UnexpectedResponseSchemaException(
                    $e->getMessage(),
                    $request,
                    $response,
                    $e
                );
            }
        });
    }
}
