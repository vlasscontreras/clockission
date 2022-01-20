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
        if (!file_exists($file)) {
            throw new \RuntimeException('File does not exist.');
        }

        $this->file = $file;
    }

    /**
     * Convert the CSV file to array.
     *
     * @return array<int, array<string, string>>
     */
    public function toArray(): array
    {
        $csv = file($this->file);

        if (!$csv) {
            return [];
        }

        $rows   = array_map('str_getcsv', $csv);
        $header = array_shift($rows);
        $csv    = array();

        foreach ($rows as $row) {
            $csv[] = array_combine($header, $row);
        }

        return $csv;
    }
}
