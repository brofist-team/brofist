<?php

namespace Brofist\Validator;

interface ValidatorInterface
{
    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isValid($value);

    /**
     * @return string[]
     */
    public function getErrorMessages();
}
