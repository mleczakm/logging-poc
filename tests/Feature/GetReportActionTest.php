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

    /** @test */
    public function shouldFilterOutSupportedFields(): void
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
                             'name' => 'Zichał',
                             'surname' => 'Mleczko',
                             'payout' => 123,
                             'seniority' => 15
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

        $allData = $client->getResponse()->getContent();
        $client->request('GET', '/report?filterOut[name]=Zichał',);
        $filtered = $client->getResponse()->getContent();

        self::assertNotSame($allData, $filtered, $allData);
        self::assertStringContainsString('1 rows', $filtered);
        self::assertStringContainsString('2 rows', $allData);
    }

    /** @test */
    public function returnBadRequestOnNotSupportedColumn(): void
    {
        $client = self::createClient();
        $client->request('GET', '/report?orderBy=xyz',);

        self::assertResponseStatusCodeSame(400);
    }
}