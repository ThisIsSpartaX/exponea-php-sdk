<?php

namespace Tauceti\ExponeaApi\Events\Traits;

trait PurchaseIdentificationTrait
{
    /**
     * @var int
     */
    protected $purchaseId;
    /**
     * @var string
     */
    protected $purchaseStatus;

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
}
