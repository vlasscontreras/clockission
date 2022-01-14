<?php

declare(strict_types=1);

namespace VlassContreras\Clockission\Csv;

use VlassContreras\Clockission\Contracts\Arrayable;

class Parser implements Arrayable
{
    /**
     * Set up the parser.
     *
     * @param string $file File path.
     */
    public function __construct(private string $file)
    {
        $this->file = $file;
    }

    /**
     * Convert the CSV file to array.
     *
     * @return array
     */
    public function toArray(): array
    {
        $rows   = array_map('str_getcsv', file($this->file));
        $header = array_shift($rows);
        $csv    = array();

        foreach ($rows as $row) {
            $csv[] = array_combine($header, $row);
        }

        return $csv;
    }
}
