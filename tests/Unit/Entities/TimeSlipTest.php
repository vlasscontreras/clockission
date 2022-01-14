<?php

declare(strict_types=1);

namespace Tests\Unit\Entities;

use PHPUnit\Framework\TestCase;
use VlassContreras\Clockission\Entities\TimeSlip;

class TimeSlipTest extends TestCase
{
    public function testItCreatesObjectValues()
    {
        $timeSlip = new TimeSlip('Production: PS-9999', '01/11/2022', 8.5, 420);
        $array = $timeSlip->toArray();

        $this->assertEquals('Production', $array['activity_type']);
        $this->assertEquals('PS-9999', $array['description']);
        $this->assertEquals('2022-01-11', $array['date']);
        $this->assertEquals('8:30', $array['hours']);
        $this->assertEquals(420, $array['team_id']);
    }

    public function testItCreatesObjectValuesWithDefaults()
    {
        $timeSlip = new TimeSlip('Production: PS-9999', '', null, null);
        $array = $timeSlip->toArray();

        $this->assertEquals('Production', $array['activity_type']);
        $this->assertEquals('PS-9999', $array['description']);
        $this->assertEquals(date('Y-m-d'), $array['date']);
        $this->assertEquals('0:00', $array['hours']);
        $this->assertEquals(0, $array['team_id']);
    }

    public function testItCreatesObjectValuesFail()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid description format. Expected: "type: description"');

        $timeSlip = new TimeSlip('Production', '', null, null);
        $array = $timeSlip->toArray();

        $this->assertEquals('Production', $array['activity_type']);
        $this->assertEquals('', $array['description']);
        $this->assertEquals(date('Y-m-d'), $array['date']);
        $this->assertEquals('0:00', $array['hours']);
        $this->assertEquals(0, $array['team_id']);
    }
}
