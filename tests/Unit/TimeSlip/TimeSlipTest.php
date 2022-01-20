<?php

declare(strict_types=1);

namespace Tests\Unit\TimeSlip;

use PHPUnit\Framework\TestCase;
use VlassContreras\Clockission\TimeSlip\TimeSlip;

class TimeSlipTest extends TestCase
{
    public function testItCreatesObjectValues(): void
    {
        $timeSlip = new TimeSlip('Production', 'PS-9999', '2022-01-11', '8:30', 420);
        $timeSlipArray = $timeSlip->toArray();

        $this->assertEquals('Production', $timeSlipArray['activity_type']);
        $this->assertEquals('PS-9999', $timeSlipArray['description']);
        $this->assertEquals('2022-01-11', $timeSlipArray['date']);
        $this->assertEquals('8:30', $timeSlipArray['time_logged']);
        $this->assertEquals(420, $timeSlipArray['team_id']);
    }

    public function testItMatchesObjectWithArray(): void
    {
        $timeSlip = new TimeSlip('Production', 'PS-9999', '2022-01-11', '8:30', 420);
        $timeSlipArray = $timeSlip->toArray();

        $this->assertEquals($timeSlip->getActivityType(), $timeSlipArray['activity_type']);
        $this->assertEquals($timeSlip->getDescription(), $timeSlipArray['description']);
        $this->assertEquals($timeSlip->getDate(), $timeSlipArray['date']);
        $this->assertEquals($timeSlip->getTimeLogged(), $timeSlipArray['time_logged']);
        $this->assertEquals($timeSlip->getTeamId(), $timeSlipArray['team_id']);
    }

    public function testItCreatesObjectValuesWithDefaults(): void
    {
        $timeSlip = new TimeSlip('Production', 'PS-9999', '', null, null);
        $timeSlipArray = $timeSlip->toArray();

        $this->assertEquals('Production', $timeSlipArray['activity_type']);
        $this->assertEquals('PS-9999', $timeSlipArray['description']);
        $this->assertEquals(date('Y-m-d'), $timeSlipArray['date']);
        $this->assertEquals('0:00', $timeSlipArray['time_logged']);
        $this->assertEquals(0, $timeSlipArray['team_id']);
    }

    public function testItValidatesActivityType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid activity type');

        new TimeSlip('Invalid Type', 'PS-9999', '', null, null);
    }
}
