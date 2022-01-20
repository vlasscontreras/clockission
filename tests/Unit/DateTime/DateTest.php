<?php

declare(strict_types=1);

namespace Tests\Unit\DateTime;

use PHPUnit\Framework\TestCase;
use VlassContreras\Clockission\DateTime\Date;

class DateTest extends TestCase
{
    public function testItConvertsDateToIso8601Date(): void
    {
        $this->assertEquals('2022-01-11', Date::toIso8601Date('01/11/2022'));
        $this->assertEquals('2022-08-10', Date::toIso8601Date('08/10/2022'));
    }
}
