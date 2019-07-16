<?php

namespace Tauceti\ExponeaApi\Events;

use JsonSerializable;
use Tauceti\ExponeaApi\Interfaces\CustomerIdInterface;
use Tauceti\ExponeaApi\Interfaces\EventInterface;

class PurchaseItem implements EventInterface
{
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
     * @var string[]|
     */
    protected $categoriesPath;

    /**
     * @var array|null
     */
    protected $tags;

    /**
     * @var string|null
     */
    protected $title;

    /**
     * @var int|null
     */
    protected $variantId;

    /**
     * @var int
     */
    protected $productId;

    /**
     * @var int
     */
    protected $totalPrice;

    /**
     * @var int
     */
    protected $quantity;

    /**
     * @var string
     */
    protected $purchaseStatus;

    /**
     * @var int
     */
    protected $purchaseId;

    /**
     * @var CustomerIdInterface
     */
    protected $customerIds;
    /**
     * @var string
     */
    protected $category;
    /**
     * @var string
     */
    protected $action;
    /**
     * @var float|null
     */
    protected $validUntil;
    /**
     * @var float
     */
    protected $timestamp;

    /**
     * @return CustomerIdInterface
     */
    public function getCustomerIds(): CustomerIdInterface
    {
        return $this->customerIds;
    }

    /**
     * @param CustomerIdInterface $customerIds
     */
    public function setCustomerIds(CustomerIdInterface $customerIds)
    {
        $this->customerIds = $customerIds;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory(string $category)
    {
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction(string $action)
    {
        $this->action = $action;
    }

    /**
     * @return float|null
     */
    public function getValidUntil()
    {
        return $this->validUntil;
    }

    /**
     * @param float|null $validUntil
     */
    public function setValidUntil(float $validUntil)
    {
        $this->validUntil = $validUntil;
    }

    /**
     * @return float
     */
    public function getTimestamp(): float
    {
        return $this->timestamp;
    }

    /**
     * @param float $timestamp
     */
    public function setTimestamp(float $timestamp)
    {
        $this->timestamp = $timestamp;
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
     * @return string[]
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
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @param int $productId
     */
    public function setProductId(int $productId)
    {
        $this->productId = $productId;
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
     * @return mixed
     */
    public function getPurchaseStatus()
    {
        return $this->purchaseStatus;
    }

    /**
     * @param mixed $purchaseStatus
     */
    public function setPurchaseStatus($purchaseStatus)
    {
        $this->purchaseStatus = $purchaseStatus;
    }

    /**
     * @return int
     */
    public function getPurchaseId(): int
    {
        return $this->purchaseId;
    }

    /**
     * @param int $purchaseId
     */
    public function setPurchaseId(int $purchaseId)
    {
        $this->purchaseId = $purchaseId;
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
            'categories_path' => empty($this->getCategoriesPath()) ? null : implode(' > ', $this->getCategoriesPath()),
            'price' => $this->getPrice(),
            'original_price' => $this->getOriginalPrice(),
            'stock_level' => $this->getStockLevel(),
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
    public function getVariantId(): int
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
