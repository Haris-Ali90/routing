<?php

namespace App\Classes;
use App\MerchantIds;

class ReturnOrderCreation {

   
    private $tracking_id;
    private $sprint;
    private $task;
    private $contact;
    private $merchantid;
    private $joeyRouteLocations;
    private $joeyRoute;
    // Response array
    private $response = [];

    public function __construct($tracking_id)
    {
      $this->tracking_id = $tracking_id;
    }
    public function isInvalidQRCode()
    {
        $this->merchantid = MerchantIds::where('merchantids.tracking_id','=',$this->tracking_id)->orderBy('id','desc')
        ->first();
        if(!$this->merchantid)
        {
            $this->response['response'] ="Invalid tracking id";
            return false;
        }
        $this->task=$this->merchantid->dropoffTask;
        if(!$this->task)
        {
            $this->response['response'] ="Invalid tracking id";
            return false;
        }
        $this->contact=$this->task->sprint_contact;
        if(!$this->contact)
        {
            $this->response['response'] ="Invalid tracking id";
            return false;
        }
        $this->sprint=$this->task->getSprint;
        if(!$this->sprint)
        {
            $this->response['response'] ="Invalid tracking id";
            return false;
        }
        $this->joeyRouteLocations=$this->task->getJoeyRouteLocations;
        if(!$this->joeyRouteLocations)
        {
            $this->response['response'] ="This tracking id has already been marked delivered or returned without a route, please kindly put the package aside and contact your administrator for assistance, thank you.";
            return false;
        }
        $this->joeyRoute=$this->joeyRouteLocations->getJoeyRoute;
        if(!$this->joeyRoute)
        {
            $this->response['response'] ="This tracking id has already been marked delivered or returned without a route, please kindly put the package aside and contact your administrator for assistance, thank you.";
            return false;
        }
        return true;
       
    }
    public function createReturnResponse()
    {
        $this->response['id'] = $this->joeyRouteLocations->id;
        $this->response['num'] = "R-".$this->joeyRouteLocations->route_id;
        $this->response['merchant_order_num'] = $this->merchantid->merchant_order_num;
        $this->response['tracking_id'] =  $this->merchantid->tracking_id;
        $this->response['contact']['name'] = $this->contact->name;
        $this->response['contact']['phone'] = $this->contact->phone;
        $this->response['contact']['email'] = $this->contact->email; 
    }
    public function getResponse()
    {
        return $this->response;
    }
    public function reattempt_order_api_call()
    {   $data['tracking_id'] = $this->tracking_id;
        $json_data = json_encode($data);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.joeyco.com/order/hub/return',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$json_data,
            CURLOPT_HTTPHEADER => array(
              'Authorization: Basic amNvcGFrOjZjZjBiNDZmZjNiZWI0YzM5MDIxOGJjZWM2NzI1MWM4',
              'Content-Type: application/json'
            ),
          ));
          
          $response = curl_exec($curl);
          
          curl_close($curl);
          
          return $response;
    }

    public function reattempt_order_api_call_local()
    {   $data['tracking_id'] = $this->tracking_id;
        $json_data = json_encode($data);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://localhost:8888/order/hub/return',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$json_data,
            CURLOPT_HTTPHEADER => array(
              'Authorization: Basic amNvcGFrOjZjZjBiNDZmZjNiZWI0YzM5MDIxOGJjZWM2NzI1MWM4',
              'Content-Type: application/json'
            ),
          ));
          
          $response = curl_exec($curl);
          
          curl_close($curl);
          
          return $response;
    }
   

    public function createReturn()
    {
        //create order for reattempt
        
        
        $response=$this->reattempt_order_api_call();
        // $response=explode("<br", $response);
        // $response=$response[0];
        $response=json_decode($response,true);
        $this->response['response'] = $response['response']['reattempOrderCreationResponse'];
        if($response['response']['reattempOrderCreationResponse']=='Reattempts limit exceeds!')
        {
            $this->response['response']='Reattempt limit exceeds!';
            $this->response['status_code']=400;
        }
        else if($response['response']['reattempOrderCreationResponse']=='Reattempt order created successfully!')
        {
            $this->response['response']='Reattempt order created successfully!';
            $this->response['status_code']=200;
        }
        else if($response['response']['reattempOrderCreationResponse']=='Sprint is not checked out yet!.')
        {
            $this->response['response']='Sprint is not checked out yet!.';
            $this->response['status_code']=400;
        }
        else
        {
            $this->response['response']='Error.';
            $this->response['status_code']=400;
        }
       
        return $this->response['response']; 
       
    }
}