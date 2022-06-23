<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Department;
use App\Domain\DepartmentRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Uid\Ulid;

#[AsMessageHandler]
final class AddDepartmentHandler
{
    public function __construct(private readonly DepartmentRepository $departmentRepository)
    {

    }

    public function __invoke(AddDepartment $addDepartmentCommand)
    {
        $this->departmentRepository->add(
            new Department(
                Ulid::fromString($addDepartmentCommand->id),
                $addDepartmentCommand->name,
                $addDepartmentCommand->strategy,
            )
        );
    }
}