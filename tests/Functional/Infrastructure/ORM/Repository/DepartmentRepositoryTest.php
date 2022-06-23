<?php

declare(strict_types=1);

namespace Functional\Infrastructure\ORM\Repository;

use App\Application\Query\Departments;
use App\Domain\Constant;
use App\Domain\Department;
use App\Domain\DepartmentRepository;
use Brick\Money\Money;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Ulid;

final class DepartmentRepositoryTest extends KernelTestCase
{
    /** @test */
    public function persistObjectOnAdd(): void
    {
        self::bootKernel();
        $departmentRepository = self::getContainer()->get(DepartmentRepository::class);
        $departmentRepository->add(
            new Department(
                $ulid = new Ulid(),
                'name',
                new Constant(Money::of(123, 'USD'))
            )
        );

        $departmentsQuery = self::getContainer()->get(Departments::class);
        self::assertNull($departmentsQuery->byId($ulid));

        self::getContainer()->get(EntityManagerInterface::class)->flush();

        self::assertInstanceOf(\App\Application\Query\Department::class, $departmentsQuery->byId($ulid));

    }
}