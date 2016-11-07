<?php

namespace Brofist\Couchbase\SearchCriteria;

class GreaterThanOrEqualTo extends BaseCriteria
{
    protected function getOperator() : string
    {
        return '>=';
    }
}
