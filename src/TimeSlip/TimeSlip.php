<?php

declare(strict_types=1);

namespace VlassContreras\Clockission\TimeSlip;

use InvalidArgumentException;
use VlassContreras\Clockission\Contracts\MissionSlip;
use VlassContreras\Clockission\TimeSlip\Enums\ActivityType;

class TimeSlip implements MissionSlip
{
    /**
     * Activity type
     *
     * @var string
     */
    protected string $activityType;

    /**
     * Set up time entry
     *
     * @param string      $activityType
     * @param string      $description
     * @param string|null $date
     * @param string|null $timeLogged
     * @param int         $teamId
     */
    public function __construct(
        string $activityType,
        protected string $description,
        protected ?string $date,
        protected ?string $timeLogged,
        protected ?int $teamId = null
    ) {
        $this->activityType = $this->validateActivityType($activityType);
    }

    /**
     * @inheritDoc
     */
    public function getActivityType(): string
    {
        return $this->activityType;
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @inheritDoc
     */
    public function getDate(): string
    {
        if (empty($this->date)) {
            return date('Y-m-d');
        }

        return $this->date;
    }

    /**
     * @inheritDoc
     */
    public function getTimeLogged(): string
    {
        if (empty($this->timeLogged)) {
            return '0:00';
        }

        return $this->timeLogged;
    }

    /**
     * @inheritDoc
     */
    public function getTeamId(): int
    {
        if (empty($this->teamId)) {
            return 0;
        }

        return $this->teamId;
    }

    /**
     * @inheritDoc
     */
    public function setTimeLogged(string $timeLogged): self
    {
        $this->timeLogged = $timeLogged;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function validateActivityType(string $activityType): string
    {
        if (!in_array($activityType, ActivityType::cases())) {
            throw new InvalidArgumentException('Invalid activity type');
        }

        return $activityType;
    }

    /**
     * Convert time entry to array.
     *
     * @return array<string, int|string>
     */
    public function toArray(): array
    {
        return [
            'activity_type' => $this->getActivityType(),
            'description'   => $this->getDescription(),
            'date'          => $this->getDate(),
            'time_logged'   => $this->getTimeLogged(),
            'team_id'       => $this->getTeamId(),
        ];
    }
}
