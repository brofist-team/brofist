<?php

namespace Brofist\Csv;

abstract class AbstractParser implements CsvParserInterface
{
    /**
     * @string
     */
    private $separator = ';';

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        if (isset($options['separator'])) {
            $this->separator = $options['separator'];
        }
    }

    public function getSeparator() : string
    {
        return $this->separator;
    }
}
