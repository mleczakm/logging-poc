<?php

declare(strict_types=1);

namespace App\Message;

final class NullTask
{
    public function __construct(public string $someData)
    {}
}
