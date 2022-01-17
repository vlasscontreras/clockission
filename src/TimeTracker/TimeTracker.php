<?php

declare(strict_types=1);

namespace VlassContreras\Clockission\TimeTracker;

use VlassContreras\Clockission\Contracts\TimeTracker as TimeTrackerInterface;

class TimeTracker implements TimeTrackerInterface
{
    /**
     * Start time.
     *
     * @var float
     */
    protected float $startTime = 0;

    /**
     * End time.
     *
     * @var float
     */
    protected float $endTime = 0;

    /**
     * @inheritdoc
     */
    public function __construct(bool $start = false)
    {
        if ($start) {
            $this->start();
        }
    }

    /**
     * @inheritdoc
     */
    public function start(): float
    {
        $this->startTime = microtime(true);

        return $this->startTime;
    }

    /**
     * @inheritdoc
     */
    public function end(): float
    {
        $this->endTime = microtime(true);

        return $this->endTime;
    }

    /**
     * @inheritdoc
     */
    public function total(): float
    {
        return number_format($this->endTime - $this->startTime, 3) * 1.00;
    }
}
