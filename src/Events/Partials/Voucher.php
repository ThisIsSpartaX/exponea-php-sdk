<?php

namespace Tauceti\ExponeaApi\Events\Partials;

/**
 * Representation of voucher (coupon) used in purchase
 * @package Tauceti\ExponeaApi\Events\Partials
 */
class Voucher
{
    /**
     * @var string
     */
    protected $code;
    /**
     * @var float
     */
    protected $value;
    /**
     * @var float
     */
    protected $percentage;

    public function __construct(string $code, float $value, float $percentage)
    {
        $this->setCode($code);
        $this->setValue($value);
        $this->setPercentage($percentage);
    }

    public function setCode(string $value)
    {
        $this->code = $value;
    }

    public function setValue(float $value)
    {
        $this->value = $value;
    }

    public function setPercentage(float $value)
    {
        $this->percentage = $value;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getPercentage(): float
    {
        return $this->percentage;
    }
}
