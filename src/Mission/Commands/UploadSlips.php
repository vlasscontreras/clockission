<?php

declare(strict_types=1);

namespace VlassContreras\Clockission\Mission\Commands;

use VlassContreras\Clockission\Config\Config;
use VlassContreras\Clockission\Contracts\Command;
use VlassContreras\Clockission\Csv\Parser;
use VlassContreras\Clockission\Mission\Client;
use VlassContreras\Clockission\TimeSlip\Aggregator;
use VlassContreras\Clockission\TimeTracker\TimeTracker;

class UploadSlips implements Command
{
    public function run(array $arguments): void
    {
        $timeTracker = new TimeTracker(true);
        $config = new Config();

        $csv = new Parser($arguments[0]);
        $timeSlips = new Aggregator($csv->toArray());
        $timeSlips->oldest();

        $client = new Client(
            $config->get('MISSION_USERNAME'),
            $config->get('MISSION_PASSWORD')
        );

        $client->authenticate();

        foreach ($timeSlips->toArray() as $timeSlip) {
            $client->pushTimeSlip($timeSlip, (int) $config->get('MISSION_TIME_CARD_ID'));
        }

        $timeTracker->end();

        printf('✅ Uploaded %d time slips in %.3f seconds 😁', count($timeSlips->toArray()), $timeTracker->total());
        echo PHP_EOL;
    }
}
