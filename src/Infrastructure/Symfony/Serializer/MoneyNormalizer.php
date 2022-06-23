<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Serializer;

use Brick\Money\Money;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class MoneyNormalizer implements NormalizerInterface
{

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        if (! $object instanceof Money) {
            throw new \InvalidArgumentException();
        }

        return [
            'amount' => (string)$object->getAmount(),
            'currency' => (string)$object->getCurrency(),
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof Money;
    }
}