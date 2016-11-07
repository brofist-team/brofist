<?php

namespace BrofistTest\ValueObjects;

use Brofist\ValueObjects\Id;
use Brofist\ValueObjects\ValueObject;
use PHPUnit_Framework_TestCase;

class IdTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Id
     */
    protected $id;

    /**
     * @before
     */
    public function initialize()
    {
        $this->id = new Id('some id');
    }

    /**
     * @test
     */
    public function inheritsFromUniqueId()
    {
        $this->assertInstanceOf(ValueObject::class, $this->id);
    }
}
