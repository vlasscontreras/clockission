<?php

declare(strict_types=1);

namespace Tests\Feature\TimeSlip;

use PHPUnit\Framework\TestCase;
use VlassContreras\Clockission\Contracts\MissionSlip;
use VlassContreras\Clockission\TimeEntry\TimeEntry;
use VlassContreras\Clockission\TimeSlip\TimeEntryAdapter;

class TimeEntryAdapterTest extends TestCase
{
    public function testItConvertsToTimeSlip(): void
    {
        $timeEntry = new TimeEntry('Production: PS-9999', '01/11/2022', 8.5);
        $timeSlip = new TimeEntryAdapter($timeEntry);

        $this->assertInstanceOf(MissionSlip::class, $timeSlip);
        $this->assertEquals('Production', $timeSlip->getActivityType());
        $this->assertEquals('PS-9999', $timeSlip->getDescription());
        $this->assertEquals('2022-01-11', $timeSlip->getDate());
        $this->assertEquals('8:30', $timeSlip->getTimeLogged());
    }

    public function testItConvertsColonsAfterActivityType(): void
    {
        $timeEntry = new TimeEntry('Production: PS-9999: Something Else: New :: :D', '01/11/2022', 8.5);
        $timeSlip = new TimeEntryAdapter($timeEntry);

        $this->assertEquals('Production', $timeSlip->getActivityType());
        $this->assertEquals('PS-9999: Something Else: New :: :D', $timeSlip->getDescription());
    }

    public function testItConvertsToTimeSlipDefaults(): void
    {
        $timeEntry = new TimeEntry('Production: PS-9999', '12/31/2022');
        $timeSlip = new TimeEntryAdapter($timeEntry);

        $this->assertEquals('Production', $timeSlip->getActivityType());
        $this->assertEquals('PS-9999', $timeSlip->getDescription());
        $this->assertEquals('2022-12-31', $timeSlip->getDate());
        $this->assertEquals('0:00', $timeSlip->getTimeLogged());
    }

    public function testItValidatesDescriptionFormat(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid description format. Expected: "type: description"');

        $timeEntry = new TimeEntry('Production', '01/11/2022', 8.5);
        new TimeEntryAdapter($timeEntry);
    }

    public function testItValidatesActivityType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid activity type');

        $timeEntry = new TimeEntry('Testing: Entry', '01/11/2022', 8.5);
        new TimeEntryAdapter($timeEntry);
    }
}
