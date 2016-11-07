<?php

namespace Brofisttests\Csv;

use Brofist\Csv\MappedColumnsParser;
use PHPUnit_Framework_TestCase;

class MappedColumnsParserTest extends PHPUnit_Framework_TestCase
{
    /** @var MappedColumnsParser */
    protected $parser;

    public function setUp()
    {
        $this->parser = new MappedColumnsParser(
            [
                'columns' => ['name', 'age'],
            ]
        );
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
        $this->parser = new MappedColumnsParser(
            [
                'separator' => '|',
                'columns'   => ['foo'],
            ]
        );

        $this->assertEquals('|', $this->parser->getSeparator());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function throwsExceptionWhenProvidedColumnsIsEmpty()
    {
        new MappedColumnsParser(['columns' => []]);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function throwsExceptionWhenNoColumnsIsGiven()
    {
        new MappedColumnsParser();
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
foo;10
"bar;baz";20

EOT;

        $expected = [
            ['name' => 'foo',     'age' => 10],
            ['name' => 'bar;baz', 'age' => 20],
        ];

        $actual = $this->parser->parse($input);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Column 'age' (offset 1) does not exist
     */
    public function readThrowsExceptionWhenIndexDoesNotExist()
    {
        $input = <<<EOT
foo
bar
EOT;

        $this->parser->parse($input);
    }
}
