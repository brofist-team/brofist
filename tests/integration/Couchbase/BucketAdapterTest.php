<?php

namespace BrofistTest\Integration\Couchbase;

use Brofist\Couchbase\BucketAdapter;
use Brofist\Test\Couchbase\BucketHelper;
use PHPUnit_Framework_TestCase;

class BucketAdapterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var BucketAdapter
     */
    protected $service;

    /**
     * @before
     */
    public function initialize()
    {
        $this->service = BucketHelper::createEmptyAdapter();
    }

    /**
     * @test
     */
    public function itCanFindAll()
    {
        $records = $this->service->findAllBy([]);
        $this->assertCount(0, $records->getData());
    }

    /**
     * @test
     */
    public function canCreateWithoutId()
    {
        $data1 = ['name' => 'foo'];
        $data2 = ['name' => 'bar'];

        $data1['_id'] = (string) $this->service->create($data1);
        $data2['_id'] = (string) $this->service->create($data2);

        BucketHelper::wait();

        $this->assertEquals(
            $data1,
            $this->service->findOneBy(['_id' => $data1['_id']])->first()
        );

        $this->assertEquals(
            $data2,
            $this->service->findOneBy(['_id' => $data2['_id']])->first()
        );
    }
}
