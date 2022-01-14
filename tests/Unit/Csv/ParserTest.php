<?php

declare(strict_types=1);

namespace Tests\Unit\Csv;

use PHPUnit\Framework\TestCase;
use VlassContreras\Clockission\Csv\Parser;

class ParserTest extends TestCase
{
    public function testItParsesCsvAsArray()
    {
        $parser = new Parser($this->getSampleCsvFile());
        $data = $parser->toArray();

        $this->assertIsArray($data);
        $this->assertCount(2, $data);
    }

    public function testItParsesFields()
    {
        $parser = new Parser($this->getSampleCsvFile());
        $data = $parser->toArray();

        $this->assertArrayHasKey('Project', $data[0]);
        $this->assertArrayHasKey('Client', $data[0]);
        $this->assertArrayHasKey('Description', $data[0]);
        $this->assertArrayHasKey('Task', $data[0]);
        $this->assertArrayHasKey('User', $data[0]);
        $this->assertArrayHasKey('Email', $data[0]);
        $this->assertArrayHasKey('Tags', $data[0]);
        $this->assertArrayHasKey('Billable', $data[0]);
        $this->assertArrayHasKey('Start Date', $data[0]);
        $this->assertArrayHasKey('Start Time', $data[0]);
        $this->assertArrayHasKey('End Date', $data[0]);
        $this->assertArrayHasKey('End Time', $data[0]);
        $this->assertArrayHasKey('Duration (h)', $data[0]);
        $this->assertArrayHasKey('Duration (decimal)', $data[0]);
    }

    public function testItParsesFielValues()
    {
        $parser = new Parser($this->getSampleCsvFile());
        $data = $parser->toArray();
        $entry = $data[1];

        $this->assertEquals('Mission', $entry['Project']);
        $this->assertEquals('Mission', $entry['Client']);
        $this->assertEquals('Planning: Stand-up meeting', $entry['Description']);
        $this->assertEquals('', $entry['Task']);
        $this->assertEquals('Vlass', $entry['User']);
        $this->assertEquals('17748144+vlasscontreras@users.noreply.github.com', $entry['Email']);
        $this->assertEquals('', $entry['Tags']);
        $this->assertEquals('Yes', $entry['Billable']);
        $this->assertEquals('01/12/2022', $entry['Start Date']);
        $this->assertEquals('07:18:00 AM', $entry['Start Time']);
        $this->assertEquals('01/12/2022', $entry['End Date']);
        $this->assertEquals('07:59:00 AM', $entry['End Time']);
        $this->assertEquals('00:41:00', $entry['Duration (h)']);
        $this->assertEquals('0.68', $entry['Duration (decimal)']);
    }

    private function getSampleCsvFile(): string
    {
        return dirname(__DIR__, 3) . '/data/sample.csv';
    }
}
