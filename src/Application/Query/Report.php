<?php

declare(strict_types=1);

namespace App\Application\Query;

interface Report
{
    public function monthly(string $orderBy, array $filterOut = []): string;
}