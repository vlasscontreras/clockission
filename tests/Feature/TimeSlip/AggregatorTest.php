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
    public function testItMatchesTotalTime(array $timeEntries)
    {
        $aggregate = new Aggregator($timeEntries);
        $array = $aggregate->toArray();
        $sum = array_sum(array_map(function ($time) {
            return Time::hourMinuteToDecimal($time);
        }, array_column($array, 'time_logged')));

        $this->assertEquals('6.9', $sum);
        $this->assertEquals('6:54', Time::decimalToHourMinute($sum));
    }

    /**
     * @dataProvider getSampleTimeSlips
     */
    public function testItUnifiesEntriesWithSameDescription(array $timeEntries)
    {
        $aggregate = new Aggregator($timeEntries);
        $array = $aggregate->toArray();
        $counts = array_count_values(array_column($array, 'description'));

        $this->assertEquals(3, count($array));
        $this->assertEquals(1, $counts['PS-7777']);
        $this->assertEquals(1, $counts['PS-9999']);
        $this->assertEquals(1, $counts['Stand-up meeting']);
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
        ]]];
    }
}