<?php

declare(strict_types=1);

namespace VlassContreras\Clockission\Contracts;

interface Enum
{
    /**
     * Get the enum values.
     *
     * @return array
     */
    public static function getValues(): array;
}
