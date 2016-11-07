<?php

namespace BrofistTest\ValueObjects;

use Brofist\ValueObjects\ValueObject;
use PHPUnit_Framework_TestCase;

class ValueObjectTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ValueObject
     */
    protected $valueObject;

    /**
     * @var ValueObject
     */
    protected $class;

    /**
     * @before
     */
    public function initialize()
    {
        $this->valueObject = $this->createObject('foobar');
    }

    /**
     * @test
     */
    public function canBeConvertedIntoAString()
    {
        $this->assertEquals('foobar', (string) $this->valueObject);
    }

    /**
     * @test
     */
    public function canBeCompared()
    {
        $this->assertTrue($this->valueObject->equalTo($this->createObject('foobar')));
        $this->assertFalse($this->valueObject->equalTo($this->createObject('foobarBaz')));
    }

    /**
     * @test
     */
    public function hasProtectedMethodGetValue()
    {
        $this->assertEquals('foobar', $this->valueObject->getTheValue());
    }

    private function createObject($value)
    {
        return new class ($value) extends ValueObject {
            public function getTheValue()
            {
                return $this->getInternalValue();
            }
        };
    }
}
