<?php

declare(strict_types=1);

namespace VlassContreras\Clockission\Contracts;

interface Arrayable
{
    /**
     * Convert the object to array.
     *
     * @return array
     */
    public function toArray(): array;
}
