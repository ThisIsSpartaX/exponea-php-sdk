<?php

namespace Tauceti\ExponeaApi\Interfaces;

/**
 * Interface describing contact for which action should be made
 * @package Tauceti\ExponeaApi\Interfaces
 */
interface CustomerIdInterface
{
    /**
     * Exponea API customer_ids.cookie field
     * @return string|null
     */
    public function getCookie();
    /**
     * Exponea API customer_ids.registered field (should contain customer e-mail address which is base identifier)
     * @return string|null
     */
    public function getRegistered();
}
