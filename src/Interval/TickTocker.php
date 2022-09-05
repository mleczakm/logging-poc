<?php

declare(strict_types=1);

namespace App\Interval;

use Psr\Log\LoggerInterface;

final class TickTocker
{
    private bool $state = true;

    public function __construct(private LoggerInterface $logger)
    {
    }

    public function __invoke(): void
    {
        $this->logger->debug($this->state ? 'Tick!' : 'Tock!');
        $this->state = !$this->state;
    }
}