<?php

declare(strict_types=1);

namespace Functional\Infrastructure\ORM\Query;

use App\Domain\Department;
use App\Domain\DepartmentRepository;
use App\Domain\Percentage;
use App\Infrastructure\ORM\Query\DepartmentsQuery;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Ulid;

final class DepartmentsQueryTest extends KernelTestCase
{
    /** @test */
    public function returnNullOrExistingDepartment(): void
    {
        self::bootKernel();
        self::assertNull(self::getContainer()->get(DepartmentsQuery::class)->byId(new Ulid()));

        $id = new Ulid();
        self::getContainer()->get(DepartmentRepository::class)->add(
            new Department(
                $id,
                'some name',
                new Percentage(12.37),
            )
        );
        self::getContainer()->get(EntityManagerInterface::class)->flush();

        self::assertNotNull(self::getContainer()->get(DepartmentsQuery::class)->byId($id));
    }
}