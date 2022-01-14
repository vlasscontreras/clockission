<?php

declare(strict_types=1);

namespace Tests\Unit\Entities;

use PHPUnit\Framework\TestCase;
use VlassContreras\Clockission\Entities\TimeEntry;

class TimeEntryTest extends TestCase
{
    public function testItCreatesObjectValues()
    {
        $timeEntry = new TimeEntry('PS-9999', '01/11/2022', 8.00);
        $array = $timeEntry->toArray();

        $this->assertEquals('PS-9999', $array['description']);
        $this->assertEquals('01/11/2022', $array['date']);
        $this->assertEquals(8.00, $array['hours']);
    }

    public function testItCreatesObjectValuesWithDefaults()
    {
        $timeEntry = new TimeEntry('', null);
        $array = $timeEntry->toArray();

        $this->assertEquals('N/A', $array['description']);
        $this->assertEquals(date('m/d/Y'), $array['date']);
        $this->assertEquals(0, $array['hours']);
    }
}
