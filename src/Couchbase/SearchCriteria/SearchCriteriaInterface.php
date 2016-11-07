<?php

namespace Brofist\Couchbase\SearchCriteria;

interface SearchCriteriaInterface
{
    public function __toString();

    public function getParams() : array;
}
