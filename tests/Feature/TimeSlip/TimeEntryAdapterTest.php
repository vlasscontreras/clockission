<?php

declare(strict_types=1);

namespace Tests\Feature\TimeSlip;

use PHPUnit\Framework\TestCase;
use VlassContreras\Clockission\Contracts\MissionSlip;
use VlassContreras\Clockission\TimeEntry\TimeEntry;
use VlassContreras\Clockission\TimeSlip\TimeEntryAdapter;
use VlassContreras\Clockission\TimeSlip\TimeSlip;

class TimeEntryAdapterTest extends TestCase
{
    public function testItConvertsToTimeSlip()
    {
        $timeEntry = new TimeEntry('Production: PS-9999', '01/11/2022', 8.5);
        $timeSlip = new TimeEntryAdapter($timeEntry);

        $this->assertInstanceOf(MissionSlip::class, $timeSlip);
        $this->assertEquals('Production', $timeSlip->getActivityType());
        $this->assertEquals('PS-9999', $timeSlip->getDescription());
        $this->assertEquals('2022-01-11', $timeSlip->getDate());
        $this->assertEquals('8:30', $timeSlip->getHours());
    }

    public function testItConvertsColonsAfterActivityType()
    {
        $timeEntry = new TimeEntry('Production: PS-9999: Something Else: New :: :D', '01/11/2022', 8.5);
        $timeSlip = new TimeEntryAdapter($timeEntry);

        $this->assertEquals('Production', $timeSlip->getActivityType());
        $this->assertEquals('PS-9999: Something Else: New :: :D', $timeSlip->getDescription());
    }

    public function testItConvertsToTimeSlipDefaults()
    {
        $timeEntry = new TimeEntry('Production: PS-9999', '12/31/2022');
        $timeSlip = new TimeEntryAdapter($timeEntry);

        $this->assertEquals('Production', $timeSlip->getActivityType());
        $this->assertEquals('PS-9999', $timeSlip->getDescription());
        $this->assertEquals('2022-12-31', $timeSlip->getDate());
        $this->assertEquals('0:00', $timeSlip->getHours());
    }

    public function testItCreatesObjectValuesFail()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid description format. Expected: "type: description"');

        $timeEntry = new TimeEntry('Production', '01/11/2022', 8.5);
        new TimeEntryAdapter($timeEntry);
    }
}