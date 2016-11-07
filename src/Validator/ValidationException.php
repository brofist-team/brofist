<?php

namespace Brofist\Validator;

class ValidationException extends \DomainException
{
    /**
     * @var array
     */
    private $validationErrors;

    /**
     * @param array $validationErrors
     * @param int $code
     * @param \Exception $code
     */
    public function __construct(
        array $validationErrors = [],
        $code = 0,
        \Exception $previous = null
    ) {
        $this->validationErrors = $validationErrors;
        $message = implode(', ', $validationErrors);
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return array
     */
    public function getValidationErrors()
    {
        return $this->validationErrors;
    }
}
