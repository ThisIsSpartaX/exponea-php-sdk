<?php

namespace Tauceti\ExponeaApi\Events\Traits;

use Tauceti\ExponeaApi\Interfaces\CustomerIdInterface;

trait CustomerIdTrait
{
    /**
     * @var CustomerIdInterface
     */
    protected $customerIds;

    /**
     * @param CustomerIdInterface $customerIds
     */
    public function setCustomerIds(CustomerIdInterface $customerIds)
    {
        $this->customerIds = $customerIds;
    }

    /**
     * @return CustomerIdInterface
     */
    public function getCustomerIds(): CustomerIdInterface
    {
        return $this->customerIds;
    }
}
