<?php

namespace Brofist\Filter;

interface FilterInterface
{
    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function filter($value);
}
