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
        $response = json_decode($clientService->listClients());

        $statusCode = $clientService->getStatusCode();

        $this->assertEquals(200, $statusCode, 'A API deve retornar status 200');
        $this->assertIsString($response->object, "O campo object deve retornar uma string.");
        $this->assertIsBool($response->hasMore, "O campo hasMore deve retornar true ou false.");
        $this->assertIsInt($response->totalCount, "O campo totalCount deve retornar um número inteiro.");
        $this->assertIsInt($response->limit, "O campo limit deve retornar um número inteiro.");
        $this->assertIsInt($response->offset, "O campo offset deve retornar um número inteiro.");
        $this->assertIsArray($response->data, "O campo data deve retornar um array de dados.");
        
        foreach ($response->data as $client) {
            $this->assertIsString($client->id, "O campo data->id deve retornar uma string.");
            $this->assertIsString($client->name, "O campo data->name deve retornar uma string.");
        }
    }

    public function testListAllClients403(): void
    {
        $clientService = new ClientService();
        $endpoint = $clientService->getEndpoint();
        $endpoint = explode("?", $endpoint);
        $clientService->setEndpoint($endpoint[0]);

        $response = json_decode($clientService->listClients());
        $statusCode = $clientService->getStatusCode();

        $this->assertEquals(401, $statusCode, "A API deve retornar status 401");
        $this->assertNull($response, "", "A API não deve retornar nada");
    }
}
