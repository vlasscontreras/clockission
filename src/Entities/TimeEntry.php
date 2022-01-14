<?php

declare(strict_types=1);

namespace VlassContreras\Clockission\Entities;

use VlassContreras\Clockission\Contracts\Arrayable;

class TimeEntry implements Arrayable
{
    /**
     * Set up time entry
     *
     * @param string|null $description
     * @param string|null $date
     * @param float|null  $hours
     */
    public function __construct(
        protected ?string $description,
        protected ?string $date,
        protected ?float $hours = 0
    ) {
        //
    }

    /**
     * Get the time entry description
     *
     * @return string
     */
    public function getDescription(): string
    {
        if (empty($this->description)) {
            return 'N/A';
        }

        return $this->description;
    }

    /**
     * Get the time entry date
     *
     * @return string
     */
    public function getDate(): string
    {
        if (empty($this->date)) {
            return date('m/d/Y');
        }

        return $this->date;
    }

    /**
     * Get the time entry hours
     *
     * @return float
     */
    public function getHours(): float
    {
        if (empty($this->hours)) {
            return 0;
        }

        return $this->hours;
    }

    /**
     * Convert time entry to array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'description' => $this->getDescription(),
            'date'        => $this->getDate(),
            'hours'       => $this->getHours(),
        ];
    }
}
