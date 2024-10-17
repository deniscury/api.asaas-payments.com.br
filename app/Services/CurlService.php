<?php

namespace App\Services;

class CurlService
{
    private $url;
    private $header;
    private $endpoint;
    private $method;
    private $body;
    private $statusCode;

    public function request()
    {
        $curl = curl_init();

        $url = $this->getUrl() . $this->getEndPoint();
        $method = $this->getMethod();
        $header = $this->getHeader();
        $body = $this->getBody();

        if ($method == "POST"){
            curl_setopt($curl, CURLOPT_POST, 1);
        }
        else{
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        }

        $verbose = fopen('php://temp', 'w+');

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, "CurlService/1.0 (denis.cury.1995@hotmail.com; +08)");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_STDERR, $verbose);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

        $response = curl_exec($curl);

        $this->setStatusCode(curl_getinfo($curl, CURLINFO_HTTP_CODE));

        curl_close($curl);

        return $response;
    }

    /**********************
    **-------------------**
    ** GETTERS E SETTERS **
    **-------------------**
    ***********************/
    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    public function getHeader()
    {
        return $this->header;
    }

    public function setHeader($header)
    {
        $this->header = $header;
    }
    
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }
}
