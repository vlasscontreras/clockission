<?php

declare(strict_types=1);

namespace Tests\Unit\TimeEntry;

use PHPUnit\Framework\TestCase;
use VlassContreras\Clockission\TimeEntry\TimeEntry;

class TimeEntryTest extends TestCase
{
    public function testItCreatesObjectValues(): void
    {
        $timeEntry = new TimeEntry('PS-9999', '01/11/2022', 8.00);
        $timeEntryArray = $timeEntry->toArray();

        $this->assertEquals('PS-9999', $timeEntryArray['description']);
        $this->assertEquals('01/11/2022', $timeEntryArray['date']);
        $this->assertEquals(8.00, $timeEntryArray['hours']);
    }

    public function testItCreatesObjectValuesWithDefaults(): void
    {
        $timeEntry = new TimeEntry('', null);
        $timeEntryArray = $timeEntry->toArray();

        $this->assertEquals('N/A', $timeEntryArray['description']);
        $this->assertEquals(date('m/d/Y'), $timeEntryArray['date']);
        $this->assertEquals(0, $timeEntryArray['hours']);
    }
}
