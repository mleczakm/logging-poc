<?php

declare(strict_types=1);

namespace App\Infrastructure\ORM\Entity;

use App\Infrastructure\ORM\Entity\VO\Amount;
use Brick\Money\Money;
use Symfony\Component\Uid\Ulid;

final class User
{
    public function __construct(
        public readonly Ulid $id,
        public readonly string $name,
        public readonly string $surname,
        public readonly int $seniority,
        public readonly Money $payout,
        public readonly Department $department,
    ) {

    }
}