<?php

declare(strict_types=1);

namespace Feature;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Ulid;

final class AddDepartmentTest extends WebTestCase
{
    /** @test */
    public function shouldAddDepartmentOnPost(): void
    {
        $client = self::createClient();
        $client->request('POST',
                         '/department',
                         [
                             'id' => $id = Ulid::generate(),
                             'name' => 'HR',
                             'strategy' => [
                                 'name' => 'constant',
                                 'amount' => 112.12,
                             ],
                         ]);
        self::assertSame(Response::HTTP_NO_CONTENT, $client->getResponse()->getStatusCode());

        $client->request('GET', '/department/' . $id);

        self::assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $responseContent = $client->getResponse()->getContent();

        self::assertSame(
            [
                'id' => $id,
                'strategy' => [
                    'name' => 'constant',
                    'amount' => [
                        'amount' => '112.12',
                        'currency' => 'USD',
                    ],
                ],
            ],
            json_decode($responseContent, true),
        );

    }
}