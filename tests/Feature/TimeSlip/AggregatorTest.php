<?php

declare(strict_types=1);

namespace Tests\Feature\TimeSlip;

use PHPUnit\Framework\TestCase;
use VlassContreras\Clockission\DateTime\Time;
use VlassContreras\Clockission\TimeSlip\Aggregator;

class AggregatorTest extends TestCase
{
    /**
     * @dataProvider getSampleTimeSlips
     */
    public function testItMatchesStructure(array $timeEntries)
    {
        $aggregate = new Aggregator($timeEntries);
        $array = $aggregate->toArray(true);

        foreach ($array as $entry) {
            $this->assertArrayHasKey('description', $entry);
            $this->assertArrayHasKey('date', $entry);
            $this->assertArrayHasKey('time_logged', $entry);
            $this->assertArrayHasKey('activity_type', $entry);
            $this->assertArrayHasKey('team_id', $entry);
        }
    }

    /**
     * @dataProvider getSampleTimeSlips
     */
    public function testItMatchesTotalTime(array $timeEntries)
    {
        $aggregate = new Aggregator($timeEntries);
        $array = $aggregate->toArray(true);
        $sum = array_sum(array_map(function ($time) {
            return Time::hourMinuteToDecimal($time);
        }, array_column($array, 'time_logged')));

        // Based on data provider.
        $this->assertEquals(17.9, $sum);
        $this->assertEquals('17:54', Time::decimalToHourMinute($sum));
    }

    /**
     * @dataProvider getSampleTimeSlips
     */
    public function testItUnifiesEntriesWithSameTypeDescriptionTime(array $timeEntries)
    {
        $aggregate = new Aggregator($timeEntries);
        $array = $aggregate->toArray(true);
        $counts = array_count_values(array_column($array, 'description'));

        $this->assertEquals(6, count($array));
        $this->assertEquals(3, $counts['PS-7777']); // Tracked in 3 different days.
        $this->assertEquals(2, $counts['PS-9999']); // Tracked in 2 different days.
        $this->assertEquals(1, $counts['Stand-up meeting']); // Tracked in 1 day only.
    }

    /**
     * @dataProvider getSampleTimeSlips
     */
    public function testItMatchesExpectedTypeDescriptionTime(array $timeEntries)
    {
        $aggregate = new Aggregator($timeEntries);
        $array = $aggregate->toArray(true);

        // #1 Based on data provider.
        $this->assertEquals('Production', $array[0]['activity_type']);
        $this->assertEquals('PS-9999', $array[0]['description']);
        $this->assertEquals('2022-01-11', $array[0]['date']);
        $this->assertEquals('5:42', $array[0]['time_logged']);

        // #2 Based on data provider.
        $this->assertEquals('Planning', $array[1]['activity_type']);
        $this->assertEquals('Stand-up meeting', $array[1]['description']);
        $this->assertEquals('2022-01-11', $array[1]['date']);
        $this->assertEquals('0:30', $array[1]['time_logged']);

        // #3 Based on data provider.
        $this->assertEquals('Production', $array[2]['activity_type']);
        $this->assertEquals('PS-7777', $array[2]['description']);
        $this->assertEquals('2022-01-11', $array[2]['date']);
        $this->assertEquals('0:42', $array[2]['time_logged']);

        // #4 Based on data provider.
        $this->assertEquals('Production', $array[3]['activity_type']);
        $this->assertEquals('PS-7777', $array[3]['description']);
        $this->assertEquals('2022-01-17', $array[3]['date']);
        $this->assertEquals('1:30', $array[3]['time_logged']);

        // #5 Based on data provider.
        $this->assertEquals('Production', $array[4]['activity_type']);
        $this->assertEquals('PS-7777', $array[4]['description']);
        $this->assertEquals('2022-01-18', $array[4]['date']);
        $this->assertEquals('7:30', $array[4]['time_logged']);

        // #6 Based on data provider.
        $this->assertEquals('Production', $array[5]['activity_type']);
        $this->assertEquals('PS-9999', $array[5]['description']);
        $this->assertEquals('2022-01-18', $array[5]['date']);
        $this->assertEquals('2:00', $array[5]['time_logged']);
    }

    /**
     * Get the sample time slips.
     *
     * @return array
     */
    public function getSampleTimeSlips(): array
    {
        return [[[
            [
                'Description' => 'Production: PS-9999',
                'Start Date' => '01/11/2022',
                'Duration (decimal)' => 4,
            ],
            [
                'Description' => 'Production: PS-9999',
                'Start Date' => '01/11/2022',
                'Duration (decimal)' => 0.25,
            ],
            [
                'Description' => 'Production: PS-9999',
                'Start Date' => '01/11/2022',
                'Duration (decimal)' => 1.45,
            ],
            [
                'Description' => 'Planning: Stand-up meeting',
                'Start Date' => '01/11/2022',
                'Duration (decimal)' => 0.5,
            ],
            [
                'Description' => 'Production: PS-7777',
                'Start Date' => '01/11/2022',
                'Duration (decimal)' => 0.7,
            ],
            [
                'Description' => 'Production: PS-7777',
                'Start Date' => '01/17/2022',
                'Duration (decimal)' => 1.5,
            ],
            [
                'Description' => 'Production: PS-7777',
                'Start Date' => '01/18/2022',
                'Duration (decimal)' => 4,
            ],
            [
                'Description' => 'Production: PS-9999',
                'Start Date' => '01/18/2022',
                'Duration (decimal)' => 2,
            ],
            [
                'Description' => 'Production: PS-7777',
                'Start Date' => '01/18/2022',
                'Duration (decimal)' => 3.5,
            ],
        ]]];
    }
}
