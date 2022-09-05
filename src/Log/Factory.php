<?php

declare(strict_types=1);

namespace App\Log;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class Factory
{
    public static function create(bool $debug = false): LoggerInterface
    {
        return (new Logger('poc'))
            ->pushHandler(
                new StreamHandler(
                    STDOUT,
                    $debug ? Logger::DEBUG : Logger::INFO
                )
            )
        ;
    }
}
