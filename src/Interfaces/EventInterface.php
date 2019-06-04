<?php

namespace Tauceti\ExponeaApi\Interfaces;

use \JsonSerializable;

/**
 * Interface describing event which happened for contact
 * @package Tauceti\ExponeaApi\Interfaces
 */
interface EventInterface
{
    /**
     * Person which event should be assigned to
     * @return CustomerIdInterface
     */
    public function getCustomerIDs() : CustomerIdInterface;
    /**
     * Please check your API panel as event types propably might vary depending on your project requirements
     * @return string
     */
    public function getEventType() : string;
    /**
     * Time when event occured
     *
     * ATTENTION: Exponea uses FLOAT values for timestamps
     * @return float
     */
    public function getTimestamp(): float;
    /**
     * Get event properties
     * @return array|JsonSerializable
     */
    public function getProperties();
}
