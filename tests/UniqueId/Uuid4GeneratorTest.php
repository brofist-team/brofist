<?php

namespace BrofistTest\UniqueId;

use Brofist\UniqueId\UniqueIdGeneratorInterface;
use Brofist\UniqueId\Uuid4Generator;
use PHPUnit_Framework_TestCase;

class Uuid4GeneratorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Uuid4Generator
     */
    protected $service;

    /**
     * @before
     */
    public function initialize()
    {
        $this->service = new Uuid4Generator();
    }

    /**
     * @test
     */
    public function implementsCorrectInterface()
    {
        $this->assertInstanceOf(UniqueIdGeneratorInterface::class, $this->service);
    }

    /**
     * @test
     */
    public function returnsAString()
    {
        $this->assertNotNull($this->service->generate());
    }
}
