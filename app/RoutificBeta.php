<?php

namespace App;

use \Laravel\Log;
use \Laravel\Config;
use \JoeyCo\Exception\RoutingException;

class RoutificBeta {
    
    private $proto = 'https://';
    private $host = 'planning-service.beta.routific.com';
    private $resource = '/';
    private $version = '1';
    private $jobId = '';
    
    /**
     * @var array
     */
    private $data = [];
    
    public function __construct($resource) {
        $this->setResource($resource);
    }
    
    public function setJobID($jobId) {
        $this->jobId = $jobId;
    }  
    
    public function setResource($resource) {
        $this->resource = $resource;
    }
    
    public function setData(array $data) {
        $this->data = $data;
    }
    
    private function getEndpoint() {
        return $this->proto . $this->host  . $this->resource;
    }
    
    public function getJobId() {
        return $this->jobId;
    }
        
    public function getJobResults() {

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->getEndpoint()."/".$this->getJobId(),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiJiNzFkOWZkYi01M2ZiLTRjNjEtODE3OC1kZWMxYTk1YmE2NTYiLCJvcmdJZCI6MTE4NiwidXNlcklkIjoyOTYzLCJ0eXBlIjoiYXBpIiwidXNlclV1aWQiOiI3NzRiOTVkNi1mMzA4LTRhNDYtODljYy1iN2Q3OTQ5M2MzYTciLCJpYXQiOjE2NDI1MzQzMTh9.Ge61p41KIbfNteW5GTKk2gEOtFduJhkIdiXKHnHX_Is'
        ),
        ));

        $response = curl_exec($curl);
        
        curl_close($curl);
        return json_decode($response);

    }

    
    
    /**
     * @throws RoutingException
     */
    public function send() {
    
    $curl = curl_init();
    $requestBody = json_encode($this->data);
   
    curl_setopt_array($curl, array(
    CURLOPT_URL => $this->getEndpoint(),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>$requestBody,
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiJiNzFkOWZkYi01M2ZiLTRjNjEtODE3OC1kZWMxYTk1YmE2NTYiLCJvcmdJZCI6MTE4NiwidXNlcklkIjoyOTYzLCJ0eXBlIjoiYXBpIiwidXNlclV1aWQiOiI3NzRiOTVkNi1mMzA4LTRhNDYtODljYy1iN2Q3OTQ5M2MzYTciLCJpYXQiOjE2NDI1MzQzMTh9.Ge61p41KIbfNteW5GTKk2gEOtFduJhkIdiXKHnHX_Is',
        'Content-Type: application/json'
    ),
    ));
    
    $response = curl_exec($curl);
   
    curl_close($curl);
    return json_decode($response);
    }
}
