<?php

declare(strict_types=1);

namespace VlassContreras\Clockission\Contracts;

interface Command
{
    /**
     * Run the command.
     *
     * @param array $arguments
     * @return void
     */
    public function run(array $arguments): void;
}
