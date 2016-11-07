<?php

namespace BrofistTest\Couchbase;

use Brofist\Couchbase\QueryBuilder;
use Brofist\Couchbase\SearchCriteria\GreaterThanOrEqualTo;
use Brofist\Couchbase\SearchCriteria\SearchCriteriaInterface;
use PHPUnit_Framework_TestCase;

class QueryBuilderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var QueryBuilder
     */
    protected $object;

    /**
     * @var QueryBuilder
     */
    protected $lastObject;

    /**
     * @before
     */
    public function initialize()
    {
        $this->object = new QueryBuilder();
        $this->lastObject = $this->object;
    }

    /**
     * @test
     */
    public function canCreateSelectQueryFromBucket()
    {
        $object = $this->object->create();
        $this->assertImmutable($object);

        $from = $object->from('bucketName');
        $this->assertImmutable($from);
        $this->assertString('SELECT * FROM `bucketName`');

        $where = $from->where(['name' => 'John', 'lastname' => 'Doe']);
        $this->assertImmutable($where);
        $this->assertString('SELECT * FROM `bucketName` WHERE name = $name AND lastname = $lastname');

        $limited = $from->limit('1');
        $this->assertImmutable($limited);
        $this->assertString('SELECT * FROM `bucketName` LIMIT 1');

        $limited = $where->limit(10, 7);
        $this->assertImmutable($limited);
        $this->assertString('SELECT * FROM `bucketName` WHERE name = $name AND lastname = $lastname LIMIT 10 OFFSET 7');
    }

    /**
     * @test
     */
    public function canCreateSelectQueryFromBucketWithCustomCriterias()
    {
        $object = $this->object->create();
        $this->assertImmutable($object);

        $from = $object->from('bucketName');
        $this->assertImmutable($from);
        $this->assertString('SELECT * FROM `bucketName`');

        $where = $from->where(['name' => 'John', new GreaterThanOrEqualTo('age', 18)]);
        $this->assertImmutable($where);
        $this->assertString('SELECT * FROM `bucketName` WHERE name = $name AND age >= $age');
    }

    private function assertImmutable(QueryBuilder $builder)
    {
        $this->assertNotSame($this->lastObject, $builder);
        $this->lastObject = $builder;
    }

    public function assertString($string)
    {
        $this->assertEquals($string, (string) $this->lastObject);
    }

    /**
     * @test
     */
    public function canAppendSearchCriterias()
    {
        $this->lastObject = $this->object;

        $criteria = $this->prophesize(SearchCriteriaInterface::class)->reveal();

        $object = $this->object->withSearchCriteria($criteria);
        $this->assertImmutable($object);

        $this->assertNotSame(
            $this->object->getSearchCriterias(),
            $object->getSearchCriterias()
        );

        $this->assertSame(0, $this->object->getSearchCriterias()->count());
        $this->assertSame(1, $object->getSearchCriterias()->count());
    }
}
