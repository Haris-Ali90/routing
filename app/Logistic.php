<?php

namespace App;

use Illuminate\Contracts\Logging\Log;
use \JoeyCo\Exception\RoutingException;

class Logistic {

    private $proto = 'https://';
    private $host = 'api.logisticsos.com/';
    private $resource = '/';
    private $version = 'v1';
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
        return $this->proto . $this->host . $this->version;
    }

    public function getJobId() {
        return $this->jobId;
    }

    public function getJobResults() {

        if (json_last_error() != JSON_ERROR_NONE) {
            Log::write('error', 'Failed to JSON encode Routific request body');
            throw new RoutingException();
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->proto . $this->host . $this->version . $this->resource . '='. $this->getJobId(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json',
                'x-api-key: u39csQUNDu9ucayzc09MD83CDedkXduP3KYxvvJZ'
            ),
        ));

        $responseData = curl_exec($curl);
        curl_close($curl);

// dd($responseData);
        if (empty($error)) {
            $response = explode("\n", $responseData);
            $httpCode = explode(' ', $response[0]);
            $httpCode = $httpCode[1];

            if ($httpCode >= 300) {
                //   Log::write('error', print_r($responseData, true));
                //throw new RoutingException();
            }

            $results = $response[count($response) - 1];
            $results = json_decode($results, true);

            if (json_last_error() != JSON_ERROR_NONE) {
                //  Log::write('error', print_r($responseData, true));
                //throw new RoutingException();
            }
        } else {
            $results = [];
        }

        return $results;
    }



    /**
     * @throws RoutingException
     */
    public function send() {

        $requestBody = json_encode($this->data);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->getEndpoint(). $this->resource,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $requestBody,
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json',
                'x-api-key: u39csQUNDu9ucayzc09MD83CDedkXduP3KYxvvJZ'
            ),
        ));

        $responseData = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);


        if (empty($error)) {
            $response = explode("\n", $responseData);

            $httpCode = explode(' ', $response[0]);
//            $httpCode = $httpCode[1];

//            if ($httpCode >= 300) {
//                 Log::write('error', print_r($responseData, true));
//                 throw new RoutingException();
//            }

            $results = $response[count($response) - 1];
            $results = json_decode($results);

            if (json_last_error() != JSON_ERROR_NONE) {
                Log::write('error', print_r($responseData, true));
                // throw new RoutingException();
            }
        } else {
            $results = [];
        }

        return $results;


    }
}
