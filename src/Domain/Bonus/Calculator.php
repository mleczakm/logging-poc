<?php

declare(strict_types=1);

namespace App\Domain\Bonus;

use App\Domain\Constant;
use App\Domain\Percentage;
use App\Domain\Strategy;
use Brick\Money\Money;

final class Calculator
{
    public function basedOnSeniority(int $seniority, Money $payout, Strategy $strategy): Money
    {
        return match (get_class($strategy)) {
            Constant::class =>  $strategy->amount->multipliedBy(min(10, $seniority)),
            Percentage::class => $payout->multipliedBy($strategy->percentage/100),
        };
    }
}