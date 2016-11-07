<?php

namespace BrofistTest\Validator;

use Brofist\Validator\AbstractValidator;
use Brofist\Validator\ValidateInterface;
use Brofist\Validator\ValidationException;
use Brofist\Validator\ValidatorInterface;
use PHPUnit_Framework_TestCase;

class AbstractValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractValidator
     */
    protected $validator;

    /**
     * @before
     */
    public function initialize()
    {
        $this->validator = new class() extends AbstractValidator {
            protected function performValidation($data)
            {
                if ($data != 'validData') {
                    $this->addError('Invalid Data');
                }
            }
        };
    }

    /**
     * @test
     */
    public function implementsValidatInterface()
    {
        $this->assertInstanceOf(ValidateInterface::class, $this->validator);
    }

    /**
     * @test
     */
    public function implementsValidatorInterface()
    {
        $this->assertInstanceOf(ValidatorInterface::class, $this->validator);
    }

    /**
     * @test
     */
    public function canValidateData()
    {
        $this->assertFalse($this->validator->isValid('data'));
        $this->assertTrue($this->validator->isValid('validData'));
    }

    /**
     * @test
     */
    public function validateThrowsExceptionWhenInvalid()
    {
        try {
            $this->validator->validate('invalid');
            $this->fail('Should have thrown an exception');
        } catch (ValidationException $e) {
            $expected = new ValidationException(['Invalid Data']);
            $this->assertEquals($expected, $e);
        }

        $this->validator->validate('validData');
    }
}
