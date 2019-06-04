<?php

namespace Tauceti\ExponeaApiTest\Tracking;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Tauceti\ExponeaApi\Events\Consent;
use Tauceti\ExponeaApi\Events\Partials\RegisteredCustomer;
use Tauceti\ExponeaApi\Exception\UnsuccessfulResponseException;
use Tauceti\ExponeaApiTest\Traits\ClientWithMockedHttp;

/**
 * Test for GET /system/time method
 * @see https://docs.exponea.com/reference#add-event
 * @see https://docs.exponea.com/docs/consent-definition (missing information for consents/agreements export)
 * @package Tauceti\ExponeaApiTest\Tracking
 */
class AddEventTest extends TestCase
{
    use ClientWithMockedHttp;

    const EXAMPLE_EMAIL = 'example@example.com';

    /**
     * Test for successful request with new event to store
     */
    public function testAddEventRequest()
    {
        $client = $this->getClient();
        $this->mockHandler->append(new Response(
            200,
            ['content-type' => 'application/json'],
            json_encode(['success' => true])
        ));

        $event = new Consent(
            new RegisteredCustomer(self::EXAMPLE_EMAIL),
            Consent::CATEGORY_NEWSLETTER,
            Consent::ACTION_GRANT
        );
        $client->tracking()->addEvent($event)->wait();

        // Request verification
        $request = $this->mockHandler->getLastRequest();
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals(
            $client->getEndpointUri() . '/track/v2/projects/' . $this->projectToken . '/customers/events',
            $request->getUri()
        );
        $body = json_decode($request->getBody()->getContents(), true);
        $this->assertArraySubset(
            [
                'customer_ids' => ['registered' => self::EXAMPLE_EMAIL],
                'event_type' => 'consent',
                'properties' => [
                    'action' => 'accept',
                    'category' => Consent::CATEGORY_NEWSLETTER,
                    'valid_until' => 'unlimited',
                ],
            ],
            $body
        );
        $this->assertEquals(
            time(),
            $body['properties']['timestamp'],
            'Default timestamp is not equal to current time',
            2
        );
    }

    /**
     * Test {"success": false} response as Exponea returns this field so we have to handle it in case they would
     * return it with successful HTTP code
     */
    public function testAddEventSuccessFalse()
    {
        $this->expectException(UnsuccessfulResponseException::class);

        $client = $this->getClient();
        $this->mockHandler->append(new Response(
            200,
            ['content-type' => 'application/json'],
            json_encode(['success' => false])
        ));

        $event = new Consent(
            new RegisteredCustomer(self::EXAMPLE_EMAIL),
            Consent::CATEGORY_NEWSLETTER,
            Consent::ACTION_GRANT
        );
        $client->tracking()->addEvent($event)->wait();
    }

    protected function tearDown()
    {
        $this->mockHandler = null;
    }
}
