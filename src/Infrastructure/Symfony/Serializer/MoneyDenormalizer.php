<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Serializer;

use Brick\Money\Money;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class MoneyDenormalizer implements DenormalizerInterface
{

    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        return Money::of($data['amount'], $data['currency']);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return $type === Money::class;
    }
}