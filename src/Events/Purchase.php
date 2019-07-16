<?php


namespace Tauceti\ExponeaApi\Events;


use JsonSerializable;
use Tauceti\ExponeaApi\Interfaces\CustomerIdInterface;
use Tauceti\ExponeaApi\Interfaces\EventInterface;

/**
 * Purchase event
 * @package Tauceti\ExponeaApi\Events
 */
class Purchase implements EventInterface
{
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
     * @var array
     */
    protected $productIds = [];

    /**
     * @var array
     */
    protected $productList;

    /**
     * @var int
     */
    protected $purchaseId;

    /**
     * @var string
     */
    protected $purchaseStatus;

    /**
     * @var int
     */
    protected $totalPrice;

    /**
     * @var int
     */
    protected $totalQuantity;

    /**
     * @var string|null
     */

    protected $voucherCode;

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
     * @return string
     */
    public function getPurchaseStatus(): string
    {
        return $this->purchaseStatus;
    }

    /**
     * @param string $purchaseStatus
     */
    public function setPurchaseStatus(string $purchaseStatus)
    {
        $this->purchaseStatus = $purchaseStatus;
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
    public function getTotalQuantity(): int
    {
        return $this->totalQuantity;
    }

    /**
     * @param int $totalQuantity
     */
    public function setTotalQuantity(int $totalQuantity)
    {
        $this->totalQuantity = $totalQuantity;
    }

    /**
     * @return string|null
     */
    public function getVoucherCode(): string
    {
        return $this->voucherCode;
    }

    /**
     * @param string|null $voucherCode
     */
    public function setVoucherCode(string $voucherCode)
    {
        $this->voucherCode = $voucherCode;
    }

    /**
     * @return int|null
     */
    public function getVoucherPercentage(): int
    {
        return $this->voucherPercentage;
    }

    /**
     * @param int|null $voucherPercentage
     */
    public function setVoucherPercentage(int $voucherPercentage)
    {
        $this->voucherPercentage = $voucherPercentage;
    }

    /**
     * @return int|null
     */
    public function getVoucherValue(): int
    {
        return $this->voucherValue;
    }

    /**
     * @param int|null $voucherValue
     */
    public function setVoucherValue(int $voucherValue)
    {
        $this->voucherValue = $voucherValue;
    }

    /**
     * @var int|null
     */

    protected $voucherPercentage;

    /**
     * @var int|null
     */

    protected $voucherValue;

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
    public function getValidUntil(): float
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
     * @return string
     */
    public function getEventType(): string
    {
        return 'purchase';
    }

    /**
     * @return array|JsonSerializable
     */
    public function getProperties()
    {
        return [
            "product_ids" => $this->getProductIds(),
            "product_list" => $this->getProductList(),
            "purchase_id" => $this->getPurchaseId(),
            "purchase_status" => $this->getPurchaseStatus(),
            "total_price" => $this->getTotalPrice(),
            "total_quantity" => $this->getTotalQuantity(),
            "voucher_code" => $this->getVoucherCode(),
            "voucher_percentage" => $this->getVoucherPercentage(),
            "voucher_value" => $this->getVoucherValue()
        ];
    }

    /**
     * @return array
     */
    public function getProductIds(): array
    {
        return $this->productIds;
    }

    /**
     * @param array $productIds
     */
    public function setProductIds(array $productIds)
    {
        $this->productIds = $productIds;
    }

    /**
     * @return array
     */
    public function getProductList(): array
    {
        return $this->productList;
    }

    /**
     * @param array $purchaseList
     */
    public function setProductList(array $purchaseList)
    {
        $this->productList = $purchaseList;
    }


}