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

    /**
     * Aggregator constructor.
     *
     * @param array<int, array<string, string>> $timeEntries
     * @return void
     * @throws InvalidArgumentException
     */
    public function __construct(array $timeEntries)
    {
        $this->parseTimeEntries($timeEntries);
    }

    /**
     * Convert the time entries to an array of time slips.
     *
     * @param array<int, array<string, string>> $entries
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

            if (($currentSlip = $this->exists($timeSlip)) !== false) {
                $this->updateSlipTimeLogged($currentSlip, (float) $entry['Duration (decimal)']);
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
     * @param MissionSlip $slip
     * @return MissionSlip|false
     */
    protected function exists(MissionSlip $slip): MissionSlip|false
    {
        foreach ($this->timeSlips as $timeSlip) {
            $descriptionMatch = $timeSlip->getDescription() === $slip->getDescription();
            $activityTypeMatch = $timeSlip->getActivityType() === $slip->getActivityType();
            $dateMatch = $timeSlip->getDate() === $slip->getDate();

            if ($descriptionMatch && $activityTypeMatch && $dateMatch) {
                return $timeSlip;
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
     * @param MissionSlip $slip
     * @param float $timeToAdd
     * @return void
     * @throws InvalidArgumentException
     */
    protected function updateSlipTimeLogged(MissionSlip $slip, float $timeToAdd): void
    {
        $slip->setTimeLogged(
            Time::addDecimalToHour(
                $slip->getTimeLogged(),
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
     * @inheritDoc
     * @return MissionSlip[]|array<int, array<int|string>>
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
