<?php

declare(strict_types=1);

namespace Tests\Unit\TimeSlip;

use PHPUnit\Framework\TestCase;
use VlassContreras\Clockission\TimeSlip\TimeSlip;

class TimeSlipTest extends TestCase
{
    public function testItCreatesObjectValues()
    {
        $timeSlip = new TimeSlip('Production', 'PS-9999', '2022-01-11', '8:30', 420);
        $array = $timeSlip->toArray();

        $this->assertEquals('Production', $array['activity_type']);
        $this->assertEquals('PS-9999', $array['description']);
        $this->assertEquals('2022-01-11', $array['date']);
        $this->assertEquals('8:30', $array['hours']);
        $this->assertEquals(420, $array['team_id']);
    }

    public function testItCreatesObjectValuesWithDefaults()
    {
        $timeSlip = new TimeSlip('Production', 'PS-9999', '', null, null);
        $array = $timeSlip->toArray();

        $this->assertEquals('Production', $array['activity_type']);
        $this->assertEquals('PS-9999', $array['description']);
        $this->assertEquals(date('Y-m-d'), $array['date']);
        $this->assertEquals('0:00', $array['hours']);
        $this->assertEquals(0, $array['team_id']);
    }
}
