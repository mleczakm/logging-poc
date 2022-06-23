<?php

declare(strict_types=1);

namespace App\Domain;

use Symfony\Component\Uid\Ulid;

final class Department
{
    public function __construct(
        public readonly Ulid $id,
        public readonly string $name,
        public readonly Strategy $strategy
    ) {
    }
}