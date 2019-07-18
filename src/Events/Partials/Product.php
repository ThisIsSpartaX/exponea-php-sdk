<?php


namespace Tauceti\ExponeaApi\Events\Partials;

use JsonSerializable;

/**
 * Entity class for single item of product_list array
 * @package Tauceti\ExponeaApi\Events\Partials
 */
class Product implements JsonSerializable
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var int
     */
    private $quantity;

    public function __construct(int $id, int $quantity)
    {
        $this->id = $id;
        $this->quantity = $quantity;
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return [
            'product_id' => $this->getId(),
            'quantity' => $this->getQuantity()
        ];
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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }
}
