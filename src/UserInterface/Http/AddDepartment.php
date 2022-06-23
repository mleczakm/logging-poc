<?php

declare(strict_types=1);

namespace App\UserInterface\Http;

use App\Domain\Constant;
use App\Domain\Percentage;
use Brick\Money\Money;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

final class AddDepartment
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
    }

    public function __invoke(Request $request): Response
    {
        $data = $request->request;

        //todo should be encapsulated in some factory
        $strategy = match ($data->all('strategy')['name']) {
            'constant' => new Constant(Money::of($data->all('strategy')['amount'], 'USD')),
            'percentage' => new Percentage((float)$data->all('strategy')['percentage']),
        };

        $this->messageBus->dispatch(
            new \App\Application\Command\AddDepartment(
                $data->get('id'),
                $data->get('name'),
                $strategy
            )
        );

        return new Response(status: 204);
    }
}