<?php

namespace BrofistTest\ValueObjects;

use Brofist\ValueObjects\EmailAddress;
use PHPUnit_Framework_TestCase;

class EmailAddressTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var EmailAddress
     */
    protected $email;

    /**
     * @before
     */
    public function initialize()
    {
        $this->email = new EmailAddress('some@address.com');
    }

    /**
     * @test
     */
    public function canConvertToString()
    {
        $this->assertEquals('some@address.com', (string) $this->email);
    }
}
