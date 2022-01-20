<?php

declare(strict_types=1);

namespace VlassContreras\Clockission\Contracts;

interface Enum
{
    /**
     * Get the class constants
     *
     * @return array<string, string>
     */
    public static function getConstants(): array;

    /**
     * Get the enum values.
     *
     * @return array<int, string>
     */
    public static function cases(): array;
}
