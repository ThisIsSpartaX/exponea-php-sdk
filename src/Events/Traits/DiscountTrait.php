<?php

namespace Tauceti\ExponeaApi\Events\Traits;

trait DiscountTrait
{
    /**
     * @var float|null
     */
    protected $discountValue = null;
    /**
     * @var float|null
     */
    protected $discountPercentage = null;

    /**
     * @param float|null $discountPercentage
     */
    public function setDiscountPercentage(float $discountPercentage = null)
    {
        $this->discountPercentage = $discountPercentage;
    }

    /**
     * @param float|null $discountValue
     */
    public function setDiscountValue(float $discountValue = null)
    {
        $this->discountValue = $discountValue;
    }

    /**
     * @return float|null
     */
    public function getDiscountPercentage()
    {
        return $this->discountPercentage;
    }

    /**
     * @return float|null
     */
    public function getDiscountValue()
    {
        return $this->discountValue;
    }
}
