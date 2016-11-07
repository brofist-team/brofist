<?php

namespace BrofistTest\Couchbase\SearchCriteria;

use Brofist\Couchbase\SearchCriteria\BaseCriteria;
use Brofist\Couchbase\SearchCriteria\EqualTo;
use PHPUnit_Framework_TestCase;

class EqualToTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var EqualTo
     */
    protected $criteria;

    /**
     * @before
     */
    public function initialize()
    {
        $this->criteria = new EqualTo('age', 18);
    }

    /**
     * @test
     */
    public function implementsCorrectInterface()
    {
        $this->assertInstanceOf(BaseCriteria::class, $this->criteria);
    }

    /**
     * @test
     */
    public function convertsToString()
    {
        $expected = 'age = $age';

        $this->assertEquals($expected, (string) $this->criteria);
    }
}
