<?php

declare(strict_types=1);

namespace VlassContreras\Clockission\Contracts;

interface TimeTracker
{
    /**
     * Constructor.
     *
     * @param bool $start Autostart timer.
     */
    public function __construct(bool $start = false);

    /**
     * Start timer.
     *
     * @return float
     */
    public function start(): float;

    /**
     * End timer
     *
     * @return float
     */
    public function end(): float;

    /**
     * Get the total time spent.
     *
     * @return float
     */
    public function total(): float;
}
