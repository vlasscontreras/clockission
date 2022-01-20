<?php

declare(strict_types=1);

namespace VlassContreras\Clockission\DateTime;

use DateTime;
use InvalidArgumentException;

class Date
{
    /**
     * Converts a date in the format 'mm/dd/yyyy' to ISO 8601 format.
     *
     * @param string $date
     * @return string
     * @throws InvalidArgumentException
     */
    public static function toIso8601Date(string $date): string
    {
        $date = DateTime::createFromFormat('m/d/Y', $date);

        if (!$date) {
            throw new InvalidArgumentException('Invalid date format.');
        }

        return $date->format('Y-m-d');
    }
}
