<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\NullTask;
use Psr\Log\LoggerInterface;

/**
 * @author Michał Mleczko <michal.mleczko@iiit.pl>
 */
class NullTaskHandler
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(NullTask $nullTask): void
    {
        sleep($sleepingAmount = random_int(5,18));
        $this->logger->info("Was sleeping for {$sleepingAmount}s while handling task {$nullTask->someData}.");
    }
}
