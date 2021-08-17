<?php

declare(strict_types=1);

namespace App\Log;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * @author Michał Mleczko <michal.mleczko@iiit.pl>
 */
class Factory
{
    public static function create(bool $debug = false): Logger
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
