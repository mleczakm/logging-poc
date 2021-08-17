<?php

declare(strict_types=1);

namespace App\Message;

use App\Event\Unload;
use App\Event\Unload\ScrollMap;
use App\Event\Unload\Url;

/**
 * @author Michał Mleczko <michal.mleczko@iiit.pl>
 */
final class NullTask
{
    public function __construct(public string $someData)
    {}
}
