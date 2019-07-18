<?php


namespace Tauceti\ExponeaApi\Events\Partials;

use JsonSerializable;
use Tauceti\ExponeaApi\Events\Traits\ProductIdentificationTrait;
use Tauceti\ExponeaApi\Events\Traits\QuantityTrait;

/**
 * Entity class for single item of product_list array
 * @package Tauceti\ExponeaApi\Events\Partials
 */
class Product implements JsonSerializable
{
    use ProductIdentificationTrait;
    use QuantityTrait;

    public function __construct(int $id, int $quantity)
    {
        $this->setProductId($id);
        $this->setQuantity($quantity);
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return [
            'product_id' => $this->getProductId(),
            'quantity' => $this->getQuantity()
        ];
    }
}
