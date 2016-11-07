<?php

namespace BrofistTest\Couchbase\SearchCriteria;

use Brofist\Collection\Collection;
use Brofist\Couchbase\SearchCriteria\SearchCriteriaInterface;
use Brofist\Couchbase\SearchCriteria\SearchCriterias;
use PHPUnit_Framework_TestCase;
use Prophecy\Prophecy\ObjectProphecy;

class SearchCriteriasTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var SearchCriterias
     */
    protected $collection;

    /**
     * @var SearchCriteriaInterface | ObjectProphecy
     */
    private $criteria1;

    /**
     * @var SearchCriteriaInterface | ObjectProphecy
     */
    private $criteria2;

    /**
     * @before
     */
    public function initialize()
    {
        $this->criteria1 = $this->prophesize(SearchCriteriaInterface::class);
        $this->criteria2 = $this->prophesize(SearchCriteriaInterface::class);

        $this->collection = new SearchCriterias([
            $this->criteria1->reveal(),
            $this->criteria2->reveal(),
        ]);
    }

    /**
     * @test
     */
    public function extendsCollection()
    {
        $this->assertInstanceOf(Collection::class, $this->collection);
    }

    /**
     * @test
     */
    public function getItemInterface()
    {
        $this->assertEquals(
            SearchCriteriaInterface::class,
            $this->collection->getItemInterface()
        );
    }

    /**
     * @test
     */
    public function implementsSearchCriteriaInterface()
    {
        $this->assertInstanceOf(SearchCriteriaInterface::class, $this->collection);
    }

    /**
     * @test
     */
    public function toArray()
    {
        $expected = [
            $this->criteria1->reveal(),
            $this->criteria2->reveal(),
        ];

        $actual = $this->collection->toArray();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function getParams()
    {
        $this->criteria1->getParams()->willReturn(['foo' => 'bar']);
        $this->criteria2->getParams()->willReturn(['bar' => 'baz']);

        $expected = [
            'foo' => 'bar',
            'bar' => 'baz',
        ];

        $actual = $this->collection->getParams();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function canConvertToString()
    {
        $this->criteria1->__toString()->willReturn('criteria1');
        $this->criteria2->__toString()->willReturn('criteria2');

        $expected = 'criteria1 AND criteria2';

        $actual = (string) $this->collection;

        $this->assertEquals($expected, $actual);
    }
}
