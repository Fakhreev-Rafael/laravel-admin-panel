<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;

class Logger 
{
    /**
     * Return the Log facade with HTTP channel.
     * 
     * @return \Psr\Log\LoggerInterface
     */
    public static function http(): LoggerInterface
    {
        return Log::channel('http');
    }

    /**
     * Return the Log facade with Errors channel.
     * 
     * @return \Psr\Log\LoggerInterface
     */
    public static function errors(): LoggerInterface
    {
        return Log::channel('errors');
    }

    /**
     * Return the Log facade with Database channel.
     * 
     * @return \Psr\Log\LoggerInterface
     */
    public static function database(): LoggerInterface
    {
        return Log::channel('database');
    }

    /**
     * Return the Log facade with Application channel.
     * 
     * @return \Psr\Log\LoggerInterface
     */
    public static function application(): LoggerInterface
    {
        return Log::channel('application');
    }

    /**
     * Return the Log facade with Dev channel.
     * 
     * @return \Psr\Log\LoggerInterface
     */
    public static function dev(): LoggerInterface
    {
        return Log::channel('dev');
    }
}