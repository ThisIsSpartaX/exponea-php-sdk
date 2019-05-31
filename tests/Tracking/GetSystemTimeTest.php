<?php

namespace Tauceti\ExponeaApiTest\Tracking;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Tauceti\ExponeaApi\Exception\UnexpectedResponseSchemaException;
use Tauceti\ExponeaApi\Tracking\Response\SystemTime;
use Tauceti\ExponeaApiTest\Traits\ClientWithMockedHttp;

/**
 * Test for GET /system/time method
 * @see https://docs.exponea.com/reference#system-time
 * @package Tauceti\ExponeaApiTest\Tracking
 */
class GetSystemTimeTest extends TestCase
{
    use ClientWithMockedHttp;

    public function testValidResponse()
    {
        $client = $this->getClient();
        $this->mockHandler->append(new Response(
            200,
            ['content-type' => 'application/json'],
            '{"success": true, "time": 123456.78}' // copied from api documentation
        ));
        /** @var SystemTime $response */
        $response = $client->tracking()->getSystemTime()->wait(true);
        $this->assertInstanceOf(SystemTime::class, $response);
        $this->assertSame(123456.78, $response->getTime());
    }

    public function testIncompleteResponse()
    {
        $this->expectException(UnexpectedResponseSchemaException::class);

        $client = $this->getClient();
        $this->mockHandler->append(new Response(
            200,
            ['content-type' => 'application/json'],
            '{"success": true}' // copied from api documentation
        ));
        $client->tracking()->getSystemTime()->wait(true);
    }

    protected function tearDown()
    {
        $this->mockHandler = null;
    }
}
