<?php

namespace Tauceti\ExponeaApiTest\Events;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Tauceti\ExponeaApi\Events\Purchase;
use Tauceti\ExponeaApi\Events\Partials\RegisteredCustomer;
use Tauceti\ExponeaApi\Events\Partials\Item;
use Tauceti\ExponeaApi\Events\Partials\Voucher;

class PurchaseTest extends TestCase
{
    public function testMinimalDataRequired()
    {
        $customerID = new RegisteredCustomer('example@example.com');
        $obj = new Purchase(
            $customerID,
            'PREFIX12345',
            [
                new Item('012345', 2.99, 1),
                new Item('12345', 3, 2),
            ],
            'COD'
        );

        $this->assertSame($customerID, $obj->getCustomerIds());
        $this->assertSame('purchase', $obj->getEventType());
        $this->assertEquals(microtime(true), $obj->getTimestamp(), 'Timestamp is not generated properly', 1);

        $properties = json_decode(json_encode($obj->getProperties()), true);
        $this->assertEquals(
            [
                'status' => 'success',
                'items' => [
                    // price field is not required by Exponea
                    ['item_id' => '012345', 'price' => 2.99, 'quantity' => 1],
                    ['item_id' => '12345', 'price' => 3.0, 'quantity' => 2],
                ],
                'purchase_id' => 'PREFIX12345',
                'total_price' => 8.99,
                // not required by Exponea
                'total_quantity' => 3,
                'payment_method' => 'COD'
            ],
            $properties,
            'Invalid properties generated (after json serialization)',
            0.01
        );
    }

    public function testWithCustomData()
    {
        $customerID = new RegisteredCustomer('example@example.com');
        $obj = new Purchase(
            $customerID,
            'PREFIX12345',
            [
                new Item('012345', 2.99, 1),
                new Item('12345', 3, 2),
            ],
            'COD',
            new Voucher('VOUCHER-CODE', 10.01, 34.01)
        );
        $obj->setStatus('somestatus');

        $this->assertSame($customerID, $obj->getCustomerIds());
        $this->assertSame('purchase', $obj->getEventType());
        $this->assertEquals(microtime(true), $obj->getTimestamp(), 'Timestamp is not generated properly', 1);

        $properties = json_decode(json_encode($obj->getProperties()), true);
        $this->assertEquals(
            [
                'status' => 'somestatus',
                'items' => [
                    // price field is not required by Exponea
                    ['item_id' => '012345', 'price' => 2.99, 'quantity' => 1],
                    ['item_id' => '12345', 'price' => 3.0, 'quantity' => 2],
                ],
                'purchase_id' => 'PREFIX12345',
                'total_price' => 8.99,
                // not required by Exponea
                'total_quantity' => 3,
                'payment_method' => 'COD',
                // voucher data which are not documentated in Exponea
                'voucher_code' => 'VOUCHER-CODE',
                'voucher_value' => 10.01,
                'voucher_percentage' => 34.01
            ],
            $properties,
            'Invalid properties generated (after json serialization)',
            0.01
        );
    }

    public function testRejectsNonObjectItems()
    {
        $this->expectException(InvalidArgumentException::class);
        $customerID = new RegisteredCustomer('example@example.com');
        new Purchase(
            $customerID,
            'PREFIX12345',
            [
                ['item_id' => '12345', 'quantity' => 3],
            ],
            'COD'
        );
    }

    public function testDataWithSource()
    {
        $obj = new Purchase(
            new RegisteredCustomer('example@example.com'),
            'PREFIX12345',
            [
                new Item('012345', 2.99, 1),
                new Item('12345', 3, 2),
            ],
            'COD',
            new Voucher('VOUCHER-CODE', 10.01, 34.01)
        );
        $obj->setSource('VPI');
        $properties = json_decode(json_encode($obj->getProperties()), true);
        $this->assertArraySubset(
            [
                'source' => 'VPI',
            ],
            $properties,
            'Invalid properties generated (after json serialization)',
            0.01
        );
    }
}
