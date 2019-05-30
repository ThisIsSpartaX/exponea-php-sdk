<?php

namespace Tauceti\ExponeaApi\Exception;

use GuzzleHttp\Exception\BadResponseException;

/**
 * Exception thrown where received success: false response
 *
 * Behavior of this field is not documentated in Exponea.
 *
 * @package Tauceti\ExponeaApiTest\Exception
 */
class UnsuccessfulResponseException extends BadResponseException
{
}
