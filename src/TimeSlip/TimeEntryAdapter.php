<?php

namespace VlassContreras\Clockission\TimeSlip;

use VlassContreras\Clockission\Contracts\ClockifyEntry;
use VlassContreras\Clockission\Contracts\MissionSlip;
use VlassContreras\Clockission\DateTime\Date;
use VlassContreras\Clockission\DateTime\Time;

class TimeEntryAdapter implements MissionSlip
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
    protected ?string $hours;

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
        $this->date = $entry->getDate();
        $this->hours = $entry->getHours();
        $this->parseDescription($entry->getDescription());
    }

    /**
     * Get the time slip activity type
     *
     * @return string
     */
    public function getActivityType(): string
    {
        return $this->activityType;
    }

    /**
     * Get the time entry description
     *
     * @return string
     */
    public function getDescription(): string
    {
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
            return date('Y-m-d');
        }

        return Date::toIso8601Date($this->date);
    }

    /**
     * Get the time entry hours
     *
     * @return string
     */
    public function getHours(): string
    {
        if (empty($this->hours)) {
            return Time::decimalToHourMinute(0);
        }

        return Time::decimalToHourMinute($this->hours);
    }

    /**
     * Get the team ID
     *
     * @return int
     */
    public function getTeamId(): int
    {
        if (empty($this->hours)) {
            return 0;
        }

        return $this->teamId;
    }

    /**
     * Convert time entry to array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'activity_type' => $this->getActivityType(),
            'description'   => $this->getDescription(),
            'date'          => $this->getDate(),
            'hours'         => $this->getHours(),
            'team_id'       => $this->getTeamId(),
        ];
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

        $this->activityType = $matches[1];
        $this->description = $matches[2];
    }
}
