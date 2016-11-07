<?php

namespace BrofistTest\Hydrator;

use Brofist\Hydrator\CollectionHydrator;
use Brofist\Hydrator\HydratorInterface;
use Prophecy\Prophecy\ObjectProphecy;

class CollectionHydratorTest extends \PHPUnit_Framework_TestCase
{
    /** @var  HydratorInterface | ObjectProphecy */
    private $hydratorInterface;

    public function setUp()
    {
        $this->hydratorInterface = $this->prophesize(HydratorInterface::class);
    }

    /**
     * @test
     */
    public function hydrateIncentiveCollection()
    {
        $collection = [
            ["keyword" => "keyword1"],
            ["keyword" => "keyword2"],
        ];

        $entity = new \StdClass();

        $this->hydratorInterface->hydrate($collection[0], $entity)
            ->willReturn($entity);

        $this->hydratorInterface->hydrate($collection[1], $entity)
            ->willReturn($entity);

        $expectedCollection = [
            new \StdClass(),
            new \StdClass(),
        ];

        $collectionHydrator = new CollectionHydrator($this->hydratorInterface->reveal());

        $actualCollection = $collectionHydrator->hydrateCollection($collection, new \StdClass());

        $this->assertEquals($expectedCollection, $actualCollection);
    }
}
