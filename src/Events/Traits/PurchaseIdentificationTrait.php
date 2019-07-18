<?php

namespace Tauceti\ExponeaApi\Events\Traits;

trait PurchaseIdentificationTrait
{
    /**
     * @var string
     */
    protected $purchaseID;

    /**
     * @return string
     */
    public function getPurchaseID(): string
    {
        return $this->purchaseID;
    }

    /**
     * @param string $purchaseID
     */
    public function setPurchaseID(string $purchaseID)
    {
        $this->purchaseID = $purchaseID;
    }
}
