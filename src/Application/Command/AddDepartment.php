<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Strategy;

final class AddDepartment
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly Strategy $strategy,
    )
    {
    }
}