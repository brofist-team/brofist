<?php

namespace Brofist\Validator;

abstract class AbstractValidator implements ValidatorInterface, ValidateInterface
{
    /**
     * @var array
     */
    private $errors = [];

    /**
     * To make data invalid, just add as much errors as you want to the collection
     * during the validation routine:
     *
     *  $this->addError('error 1');
     *  $this->addError('error 2');
     *
     * @param mixed data
     */
    abstract protected function performValidation($data);

    protected function clearErrors()
    {
        $this->errors = [];
    }

    /**
     * @param string $error
     */
    protected function addError($error)
    {
        $this->errors[] = $error;
    }

    public function getErrorMessages()
    {
        return $this->errors;
    }

    public function isValid($data)
    {
        $this->clearErrors();
        $this->performValidation($data);
        return empty($this->getErrorMessages());
    }

    public function validate($data)
    {
        if ($this->isValid($data)) {
            return;
        }

        throw new ValidationException($this->getErrorMessages());
    }
}
