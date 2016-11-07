<?php

require_once __DIR__ .  '/../vendor/autoload.php';

define('CB_HOST_AND_PORT', 'http://localhost:8091');
define('CB_USERNAME', 'Administrator');
define('CB_PASSWORD', 'password');
define('CB_TEST_BUCKET_NAME', 'test_bucket');

\Brofist\Test\Couchbase\BucketHelper::setConfig([
    'host'       => CB_HOST_AND_PORT,
    'username'   => CB_USERNAME,
    'password'   => CB_PASSWORD,
    'bucketName' => CB_TEST_BUCKET_NAME,
    'waitTime'   => 300000,
]);
