<?php

namespace VlassContreras\Clockission\Contracts;

interface MissionSlip extends Arrayable
{
    /**
     * Get the time slip activity type
     *
     * @return string
     */
    public function getActivityType(): string;

    /**
     * Get the time entry description
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Get the time entry date
     *
     * @return string
     */
    public function getDate(): string;

    /**
     * Get the time entry hours
     *
     * @return string
     */
    public function getHours(): string;

    /**
     * Get the team ID
     *
     * @return int
     */
    public function getTeamId(): int;
}
