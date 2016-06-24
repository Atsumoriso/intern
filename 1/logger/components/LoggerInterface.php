<?php

namespace logger\components;

/**
 * Interface LoggerInterface
 *
 * declares methods for logger
 * 
 */
interface LoggerInterface
{
    public function warning($message);

    public function error($message);

    public function notice($message);
}