<?php

declare(strict_types=1);

namespace VlassContreras\Clockission\TimeSlip;

use InvalidArgumentException;
use VlassContreras\Clockission\Config\Config;
use VlassContreras\Clockission\Contracts\Arrayable;
use VlassContreras\Clockission\Contracts\MissionSlip;
use VlassContreras\Clockission\DateTime\Time;
use VlassContreras\Clockission\TimeEntry\TimeEntry;

class Aggregator implements Arrayable
{
    /**
     * Time entries
     *
     * @var array
     */
    protected array $timeEntries = [];

    public function __construct(array $timeEntries)
    {
        $this->parseTimeEntries($timeEntries);
    }

    /**
     * Convert the time entries to an array of time slips.
     *
     * @param array $entries
     * @return Aggregator
     * @throws InvalidArgumentException
     */
    protected function parseTimeEntries(array $entries): self
    {
        foreach ($entries as $entry) {
            $timeEntry = new TimeEntry(
                $entry['Description'],
                $entry['Start Date'],
                $entry['Duration (decimal)']
            );

            $timeSlip = new TimeEntryAdapter($timeEntry);

            $index = $this->exists($timeSlip);

            if ($index !== false) {
                $this->updateSlipTimeLogged($index, $entry['Duration (decimal)']);
            } else {
                $this->pushSlip($timeSlip);
            }
        }

        return $this;
    }

    /**
     * Check if the time slip already exists.
     *
     * It is determined by the description and activity type.
     *
     * @param MissionSlip $timeSlip
     * @return int|false
     */
    protected function exists(MissionSlip $timeSlip): int|false
    {
        foreach ($this->timeEntries as $key => $timeEntry) {
            $descriptionMatch = $timeEntry['description'] === $timeSlip->getDescription();
            $activityTypeMatch = $timeEntry['activity_type'] === $timeSlip->getActivityType();

            if ($descriptionMatch && $activityTypeMatch) {
                return $key;
            }
        }

        return false;
    }

    /**
     * Push a time slip to the main array.
     *
     * @param MissionSlip $timeSlip
     * @return void
     */
    protected function pushSlip(MissionSlip $timeSlip): void
    {
        $this->timeEntries[] = $timeSlip->toArray();
    }

    /**
     * Update the time logged of a time slip.
     *
     * @param int $index
     * @param float $timeToAdd
     * @return void
     * @throws InvalidArgumentException
     */
    protected function updateSlipTimeLogged(int $index, float $timeToAdd): void
    {
        $this->timeEntries[$index]['time_logged'] = Time::addDecimalToHour(
            $this->timeEntries[$index]['time_logged'],
            $timeToAdd
        );
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return $this->timeEntries;
    }
}
