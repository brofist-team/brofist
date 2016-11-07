<?php

namespace BrofistTest\Couchbase\SearchCriteria;

use Brofist\Couchbase\SearchCriteria\BaseCriteria;
use Brofist\Couchbase\SearchCriteria\SearchCriteriaInterface;
use PHPUnit_Framework_TestCase;

class BaseCriteriaTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var BaseCriteria
     */
    protected $criteria;

    /**
     * @before
     */
    public function initialize()
    {
        $this->criteria = new class ('foo', 'bar') extends BaseCriteria {
            protected function getOperator() : string
            {
                return 'operator';
            }
        };
    }

    /**
     * @test
     */
    public function implementsCorrectInterface()
    {
        $this->assertInstanceOf(SearchCriteriaInterface::class, $this->criteria);
    }

    /**
     * @test
     */
    public function convertsToString()
    {
        $expected = 'foo operator $foo';

        $this->assertEquals($expected, (string) $this->criteria);
    }

    /**
     * @test
     */
    public function getParams()
    {
        $expected = ['foo' => 'bar'];

        $this->assertEquals($expected, $this->criteria->getParams());
    }
}
