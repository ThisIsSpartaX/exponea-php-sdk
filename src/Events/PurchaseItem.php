<?php

namespace Tauceti\ExponeaApi\Events;

use JsonSerializable;
use Tauceti\ExponeaApi\Events\Traits\CustomerIdTrait;
use Tauceti\ExponeaApi\Events\Traits\DiscountTrait;
use Tauceti\ExponeaApi\Events\Traits\ItemIdentificationTrait;
use Tauceti\ExponeaApi\Events\Traits\PurchaseIdentificationTrait;
use Tauceti\ExponeaApi\Events\Traits\QuantityTrait;
use Tauceti\ExponeaApi\Events\Traits\SourceTrait;
use Tauceti\ExponeaApi\Events\Traits\TimestampTrait;
use Tauceti\ExponeaApi\Interfaces\CustomerIdInterface;
use Tauceti\ExponeaApi\Interfaces\EventInterface;
use Tauceti\ExponeaApi\Events\Traits\PriceTrait;
use Tauceti\ExponeaApi\Events\Partials\Category;
use Tauceti\ExponeaApi\Events\Traits\StatusTrait;

/**
 * Event of one item purchase (equal to one order row)
 * @package Tauceti\ExponeaApi\Events
 */
class PurchaseItem implements EventInterface
{
    use CustomerIdTrait;
    use PurchaseIdentificationTrait;
    use TimestampTrait;
    use ItemIdentificationTrait;
    use PriceTrait;
    use QuantityTrait;
    use StatusTrait;
    use SourceTrait;
    use DiscountTrait;

    /**
     * @var string
     */
    protected $sku;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var Category
     */
    protected $category;

    public function __construct(
        CustomerIdInterface $customerIds,
        string $purchaseID,
        string $id,
        float $price,
        int $quantity,
        string $sku,
        string $name,
        Category $category
    ) {
        $this->setCustomerIds($customerIds);
        $this->setPurchaseID($purchaseID);
        $this->setItemID($id);
        $this->setPrice($price);
        $this->setQuantity($quantity);
        $this->setSKU($sku);
        $this->setName($name);
        $this->setCategory($category);
        $this->setTimestamp(microtime(true));
    }

    public function setSKU(string $sku)
    {
        $this->sku = $sku;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setCategory(Category $category)
    {
        $this->category = $category;
    }

    public function getSKU(): string
    {
        return $this->sku;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getTotalPrice(): float
    {
        return $this->quantity * $this->price;
    }

    public function getEventType(): string
    {
        return 'purchase_item';
    }

    /**
     * Get event properties
     * @return array|JsonSerializable
     */
    public function getProperties()
    {
        return array_filter(
            [
                'status' => $this->getStatus(),
                'purchase_id' => $this->getPurchaseID(),
                'item_id' => $this->getItemID(),
                'item_price' => $this->getPrice(),
                'item_sku' => $this->getSKU(),
                'item_name' => $this->getName(),
                'category_id' => $this->category->getID(),
                'category_name' => $this->getCategory()->getName(),
                'quantity' => $this->getQuantity(),
                'total_price' => $this->getTotalPrice(),
                'source' => $this->getSource(),
                'discount_value' => $this->getDiscountValue(),
                'discount_percentage' => $this->getDiscountPercentage(),
            ],
            function ($value) {
                return $value !== null;
            }
        );
    }
}
