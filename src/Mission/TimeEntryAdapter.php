<?php

declare(strict_types=1);

namespace VlassContreras\Clockission\Mission;

use InvalidArgumentException;
use VlassContreras\Clockission\Config\Config;
use VlassContreras\Clockission\Contracts\TimeEntry;
use VlassContreras\Clockission\DateTime\Date;
use VlassContreras\Clockission\DateTime\Time;

class TimeEntryAdapter extends TimeSlip
{
    /**
     * Activity type
     *
     * @var string
     */
    protected string $activityType;

    /**
     * Activity description
     *
     * @var string
     */
    protected string $description;

    /**
     * Slip date
     *
     * @var string|null
     */
    protected ?string $date;

    /**
     * Slip hours
     *
     * @var string|null
     */
    protected ?string $timeLogged;

    /**
     * Slip team ID
     *
     * @var int|null
     */
    protected ?int $teamId = 0;

    /**
     * Set up time slip
     *
     * @param TimeEntry $entry
     */
    public function __construct(TimeEntry $entry)
    {
        $this->date = Date::toIso8601Date($entry->getDate());
        $this->timeLogged = Time::decimalToHourMinute($entry->getHours());
        $this->teamId = (int) (new Config())->get('mission_team_id');
        $this->parseDescription($entry->getDescription());
    }

    /**
     * Parse description
     *
     * @param string $description
     * @return void
     */
    protected function parseDescription(string $description): void
    {
        preg_match('/^(.[^:]+): (.*)$/', $description, $matches);

        if (count($matches) !== 3) {
            throw new InvalidArgumentException('Invalid description format. Expected: "type: description"');
        }

        $this->activityType = $this->validateActivityType($matches[1]);
        $this->description = $matches[2];
    }
}
