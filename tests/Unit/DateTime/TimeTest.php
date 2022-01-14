<?php

declare(strict_types=1);

namespace Tests\Unit\DateTime;

use PHPUnit\Framework\TestCase;
use VlassContreras\Clockission\DateTime\Time;

class TimeTest extends TestCase
{
    public function testItConvertsDecimalsToHoursAndMinutes()
    {
        $this->assertEquals('0:00', Time::decimalToHourMinute(0));
        $this->assertEquals('0:01', Time::decimalToHourMinute(0.01));
        $this->assertEquals('0:15', Time::decimalToHourMinute(0.25));
        $this->assertEquals('0:30', Time::decimalToHourMinute(0.5));
        $this->assertEquals('1:09', Time::decimalToHourMinute(1.15));
        $this->assertEquals('17:45', Time::decimalToHourMinute(17.75));
        $this->assertEquals('23:59', Time::decimalToHourMinute(23.99));
        $this->assertEquals('85:12', Time::decimalToHourMinute(85.2));
    }

    public function testItConvertsHoursAndMinutesToDecimals()
    {
        $this->assertEquals(0.25, Time::hourMinuteToDecimal('0:15'));
        $this->assertEquals(0.5, Time::hourMinuteToDecimal('0:30'));
        $this->assertEquals(1.15, Time::hourMinuteToDecimal('1:09'));
        $this->assertEquals(17.75, Time::hourMinuteToDecimal('17:45'));
        $this->assertEquals(23.98, Time::hourMinuteToDecimal('23:59'));
        $this->assertEquals(85.2, Time::hourMinuteToDecimal('85:12'));
    }
}
