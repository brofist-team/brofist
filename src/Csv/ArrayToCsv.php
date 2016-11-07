<?php

namespace Brofist\Csv;

class ArrayToCsv
{
    /** @var string */
    private $delimiter = ';';

    /**
     * Available options: delimiter
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        if (isset($options['delimiter'])) {
            $this->delimiter = $options['delimiter'];
        }
    }

    public function toCsv($data) : string
    {
        $filename = tempnam('/tmp', 'array_to_csv');

        $handle = fopen($filename, 'w');

        foreach ($data as $line) {
            fputcsv($handle, $line, $this->delimiter, '"');
        }

        fclose($handle);
        return file_get_contents($filename);
    }
}
