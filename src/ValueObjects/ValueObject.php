<?php

namespace Brofist\ValueObjects;

abstract class ValueObject
{
    /**
     * @var string
     */
    private $internalValue;

    public function __construct(string $value)
    {
        $this->internalValue = $value;
    }

    public function __toString() : string
    {
        return $this->internalValue;
    }

    public function equalTo(ValueObject $other) : bool
    {
        return $this->internalValue === $other->internalValue;
    }

    protected function getInternalValue() : string
    {
        return $this->internalValue;
    }
}
