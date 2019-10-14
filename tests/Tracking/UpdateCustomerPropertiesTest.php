<?php

namespace Tauceti\ExponeaApiTest\Tracking;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Tauceti\ExponeaApi\Events\Partials\RegisteredCustomer;
use Tauceti\ExponeaApi\Exception\UnsuccessfulResponseException;
use Tauceti\ExponeaApiTest\Traits\ClientWithMockedHttp;

class UpdateCustomerPropertiesTest extends TestCase
{
    use ClientWithMockedHttp;

    public function testUpdateCustomerPropertiesRequest()
    {
        $client = $this->getClient();
        $this->mockHandler->append(new Response(
            200,
            ['content-type' => 'application/json'],
            json_encode(['success' => true])
        ));

        $email = 'marian@exponea.com';
        $properties = [
            'first_name' => 'Marian',
            'fidelity_points' => 687,
        ];

        $client->tracking()->updateCustomerProperties(new RegisteredCustomer($email), $properties)->wait();

        $request = $this->mockHandler->getLastRequest();
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals(
            $client->getEndpointUri() . '/track/v2/projects/' . $this->projectToken . '/customers',
            $request->getUri()
        );

        $body = json_decode($request->getBody()->getContents(), true);
        $this->assertArraySubset(
            [
                'customer_ids' => ['registered' => $email],
                'properties' => [
                    'first_name' => 'Marian',
                    'fidelity_points' => 687,
                ],
            ],
            $body
        );
    }

    public function testUpdateCustomerPropertiesSuccessFalse()
    {
        $this->expectException(UnsuccessfulResponseException::class);

        $client = $this->getClient();
        $this->mockHandler->append(new Response(
            200,
            ['content-type' => 'application/json'],
            json_encode(['success' => false])
        ));

        $email = 'marian@exponea.com';
        $properties = [
            'first_name' => 'Marian',
            'fidelity_points' => 687,
        ];

        $client->tracking()->updateCustomerProperties(new RegisteredCustomer($email), $properties)->wait();
    }

    protected function tearDown()
    {
        $this->mockHandler = null;
    }
}
