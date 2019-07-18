<?php

namespace Tauceti\ExponeaApiTest\Events;

use PHPUnit\Framework\TestCase;
use Tauceti\ExponeaApi\Events\Partials\RegisteredCustomer;
use Tauceti\ExponeaApi\Events\Consent;

class ConsentTest extends TestCase
{
    public function testGrant()
    {
        $customerID = new RegisteredCustomer('example@example.com');
        $obj = new Consent(
            $customerID,
            Consent::CATEGORY_NEWSLETTER,
            Consent::ACTION_GRANT
        );

        $this->assertSame($customerID, $obj->getCustomerIds());
        $this->assertSame('consent', $obj->getEventType());
        $this->assertEquals(microtime(true), $obj->getTimestamp(), 'Timestamp is not generated properly', 1);

        $properties = json_decode(json_encode($obj->getProperties()), true);
        $this->assertEquals(
            [
                'action' => 'accept',
                'category' => 'newsletter',
                'timestamp' => $obj->getTimestamp(),
                'valid_until' => 'unlimited',
            ],
            $properties,
            'Invalid properties generated (after json serialization)',
            0.01
        );
    }

    public function testRevokeWithValidUntil()
    {
        $customerID = new RegisteredCustomer('example@example.com');
        $obj = new Consent(
            $customerID,
            Consent::CATEGORY_NEWSLETTER,
            Consent::ACTION_REVOKE
        );
        $validUntil = microtime(true) + 30;
        $obj->setValidUntil($validUntil);

        $this->assertSame($customerID, $obj->getCustomerIds());
        $this->assertSame('consent', $obj->getEventType());
        $this->assertEquals(microtime(true), $obj->getTimestamp(), 'Timestamp is not generated properly', 1);

        $properties = json_decode(json_encode($obj->getProperties()), true);
        $this->assertEquals(
            [
                'action' => 'reject',
                'category' => 'newsletter',
                'timestamp' => $obj->getTimestamp(),
                'valid_until' => $validUntil,
            ],
            $properties,
            'Invalid properties generated (after json serialization)',
            0.01
        );
    }
}
