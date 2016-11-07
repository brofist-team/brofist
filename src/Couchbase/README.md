Brofist Couchbase
-------------------


```php
<?php

use Brofist\Couchbase\BucketAdapter;
use Brofist\Couchbase\SearchCriteria\GreaterThanOrEqualTo;
use Brofist\Couchbase\QueryResultSet;

/* @var \CouchbaseBucket $couchbase */
$bucketName = 'users';
$adapter = new BucketAdapter($couchbase, $bucketName);
```

### Querying:

```php
<?php
/* @var QueryResultSet $users */
$users = $adapter->findAllBy([
    'lastName' => 'Jacobus',
]);

$users = $adapter->findAllBy([
    'lastName' => 'Jacobus',
    new GreaterThanOrEqualTo("age", 18)
]);

```

### Inserting/Updating:

```php
<?php

$adapter->insert('someId', [
    'name'     => 'John',
    'lastMame' => 'Doe',
]);

// or
$adapter->insert('someId', [
    'name'     => 'John',
    'lastMame' => 'Doe',
]);

```

### Deleting

```php
<?php

$adapter->delete('someId');
```
