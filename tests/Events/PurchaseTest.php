<?php

namespace Tauceti\ExponeaApiTest\Events;

use PHPUnit\Framework\TestCase;
use Tauceti\ExponeaApi\Events\Partials\Product;
use Tauceti\ExponeaApi\Events\Partials\RegisteredCustomer;
use Tauceti\ExponeaApi\Events\Purchase;
use Tauceti\ExponeaApi\Interfaces\EventInterface;

class PurchaseTest extends TestCase
{
    public function testInstanceOfEventInterface()
    {
        $object = new Purchase(
            new RegisteredCustomer('example@example.com'),
            'a > b > c',
            'test',
            [
                new Product(3, 20),
                new Product(4, 30)
            ],
            3,
            'closed',
            55.42,
            30
        );
        $this->assertInstanceOf(EventInterface::class, $object);
    }

    public function testParseObjectRequirementProperty()
    {
        $expectedData = [
            'purchase_id' => 3,
            'purchase_status' => 'closed',
            'voucher_code' => null,
            'voucher_percentage' => null,
            'voucher_value' => null,
            'payment_type' => null,
            'shipping_type' => null,
            'shipping_cost' => null,
            'shipping_country' => null,
            'shipping_city' => null,
            'product_list' => [
                new Product(3, 20),
                new Product(4, 30)
            ],
            'product_ids' => [3,4],
            'total_quantity' => 30,
            'total_price' => 55.42
        ];

        $object = new Purchase(
            new RegisteredCustomer('example@example.com'),
            'a > b > c',
            'test',
            [
                new Product(3, 20),
                new Product(4, 30)
            ],
            3,
            'closed',
            55.42,
            30
        );

        $objectData = $object->getProperties();
        $this->assertEquals($expectedData, $objectData);
    }

    public function testJsonParseObjectRequirementProperty()
    {
        // phpcs:ignore
        $expectedData = '{"purchase_id":3,"purchase_status":"closed","voucher_code":null,"voucher_percentage":null,"voucher_value":null,"payment_type":null,"shipping_type":null,"shipping_cost":null,"shipping_country":null,"shipping_city":null,"product_list":[{"product_id":3,"quantity":20},{"product_id":4,"quantity":30}],"product_ids":[3,4],"total_quantity":30,"total_price":55.42}';

        $object = new Purchase(
            new RegisteredCustomer('example@example.com'),
            'a > b > c',
            'test',
            [
                new Product(3, 20),
                new Product(4, 30)
            ],
            3,
            'closed',
            55.42,
            30
        );

        $objectData = $object->getProperties();
        $this->assertEquals($expectedData, json_encode($objectData));
    }

    public function testParseObjectProperty()
    {
        $expectedData = [
            'purchase_id' => 3,
            'purchase_status' => 'closed',
            'voucher_code' => 'XXXX',
            'voucher_percentage' => 22,
            'voucher_value' => 30,
            'payment_type' => 'COD',
            'shipping_type' => 'X',
            'shipping_cost' => 3.13,
            'shipping_country' => 'PL',
            'shipping_city' => 'Skierniewice',
            'product_list' => [
                new Product(3, 20),
                new Product(4, 30)
            ],
            'product_ids' => [3,4],
            'total_quantity' => 30,
            'total_price' => 55.42
        ];

        $object = new Purchase(
            new RegisteredCustomer('example@example.com'),
            'a > b > c',
            'test',
            [
                new Product(3, 20),
                new Product(4, 30)
            ],
            3,
            'closed',
            55.42,
            30
        );

        $object->setVoucherCode('XXXX');
        $object->setVoucherPercentage(22);
        $object->setVoucherValue(30);
        $object->setPaymentType('COD');
        $object->setShippingType('X');
        $object->setShippingCost(3.13);
        $object->setShippingCountry('PL');
        $object->setShippingCity('Skierniewice');

        $objectData = $object->getProperties();

        $this->assertEquals($expectedData, $objectData);
    }
}
