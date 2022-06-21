<?php

declare(strict_types=1);

namespace App\Infrastructure\ORM\Entity;

use Symfony\Component\Uid\Ulid;

final class User
{
    public function __construct(
        private Ulid $id,
        private string $name,
        private string $surname,
        private string $department,
    )
    {

    }
}