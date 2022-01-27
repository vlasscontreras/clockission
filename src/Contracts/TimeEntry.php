<?php

declare(strict_types=1);

namespace VlassContreras\Clockission\Contracts;

interface TimeEntry extends Arrayable
{
    /**
     * Get the time entry description
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Get the time entry date
     *
     * @return string
     */
    public function getDate(): string;

    /**
     * Get the time entry hours
     *
     * @return float
     */
    public function getHours(): float;

    /**
     * Convert time entry to array.
     *
     * @return array<string, string|float>
     */
    public function toArray(): array;
}
