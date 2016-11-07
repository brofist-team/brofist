<?php

namespace Brofist\Couchbase\SearchCriteria;

class EqualTo extends BaseCriteria
{
    protected function getOperator() : string
    {
        return '=';
    }
}
