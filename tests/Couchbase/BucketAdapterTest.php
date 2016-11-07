<?php

namespace BrofistTest\Couchbase;

use Brofist\Couchbase\BucketAdapter;
use Brofist\Couchbase\QueryResultSet;
use Brofist\Couchbase\SearchCriteria\GreaterThanOrEqualTo;
use CouchbaseBucket;
use CouchbaseN1qlQuery;
use PHPUnit_Framework_TestCase;
use Prophecy\Prophecy\ObjectProphecy;

class BucketAdapterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var BucketAdapter
     */
    protected $adapter;

    /**
     * @var CouchbaseBucket | ObjectProphecy
     */
    protected $bucket;

    /**
     * @before
     */
    public function initialize()
    {
        $this->bucket = $this->prophesize(CouchbaseBucket::class);
        $this->adapter = new BucketAdapter($this->bucket->reveal(), 'bucketName');
    }

    /**
     * @test
     */
    public function canFindObjectsByQuery()
    {
        $this->mockQuery('SELECT * FROM `bucketName`');

        $actual = $this->adapter->findAll();

        $this->assertEquals(new QueryResultSet(new \StdClass()), $actual);
    }

    /**
     * @test
     */
    public function canFindAllByConditions()
    {
        $query = $this->mockQuery('SELECT * FROM `bucketName` WHERE foo = $foo AND bar = $bar');

        $query->namedParams([
            'foo' => 'fooValue',
            'bar' => 'barValue',
        ]);

        $actual = $this->adapter->findAllBy([
            'foo' => 'fooValue',
            'bar' => 'barValue',
        ]);

        $this->assertEquals(new QueryResultSet(new \StdClass()), $actual);
    }

    /**
     * @test
     */
    public function canPersistData()
    {
        $this->bucket->upsert('foo', ['bar'], ['options'])->wilLReturn('returnValue');

        $data = $this->adapter->persist('foo', ['bar'], ['options']);

        $this->assertEquals('returnValue', $data);
    }

    /**
     * @test
     */
    public function canInsertData()
    {
        $this->bucket->insert('foo', ['bar'], ['options'])->wilLReturn('returnValue');

        $data = $this->adapter->insert('foo', ['bar'], ['options']);

        $this->assertEquals('returnValue', $data);
    }

    /**
     * @test
     */
    public function canFindAllByConditionsAndLimit()
    {
        $query = $this->mockQuery('SELECT * FROM `bucketName` WHERE foo = $foo AND bar = $bar LIMIT 1');

        $query->namedParams([
            'foo' => 'fooValue',
            'bar' => 'barValue',
        ]);

        $actual = $this->adapter->findAllBy(
            [
                'foo' => 'fooValue',
                'bar' => 'barValue',
            ],
            [
                'limit' => 1,
            ]
        );

        $this->assertEquals(new QueryResultSet(new \StdClass()), $actual);
    }

    /**
     * @test
     */
    public function canFindOneByConditions()
    {
        $query = $this->mockQuery('SELECT * FROM `bucketName` WHERE foo = $foo AND bar = $bar LIMIT 1');

        $query->namedParams([
            'foo' => 'fooValue',
            'bar' => 'barValue',
        ]);

        $actual = $this->adapter->findOneBy(
            [
                'foo' => 'fooValue',
                'bar' => 'barValue',
            ]
        );

        $this->assertEquals(new QueryResultSet(new \StdClass()), $actual);
    }

    /**
     * @test
     */
    public function canFindBySearchCriterias()
    {
        $query = $this->mockQuery('SELECT * FROM `bucketName` WHERE foo = $foo AND age >= $age LIMIT 1');
        $ageCriteria = new GreaterThanOrEqualTo('age', 18);

        $query->namedParams([
            'foo' => 'fooValue',
            'age' => '18',
        ]);

        $actual = $this->adapter->findOneBy(
            [
                'foo' => 'fooValue',
                $ageCriteria
            ]
        );

        $this->assertEquals(new QueryResultSet(new \StdClass()), $actual);
    }

    /**
     * @test
     */
    public function canRemoveRecords()
    {
        $this->bucket->remove('foo', ['options'])->willReturn('foo');

        $actual = $this->adapter->remove('foo', ['options']);

        $this->assertEquals('foo', $actual);
    }

    private function mockQuery($string)
    {
        $expectedQuery = CouchbaseN1qlQuery::fromString($string);

        $this->bucket->query($expectedQuery, true)->willReturn(new \stdClass());

        return $expectedQuery;
    }
}
