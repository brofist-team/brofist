<?php

namespace Brofist\Csv;

interface CsvParserInterface
{
    public function getSeparator() : string;

    public function parse(string $content) : array;
}
