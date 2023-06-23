<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NewControllerTest extends WebTestCase
{
    private readonly KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = self::createClient();
    }

    public function testIndex(): void
    {
        $this->client->request('GET', '/new');

        // Asserts that '/new' URI matches the app_new route
        $this->assertRouteSame('app_new');

        // Asserts that index action return type is Response
        $response = $this->client->getResponse();
        $this->assertInstanceOf(Response::class, $response);

        // Asserts that the response was successful (HTTP status is 2xx).
        $this->assertResponseIsSuccessful();
    }
}
