<?php

namespace Brofist\Csv;

use PHPUnit_Framework_TestCase;

class ArrayToCsvTest extends PHPUnit_Framework_TestCase
{
    /** @var ArrayToCsv */
    protected $service;

    public function setUp()
    {
        $this->service = new ArrayToCsv([
            'delimiter' => ';',
        ]);
    }

    /**
     * @test
     */
    public function convertsArrayToCsv()
    {
        $data = [
            ['foo', 'bar', 'baz'],
            ['2001-01-01', 'Hey "you"; sup?', 'what is up'],
        ];

        $expected = <<<EOT
foo;bar;baz
2001-01-01;"Hey ""you""; sup?";"what is up"

EOT;

        $actual = $this->service->toCsv($data);
        $this->assertEquals($expected, $actual);
    }
}
