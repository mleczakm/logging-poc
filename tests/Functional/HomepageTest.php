<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class HomepageTest extends WebTestCase
{
    /** @test */
    public function show404OnHomepage(): void
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}