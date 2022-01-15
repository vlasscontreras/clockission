<?php

namespace VlassContreras\Clockission\Contracts;

interface ClockifyEntry extends Arrayable
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
}
