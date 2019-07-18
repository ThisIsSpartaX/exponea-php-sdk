<?php


namespace Tauceti\ExponeaApi\Events\Partials;

use JsonSerializable;
use Tauceti\ExponeaApi\Events\Traits\ItemIdentificationTrait;
use Tauceti\ExponeaApi\Events\Traits\QuantityTrait;
use Tauceti\ExponeaApi\Events\Traits\PriceTrait;

/**
 * Entity class for single item of purchase items array
 * @package Tauceti\ExponeaApi\Events\Partials
 */
class Item implements JsonSerializable
{
    use ItemIdentificationTrait;
    use PriceTrait;
    use QuantityTrait;

    public function __construct(string $id, float $price, int $quantity)
    {
        $this->setItemID($id);
        $this->setPrice($price);
        $this->setQuantity($quantity);
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return [
            'item_id' => $this->getItemID(),
            'price' => $this->getPrice(),
            'quantity' => $this->getQuantity()
        ];
    }
}
