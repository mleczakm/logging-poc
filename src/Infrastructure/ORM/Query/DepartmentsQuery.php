<?php

declare(strict_types=1);

namespace App\Infrastructure\ORM\Query;

use App\Application\Query\Department;
use App\Application\Query\Departments;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Ulid;

final class DepartmentsQuery implements Departments
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {

    }

    public function byId(Ulid $id): ?Department
    {
        $departmentDto = Department::class;
        $departmentEntityClass = \App\Infrastructure\ORM\Entity\Department::class;

        return $this->entityManager
            ->createQuery(<<<DQL
                SELECT NEW $departmentDto(department.id, department.name, department.strategy)
                FROM $departmentEntityClass department
                WHERE department.id = :id
                DQL
            )
            ->setParameter('id', $id, 'ulid')
            ->getOneOrNullResult();
    }
}