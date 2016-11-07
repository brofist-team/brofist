<?php

namespace Brofist\Couchbase;

use Brofist\Couchbase\SearchCriteria\EqualTo;
use Brofist\Couchbase\SearchCriteria\SearchCriteriaInterface;
use Brofist\Couchbase\SearchCriteria\SearchCriterias;

class QueryBuilder
{
    /**
     * @var string
     */
    private $from;

    /**
     * @var SearchCriterias
     */
    private $searchCriterias;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var int
     */
    private $offset;

    public function __construct()
    {
        $this->searchCriterias = new SearchCriterias();
    }

    /**
     * @return QueryBuilder
     */
    public function create() : QueryBuilder
    {
        return clone $this;
    }

    public function from(string $from) : QueryBuilder
    {
        $new = clone $this;
        $new->from = $from;
        return $new;
    }

    public function where(array $conditions) : QueryBuilder
    {
        $new = clone $this;

        foreach ($conditions as $field => $value) {
            if (!($value instanceof SearchCriteriaInterface)) {
                $value = new EqualTo($field, $value);
            }

            $new = $new->withSearchCriteria($value);
        }

        return $new;
    }

    public function withSearchCriteria(SearchCriteriaInterface $criteria) : QueryBuilder
    {
        $new = clone $this;
        $new->getSearchCriterias()->add($criteria);
        return $new;
    }

    public function limit(int $limit, int $offset = 0) : QueryBuilder
    {
        $new = clone $this;
        $new->limit = $limit;
        $new->offset = $offset;

        return $new;
    }

    public function getSearchCriterias() : SearchCriterias
    {
        return $this->searchCriterias;
    }

    public function __toString()
    {
        $query = [];

        if ($this->from) {
            $query[] = sprintf('SELECT * FROM `%s`', $this->from);
        }

        if ($this->getSearchCriterias()->count()) {
            $query[] = 'WHERE ' . $this->getSearchCriterias();
        }

        if ($this->limit) {
            $query[] = 'LIMIT ' . $this->limit;

            if ($this->offset !== 0) {
                $query[] = 'OFFSET ' . $this->offset;
            }
        }

        return implode(' ', $query);
    }

    public function __clone()
    {
        $this->searchCriterias = clone $this->searchCriterias;
    }
}
