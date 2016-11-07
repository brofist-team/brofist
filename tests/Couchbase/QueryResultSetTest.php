<?php

namespace BrofistTest\Couchbase;

use Brofist\Couchbase\QueryResultSet;
use PHPUnit_Framework_TestCase;

class QueryResultSetTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var QueryResultSet
     */
    protected $object;

    /**
     * @before
     */
    public function initialize()
    {
        $object = new \stdClass();

        $object->rows = [
            [
                'bucketName' => [
                    'id'    => '1',
                    'value' => 'v1',
                ]
            ],
            [
                'bucketName' => [
                    'id'    => '2',
                    'value' => 'v2',
                ]
            ]
        ];

        $this->object = new QueryResultSet($object);
    }

    /**
     * @test
     */
    public function canGetData()
    {
        $expected = [
            [
                'id'    => '1',
                'value' => 'v1',
            ],
            [
                'id'    => '2',
                'value' => 'v2',
            ],
        ];

        $actual = $this->object->getData();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function firstReturnsFirstResultWhenFound()
    {
        $actual = $this->object->first();

        $this->assertEquals(['id' => '1', 'value' => 'v1'], $actual);
    }

    /**
     * @test
     */
    public function firstReturnsNullWhenNoDataExists()
    {
        $object = new \stdClass();
        $object->rows = [];
        $this->object = new QueryResultSet($object);

        $actual = $this->object->first();

        $this->assertNull($actual);
    }
}
