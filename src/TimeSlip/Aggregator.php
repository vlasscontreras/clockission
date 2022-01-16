<?php

declare(strict_types=1);

namespace VlassContreras\Clockission\TimeSlip;

use InvalidArgumentException;
use VlassContreras\Clockission\Contracts\Arrayable;
use VlassContreras\Clockission\Contracts\MissionSlip;
use VlassContreras\Clockission\DateTime\Time;
use VlassContreras\Clockission\TimeEntry\TimeEntry;

class Aggregator implements Arrayable
{
    /**
     * Time entries
     *
     * @var MissionSlip[]
     */
    protected array $timeSlips = [];

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
                (float) $entry['Duration (decimal)']
            );

            $timeSlip = new TimeEntryAdapter($timeEntry);

            $index = $this->exists($timeSlip);

            if ($index !== false) {
                $this->updateSlipTimeLogged($index, (float) $entry['Duration (decimal)']);
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
        foreach ($this->timeSlips as $key => $timeEntry) {
            $descriptionMatch = $timeEntry->getDescription() === $timeSlip->getDescription();
            $activityTypeMatch = $timeEntry->getActivityType() === $timeSlip->getActivityType();

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
        $this->timeSlips[] = $timeSlip;
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
        $this->timeSlips[$index] = $this->timeSlips[$index]->setTimeLogged(
            Time::addDecimalToHour(
                $this->timeSlips[$index]->getTimeLogged(),
                $timeToAdd
            )
        );
    }

    /**
     * Sort slips by date from oldest to newest.
     *
     * @return void
     */
    public function oldest(): void
    {
        usort($this->timeSlips, function (MissionSlip $a, MissionSlip $b) {
            return $a->getDate() <=> $b->getDate();
        });
    }

    /**
     * @inheritdoc
     * @return array|MissionSlip[]
     */
    public function toArray(bool $deep = false): array
    {
        if (!$deep) {
            return $this->timeSlips;
        }

        return array_map(function (MissionSlip $timeSlip) {
            return $timeSlip->toArray();
        }, $this->timeSlips);
    }
}
