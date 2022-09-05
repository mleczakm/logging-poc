<?php

declare(strict_types=1);

namespace App\Log;

use Psr\Log\LoggerInterface;

class Factory
{
    public static function create(bool $debug = false): LoggerInterface
    {
        return new StdOutLogger($debug);
    }
}
