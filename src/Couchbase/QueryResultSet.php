<?php

namespace Brofist\Couchbase;

use Countable;

class QueryResultSet implements Countable
{
    /**
     * @var \stdClass
     */
    private $rawResult;

    public function __construct($rawResult)
    {
        $this->rawResult = $rawResult;
    }

    public function getRows() : array
    {
        return $this->rawResult->rows;
    }

    public function getData() : array
    {
        $data = [];

        foreach ($this->getRows() as $rows) {
            $data[] = array_values($rows)[0];
        }

        return $data;
    }

    /**
     * Either the first row or null
     *
     * @return array|null
     */
    public function first()
    {
        $data = $this->getData();
        return array_shift($data);
    }

    public function count()
    {
        return count($this->getData());
    }
}
