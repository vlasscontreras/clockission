<?php

declare(strict_types=1);

namespace VlassContreras\Clockission\Config;

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidEncodingException;
use Dotenv\Exception\InvalidFileException;

class Config
{
    /**
     * Set up config
     *
     * @return void
     * @throws InvalidEncodingException
     * @throws InvalidFileException
     */
    public function __construct()
    {
        $dotenv = Dotenv::createMutable($this->getEnvironmentPath());
        $dotenv->safeLoad();
    }

    /**
     * Get a config value from environment
     *
     * @param string $key
     * @param string $default
     * @return string|null
     */
    public function get(string $key, string $default = null): ?string
    {
        $key = strtoupper($key);

        return $_SERVER[$key] ?? $default;
    }

    /**
     * Get the environment path
     *
     * @return string
     */
    protected function getEnvironmentPath(): string
    {
        return dirname(__DIR__, 2);
    }
}
