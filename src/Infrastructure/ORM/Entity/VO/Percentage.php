<?php

declare(strict_types=1);

namespace App\Infrastructure\ORM\Entity\VO;

use JetBrains\PhpStorm\Internal\TentativeType;

final class Percentage implements Strategy, \JsonSerializable
{
    public const NAME = 'percentage';

    public function __construct(public readonly float $percentage)
    {
    }


    public function jsonSerialize(): array
    {
        return [
            'name' => self::NAME,
            'percentage' => $this->percentage
        ];
    }
}