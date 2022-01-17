<?php

declare(strict_types=1);

namespace VlassContreras\Clockission\TimeSlip\Enums;

use VlassContreras\Clockission\Enums\Enum;

class ActivityType extends Enum
{
    protected const PRODUCTION = 'Production';
    protected const PLANNING = 'Planning';
    protected const COMMUNICATION = 'Communication';
    protected const REVIEW = 'Review';
}
