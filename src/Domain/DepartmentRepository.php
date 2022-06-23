<?php

declare(strict_types=1);

namespace App\Domain;

interface DepartmentRepository
{
    public function add(Department $department);
}