<?php

declare(strict_types=1);

namespace VlassContreras\Clockission\Enums;

use ReflectionClass;
use VlassContreras\Clockission\Contracts\Enum as EnumInterface;

abstract class Enum implements EnumInterface
{
    /**
     * @inheritdoc
     */
    public static function getValues(): array
    {
        return array_values(static::toArray());
    }

    /**
     * @inheritdoc
     */
    public static function toArray(): array
    {
        return (new ReflectionClass(static::class))->getConstants();
    }
}
