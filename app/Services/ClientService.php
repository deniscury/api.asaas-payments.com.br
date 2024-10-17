<?php

namespace App\Services;

use App\Constants\AsaasConstants;

class ClientService extends CurlService
{
    protected $apiKey = AsaasConstants::API_KEY;

    public function __construct($customerId = null)
    {
        $this->setUrl(AsaasConstants::URL);

        $headers = array(
            "accept" => "application/json", 
            "content-type" => "application/json"
        );

        $this->setHeader($headers);
        
        $endpoint = "customers";

        if (!is_null($customerId)){
            $endpoint .= "/$customerId";
        }

        $endpoint .= "?access_token=$this->apiKey";

        $this->setEndpoint($endpoint);
    }

    public function registerClient($body){
        $this->setMethod("POST");
        $this->setBody($body);

        $response = $this->request();

        return $response;
    }

    public function listClients(){
        $this->setMethod("GET");

        $response = $this->request();

        return $response;
    }

    public function updateClient(){
        $this->setMethod("DELETE");
        $response = $this->request();

        return $response;
    }

    public function restoreClient(){
        $endpoint = $this->getEndpoint();
        $endpoint = explode("?", $endpoint);

        $endpoint = "$endpoint[0]/restore$endpoint[1]";

        $this->setMethod("POST");
        $response = $this->request();

        return $response;
    }

    public function notificationClient(){
        $endpoint = $this->getEndpoint();

        $endpoint = "$endpoint[0]/notification$endpoint[1]";

        $this->setMethod("GET");
        $response = $this->request();

        return $response;
    }
}
