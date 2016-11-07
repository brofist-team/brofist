<?php

namespace Brofist\ValueObjects;

use DateTimeImmutable;
use DateTimeZone;

class DateTime extends DateTimeImmutable
{
    /**
     * @return Date
     */
    public function toUtc()
    {
        return $this->setTimezone(new DateTimeZone('UTC'));
    }

    /**
     * @return the standard database format for date time
     */
    public function __toString()
    {
        return $this->format('Y-m-d H:i:s');
    }
}
