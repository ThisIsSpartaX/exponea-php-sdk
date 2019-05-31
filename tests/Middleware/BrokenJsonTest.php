<?php

namespace Tauceti\ExponeaApiTest;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Tauceti\ExponeaApi\Exception\UnexpectedResponseSchemaException;
use Tauceti\ExponeaApiTest\Traits\ClientWithMockedHttp;

/**
 * Verification of invalid JSON detection (all responses from API must be JSON)
 * @package Tauceti\ExponeaApiTest
 */
class BrokenJsonTest extends TestCase
{
    use ClientWithMockedHttp;

    /**
     * @dataProvider providerBrokenBodies
     * @param string $body Response body containing broken JSON
     */
    public function testBrokenJson(string $body)
    {
        $this->expectException(UnexpectedResponseSchemaException::class);

        $client = $this->getClient();

        $this->mockHandler->append(new Response(
            200,
            ['content-type' => 'application/json'],
            $body
        ));

        $client->call(new Request('POST', '/test'))->wait();
    }

    public function providerBrokenBodies()
    {
        return [
            ['{a: c}'],
            ['{"a: 2}'],
            [''],
            ['<html...'],
        ];
    }

    protected function tearDown()
    {
        $this->mockHandler = null;
    }
}
