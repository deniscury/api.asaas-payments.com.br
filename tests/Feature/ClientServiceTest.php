<?php

namespace Tests\Feature;

use App\Services\ClientService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ClientServiceTest extends TestCase
{
    public function testListAllClients200(): void
    {
        $clientService = new ClientService();
        $clientService->list();

        $statusCode = $clientService->getStatusCode();

        $this->assertEquals(200, $statusCode, 'A API deve retornar status 200');
    }

    public function testListAllClients403(): void
    {
        $clientService = new ClientService();
        $endpoint = $clientService->getEndpoint();
        $endpoint = explode("?", $endpoint);
        $clientService->setEndpoint($endpoint[0]);

        $clientService->list();
        $statusCode = $clientService->getStatusCode();

        $this->assertEquals(401, $statusCode, "A API deve retornar status 401");
    }
}
