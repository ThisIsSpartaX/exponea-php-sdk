<?php

namespace Tauceti\ExponeaApi\Events;

use JsonSerializable;
use Tauceti\ExponeaApi\Events\Traits\CustomerIdTrait;
use Tauceti\ExponeaApi\Events\Traits\ProductIdentificationTrait;
use Tauceti\ExponeaApi\Events\Traits\PurchaseIdentificationTrait;
use Tauceti\ExponeaApi\Events\Traits\QuantityTrait;
use Tauceti\ExponeaApi\Events\Traits\TimestampTrait;
use Tauceti\ExponeaApi\Interfaces\CustomerIdInterface;
use Tauceti\ExponeaApi\Interfaces\EventInterface;

/**
 * Event of one item purchase (equal to one order row)
 * @package Tauceti\ExponeaApi\Events
 */
class PurchaseItem implements EventInterface
{
    use CustomerIdTrait;
    use PurchaseIdentificationTrait;
    use TimestampTrait;
    use ProductIdentificationTrait;
    use QuantityTrait;

    /**
     * @var string|null
     */
    protected $title;

    /**
     * @var int|null
     */
    protected $variantId;

    /**
     * @var integer|null
     */
    protected $stockLevel;

    /**
     * @var float|null
     */
    protected $originalPrice;
    /**
     * @var float|null
     */
    protected $price;
    /**
     * @var int
     */
    protected $totalPrice;

    /**
     * @var string
     */
    protected $categoriesPath;
    /**
     * @var array|null
     */
    protected $tags;

    /**
     * PurchaseItem constructor.
     * @param CustomerIdInterface $customerIds
     * @param string[] $categoriesPath
     * @param int $productId
     * @param int $quantity
     * @param string $purchaseStatus
     * @param int $purchaseId
     */
    public function __construct(
        CustomerIdInterface $customerIds,
        array $categoriesPath,
        int $productId,
        int $quantity,
        string $purchaseStatus,
        int $purchaseId
    ) {
        $this->setCustomerIds($customerIds);
        $this->setCategoriesPath($categoriesPath);
        $this->setProductId($productId);
        $this->setQuantity($quantity);
        $this->setPurchaseStatus($purchaseStatus);
        $this->setPurchaseId($purchaseId);
        $this->setTimestamp(microtime(true));
    }

    /**
     * Please check your API panel as event types propably might vary depending on your project requirements
     * @return string
     */
    public function getEventType(): string
    {
        return 'purchase_item';
    }

    /**
     * @return int|null
     */
    public function getStockLevel()
    {
        return $this->stockLevel;
    }

    /**
     * @param int|null $stockLevel
     */
    public function setStockLevel(int $stockLevel)
    {
        $this->stockLevel = $stockLevel;
    }

    /**
     * @return float|null
     */
    public function getOriginalPrice()
    {
        return $this->originalPrice;
    }

    /**
     * @param float|null $originalPrice
     */
    public function setOriginalPrice(float $originalPrice)
    {
        $this->originalPrice = $originalPrice;
    }

    /**
     * @return float|null
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getCategoriesPath(): array
    {
        return $this->categoriesPath;
    }

    /**
     * @param string[] $categoriesPath
     */
    public function setCategoriesPath(array $categoriesPath)
    {
        $this->categoriesPath = $categoriesPath;
    }

    /**
     * @return array|null
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param array|null $tags
     */
    public function setTags(array $tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getTotalPrice(): int
    {
        return $this->totalPrice;
    }

    /**
     * @param int $totalPrice
     */
    public function setTotalPrice(int $totalPrice)
    {
        $this->totalPrice = $totalPrice;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * Get event properties
     * @return array|JsonSerializable
     */
    public function getProperties()
    {
        $data = [
            'purchase_id' => $this->getPurchaseId(),
            'purchase_status' => $this->getPurchaseStatus(),
            'quantity' => $this->getQuantity(),
            'total_price' => $this->getPrice() * $this->getQuantity(),
            'variant_id' => $this->getVariantId(),
            'title' => $this->getTitle(),
            'tags' => $this->getTags() !== null ? $this->getTags() : null,
            'categories_path' => empty($this->getCategoriesPath()) ? null : explode(' > ', $this->getCategoriesPath()),
            'price' => $this->getPrice(),
            'original_price' => $this->getOriginalPrice(),
            'stock_level' => $this->getStockLevel(),
            'product_id' => $this->getProductId()
        ];

        if ($data['price'] != $data['original_price'] && $data['original_price'] != 0) {
            $data['discount_value'] = round($data['original_price'] - $data['price']);
            $data['discount_percentage'] = (float) intval(
                round(($data['discount_value'] / $data['original_price']) * 100)
            );
        } else {
            $data['discount_percentage'] = 0;
            $data['discount_value'] = 0.0;
        }

        foreach ($data as $key => $value) {
            if ($value === null) {
                unset($data[$key]);
            }
        }

        return $data;
    }

    /**
     * @return int|null
     */
    public function getVariantId()
    {
        return $this->variantId;
    }

    /**
     * @param int|null $variantId
     */
    public function setVariantId(int $variantId)
    {
        $this->variantId = $variantId;
    }
}
