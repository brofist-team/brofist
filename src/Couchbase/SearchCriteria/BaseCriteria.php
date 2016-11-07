<?php

namespace Brofist\Couchbase\SearchCriteria;

abstract class BaseCriteria implements SearchCriteriaInterface
{
    /**
     * @var string
     */
    private $field;

    /**
     * @var array
     */
    private $value;

    public function __construct(string $field, $value)
    {
        $this->field = $field;
        $this->value = $value;
    }

    abstract protected function getOperator() : string;

    public function getParams() : array
    {
        return [
            $this->getField() => $this->getValue(),
        ];
    }

    protected function getField() : string
    {
        return $this->field;
    }

    protected function getValue()
    {
        return $this->value;
    }

    protected function getFieldPlaceholder() : string
    {
        return '$' . $this->getField();
    }

    public function __toString()
    {
        return implode(' ', [$this->getField(), $this->getOperator(), $this->getFieldPlaceholder()]);
    }
}
