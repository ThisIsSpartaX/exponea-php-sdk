<?php

namespace Tauceti\ExponeaApi\Events\Partials;

use Tauceti\ExponeaApi\Interfaces\CustomerIdInterface;

/**
 * Identification of registered customer ID (e-mail in real usage)
 * @package Tauceti\ExponeaApi\Events\Partials
 */
class RegisteredCustomer implements CustomerIdInterface
{
    /**
     * @var string
     */
    protected $email;

    public function __construct(string $email)
    {
        $this->setEmail($email);
    }

    public function getRegistered()
    {
        return $this->getEmail();
    }

    public function getCookie()
    {
        return null;
    }

    /**
     * @param string $email
     */
    protected function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
