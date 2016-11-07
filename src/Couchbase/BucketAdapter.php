<?php

namespace Brofist\Couchbase;

use Brofist\UniqueId\UniqueId;
use Brofist\UniqueId\Uuid4Generator;
use CouchbaseBucket;
use CouchbaseException;
use CouchbaseN1qlQuery;

class BucketAdapter
{
    const OPTION_LIMIT = 'limit';

    /**
     * @var QueryBuilder
     */
    private $queryBuilder;

    /**
     * @var CouchbaseBucket
     */
    private $bucket;

    /**
     * @var string
     */
    private $bucketName;

    /**
     * @param CouchbaseBucket $bucket
     * @param string $bucketName
     */
    public function __construct(CouchbaseBucket $bucket, $bucketName)
    {
        $this->queryBuilder = new QueryBuilder();
        $this->bucket = $bucket;
        $this->bucketName = $bucketName;
        $this->idGenerator = new Uuid4Generator();
    }

    /**
     * @see CouchbaseBucket::insert()
     *
     * @throws CouchbaseException
     *
     * @return mixed
     */
    public function insert(string $id, array $data, array $options = [])
    {
        return $this->getBucket()->insert($id, $data, $options);
    }


    /**
     * @throws CouchbaseException
     */
    public function create(array $data, array $options = []) : UniqueId
    {
        $id = $this->idGenerator->generate();
        $data['_id'] = (string) $id;
        $this->insert($id, $data, $options);
        return $id;
    }

    /**
     * @see CouchbaseBucket::upsert()
     *
     * @throws CouchbaseException
     *
     * @return mixed
     */
    public function persist(string $id, array $data, array $options = [])
    {
        return $this->getBucket()->upsert($id, $data, $options);
    }


    /**
     * @see CouchbaseBucket::remove()
     *
     * @param string|array $id
     *
     * @throws CouchbaseException
     *
     * @return mixed
     */
    public function remove($id, array $options = [])
    {
        return $this->getBucket()->remove($id, $options);
    }

    /**
     * @throws CouchbaseException
     */
    public function findAll() : QueryResultSet
    {
        return $this->fetchAll($this->select());
    }

    /**
     * @param array $options 'limit' is an option
     *
     * @throws CouchbaseException
     */
    public function findAllBy(array $conditions, array $options = []) : QueryResultSet
    {
        $query = $this->select();
        $query = $this->applyOptions($query, $options);

        return $this->fetchAll($query, $conditions);
    }

    /**
     * @throws CouchbaseException
     */
    public function findOneBy(array $conditions) : QueryResultSet
    {
        return $this->findAllBy($conditions, ['limit' => 1]);
    }

    /**
     * @throws CouchbaseException
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    protected function fetchAll(QueryBuilder $query, array $conditions = []) : QueryResultSet
    {
        $query = $query->where($conditions);
        $n1ql = CouchbaseN1qlQuery::fromString((string) $query);

        $params = $query->getSearchCriterias()->getParams();
        $n1ql->namedParams($params);

        return new QueryResultSet($this->getBucket()->query($n1ql, true));
    }

    private function applyOptions(QueryBuilder $query, array $options) : QueryBuilder
    {
        if (array_key_exists(self::OPTION_LIMIT, $options)) {
            $query = $query->limit($options[self::OPTION_LIMIT]);
        }

        return $query;
    }

    protected function getBucket() : CouchbaseBucket
    {
        return $this->bucket;
    }

    private function select() : QueryBuilder
    {
        return $this->queryBuilder->from($this->bucketName);
    }
}
