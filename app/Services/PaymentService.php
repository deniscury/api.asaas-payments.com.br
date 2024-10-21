<?php

namespace App\Services;

use App\Constants\AsaasConstants;

class PaymentService extends CurlService
{
    protected $apiKey = AsaasConstants::API_KEY;

    public function __construct($paymentId = null)
    {
        $this->setUrl(AsaasConstants::URL);

        $headers = array(
            "accept" => "application/json", 
            "content-type" => "application/json"
        );

        $this->setHeader($headers);
        
        $endpoint = "payments";

        if (!is_null($paymentId)){
            $endpoint .= "/$paymentId";
        }

        $endpoint .= "?access_token=$this->apiKey";

        $this->setEndpoint($endpoint);
    }

    public function list(){
        $this->setMethod("GET");

        $response = $this->request();

        return $response;
    }

    public function generate($body){
        $this->setMethod("POST");

        $this->setBody($body);

        $response = $this->request();

        return $response;
    }

    public function pix(){
        $endpoint = $this->getEndpoint();
        $endpoint = explode("?", $endpoint);
        $endpoint = "$endpoint[0]/pixQrCode?$endpoint[1]";

        $this->setEndpoint($endpoint);

        $this->setMethod("GET");

        $response = $this->request();

        return $response;
    }

    public function bill(){
        $endpoint = $this->getEndpoint();
        $endpoint = explode("?", $endpoint);
        $endpoint = "$endpoint[0]/identificationField?$endpoint[1]";

        $this->setEndpoint($endpoint);

        $this->setMethod("GET");

        $response = $this->request();

        return $response;
    }

    public function creditCard($body){
        $endpoint = $this->getEndpoint();
        $endpoint = explode("?", $endpoint);
        $endpoint = "$endpoint[0]/payWithCreditCard?$endpoint[1]";

        $this->setEndpoint($endpoint);

        $this->setMethod("PUT");

        $body = json_encode($body, JSON_UNESCAPED_UNICODE );
        
        $this->setBody($body);

        $response = $this->request();

        return $response;
    } 

    public function money($body){
        $endpoint = $this->getEndpoint();
        $endpoint = explode("?", $endpoint);
        $endpoint = "$endpoint[0]/receiveInCash?$endpoint[1]";

        $this->setEndpoint($endpoint);

        $this->setMethod("POST");
        
        $this->setBody($body);

        $response = $this->request();

        return $response;
    }   
}
