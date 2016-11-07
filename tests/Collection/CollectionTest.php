<?php

namespace BrofistTest\Collection;

use Brofist\Collection\Collection;
use PHPUnit_Framework_TestCase;

class CollectionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var array
     */
    private $items = [];

    /**
     * @before
     */
    public function initialize()
    {
        $item1 = new \stdClass();
        $item1->name = 'one';
        $item2 = new \stdClass();
        $item2->name = 'two';

        $this->items[] = $item1;
        $this->items[] = $item2;

        $this->collection = new Collection(\stdClass::class, [$item1, $item2]);
    }

    /**
     * @test
     */
    public function canBeUsedAsArray()
    {
        $this->assertInstanceOf(\Traversable::class, $this->collection);
    }

    /**
     * @test
     */
    public function implementsCountable()
    {
        $this->assertInstanceOf(\Countable::class, $this->collection);
        $this->assertSame(2, $this->collection->count());
    }

    /**
     * @test
     */
    public function behaveLikeArray()
    {
        $expected = ['one' => 0, 'two' => 1];
        $actual = [];

        foreach ($this->collection as $i => $item) {
            $actual[$item->name] = $i;
        }

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function canAddItems()
    {
        $item = new \stdClass();
        $item->name = 'three';

        $this->collection->add($item);

        $expected = $this->items;
        $expected[] = $item;

        $this->assertEquals($expected, $this->collection->toArray());
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Item must implement "stdClass"
     */
    public function addOnlyTakesItemsWithTheGivenConstructorInterface()
    {
        $this->collection->add('foo');
    }

    /**
     * @test
     */
    public function canRemoveItem()
    {
        $one = $this->create('one');
        $two = $this->create('two');
        $three = $this->create('three');

        $collection = new Collection('stdClass', [$one, $three]);

        $collection->remove($two);
        $collection->remove($three);
        $collection->add($two)->add($three);

        $data = [];

        foreach ($collection as $item) {
            $data[] = $item->name;
        }

        foreach ($collection as $item) {
            $data[] = $item->name;
        }

        $expected = ['one', 'two', 'three', 'one', 'two', 'three'];

        $this->assertEquals($expected, $data);
    }

    private function create($name)
    {
        $object = new \stdClass();
        $object->name = $name;
        return $object;
    }
}
