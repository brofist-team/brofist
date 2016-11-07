<?php

namespace Brofist\TestHydrator;

use Brofist\Hydrator\HydratorInterface;
use Brofist\Hydrator\ZendHydratorAdapter;
use PHPUnit_Framework_TestCase;
use Zend\Hydrator\HydratorInterface as ZendHydratorInterface;

class ZendHydratorAdapterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ZendHydratorAdapter
     */
    protected $hydrator;

    /**
     * @var ZendHydratorInterface
     */
    protected $zendHydrator;

    /**
     * @before
     */
    public function initialize()
    {
        $this->zendHydrator = $this->prophesize(ZendHydratorInterface::class);
        $this->hydrator = new ZendHydratorAdapter($this->zendHydrator->reveal());
    }

    /**
     * @test
     */
    public function implementsHydratorInterface()
    {
        $this->assertInstanceOf(HydratorInterface::class, $this->hydrator);
    }

    /**
     * @test
     */
    public function delegatesHydrationToTheZendHydratorAndReturnsZendHydratorAndReturnsObjectEvenIfZendWontReturnIt()
    {
        $object = new \stdClass();
        $data = [];

        $this->zendHydrator->hydrate($data, $object)->shouldBeCalled();
        $actual = $this->hydrator->hydrate($data, $object);

        $this->assertEquals($object, $actual);
    }

    /**
     * @test
     */
    public function delegatesHydrationAndReturnsObject()
    {
        $object = new \stdClass();
        $data = [];

        $this->zendHydrator->hydrate($data, $object)->willReturn('foo');

        $actual = $this->hydrator->hydrate($data, $object);

        $this->assertEquals('foo', $actual);
    }

    /**
     * @test
     */
    public function canDelegateExtractMethod()
    {
        $object = new \stdClass();
        $data = [];

        $this->zendHydrator->extract($object)->willReturn($data);

        $actual = $this->hydrator->extract($object);

        $this->assertEquals($data, $actual);
    }
}
