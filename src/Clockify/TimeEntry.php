<?php

declare(strict_types=1);

namespace VlassContreras\Clockission\Clockify;

use VlassContreras\Clockission\Contracts\TimeEntry as TimeEntryContract;

class TimeEntry implements TimeEntryContract
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
     * @inheritDoc
     */
    public function getDescription(): string
    {
        if (empty($this->description)) {
            return 'N/A';
        }

        return $this->description;
    }

    /**
     * @inheritDoc
     */
    public function getDate(): string
    {
        if (empty($this->date)) {
            return date('m/d/Y');
        }

        return $this->date;
    }

    /**
     * @inheritDoc
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
     * @return array<string, string|float>
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
