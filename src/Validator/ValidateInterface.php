<?php

namespace Brofist\Validator;

interface ValidateInterface
{
    /**
     * @param mixed $data
     *
     * @throws ValidationException when data is invalid
     */
    public function validate($data);
}
