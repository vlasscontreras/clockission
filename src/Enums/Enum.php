<?php

declare(strict_types=1);

namespace VlassContreras\Clockission\Enums;

use ReflectionClass;
use VlassContreras\Clockission\Contracts\Enum as EnumInterface;

abstract class Enum implements EnumInterface
{
    /**
     * @inheritDoc
     */
    public static function getConstants(): array
    {
        $reflection = new ReflectionClass(static::class);

        /** @var string[] */
        return $reflection->getConstants();
    }

    /**
     * @inheritDoc
     */
    public static function cases(): array
    {
        return array_values(static::getConstants());
    }
}
