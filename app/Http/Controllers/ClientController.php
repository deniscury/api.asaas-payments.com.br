<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientResource;
use App\Http\Resources\ClientsCollection;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;

use App\Models\Client;

use App\Services\ClientService;
use App\Services\AppService;

use Exception;
use Illuminate\Support\MessageBag;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller
{
    public function index()
    {     
        try{
            $clients = new ClientsCollection(Client::all());

            return AppService::return(Response::HTTP_OK, $clients);
        }
        catch(Exception $e){
            $error = new MessageBag(array($e->getMessage()));
            return AppService::return(Response::HTTP_INTERNAL_SERVER_ERROR, array(), "Algo errado aconteceu", $error);
        }
    }

    public function store(StoreClientRequest $request)
    {
        try{
            $request = $request->validated();
            
            $clientService = new ClientService();

            $body = array(
                "name" => $request['name'],
                "cpfCnpj" => $request['document'],
                "email"=> $request['email'],
                "phone" => $request['phone'],
                "postalCode" => $request['postal_code'],
                "address" => $request['address'],
                "addressNumber" => $request['address_number']
            );

            $response = json_decode($clientService->register($body));
            
            $statusCode = $clientService->getStatusCode();

            if($statusCode == Response::HTTP_OK){
                $request["customer_id"] = $response->id;
                
                $client = Client::create($request);

                $client->asaas = $response;

                if($client){
                    $client = new ClientResource($client);
                    return AppService::return(Response::HTTP_CREATED, $client);
                }
            }

            $errors = isset($response->errors)?$response->errors:false;
            $errors = new MessageBag(($errors?array_column($errors, 'description'):array()));
            
            return AppService::return($statusCode, null, 'Algo errado aconteceu', $errors);
        }
        catch(Exception $e){
            $error = new MessageBag(array($e->getMessage()));
            return AppService::return(Response::HTTP_INTERNAL_SERVER_ERROR, array(), "Algo errado aconteceu", $error);
        }
    }
    
    public function show($client)
    {
        try{
            $client = Client::with('invoices')->find($client);

            if (!$client){
                return AppService::return(Response::HTTP_NOT_FOUND, array(), "Cliente não encontrado");
            }

            if (!is_null($client->customer_id)){
                $clientService = new ClientService($client->customer_id);

                $client->asaas = json_decode($clientService->list());
            }

            $client = new ClientResource($client);
            return AppService::return(Response::HTTP_OK, $client);
        }
        catch(Exception $e){
            $error = new MessageBag(array($e->getMessage()));
            return AppService::return(Response::HTTP_INTERNAL_SERVER_ERROR, array(), "Algo errado aconteceu", $error);
        }
    }
    
    public function update(UpdateClientRequest $request, $client)
    {
        try{
            $client = Client::find($client);

            if (!$client){
                return AppService::return(Response::HTTP_NOT_FOUND, array(), "Cliente não encontrado");
            }

            $request = $request->validated();

            $clientService = new ClientService($client->customer_id);

            $body = array(
                "name" => $request['name'],
                "cpfCnpj" => $request['document'],
                "email"=> $request['email'],
                "phone" => $request['phone'],
                "postalCode" => $request['postal_code'],
                "address" => $request['address'],
                "addressNumber" => $request['address_number']
            );
            $body = json_encode($body);

            if (!is_null($client->customer_id)){
                $response = json_decode($clientService->update($body));                
            }
            else{
                $response = json_decode($clientService->register($body));
            }
            
            $statusCode = $clientService->getStatusCode();

            if($statusCode == Response::HTTP_OK){
                $client->name = $request['name'];
                $client->document = $request['document'];
                $client->email = $request['email'];
                $client->phone = $request['phone'];
                $client->postal_code = $request['postal_code'];
                $client->address = $request['address'];
                $client->address_number = $request['address_number'];
                $client->customer_id = $response->id;
                
                $client->save();

                $client->asaas = $response;

                $client = new ClientResource($client);
                return AppService::return(Response::HTTP_CREATED, $client);
            }

            $errors = isset($response->errors)?$response->errors:false;
            $errors = new MessageBag(($errors?array_column($errors, 'description'):array()));
            
            return AppService::return($statusCode, null, 'Algo errado aconteceu', $errors);
        }
        catch(Exception $e){
            $error = new MessageBag(array($e->getMessage()));
            return AppService::return(Response::HTTP_INTERNAL_SERVER_ERROR, array(), "Algo errado aconteceu", $error);
        }
    }
    
    public function destroy($client)
    {
        try{
            $client = Client::find($client);

            if (!$client){
                return AppService::return(Response::HTTP_NOT_FOUND, array(), "Cliente não encontrado");
            }

            if (!is_null($client->customer_id)){
                $clientService = new ClientService($client->customer_id);
                $response = json_decode($clientService->delete());
            }

            $client->delete();

            $client->asaas = $response;
            $client = new ClientResource($client);
            
            return AppService::return(Response::HTTP_OK, $client, "Cliente excluído com sucesso");

        }
        catch(Exception $e){
            $error = new MessageBag(array($e->getMessage()));
            return AppService::return(Response::HTTP_INTERNAL_SERVER_ERROR, array(), "Algo errado aconteceu", $error);
        }
    }
    
    public function restore($client)
    {
        try{
            $client = Client::onlyTrashed()->find($client);

            if (!$client){
                return AppService::return(Response::HTTP_NOT_FOUND, array(), "Cliente não encontrado");
            }
            if (!is_null($client->customer_id)){
                $clientService = new ClientService($client->customer_id);

                $response = json_decode($clientService->restore());
            }
            $client->restore();

            $client->asaas = $response;
            
            $client = new ClientResource($client);
            
            return AppService::return(Response::HTTP_OK, $client, "Cliente restaurado com sucesso");

        }
        catch(Exception $e){
            $error = new MessageBag(array($e->getMessage()));
            return AppService::return(Response::HTTP_INTERNAL_SERVER_ERROR, array(), "Algo errado aconteceu", $error);
        }
    }
}
