<?php

namespace Tauceti\ExponeaApi\Tracking\Response;

use Tauceti\ExponeaApi\Exception\Internal\MissingResponseFieldException;

/**
 * Result of getSystemTime() call
 * @package Tauceti\ExponeaApi\Response
 */
class SystemTime
{
    /**
     * @var int
     */
    protected $time;

    const FIELD_TIME = 'time';

    /**
     * SystemTime constructor.
     * @param array $data
     * @throws MissingResponseFieldException
     */
    public function __construct(array $data)
    {
        if (isset($data[self::FIELD_TIME])) {
            $this->setTime($data[self::FIELD_TIME]);
        } else {
            throw new MissingResponseFieldException(self::FIELD_TIME);
        }
    }

    /**
     * @param int $time
     */
    public function setTime(int $time)
    {
        $this->time = $time;
    }

    /**
     * @return int
     */
    public function getTime(): int
    {
        return $this->time;
    }
}
