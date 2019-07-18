<?php

namespace Tauceti\ExponeaApi\Events;

use JsonSerializable;
use Tauceti\ExponeaApi\Events\Partials\Product;
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
     * @var float
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
     * @var string|null
     */

    protected $paymentType;

    /**
     * @var string|null
     */
    protected $shippingType;

    /**
     * @var float|null
     */
    protected $shippingCost;

    /**
     * @var string|null
     */

    protected $shippingCountry;

    /**
     * @var string|null
     */

    protected $shippingCity;


    /**
     * Purchase constructor.
     * @param CustomerIdInterface $customerIds
     * @param string $category
     * @param string $action
     * @param array $productIds
     * @param array $productList
     * @param int $purchaseId
     * @param string $purchaseStatus
     * @param float $totalPrice
     * @param int $totalQuantity
     */
    public function __construct(
        CustomerIdInterface $customerIds,
        string $category,
        string $action,
        array $productIds,
        array $productList,
        int $purchaseId,
        string $purchaseStatus,
        float $totalPrice,
        int $totalQuantity
    )
    {
        $this->setCustomerIds($customerIds);
        $this->setCategory($category);
        $this->setAction($action);
        $this->setProductIds($productIds);
        $this->setPurchaseId($purchaseId);
        $this->setPurchaseStatus($purchaseStatus);
        $this->setTotalPrice($totalPrice);
        $this->setTotalQuantity($totalQuantity);
        $this->setTimestamp(microtime(true));

        if ($productList != null) {
            foreach ($productList as $product) {
                if (!$product instanceof Product) {
                    throw new \InvalidArgumentException('Items of $productList array must be instance of '.Product::class);
                }
                $this->addProduct($product);
            }
        }
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
    public function getVoucherCode()
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
    public function getVoucherPercentage()
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
    public function getVoucherValue()
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
     * @return string|null
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * @param string|null $paymentType
     */
    public function setPaymentType(string $paymentType)
    {
        $this->paymentType = $paymentType;
    }

    /**
     * @return string|null
     */
    public function getShippingType()
    {
        return $this->shippingType;
    }

    /**
     * @param string|null $shippingType
     */
    public function setShippingType(string $shippingType)
    {
        $this->shippingType = $shippingType;
    }

    /**
     * @return float|null
     */
    public function getShippingCost()
    {
        return $this->shippingCost;
    }

    /**
     * @param float|null $shippingCost
     */
    public function setShippingCost(float $shippingCost)
    {
        $this->shippingCost = $shippingCost;
    }

    /**
     * @return string|null
     */
    public function getShippingCountry()
    {
        return $this->shippingCountry;
    }

    /**
     * @param string|null $shippingCountry
     */
    public function setShippingCountry(string $shippingCountry)
    {
        $this->shippingCountry = $shippingCountry;
    }

    /**
     * @return string|null
     */
    public function getShippingCity()
    {
        return $this->shippingCity;
    }

    /**
     * @param string|null $shippingCity
     */
    public function setShippingCity(string $shippingCity)
    {
        $this->shippingCity = $shippingCity;
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
            'purchase_id' => $this->getPurchaseId(),
            'purchase_status' => $this->getPurchaseStatus(),
            'voucher_code' => $this->getVoucherCode(),
            'voucher_percentage' => $this->getVoucherPercentage(),
            'voucher_value' => $this->getVoucherValue(),
            'payment_type' => $this->getPaymentType(),
            'shipping_type' => $this->getShippingType(),
            'shipping_cost' => $this->getShippingCost(),
            'shipping_country' => $this->getShippingCountry(),
            'shipping_city' => $this->getShippingCity(),
            'product_list' => $this->getProductList(),
            'product_ids' => $this->getProductIds(),
            'total_quantity' => $this->getTotalQuantity(),
            'total_price' => $this->getTotalPrice(),
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
     * @return float
     */
    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }

    /**
     * @param float $totalPrice
     */
    public function setTotalPrice(float $totalPrice)
    {
        $this->totalPrice = $totalPrice;
    }

    /**
     * @param Product $product
     */
    public function addProduct(Product $product) {
        $this->productList[] = $product;
    }
}
