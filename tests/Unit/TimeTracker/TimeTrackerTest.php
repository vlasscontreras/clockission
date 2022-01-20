<?php

declare(strict_types=1);

namespace Tests\Unit\TimeSlip;

use PHPUnit\Framework\TestCase;
use VlassContreras\Clockission\TimeTracker\TimeTracker;

class TimeTrackerTest extends TestCase
{
    public function testItCountsTime(): void
    {
        $timeTracker = new TimeTracker();
        $timeTracker->start();
        usleep(150000);
        $timeTracker->end();

        $this->assertLessThan(0.16, $timeTracker->total());
        $this->assertGreaterThan(0.14, $timeTracker->total());
    }
}
