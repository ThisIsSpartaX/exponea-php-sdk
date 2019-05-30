<?php

namespace Tauceti\ExponeaApi\Tracking;

use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
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
        return $this->getClient()->call(new Request(
            'GET',
            '/track/v2/projects/{projectToken}/system/time'
        ))->then(function (ResponseInterface $response) {
            return new SystemTime(json_decode($response->getBody()->getContents(), true));
        });
    }
}
