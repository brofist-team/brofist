<?php

namespace BrofistTest\Validator;

use Brofist\Validator\ValidationException;
use PHPUnit_Framework_TestCase;

class ValidationExceptionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function extendsDomainException()
    {
        $this->assertInstanceOf(\DomainException::class, new ValidationException());
    }

    /**
     * @test
     */
    public function canBeConstrcutedWithErrorMessages()
    {
        $exception = new ValidationException(['error1', 'error2']);

        $expected = "error1, error2";

        $this->assertEquals($expected, $exception->getMessage());
    }

    /**
     * @test
     */
    public function canGetValidationErrors()
    {
        $errors = ['error1', 'error2'];
        $exception = new ValidationException($errors);

        $this->assertEquals($errors, $exception->getValidationErrors());
    }

    /**
     * @test
     */
    public function canSetCodeAndPreviousException()
    {
        $previous = new \Exception();
        $exception = new ValidationException([], 2, $previous);

        $this->assertSame($previous, $exception->getPrevious());
        $this->assertSame(2, $exception->getCode());
    }
}
