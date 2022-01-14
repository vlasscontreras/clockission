<?php

declare(strict_types=1);

namespace VlassContreras\Clockission\DateTime;

class Date
{
    /**
     * Converts a date in the format 'mm/dd/yyyy' to ISO 8601 format.
     *
     * @param string $date
     * @return string
     */
    public static function toIso8601Date(string $date): string
    {
        $date = \DateTime::createFromFormat('m/d/Y', $date);

        return $date->format('Y-m-d');
    }
}
