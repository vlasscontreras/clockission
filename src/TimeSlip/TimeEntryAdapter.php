<?php

declare(strict_types=1);

namespace VlassContreras\Clockission\TimeSlip;

use VlassContreras\Clockission\Config\Config;
use VlassContreras\Clockission\Contracts\ClockifyEntry;
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
     * Entry date
     *
     * @var string|null
     */
    protected ?string $date;

    /**
     * Entry hours
     *
     * @var string|null
     */
    protected ?string $timeLogged;

    /**
     * Entry team ID
     *
     * @var int|null
     */
    protected ?int $teamId = 0;

    /**
     * Set up time entry
     *
     * @param ClockifyEntry $entry
     */
    public function __construct(ClockifyEntry $entry)
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
     */
    protected function parseDescription(string $description)
    {
        preg_match('/^(.[^:]+): (.*)$/', $description, $matches);

        if (count($matches) !== 3) {
            throw new \InvalidArgumentException('Invalid description format. Expected: "type: description"');
        }

        $this->activityType = $this->validateActivityType($matches[1]);
        $this->description = $matches[2];
    }
}
