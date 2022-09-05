<?php

declare(strict_types=1);

namespace App\Task;

use Ds\Map;
use Monolog\Logger;
use Swoole\Http\Server;
use Swoole\Server\Task;

class Handler
{
    private Logger $logger;
    /**
     * @var Map<string, callable>
     */
    private Map $handlers;

    /**
     * Handler constructor.
     *
     * @param Map<string, callable> $handlers
     */
    public function __construct(Logger $logger, Map $handlers)
    {
        $this->logger = $logger;
        $this->handlers = $handlers;
    }

    public function start(Server $server, int $workerId): void
    {
        $this->logger->info('Starting worker #' . $workerId);
    }

    public function handle(Server $server, Task $task): bool
    {
        $message = $task->data;
        $messageClass = get_class($message);

        ($logger = $this->logger)->info(
            'Starting task handling on worker #' . $task->worker_id,
            [
                'type' => $messageClass,
                'message' => $message,
                'worker_id' => $task->worker_id,
            ]
        );

        try {
            if (!is_string($messageClass) || !$this->handlers->hasKey($messageClass)) {
                throw new \LogicException('Unexpected message type: ' . $messageClass);
            }
            $this->handlers->get($messageClass)($message);

            $logger->info('Successfully handled message',
                [
                    'type' => $messageClass,
                    'message' => $message,
                    'worker_id' => $task->worker_id,
                ]
            );

            return true;
        } catch (\Throwable $throwable) {
            $logger->error('Handling task failed',
                [
                    'exception' => $throwable,
                    'type' => $messageClass,
                    'message' => $message,
                ]);

            return false;
        } finally {
            $this->logger->reset();
        }
    }

    public function finish(int $workerId): void
    {
        ($logger = $this->logger)->info('Stopping worker #' . $workerId);
        $logger->reset();
    }
}
