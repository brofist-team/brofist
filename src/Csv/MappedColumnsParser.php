<?php

namespace Brofist\Csv;

use InvalidArgumentException;

class MappedColumnsParser extends AbstractParser
{
    /**
     * @var array
     */
    private $columns = [];

    /**
     * {@inheritdoc}
     *
     * @throws InvalidArgumentException
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);

        if (!isset($options['columns'])) {
            throw new InvalidArgumentException('No columns provided');
        }

        $columns = $options['columns'];

        if (!is_array($columns) || !count($columns)) {
            throw new InvalidArgumentException('You must provide at least one column');
        }

        $this->columns = $columns;
    }

    public function parse(string $content) : array
    {
        $lines = explode("\n", $content);
        $data = [];

        foreach ($lines as $line) {
            if (!$this->lineIsEmpty($line)) {
                $data[] = $this->getLineData($line);
            }
        }

        return $data;
    }

    private function getLineData(string $line) : array
    {
        $columns = str_getcsv($line, $this->getSeparator());
        $data = [];

        foreach ($this->columns as $index => $columnName) {
            $data[$columnName] = $this->getColumnValue($index, $columns, $columnName);
        }

        return $data;
    }

    private function lineIsEmpty($line) : bool
    {
        return $line === '';
    }

    private function getColumnValue(int $index, array $data, string $columnName) : string
    {
        if (array_key_exists($index, $data)) {
            return $data[$index];
        }

        throw new InvalidArgumentException(
            sprintf(
                "Column '%s' (offset %s) does not exist",
                $columnName,
                $index
            )
        );
    }
}
