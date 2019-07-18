<?php

namespace Tauceti\ExponeaApi\Events\Traits;

trait ProductIdentificationTrait
{
    /**
     * @var int
     */
    protected $productId;

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @param int $productId
     */
    public function setProductId(int $productId)
    {
        $this->productId = $productId;
    }
}
