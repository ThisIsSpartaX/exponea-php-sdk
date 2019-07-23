<?php

namespace Tauceti\ExponeaApiTest\Events;

use PHPUnit\Framework\TestCase;
use Tauceti\ExponeaApi\Events\PurchaseItem;
use Tauceti\ExponeaApi\Events\Partials\Category;
use Tauceti\ExponeaApi\Events\Partials\RegisteredCustomer;

class PurchaseItemTest extends TestCase
{
    public function testMinimalDataRequired()
    {
        $customerID = new RegisteredCustomer('example@example.com');
        $obj = new PurchaseItem(
            $customerID,
            'PREFIX12345',
            '012345',
            2.99,
            2,
            'SKU012345',
            'Product name',
            new Category('CAT1', 'Some > Category > Breadcrumb')
        );

        $this->assertSame($customerID, $obj->getCustomerIds());
        $this->assertSame('purchase_item', $obj->getEventType());
        $this->assertEquals(microtime(true), $obj->getTimestamp(), 'Timestamp is not generated properly', 1);

        $properties = json_decode(json_encode($obj->getProperties()), true);
        $this->assertEquals(
            [
                'status' => 'success',
                'purchase_id' => 'PREFIX12345',
                'item_id' => '012345',
                'item_price' => 2.99,
                'item_sku' => 'SKU012345',
                'item_name' => 'Product name',
                'category_id' => 'CAT1',
                'category_name' => 'Some > Category > Breadcrumb',
                'quantity' => 2,
                'total_price' => 5.98,
                'source' => 'VPI'
            ],
            $properties,
            'Invalid properties generated (after json serialization)',
            0.01
        );
    }
}
