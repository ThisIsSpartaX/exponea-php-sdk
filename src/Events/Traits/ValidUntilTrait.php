<?php

namespace Tauceti\ExponeaApi\Events\Traits;

trait ValidUntilTrait
{
    /**
     * @var float|null
     */
    protected $validUntil;

    /**
     * @param float|null $validUntil
     */
    public function setValidUntil(float $validUntil)
    {
        $this->validUntil = $validUntil;
    }

    /**
     * @return float|null
     */
    public function getValidUntil()
    {
        return $this->validUntil;
    }
}
