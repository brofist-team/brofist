<?php

namespace Brofist\Couchbase\SearchCriteria;

use Brofist\Collection\Collection;

class SearchCriterias extends Collection implements SearchCriteriaInterface
{
    public function __construct(array $items = [])
    {
        parent::__construct(SearchCriteriaInterface::class, $items);
    }

    public function getParams() : array
    {
        $params = [];

        foreach ($this as $criteria) {
            $params = array_merge($params, $criteria->getParams());
        }

        return $params;
    }

    public function __toString()
    {
        $criterias = [];

        foreach ($this as $criteria) {
            $criterias[] = $criteria;
        }

        return implode(' AND ', $criterias);
    }
}
