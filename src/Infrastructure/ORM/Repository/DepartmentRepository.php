<?php

declare(strict_types=1);

namespace App\Infrastructure\ORM\Repository;

use App\Domain\Department;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DepartmentRepository extends ServiceEntityRepository implements \App\Domain\DepartmentRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, \App\Infrastructure\ORM\Entity\Department::class);
    }

    public function add(Department $department)
    {
        $this->getEntityManager()->persist(\App\Infrastructure\ORM\Entity\Department::fromDomainObject($department));
    }
}