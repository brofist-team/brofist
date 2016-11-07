<?php

namespace BrofistTest\ValueObjects;

use Brofist\ValueObjects\DateTime;
use PHPUnit_Framework_TestCase;

class DateTimeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var DateTime
     */
    protected $time;

    /**
     * @before
     */
    public function initialize()
    {
        $this->time = new DateTime();
    }

    /**
     * @test
     */
    public function extendsPhpDateTimeImmutable()
    {
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->time);
    }

    /**
     * @test
     */
    public function canConvertDateToUtc()
    {
        $actual = $this->time->toUtc();

        $newTime = clone $this->time;
        $expected = $newTime->setTimezone(new \DateTimeZone('UTC'));

        $this->assertEquals($expected, $actual);

        $this->assertNotSame($actual, $this->time->toUtc());
    }

    /**
     * @test
     */
    public function canConvertToString()
    {
        $time = new DateTime('2001-02-03 04:05:06.0');

        $expected = '2001-02-03 04:05:06';

        $this->assertEquals($expected, (string) $time);
    }
}
