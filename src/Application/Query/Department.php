<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Infrastructure\ORM\Entity\VO\Strategy;

final class Department
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly Strategy $strategy,
    ) {
    }
}