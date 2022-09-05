<?php

declare(strict_types=1);

namespace App\Action;

use App\Message\NullTask;
use Psr\Log\LoggerInterface;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;

class IndexAction
{
    private Server $server;

    private LoggerInterface $logger;

    public function __construct(Server $server, LoggerInterface $logger
    ) {
        $this->server = $server;
        $this->logger = $logger;
    }

    public function __invoke(Request $request, Response $response): void
    {
        $this->logger->info('Handling request', [
            'request_uri' => $request->server['request_uri'],
        ]);

        try {
            $this->server->task(new NullTask(bin2hex(random_bytes(5))));

            if (empty($requestTime = (float) $request->server['request_time_float'])) {
                throw new \LogicException('Request time is no longer available!');
            }
            $response->end((string) $requestTime);
            return;
        } catch (\Throwable $throwable) {
            $this->logger->error('Handling request failed', ['exception' => $throwable]);
        } finally {
            $this->logger->reset();
        }
    }
}
