<?php

namespace BrofistTest\Csv;

use Brofist\Csv\NamedColumnsParser;
use PHPUnit_Framework_TestCase;

class NamedColumnsParserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var NamedColumnsParser
     */
    protected $parser;

    /**
     * @before
     */
    public function initialize()
    {
        $this->parser = new NamedColumnsParser();
    }

    /**
     * @test
     */
    public function defaultSeparatorIsComa()
    {
        $this->assertEquals(';', $this->parser->getSeparator());
    }

    /**
     * @test
     */
    public function canMutateSeparator()
    {
        $this->parser = new NamedColumnsParser(['separator' => '|']);

        $this->assertEquals('|', $this->parser->getSeparator());
    }

    /**
     * @test
     */
    public function implementsCorrectInterface()
    {
        $this->assertInstanceOf('Brofist\Csv\CsvParserInterface', $this->parser);
    }

    /**
     * @test
     */
    public function readMapsCorrectDataCorrectly()
    {
        $input = <<<EOT
name;age
foo;10
bar;20
EOT;

        $expected = [
            ['name' => 'foo', 'age' => 10],
            ['name' => 'bar', 'age' => 20],
        ];

        $actual = $this->parser->parse($input);

        $this->assertEquals($expected, $actual);
    }
}
