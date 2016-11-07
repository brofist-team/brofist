<?php

namespace BrofistTest\UniqueId;

use Brofist\UniqueId\UniqueId;
use Brofist\ValueObjects\Id;
use PHPUnit_Framework_TestCase;

class UniqueIdTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var UniqueId
     */
    protected $uniqueId;

    /**
     * @before
     */
    public function initialize()
    {
        $this->uniqueId = new UniqueId('someString');
    }

    /**
     * @test
     */
    public function convertsToString()
    {
        $this->assertEquals('someString', (string) $this->uniqueId);
    }

    /**
     * @test
     */
    public function extendsId()
    {
        $this->assertInstanceOf(Id::class, $this->uniqueId);
    }
}
