<?php

declare(strict_types=1);

namespace App\Infrastructure\ORM\Entity;

use App\Domain\Constant;
use App\Domain\Percentage;
use App\Infrastructure\ORM\Entity\VO\Strategy;
use Symfony\Component\Uid\Ulid;

final class Department
{
    private function __construct(
        public readonly Ulid $id,
        public readonly string $name,
        public readonly Strategy $strategy,
    ) {

    }

    public static function fromDomainObject(\App\Domain\Department $department): self
    {
        $strategy = match (get_class($department->strategy)) {
            Constant::class => new VO\Constant($department->strategy->amount),
            Percentage::class => new VO\Percentage($department->strategy->percentage),
        };

        return new self(
            $department->id,
            $department->name,
            $strategy
        );
    }
}