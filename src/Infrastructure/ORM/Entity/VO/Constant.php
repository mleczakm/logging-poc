<?php

declare(strict_types=1);

namespace App\Infrastructure\ORM\Entity\VO;

use Brick\Money\Money;
use JetBrains\PhpStorm\Internal\TentativeType;

final class Constant implements Strategy, \JsonSerializable
{
    public const NAME = 'constant';

    public function __construct(public readonly Money $amount)
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => self::NAME,
            'amount' => [
                'amount' => (string) $this->amount->getAmount(),
                'currency' => (string) $this->amount->getCurrency(),
            ]
        ];
    }
}