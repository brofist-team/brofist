<?php

namespace Brofist\Csv;

class NamedColumnsParser extends AbstractParser
{
    public function parse(string $content) : array
    {
        $lines = explode("\n", $content);
        $firstLine = array_shift($lines);
        $columns = explode($this->getSeparator(), $firstLine);
        $body = implode("\n", $lines);

        $parser = new MappedColumnsParser([
            'columns'   => $columns,
            'separator' => $this->getSeparator(),
        ]);

        return $parser->parse($body);
    }
}
