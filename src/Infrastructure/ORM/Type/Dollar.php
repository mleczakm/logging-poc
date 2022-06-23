<?php

declare(strict_types=1);

namespace App\Infrastructure\ORM\Type;

use Brick\Money\Currency;
use Brick\Money\Money;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class Dollar extends Type
{

    /**
     * @param ?Money $value
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value === null ? $value : (string) $value?->getAmount();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?object
    {
        return $value === null ? $value : Money::of($value, Currency::of('USD'));
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getDecimalTypeDeclarationSQL($column);
    }

    public function getName(): string
    {
        return 'dollar';
    }
}