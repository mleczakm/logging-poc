<?php

declare(strict_types=1);

namespace Unit\Infrastructure\ORM\Type;

use App\Infrastructure\ORM\Type\Dollar;
use Brick\Money\Money;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use PHPUnit\Framework\TestCase;

final class DollarTest extends TestCase
{
    private Dollar $dollarType;
    private PostgreSQLPlatform $platform;

    public function setUp(): void
    {
        $this->dollarType = new Dollar();
        $this->platform = new PostgreSQLPlatform();
    }

    /** @test */
    public function convertToDecimalAmount(): void
    {
        $money = Money::of(123, 'PLN');
        $decimal = $this->dollarType->convertToDatabaseValue($money, $this->platform);

        self::assertSame('123.00', $decimal);
    }

    /** @test */
    public function convertFromDecimalAmountToUSD(): void
    {
        self::assertNull($this->dollarType->convertToPHPValue(null, $this->platform));
        self::assertEquals(
            Money::of(123, 'USD'),
            $this->dollarType->convertToPHPValue('123.00', $this->platform));

    }

    /** @test */
    public function isNamedDollar(): void
    {
        self::assertSame(
            'dollar',
            $this->dollarType->getName(),
        );
    }

    /** @test */
    public function usePlatformDecimalDeclaration(): void
    {
        $platformMock = $this->createMock(AbstractPlatform::class);
        $platformMock
            ->expects(self::once())
            ->method('getDecimalTypeDeclarationSQL')
            ->willReturn('')
        ;

        $this->dollarType->getSQLDeclaration([], $platformMock);
    }
}