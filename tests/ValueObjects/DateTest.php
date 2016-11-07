<?php

namespace BrofistTest\ValueObjects;

use Brofist\ValueObjects\Date;
use Brofist\ValueObjects\DateTime;
use PHPUnit_Framework_TestCase;

class DateTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Date
     */
    protected $date;

    /**
     * @before
     */
    public function initialize()
    {
        $this->date = new Date();
    }

    /**
     * @test
     */
    public function extendsDateTime()
    {
        $this->assertInstanceOf(DateTime::class, $this->date);
    }
}
