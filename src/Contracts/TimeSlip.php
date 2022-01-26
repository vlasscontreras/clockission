<?php

declare(strict_types=1);

namespace VlassContreras\Clockission\Contracts;

interface TimeSlip extends Arrayable
{
    /**
     * Get the time slip activity type
     *
     * @return string
     */
    public function getActivityType(): string;

    /**
     * Get the time slip description
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Get the time slip date
     *
     * @return string
     */
    public function getDate(): string;

    /**
     * Get the time slip hours
     *
     * @return string
     */
    public function getTimeLogged(): string;

    /**
     * Get the team ID
     *
     * @return int
     */
    public function getTeamId(): int;

    /**
     * Set the time slip hours
     *
     * @param string $timeLogged
     * @return self
     */
    public function setTimeLogged(string $timeLogged): self;

    /**
     * Validate and assign the activity type.
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    public function validateActivityType(string $activityType): string;

    /**
     * Get the time slip activity type
     *
     * @return array<string, int|string>
     */
    public function toArray(): array;
}
