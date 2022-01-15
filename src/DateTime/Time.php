<?php

declare(strict_types=1);

namespace VlassContreras\Clockission\DateTime;

class Time
{
    /**
     * Converts a decimal to a string of hours and minutes.
     *
     * @param float $decimal
     * @return string
     */
    public static function decimalToHourMinute(float $decimal): string
    {
        $hours = floor($decimal);
        $minutes = round(($decimal - $hours) * 60);

        return sprintf('%d:%02d', $hours, $minutes);
    }

    /**
     * Converts a string of hours and minutes to a decimal.
     *
     * @param string $hourMinute
     * @return float
     */
    public static function hourMinuteToDecimal(string $hourMinute): float
    {
        $parts = explode(':', $hourMinute);

        if (!isset($parts[0]) || !isset($parts[1])) {
            throw new \InvalidArgumentException('Invalid format: The hour and minute must be separated by a colon.');
        }

        $hours = (int) $parts[0];
        $minutes = (int) $parts[1];

        return (float) sprintf('%.2f', $hours + ($minutes / 60));
    }

    /**
     * Adds a decimal to a string of hours.
     *
     * @param string $hour
     * @param float $decimal
     * @return string
     */
    public static function addDecimalToHour(string $hour, float $decimal): string
    {
        return self::decimalToHourMinute(self::hourMinuteToDecimal($hour) + $decimal);
    }
}
