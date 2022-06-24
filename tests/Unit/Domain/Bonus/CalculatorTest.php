<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Bonus;

use App\Domain\Bonus\Calculator;
use App\Domain\Constant;
use App\Domain\Percentage;
use App\Domain\Strategy;
use Brick\Money\Money;
use PHPUnit\Framework\TestCase;

final class CalculatorTest extends TestCase
{
    /**
     * @test
     * @dataProvider seniorityPayoutAndStrategyToExpectedBonusProvider
     */
    public function shouldCalculateBonusAsExpected(int $seniority, Money $payout, Strategy $strategy, Money $expectedBonus): void
    {
        self::assertEquals(
            $expectedBonus,
            (new Calculator())->basedOnSeniority($seniority, $payout, $strategy)
        );
    }

    public function seniorityPayoutAndStrategyToExpectedBonusProvider(): \Generator
    {
        yield 'constant bonus, below 10 years of seniority' => [
            8,
            Money::of(123, 'USD'),
            new Constant(Money::of(100, 'USD')),
            Money::of(800, 'USD')
        ];

        yield 'constant bonus, over 10 years of seniority' => [
            15,
            Money::of(123, 'USD'),
            new Constant(Money::of(100, 'USD')),
            Money::of(1000, 'USD')
        ];

        yield 'percentage bonus' => [
            15,
            Money::of(1100, 'USD'),
            new Percentage(10.00),
            Money::of(110, 'USD')
        ];
    }
}