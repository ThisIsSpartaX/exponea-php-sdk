<?php

namespace Tauceti\ExponeaApi\Events;

use Tauceti\ExponeaApi\Interfaces\CustomerIdInterface;
use Tauceti\ExponeaApi\Interfaces\EventInterface;

/**
 * Consent (agreement) change event
 * @package Tauceti\ExponeaApi\Events
 */
class Consent implements EventInterface
{
    const CATEGORY_NEWSLETTER = 'newsletter';
    const CATEGORY_SMS = 'sms';

    const ACTION_REVOKE = 'reject';
    const ACTION_GRANT = 'accept';

    /**
     * @var CustomerIdInterface
     */
    protected $customerIds;
    /**
     * @var string
     */
    protected $category;
    /**
     * @var string
     */
    protected $action;
    /**
     * @var float|null
     */
    protected $validUntil;
    /**
     * @var float
     */
    protected $timestamp;

    public function __construct(CustomerIdInterface $customerIds, string $category, string $action)
    {
        $this->setCustomerIds($customerIds);
        $this->setCategory($category);
        $this->setAction($action);
        $this->setTimestamp(microtime(true));
    }

    public function getProperties()
    {
        return [
            'action' => $this->getAction(),
            'category' => $this->getCategory(),
            'timestamp' => $this->getTimestamp(),
            'valid_until' => $this->getValidUntil() ?? 'unlimited',
        ];
    }

    public function getEventType(): string
    {
        return 'consent';
    }

    /**
     * @param CustomerIdInterface $customerIds
     */
    public function setCustomerIds(CustomerIdInterface $customerIds)
    {
        $this->customerIds = $customerIds;
    }

    /**
     * @param string $category
     */
    public function setCategory(string $category)
    {
        $this->category = $category;
    }

    /**
     * @param string $action
     */
    public function setAction(string $action)
    {
        $this->action = $action;
    }

    /**
     * @param float|null $validUntil
     */
    public function setValidUntil(float $validUntil)
    {
        $this->validUntil = $validUntil;
    }

    /**
     * @param float $timestamp
     */
    public function setTimestamp(float $timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @return float|null
     */
    public function getValidUntil()
    {
        return $this->validUntil;
    }

    /**
     * @return float
     */
    public function getTimestamp(): float
    {
        return $this->timestamp;
    }

    /**
     * @return CustomerIdInterface
     */
    public function getCustomerIds(): CustomerIdInterface
    {
        return $this->customerIds;
    }
}
