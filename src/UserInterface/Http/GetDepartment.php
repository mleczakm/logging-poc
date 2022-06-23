<?php

declare(strict_types=1);

namespace App\UserInterface\Http;

use App\Application\Query\Departments;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Ulid;

final class GetDepartment
{
    public function __construct(private readonly Departments $departments)
    {
    }

    public function __invoke(string $id): Response
    {
        $department = $this->departments->byId(Ulid::fromString($id));

        if ($department === null) {
            return new Response(status: Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(
            data:   [
                        'id' => $id,
                        'strategy' => $department->strategy,
                    ],
            status: 200,
        );
    }
}