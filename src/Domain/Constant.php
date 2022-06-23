<?php

declare(strict_types=1);

namespace App\Domain;

use Brick\Money\Money;

final class Constant implements Strategy
{
    public function __construct(public readonly Money $amount)
    {
    }
}