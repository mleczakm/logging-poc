<?php

declare(strict_types=1);

namespace Feature;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Ulid;

final class AddUserTest extends WebTestCase
{
    /** @test */
    public function shouldAddUserOnPost(): void
    {
        $client = self::createClient();
        $client->request('POST',
                         '/department',
                         [
                             'id' => $departmentId = Ulid::generate(),
                             'name' => 'HR',
                             'strategy' => [
                                 'name' => 'constant',
                                 'amount' => 112.12,
                             ],
                         ]);
        $client->request('POST',
                         '/user',
                         [
                             'id' => $id = Ulid::generate(),
                             'department_id' => $departmentId,
                             'name' => 'Michał',
                             'surname' => 'Mleczko',
                             'payout' => '112.12',
                         ]);

        self::assertSame(Response::HTTP_NO_CONTENT, $client->getResponse()->getStatusCode());
    }
}