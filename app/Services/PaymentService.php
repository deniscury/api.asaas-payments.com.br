<?php

namespace App\Services;

use App\Constants\AsaasConstants;

class PaymentService extends CurlService
{
    protected $apiKey = AsaasConstants::API_KEY;
    protected $customerId;

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

    public function generate($body){
        $this->setMethod("POST");

        $body['customer'] = $this->getCustomerId();

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

    /**********************
    **-------------------**
    ** GETTERS E SETTERS **
    **-------------------**
    ***********************/
    public function getCustomerId()
    {
        return $this->customerId;
    }

    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
    }
    
}
