<?php

declare(strict_types=1);

namespace Tests\Feature\TimeSlip;

use PHPUnit\Framework\TestCase;
use VlassContreras\Clockission\Contracts\MissionSlip;
use VlassContreras\Clockission\DateTime\Time;
use VlassContreras\Clockission\TimeSlip\Aggregator;

class AggregatorTest extends TestCase
{
    /**
     * @dataProvider getSampleTimeSlips
     * @param array<int, array<string, string>> $timeEntries
     */
    public function testItMatchesStructure(array $timeEntries): void
    {
        $aggregate = new Aggregator($timeEntries);
        $timeSlips = $aggregate->toArray(true);

        /** @var array<string, float> $timeSlip */
        foreach ($timeSlips as $timeSlip) {
            $this->assertArrayHasKey('description', $timeSlip);
            $this->assertArrayHasKey('date', $timeSlip);
            $this->assertArrayHasKey('time_logged', $timeSlip);
            $this->assertArrayHasKey('activity_type', $timeSlip);
            $this->assertArrayHasKey('team_id', $timeSlip);
        }
    }

    /**
     * @dataProvider getSampleTimeSlips
     * @param array<int, array<string, string>> $timeEntries
     */
    public function testItMatchesTotalTime(array $timeEntries): void
    {
        $aggregate = new Aggregator($timeEntries);
        $timeSlips = $aggregate->toArray(true);
        $sum = array_sum(array_map(function ($time) {
            return Time::hourMinuteToDecimal($time);
        }, array_column($timeSlips, 'time_logged')));

        // Based on data provider.
        $this->assertEquals(17.9, $sum);
        $this->assertEquals('17:54', Time::decimalToHourMinute($sum));
    }

    /**
     * @dataProvider getSampleTimeSlips
     * @param array<int, array<string, string>> $timeEntries
     */
    public function testItUnifiesEntriesWithSameTypeDescriptionTime(array $timeEntries): void
    {
        $aggregate = new Aggregator($timeEntries);
        $timeSlips = $aggregate->toArray(true);
        $counts = array_count_values(array_column($timeSlips, 'description'));

        $this->assertEquals(6, count($timeSlips));
        $this->assertEquals(3, $counts['PS-7777']); // Tracked in 3 different days.
        $this->assertEquals(2, $counts['PS-9999']); // Tracked in 2 different days.
        $this->assertEquals(1, $counts['Stand-up meeting']); // Tracked in 1 day only.
    }

    /**
     * @dataProvider getSampleTimeSlips
     * @param array<int, array<string, string>> $timeEntries
     */
    public function testItMatchesExpectedTypeDescriptionTime(array $timeEntries): void
    {
        $aggregate = new Aggregator($timeEntries);

        /** @var MissionSlip[] $timeSlips */
        $timeSlips = $aggregate->toArray();

        // #1 Based on data provider.
        $this->assertEquals('Production', $timeSlips[0]->getActivityType());
        $this->assertEquals('PS-9999', $timeSlips[0]->getDescription());
        $this->assertEquals('2022-01-11', $timeSlips[0]->getDate());
        $this->assertEquals('5:42', $timeSlips[0]->getTimeLogged());

        // #2 Based on data provider.
        $this->assertEquals('Planning', $timeSlips[1]->getActivityType());
        $this->assertEquals('Stand-up meeting', $timeSlips[1]->getDescription());
        $this->assertEquals('2022-01-11', $timeSlips[1]->getDate());
        $this->assertEquals('0:30', $timeSlips[1]->getTimeLogged());

        // #3 Based on data provider.
        $this->assertEquals('Production', $timeSlips[2]->getActivityType());
        $this->assertEquals('PS-7777', $timeSlips[2]->getDescription());
        $this->assertEquals('2022-01-11', $timeSlips[2]->getDate());
        $this->assertEquals('0:42', $timeSlips[2]->getTimeLogged());

        // #4 Based on data provider.
        $this->assertEquals('Production', $timeSlips[3]->getActivityType());
        $this->assertEquals('PS-7777', $timeSlips[3]->getDescription());
        $this->assertEquals('2022-01-17', $timeSlips[3]->getDate());
        $this->assertEquals('1:30', $timeSlips[3]->getTimeLogged());

        // #5 Based on data provider.
        $this->assertEquals('Production', $timeSlips[4]->getActivityType());
        $this->assertEquals('PS-7777', $timeSlips[4]->getDescription());
        $this->assertEquals('2022-01-18', $timeSlips[4]->getDate());
        $this->assertEquals('7:30', $timeSlips[4]->getTimeLogged());

        // #6 Based on data provider.
        $this->assertEquals('Production', $timeSlips[5]->getActivityType());
        $this->assertEquals('PS-9999', $timeSlips[5]->getDescription());
        $this->assertEquals('2022-01-18', $timeSlips[5]->getDate());
        $this->assertEquals('2:00', $timeSlips[5]->getTimeLogged());
    }

    /**
     * Get the sample time slips.
     *
     * @return array<int, array<int, array<int, array<string, float|string>>>>
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
