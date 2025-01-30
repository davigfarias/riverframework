<?php

namespace Config;

use Dotenv\Dotenv;

final class FrameworkEnvironment
{
    private static ?Dotenv $dotenv = null;

    public static function initialize(): void
    {
        if(self::$dotenv === null)
        {
            self::$dotenv = Dotenv::createImmutable(__DIR__."/../");
            self::$dotenv->load();
        }
    }

    public static function getEnv(string $key)
    {
        if(!is_string($key))
        {
            throw new \InvalidArgumentException('The $key must be a string');
        }
        
        return $_ENV[$key] ?? null;
    }
}