<?php

declare(strict_types=1);

namespace App\Application\Query;

use Symfony\Component\Uid\Ulid;

interface Departments
{
    public function byId(Ulid $id): ?Department;
}