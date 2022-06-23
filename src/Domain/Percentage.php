<?php

declare(strict_types=1);

namespace App\Domain;

final class Percentage implements Strategy
{
    public function __construct(public readonly float $percentage)
    {
        if ($this->percentage < 0 ) {
            throw new \LogicException();
        }
    }
}