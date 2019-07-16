<?php

namespace Tauceti\ExponeaApiTest\Events;

use PHPUnit\Framework\TestCase;
use Tauceti\ExponeaApi\Events\Purchase;
use Tauceti\ExponeaApi\Interfaces\EventInterface;

class PurchaseTest extends TestCase
{
    public function testInstanceOfEventInterface() {
        $object = new Purchase();
        $this->assertInstanceOf(EventInterface::class, $object);
    }

    public function testParseObjectProperty() {
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
            'product_list' => ['a','b','c','d'],
            'product_ids' => [123,345,567,891],
            'total_quantity' => 30,
            'total_price' => 55.42
        ];

        $object = new Purchase();

        $object->setPurchaseId(3);
        $object->setPurchaseStatus('closed');
        $object->setVoucherCode('XXXX');
        $object->setVoucherPercentage(22);
        $object->setVoucherValue(30);
        $object->setPaymentType('COD');
        $object->setShippingType('X');
        $object->setShippingCost(3.13);
        $object->setShippingCountry('PL');
        $object->setShippingCity('Skierniewice');
        $object->setProductList([
           'a','b','c','d'
        ]);
        $object->setProductIds([123,345,567,891]);
        $object->setTotalQuantity(30);
        $object->setTotalPrice(55.42);

        $objectData = $object->getProperties();

        $this->assertEquals($expectedData, $objectData);
    }
}