<?php

namespace Tauceti\ExponeaApi\Events\Traits;

trait ItemIdentificationTrait
{
    /**
     * @var string
     */
    protected $itemID;

    /**
     * @return string
     */
    public function getItemID(): string
    {
        return $this->itemID;
    }

    /**
     * @param string $ItemID
     */
    public function setItemID(string $itemID)
    {
        $this->itemID = $itemID;
    }
}
