<?php

namespace Tauceti\ExponeaApi\Events\Traits;

trait PriceTrait
{
    /**
     * @var float
     */
    protected $price;

    /**
     * @var float $price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }
}
