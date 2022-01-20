<?php

declare(strict_types=1);

namespace VlassContreras\Clockission\Contracts;

interface Arrayable
{
    /**
     * Convert the object to array.
     *
     * @return array<mixed, mixed>
     */
    public function toArray(): array;
}
