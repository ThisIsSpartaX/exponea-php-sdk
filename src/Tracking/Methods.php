<?php

namespace Tauceti\ExponeaApi\Tracking;

use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use Tauceti\ExponeaApi\Events\Partials\RegisteredCustomer;
use Tauceti\ExponeaApi\Exception\Internal\MissingResponseFieldException;
use Tauceti\ExponeaApi\Exception\UnexpectedResponseSchemaException;
use Tauceti\ExponeaApi\Interfaces\EventInterface;
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

    /**
     * Propagate event to Expponea
     *
     * Please note that sending event for customer id which doesn't exist in Exponea, will automatically create
     * contact with sent identifier. It's transparent from your side (there will be no errors).
     *
     * Promise resolves to null
     * @param EventInterface $event
     * @return PromiseInterface
     */
    public function addEvent(EventInterface $event): PromiseInterface
    {
        $customerIds = [];
        if ($event->getCustomerIDs()->getRegistered() !== null) {
            $customerIds['registered'] = $event->getCustomerIDs()->getRegistered();
        }
        if ($event->getCustomerIDs()->getCookie() !== null) {
            $customerIds['cookie'] = $event->getCustomerIDs()->getCookie();
        }

        $body = [
            'customer_ids' => $customerIds,
            'event_type' => $event->getEventType(),
            'timestamp' => $event->getTimestamp(),
            'properties' => $event->getProperties(),
        ];
        $request = new Request(
            'POST',
            '/track/v2/projects/{projectToken}/customers/events',
            [],
            json_encode($body)
        );
        return $this->getClient()->call($request)->then(function () {
            return null;
        });
    }

    /**
     * @param RegisteredCustomer $registeredCustomer
     * @param array $properties
     * @return PromiseInterface
     */
    public function updateCustomerProperties(RegisteredCustomer $registeredCustomer, array $properties)
    {
        $body = [
            'customer_ids' => ['registered' => $registeredCustomer->getRegistered()],
            'properties' => $properties,
        ];

        $request = new Request(
            'POST',
            '/track/v2/projects/{projectToken}/customers',
            [],
            json_encode($body)
        );

        return $this->getClient()->call($request)->then(function () {
            return null;
        });
    }
}
