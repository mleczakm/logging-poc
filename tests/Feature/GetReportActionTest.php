<?php

declare(strict_types=1);

namespace App\Tests\Feature;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Uid\Ulid;

final class GetReportActionTest extends WebTestCase
{
    /** @test */
    public function returnsValidMonthlyPayoutReport(): void
    {
        $client = self::createClient();
        $client->request('POST',
                         '/department',
                         [
                             'id' => $departmentId = Ulid::generate(),
                             'name' => 'HR',
                             'strategy' => [
                                 'name' => 'constant',
                                 'amount' => 100,
                             ],
                         ]);
        $client->request('POST',
                         '/user',
                         [
                             'id' => Ulid::generate(),
                             'department_id' => $departmentId,
                             'name' => 'Michał',
                             'surname' => 'Mleczko',
                             'payout' => 123,
                             'seniority' => 15
                         ]);

        $client->request('GET', '/report',);

        self::assertStringEqualsFile(__DIR__ . '/report', $client->getResponse()->getContent());
    }
}