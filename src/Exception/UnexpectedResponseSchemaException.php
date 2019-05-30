<?php

namespace Tauceti\ExponeaApi\Exception;

use GuzzleHttp\Exception\BadResponseException;

/**
 * Exception thrown when response doesn't match to expected schema
 * @package Tauceti\ExponeaApiTest\Exception
 */
class UnexpectedResponseSchemaException extends BadResponseException
{
}
