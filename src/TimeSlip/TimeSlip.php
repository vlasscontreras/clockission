<?php

declare(strict_types=1);

namespace VlassContreras\Clockission\TimeSlip;

use VlassContreras\Clockission\Contracts\MissionSlip;

class TimeSlip implements MissionSlip
{
    /**
     * Set up time entry
     *
     * @param string|null $activityType
     * @param string|null $description
     * @param string|null $date
     * @param string|null  $hours
     * @param int         $teamId
     */
    public function __construct(
        protected string $activityType,
        protected string $description,
        protected ?string $date,
        protected ?string $hours,
        protected ?int $teamId = 0
    ) {
        //
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

        return $this->date;
    }

    /**
     * Get the time entry hours
     *
     * @return string
     */
    public function getHours(): string
    {
        if (empty($this->hours)) {
            return '0:00';
        }

        return $this->hours;
    }

    /**
     * Get the team ID
     *
     * @return int
     */
    public function getTeamId(): int
    {
        if (empty($this->teamId)) {
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
}
