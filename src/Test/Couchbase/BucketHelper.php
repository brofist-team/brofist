<?php

namespace Brofist\Test\Couchbase;

use Brofist\Couchbase\BucketAdapter;
use CouchbaseBucket;
use CouchbaseCluster;
use CouchbaseN1qlQuery;

class BucketHelper
{
    private static $config = [
        'waitTime' => 300000,
    ];

    public static function setConfig(array $config)
    {
        foreach ($config as $key => $value) {
            self::$config[$key] = $value;
        }
    }

    public static function getConfig(string $key) : string
    {
        if (isset(self::$config[$key])) {
            return self::$config[$key];
        }

        throw new \InvalidArgumentException(sprintf('Key "%s" does not exist'), $key);
    }

    public static function create() : CouchbaseBucket
    {
        $cluster = new CouchbaseCluster(
            self::getConfig('host'),
            self::getConfig('username'),
            self::getConfig('password')
        );

        return $cluster->openBucket(self::getConfig('bucketName'));
    }

    public static function truncate(CouchbaseBucket $bucket = null)
    {
        $bucket = $bucket ?? self::create();

        $query = CouchbaseN1qlQuery::fromString(
            sprintf('DELETE FROM %s', self::getConfig('bucketName'))
        );
        $bucket->query($query);
    }

    public static function createAdapter() : BucketAdapter
    {
        return new BucketAdapter(self::create(), CB_TEST_BUCKET_NAME);
    }

    public static function createEmptyAdapter() : BucketAdapter
    {
        self::truncate();
        return self::createAdapter();
    }

    public static function wait()
    {
        usleep(self::getConfig('waitTime'));
    }
}
