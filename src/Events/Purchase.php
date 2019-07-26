<?php

namespace Tauceti\ExponeaApi\Events;

use InvalidArgumentException;
use JsonSerializable;
use Tauceti\ExponeaApi\Events\Traits\CustomerIdTrait;
use Tauceti\ExponeaApi\Events\Traits\PurchaseIdentificationTrait;
use Tauceti\ExponeaApi\Events\Traits\SourceTrait;
use Tauceti\ExponeaApi\Events\Traits\TimestampTrait;
use Tauceti\ExponeaApi\Interfaces\CustomerIdInterface;
use Tauceti\ExponeaApi\Interfaces\EventInterface;
use Tauceti\ExponeaApi\Events\Partials\Item;
use Tauceti\ExponeaApi\Events\Partials\Voucher;
use Tauceti\ExponeaApi\Events\Traits\StatusTrait;

/**
 * Purchase event
 * @package Tauceti\ExponeaApi\Events
 */
class Purchase implements EventInterface
{
    use CustomerIdTrait;
    use TimestampTrait;
    use PurchaseIdentificationTrait;
    use StatusTrait;
    use SourceTrait;

    /**
     * @var Item[]
     */
    protected $items = [];
    /**
     * @var string
     */
    protected $paymentMethod;
    /**
     * @var Voucher|null
     */
    protected $voucher = null;

    public function __construct(
        CustomerIdInterface $customerIds,
        string $purchaseID,
        array $items,
        string $paymentMethod,
        Voucher $voucher = null
    ) {
        $this->setCustomerIds($customerIds);
        $this->setPurchaseID($purchaseID);
        $this->setItems($items);
        $this->setPaymentMethod($paymentMethod);
        $this->setVoucher($voucher);
        $this->setTimestamp(microtime(true));
    }

    /**
     * @var Item[] $items
     */
    public function setItems(array $items)
    {
        $this->items = [];

        foreach ($items as $item) {
            if (!$item instanceof Item) {
                throw new InvalidArgumentException(
                    'Items of $items array must be instance of ' . Item::class
                );
            }
            $this->addItem($item);
        }
    }

    /**
     * @var Item $item
     */
    public function addItem(Item $item)
    {
        $this->items[] = $item;
    }

    /**
     * @var Voucher|null $voucher
     */
    public function setVoucher(Voucher $voucher = null)
    {
        $this->voucher = $voucher;
    }

    /**
     * @param string $paymentMethod
     */
    public function setPaymentMethod(string $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    public function getEventType(): string
    {
        return 'purchase';
    }

    /**
     * @return float
     */
    public function getTotalPrice(): float
    {
        $total = 0.0;
        foreach ($this->items as $item) {
            /** @var Item $item */
            $total = $total + $item->getPrice() * $item->getQuantity();
        }
        return $total;
    }

    /**
     * @return int
     */
    public function getTotalQuantity(): int
    {
        $total = 0;
        foreach ($this->items as $item) {
            /** @var Item $item */
            $total = $total + $item->getQuantity();
        }
        return $total;
    }

    /**
     * @return array|JsonSerializable
     */
    public function getProperties()
    {
        return array_filter(
            [
                'status' => $this->getStatus(),
                'items' => $this->getItems(),
                'purchase_id' => $this->getPurchaseID(),
                'total_price' => $this->getTotalPrice(),
                'total_quantity' => $this->getTotalQuantity(),
                'payment_method' => $this->getPaymentMethod(),
                'source' => $this->getSource(),
                'voucher_code' => $this->voucher === null ? null : $this->voucher->getCode(),
                'voucher_percentage' => $this->voucher === null ? null : $this->voucher->getPercentage(),
                'voucher_value' => $this->voucher === null ? null : $this->voucher->getValue(),
            ],
            function ($value) {
                return $value !== null;
            }
        );
    }
}
