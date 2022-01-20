<?php

declare(strict_types=1);

namespace VlassContreras\Clockission\Contracts;

interface Command
{
    /**
     * Run the command.
     *
     * @param array<int, string> $arguments
     * @return void
     */
    public function run(array $arguments): void;
}
