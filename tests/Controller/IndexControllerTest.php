<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase
{
    private readonly KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = self::createClient();
    }

    public function testIndex(): void
    {
        $this->client->request('GET', '/');

        // Asserts that '/' URI matches the app_index route
        $this->assertRouteSame('app_index');

        // Asserts that index action return type is Response
        $response = $this->client->getResponse();
        $this->assertInstanceOf(Response::class, $response);

        // Asserts that the response was successful (HTTP status is 2xx).
        $this->assertResponseIsSuccessful();
    }
}
