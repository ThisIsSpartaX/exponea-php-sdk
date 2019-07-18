<?php

namespace Tauceti\ExponeaApiTest\Events;

use PHPUnit\Framework\TestCase;
use Tauceti\ExponeaApi\Events\Partials\Product;
use Tauceti\ExponeaApi\Events\Partials\RegisteredCustomer;
use Tauceti\ExponeaApi\Events\Purchase;
use Tauceti\ExponeaApi\Events\PurchaseItem;
use Tauceti\ExponeaApi\Interfaces\EventInterface;

class PurchaseItemTest extends TestCase
{
    public function testInstanceOfEventInterface()
    {
        $object = new PurchaseItem(
            new RegisteredCustomer('example@example.com'),
            ['a', 'b', 'c'],
            10,
            30,
            'closed',
            3
        );
        $this->assertInstanceOf(EventInterface::class, $object);
    }

    public function testJsonParseObjectRequirementProperty()
    {
        // phpcs:ignore
        $expectedData = '{"purchase_id":3,"purchase_status":"closed","quantity":30,"total_price":0,"categories_path":["a","b","c"],"product_id":10,"discount_percentage":0,"discount_value":0}';

        $object = new PurchaseItem(
            new RegisteredCustomer('example@example.com'),
            ['a', 'b', 'c'],
            10,
            30,
            'closed',
            3
        );

        $objectData = $object->getProperties();
        $this->assertEquals($expectedData, json_encode($objectData));
    }

    public function testParseObjectRequirementProperty()
    {
        $object = new PurchaseItem(
            new RegisteredCustomer('example@example.com'),
            ['a', 'b', 'c'],
            10,
            30,
            'closed',
            3
        );

        $expectedData = [
            'purchase_id' => 3,
            'purchase_status' => 'closed',
            'quantity' => 30,
            'categories_path' => ['a','b','c'],
            'product_id' => 10,
            'total_price' => 0,
            'discount_percentage' => 0,
            'discount_value' => 0.0
        ];

        $objectData  = $object->getProperties();

        $this->assertEquals($expectedData, $objectData);
    }

    public function testParseObjectProperty()
    {
        $expectedData = [
            'purchase_id' => 3,
            'purchase_status' => 'closed',
            'quantity' => 30,
            'total_price' => 705.0,
            'variant_id' => 33,
            'title' => 'abc',
            'tags' => [
                [
                    'id' => 3,
                    'name' => 'ZZZ'
                ],
                [
                    'id' => 4,
                    'name' => 'YYY'
                ]
            ],
            'categories_path' => ['a','b','c'],
            'price' => 23.50,
            'original_price' => 22.39,
            'stock_level' => 999,
            'discount_percentage' => -4.0,
            'discount_value' => -1.0,
            'product_id' => 10
        ];

        $object = new PurchaseItem(
            new RegisteredCustomer('example@example.com'),
            ['a', 'b', 'c'],
            10,
            30,
            'closed',
            3
        );

        $object->setVariantId(33);
        $object->setTitle('abc');
        $object->setTags([
            [
                'id' => 3,
                'name' => 'ZZZ'
            ],
            [
                'id' => 4,
                'name' => 'YYY'
            ]
        ]);
        $object->setPrice(23.50);
        $object->setOriginalPrice(22.39);
        $object->setStockLevel(999);

        $objectData = $object->getProperties();

        $this->assertEquals($expectedData, $objectData);
    }
}
