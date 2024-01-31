<?php

namespace App\Classes;

use App\Classes\Contact;
use App\Classes\Order;
use \Laravel\Config;
use App\Hub;
use App\Sprint;
use App\Location;
use App\Task;
use App\Contact as TaskContact;
use App\ProcessedXmlFiles;
use App\Vendor;
use App\MerchantIds;
use App\XmlFailedOrders;
use App\MainfestFields;
use App\AmazonEntry;
use App\TaskHistory;

class AmazonXmlOrder {
    private $xmlFile;
    private $vendor_id = "";
    private $fileName="";
    private $filePath="";
    private $fileData;
    private $mainfestData="";
    private $endTime;
    private $startTime;
    private $due;
    private $dueTime;

    public function __construct($xmlFile,$vendor_id)
    {
        $this->xmlFile=$xmlFile;
        $this->vendor_id=$vendor_id;
        $this->setFileName();
    }  
       
    public function validateXmlFile()
    {
        $extension = pathinfo($this->getFileName(), PATHINFO_EXTENSION);
        $allow_file = array(
            "xml"
        );
        if (!in_array($extension, $allow_file))
        {
            return false;
        }
        return true;
    }
    public function setOrderTime($vendor)
    {
        $this->startTime = empty($vendor->attributes['order_start_time']) ? time() : $vendor->attributes['order_start_time'];
        date_default_timezone_set("America/Toronto");
        $this->due = strtotime( date("Y-m-d $this->startTime" ) );
        $this->dueTime = new \DateTime();
        $this->dueTime->setTimestamp($this->due);
        $this->dueTime->modify("+1 day");
    }
    public function checkIfFileAlreadyProcessed(){

        if(ProcessedXmlFiles::getFileByFileName($this->getFileName())!=null)
        {
            
            return true;
        }
        ProcessedXmlFiles::create([ 'file_name' => $this->getFileName() ,'vendor_id'=>$this->vendor_id]);
        return false;
    }
    public function setFileName()
    {
        $this->fileName = $this->xmlFile->getClientOriginalName();
    }
    public function getFileName()
    {
       return $this->fileName;
    }
    public function setXmlFileContent()
    {
        $rand_num = uniqid();
        $this->filePath = $rand_num . '-opimg-' . $this->getFileName();
        $this->xmlFile->move("public/", $this->filePath);
        $this->fileData = simplexml_load_file("public/".$this->filePath);
    }
    
    public function getXmlFileContent()
    {
       return $this->fileData;
    }
    public function mainfestData($xml)
    {
                        // try
                        // {
                        $this->mainfestData = [ 
                          'vendor_id' => $this->vendor_id,
                          'xsi' => $xml['xsi:noNamespaceSchemaLocation'],
                          'sendingPartyID' => $xml['sendingPartyID'],
                          'receivingPartyID' => $xml['receivingPartyID'],
                          'warehouseLocationID' => $xml->message->amazonManifest->manifestHeader->warehouseLocationID,
                          'manifestCreateDateTime' => $xml->message->amazonManifest->manifestHeader->manifestCreateDateTime,
                          'carrierInternalID' => $xml->message->amazonManifest->manifestHeader->carrierInternalID,
                          'manifestNumber' => $xml->message->amazonManifest->manifestHeader->manifestNumber,
                          'carrierAccountID' => $xml->message->amazonManifest->manifestHeader->carrierAccountID,
                          'shipmentDate' => $xml->message->amazonManifest->manifestHeader->shipmentDate,
                          'currencyCode' => $xml->message->amazonManifest->manifestHeader->currencyCode,
                          'shipFromAddressType' => $xml->message->amazonManifest->manifestHeader->shipFromAddress['AddressType'],
                          'shipFromAddressName' => $xml->message->amazonManifest->manifestHeader->shipFromAddress->name,
                          'shipFromAddressLine1' => $xml->message->amazonManifest->manifestHeader->shipFromAddress->addressLine1,
                          'shipFromAddressCity' => $xml->message->amazonManifest->manifestHeader->shipFromAddress->city,
                          'shipFromAddressStateProvince' => preg_replace('/[^A-Za-z0-9]/', '',$xml->message->amazonManifest->manifestHeader->shipFromAddress->stateChoice->stateProvince),
                          'shipFromAddressZip' => $xml->message->amazonManifest->manifestHeader->shipFromAddress->zip,
                          'shipFromAddressCountryCode' => $xml->message->amazonManifest->manifestHeader->shipFromAddress->countryCode,
                          'shipFromAddressCountryName' => $xml->message->amazonManifest->manifestHeader->shipFromAddress->countryName,
                          'amazonTaxID' => $xml->message->amazonManifest->manifestHeader->shipperInformation->amazonTaxID,
                          'totalShipmentQuantity' => $xml->message->amazonManifest->manifestSummary->totalShipmentQuantity->quantity,
                          'totalShipmentQuantityUnitOfMeasure' => $xml->message->amazonManifest->manifestSummary->totalShipmentQuantity->quantity['unitOfMeasure'],
                          'totalShipmentValue' => $xml->message->amazonManifest->manifestSummary->totalShipmentValue->monetaryAmount,
                          'totalShipmentValueCurrencyISOCode' => $xml->message->amazonManifest->manifestSummary->totalShipmentValue->monetaryAmount['currencyISOCode'],
                          'totalDeclaredGrossWeight' => $xml->message->amazonManifest->manifestSummary->totalDeclaredGrossWeight->weightValue,
                          'totalDeclaredGrossWeightUnitOfMeasure' => $xml->message->amazonManifest->manifestSummary->totalDeclaredGrossWeight->weightValue['unitOfMeasure'],
                          'totalActualGrossWeight' => $xml->message->amazonManifest->manifestSummary->totalActualGrossWeight->weightValue,
                          'totalActualGrossWeightUnitOfMeasure' => $xml->message->amazonManifest->manifestSummary->totalActualGrossWeight->weightValue['unitOfMeasure']

                        ];

                        // }
                        // catch(\Exception $e)
                        // {
                        //   continue;
                        // }
                       
    }

    public function mainfestDataShipment($shipment)
    {
        $mainfestData=$this->mainfestData;
        $mainfestData['customerOrderNumber'] = $shipment->customerOrderNumber;
        $mainfestData['consigneeAddressType'] = $shipment->consigneeAddress['AddressType'];
        $mainfestData['consigneeAddressName'] = preg_replace('/[^A-Za-z0-9]/', '',$shipment->consigneeAddress->name);
        $mainfestData['consigneeAddressLine1'] = $shipment->consigneeAddress->addressLine1;
        $mainfestData['consigneeAddressLine2'] = $shipment->consigneeAddress->addressLine2;
        $mainfestData['consigneeAddressLine3'] = $shipment->consigneeAddress->addressLine3;
        // $mainfestData['consigneeAddressCity'] = $shipment->consigneeAddress->city;
        $mainfestData['consigneeAddressCity'] = preg_replace('/[^A-Za-z0-9]/', '',$shipment->consigneeAddress->city);
        $mainfestData['consigneeAddressStateProvince'] = preg_replace('/[^A-Za-z0-9]/', '',$shipment->consigneeAddress->stateChoice->stateProvince);
        //$mainfestData['consigneeAddressZip'] = $shipment->consigneeAddress->zip;
        $mainfestData['consigneeAddressZip'] = str_replace(' ', '', $shipment->consigneeAddress->zip);
        $mainfestData['consigneeAddressCountryCode'] = $shipment->consigneeAddress->countryCode;
        $mainfestData['consigneeAddressCountryName'] = $shipment->consigneeAddress->countryName;
        $mainfestData['consigneeAddressContactPhone'] = $shipment->consigneeAddress->contactPhone;
        $mainfestData['consigneeAddressContactEmail'] = $shipment->consigneeAddress->contactEmail;
        $mainfestData['AmzShipAddressUsage'] = $shipment->consigneeAddress->amzShipAddressUsage;
        $mainfestData['AddressType'] = $shipment->deliveryPreferences->addressType;
        $mainfestData['SafePlace'] = $shipment->deliveryPreferences->SafePlace;
        $mainfestData['DeliverToCustOnly'] = $shipment->deliveryPreferences->DeliverToCustOnly;
        $mainfestData['IsSignatureRequired'] = $shipment->deliveryPreferences->IsSignatureRequired;
        $mainfestData['AgeVerificationRequired'] = $shipment->deliveryPreferences->AgeVerificationRequired;
        $mainfestData['encryptedShipmentID'] = $shipment->shipmentPackageInfo->cartonID->encryptedShipmentID;
        $mainfestData['packageID'] = $shipment->shipmentPackageInfo->cartonID->packageID;
        $mainfestData['trackingID'] = $shipment->shipmentPackageInfo->cartonID->trackingID;
        $mainfestData['batteryStatements'] = $shipment->shipmentPackageInfo->batteryStatements;
        $mainfestData['amazonTechnicalName'] = $shipment->shipmentPackageInfo->packageShipmentMethod->amazonTechnicalName;
        $mainfestData['shipZone'] = $shipment->shipmentPackageInfo->shipZone;
        $mainfestData['shipSort'] = $shipment->shipmentPackageInfo->shipSort;
        $mainfestData['scheduledDeliveryDate'] = $shipment->shipmentPackageInfo->scheduledDeliveryDate; 
        $mainfestData['valueOfGoodsChargeOrAllowance'] = $shipment->shipmentPackageInfo->valueOfGoods->chargeOrAllowance;
        $mainfestData['valueOfGoodsMonetaryAmount'] = $shipment->shipmentPackageInfo->valueOfGoods->monetaryAmount;
        $mainfestData['valueOfGoodsCurrencyISOCode'] = $shipment->shipmentPackageInfo->valueOfGoods->monetaryAmount['currencyISOCode'];
        $mainfestData['packageCostChargeOrAllowance'] = $shipment->shipmentPackageInfo->packageCost->chargeOrAllowance;
        $mainfestData['packageCostMonetaryAmount'] = $shipment->shipmentPackageInfo->packageCost->monetaryAmount;
        $mainfestData['packageCostCurrencyISOCode'] = $shipment->shipmentPackageInfo->packageCost->monetaryAmount['currencyISOCode'];
        $mainfestData['declaredWeightValue'] = $shipment->shipmentPackageInfo->shipmentPackageActualGrossWeight->weightValue;
        $mainfestData['declaredUnitOfMeasure'] = $shipment->shipmentPackageInfo->shipmentPackageActualGrossWeight->weightValue['unitOfMeasure'];
        $mainfestData['actualWeightValue'] = $shipment->shipmentPackageInfo->shipmentPackageActualGrossWeight->weightValue;
        $mainfestData['actualUnitOfMeasure'] = $shipment->shipmentPackageInfo->shipmentPackageActualGrossWeight->weightValue['unitOfMeasure'];
        $mainfestData['lengthValue'] = $shipment->shipmentPackageInfo->shipmentPackageDimensions->lengthValue;
        $mainfestData['lengthUnitOfMeasure'] = $shipment->shipmentPackageInfo->shipmentPackageDimensions->lengthValue['unitOfMeasure'];
        $mainfestData['heightValue'] = $shipment->shipmentPackageInfo->shipmentPackageDimensions->heightValue;
        $mainfestData['heightUnitOfMeasure'] = $shipment->shipmentPackageInfo->shipmentPackageDimensions->heightValue['unitOfMeasure'];
        $mainfestData['widthValue'] = $shipment->shipmentPackageInfo->shipmentPackageDimensions->widthValue;
        $mainfestData['widthUnitOfMeasure'] = $shipment->shipmentPackageInfo->shipmentPackageDimensions->widthValue['unitOfMeasure'];
        $this->mainfestData=$mainfestData;
    }

    public function post_xml_order()
    {
       
            $hub = Hub::getHubAdressFromVendorId($this->vendor_id);

            if( count($hub) == 0 ){
                // $this->setResponse('Hub address not found',  400);
                return ["error"=>"Hub address not found","status_code"=>400];
            }
           
            $pickupAddress = Location::canadian_address($hub->address);
         
            if(!isset($pickupAddress['postal_code']))
            {
                return ["error"=>"Postal code is required in hub address field.","status_code"=>400];
             
            }


              $xml = null;
              try{
                $xml = $this->getXmlFileContent();
              }catch(\Exception $e){
                return ["error"=>"No Data In File","status_code"=>400];
              }
               
                $this->mainfestData($xml);
               
              $vendor = Vendor::find($this->vendor_id);
              $this->setOrderTime($vendor);
              $response = [];
              $i=0;
              foreach ($xml->message->amazonManifest->manifestDetail->shipmentDetail as $shipment) {
                //   try 
                //   {
                    $this->mainfestDataShipment($shipment);
                  // try {
                    
                      $order=new Order($shipment);
                      if($order->isAlreadyExists())
                      {
                        continue;
                      }
                      $this->endTime = $shipment->consigneeAddress->amzShipAddressUsage == 'R' ? date('H:i',strtotime("21:00:00") ) : date('H:i',strtotime("21:00:00") );

                      $pickUpTaskResponse = $this->pikcupTask($this->vendor_id, $pickupAddress);
    
                      if(! $pickUpTaskResponse ){
                          $response['failed_orders'][] = $shipment->customerOrderNumber;
                          XmlFailedOrders::create(['tracking_id' => $order->getTrackingId(), 'merchant_order_num' => $order->getMerchantOrderNum(), 'response' => json_encode($pickUpTaskResponse) ]);
                          MainfestFields::create($this->mainfestData);
                          continue;
                      }
                      else
                      {
                          $order->setOrderSprintId($pickUpTaskResponse['sprint']['id']);
                      }

                      
                      $sprint = array(
                          'merchant_order_num' =>  $order->getMerchantOrderNum(),
                          'start_time' => substr($this->startTime, 0, 5),
                          'end_time' => $this->endTime,
                          'tracking_id' =>$order->getTrackingId(),
                          'id'=> $order->getOrderSprintId()
                      );
                      $Contact=new Contact($shipment);
                      //validate phone number
                      $dropoffAddress = null;
                      //Before Parser   
                      // $addressString = (string)$shipment->consigneeAddress->addressLine1;
                      //end before parser
                      //Parser Changes 
                      $addressString=null;
                      $addressString = $order->getAddressLine1();
                      $condition=true;
                      while($condition)
                      {
                          $address = Location::addressParser($addressString);
                          if($address == $addressString)
                          {
                             $condition = false;
                          }
                          else
                          {
                              $addressString = $address;
                          }
                      }
                      //End of Parser Changes

                      //validate dropoff address
                    
                      if( !Location::isAddressValid($addressString) )
                      {
                          
                        $addressString = $order->getAddressLine2();
                         //Parser Changes 
                        $condition=true;
                        while($condition)
                        {
                            $address = Location::addressParser($addressString);
                            if($address == $addressString)
                            {
                               $condition=false;
                            }
                            else
                            {
                                $addressString = $address;
                            }
                        }
                        //Parser Changes End  

                         if( !Location::isAddressValid($addressString) ){
                          
                            $addressString = $order->getAddressLine3();
                            //Parser Changes
                            $condition=true;

                            while($condition)
                            {
                                $address = Location::addressParser($addressString);
                                if($address == $addressString)
                                {
                                   $condition=false;
                                }
                                else
                                {
                                    $addressString = $address;
                                }
                            }
                            //Parser Changes End


                             if( !Location::isAddressValid($addressString) ){
                                //none of the address fields are valid
                                $response['failed_orders'][] = $shipment->customerOrderNumber;
                                XmlFailedOrders::create(['tracking_id' => $order->getTrackingId(), 'merchant_order_num' => $order->getMerchantOrderNum(), 'response' => 'Invalid dropoff address!.' ]);
                                MainfestFields::create($this->mainfestData);
                                continue;

                             }else{
                               // $dropoffAddress = (string)$shipment->consigneeAddress->addressLine3;
                                //Parser Changes
                                 $dropoffAddress = $addressString;
                                 //End PArser Changes
                             }
                          

                         }else{
                            // $dropoffAddress = (string)$shipment->consigneeAddress->addressLine2;
                            //Parser Changes
                            $dropoffAddress = $addressString;
                            //End PArser Changes

                         }
                      

                      }else{
                        // $dropoffAddress = (string)$shipment->consigneeAddress->addressLine1;
                        //Parser Changes
                        $dropoffAddress = $addressString;
                        //End PArser Changes
                      }
                      
                      $city = (string)$shipment->consigneeAddress->city;
                      $zip = (string)$shipment->consigneeAddress->zip;
                     
                      $location = array(

                          "address" => $dropoffAddress,
                          'postal_code' => $zip,
                        //  'city' => $city,
                          'country' => 'CA'
                          
                      );

                     $data=array(
                         'sprint'=> $sprint,
                         'contact' => $Contact->getData(),
                         'location' => $location,
                         'notification_method' => 'none'
                     );  
                   
                      $dropOffTaskResponse = $this->dropoffTask($data);
                     
                     //if response has some errors then return
                      if( !$dropOffTaskResponse){
                          $response['failed_orders'][] = $shipment->customerOrderNumber;
                          XmlFailedOrders::create(['tracking_id' =>$order->getTrackingId(), 'merchant_order_num' => $order->getMerchantOrderNum(), 'response' => json_encode($dropOffTaskResponse) ]);
                          MainfestFields::create($this->mainfestData);
                          continue;
                      }

                    //  $this->updateTime($sprintId,$dueTime);

                    //  $checkout = $this->checkOut($sprintId);

                     $mainfestData['sprint_id'] = $order->getOrderSprintId();
                     $i++;
                     $dist=Sprint::where('id','=',$order->getOrderSprintId())->first(['distance']);
                     if(!empty($dist))
                     {
                     $d1=($dist->distance)*0.001;
                      if($d1>130)
                      {
                      $response['failed_orders'][] = $shipment->customerOrderNumber;
                      XmlFailedOrders::create(['tracking_id' => $order->getTrackingId(), 'merchant_order_num' => $order->getMerchantOrderNum(),
                      'response' => "distance between pickup and drop address is greater than 100 KM"]);
                      $this->mainfestData['sprint_id']=$order->getOrderSprintId();
                      MainfestFields::create($this->mainfestData);
                      Sprint::where('id','=',$order->getOrderSprintId())->update(['deleted_at'=> date('Y-m-d H:i:s')]);
                      MerchantIds::where('tracking_id','=',$order->getTrackingId())->update(['tracking_id'=>""]);

                      }
                      else
                      {
                       
                      //amazon dashbaord changes 
                      $task = Task::where('sprint_id','=',$order->getOrderSprintId())->where('ordinal','=',2)->first(['id','status_id']);
                      $this->mainfestData['sprint_id']=$order->getOrderSprintId();
                      MainfestFields::create($this->mainfestData);
                      $amazonorder['sprint_id'] = $order->getOrderSprintId();
                      $amazonorder['task_id'] = $task->id;
                      $amazonorder['task_status_id'] = $task->status_id;
                      $amazonorder['creator_id'] = $this->vendor_id;
                      $amazonorder['tracking_id'] =  $this->mainfestData['trackingID'];
                      $amazonorder['address_line_1'] = $this->mainfestData['consigneeAddressLine1'];
                      $amazonorder['address_line_2'] = $this->mainfestData['consigneeAddressLine2'];
                      $amazonorder['address_line_3'] = $this->mainfestData['consigneeAddressLine1'];

                      AmazonEntry::create($amazonorder);
                      
                    //   $response['successfull_orders'][] = $checkout;
                      }
                    }
                    else
                      {
                        
                      //Amazon dashbaord changes 
                     $task = Task::where('sprint_id','=',$order->getOrderSprintId())->where('ordinal','=',2)->first(['id','status_id']);
                     $this->mainfestData['sprint_id']=$order->getOrderSprintId();
                     MainfestFields::create($this->mainfestData);
                      $amazonorder['sprint_id'] = $order->getOrderSprintId();
                      $amazonorder['task_id'] = $task->id;
                      $amazonorder['task_status_id'] = $task->status_id;
                      $amazonorder['creator_id'] = $this->vendor_id;
                      $amazonorder['tracking_id'] =  $this->mainfestData['trackingID'];
                      $amazonorder['address_line_1'] = $this->mainfestData['consigneeAddressLine1'];
                      $amazonorder['address_line_2'] = $this->mainfestData['consigneeAddressLine2'];
                      $amazonorder['address_line_3'] = $this->mainfestData['consigneeAddressLine1'];
                     
                      AmazonEntry::create($amazonorder);
                       
                    //   $response['successfull_orders'][] = $checkout;
                      }

                    //  MainfestFields::create($this->mainfestData);

                    //  $response['successfull_orders'][] = $checkout;

                //   }
                //   catch(\Exception $e){

                //       $response['failed_orders'][] = $shipment->customerOrderNumber;
                //       XmlFailedOrders::create(['tracking_id' => (string)$shipment->shipmentPackageInfo->cartonID->trackingID, 'merchant_order_num' => (string)$shipment->customerOrderNumber, 'response' => "Order Could Not Be Created" ]);
                //       MainfestFields::create($this->mainfestData);
                //       continue;

                //   }
                  
                 
              }
              if($i==0)
              {
                return ["error"=>"No Order Created","status_code"=>400];
              }
              $fileResp[] = $response;
			  return ["success"=>"Order Created Successfully","status_code"=>200];
			  // Terminate loop after the first file has been processed from the list.
		
       
       
    }
    private function pikcupTask($creatorId, $location){

        $vendor = Vendor::find($creatorId);
        //$location = $vendor->getLocation();
     
        $pickupData = [
                        "type" => "pickup",
                        "sprint" =>  [
                            "creator_id" => $vendor->getId(),
                            "creator_type" => "vendor",
                            "vehicle_id" => $vendor->getVehicle->getId()
                        ],
                        "contact" => [
                            "id" =>$vendor->getId(),
                            // $vendor->getContact->getId(),
                            "name" => $vendor->getName(),
                            "email" => $vendor->getEmail(),
                            "phone" => $vendor->getPhone()
                        ],
                        "location" => [
                            //"address" => $location->attributes['address'],
                            //"postal_code" => $location->attributes['postal_code'],
                            "address" => $location['address'],
                            "postal_code" => $location['postal_code'],
                            "country" => "CA"
                        ],
                        "notification_method" => 'none'
                        ];

        $pickUpResponse = $this->processTask($pickupData);
                     
        return $pickUpResponse;       
    
    }
    private function dropoffTask($dropoffData){

        $dropoffData['type'] = 'dropoff';
        
        $dropOffResponse = $this->processTask($dropoffData);

        return $dropOffResponse;

    }
    private function processTask($requestData){

        // try {
            
            if(!isset($requestData['sprint']['id']))
            {
                $sprint=new Sprint();
                $sprint->creator_id=$requestData['sprint']['creator_id'];
                $sprint->creator_type=$requestData['sprint']['creator_type'];
                $sprint->vehicle_id=$requestData['sprint']['vehicle_id'];
                $sprint->active=1;
                $sprint->status_id=61;
                $sprint->timezone='America/Toronto';
                $sprint->save();
            }
            else
            {
                $sprint=Sprint::where('id','=',$requestData['sprint']['id'])->first();
            }
            
           
            if(isset($requestData['type']) && $requestData['type']=='dropoff')
            {
                $TaskContact=new TaskContact();
                $TaskContact->name=$requestData['contact']['name'];
                $TaskContact->phone=$requestData['contact']['phone'];
                $TaskContact->email=$requestData['contact']['email'];
                $TaskContact->save();
                $ordinal=2;
            }
            else
            {
                $ordinal=1;
                $TaskContact=new TaskContact();
                $TaskContact->id=$requestData['contact']['id'];
            }
            

            $location=new Location();
            $contact_address=Location::canadian_address($requestData['location']['address']);
            $location->address=$requestData['location']['address'];
            $location->postal_code=$requestData['location']['postal_code'];
            $location->country_id=43;
            $location->latitude=$contact_address['lat'];
            $location->longitude=$contact_address['lng'];
            $location->save();

            $task=new Task();
            $task->sprint_id=$sprint->id;
            $task->ordinal=$ordinal;
            $task->status_id=61;
            $task->due_time=Time();
            $task->type=$requestData['type'];
            $task->location_id=$location->id;
            $task->contact_id=$TaskContact->id;
            $task->save();

            $taskhistory=new TaskHistory();
            $taskhistory->sprint_id=$task->sprint_id;
            $taskhistory->sprint__tasks_id=$task->id;
            $taskhistory->status_id=38;
            $taskhistory->date=date('Y-m-d H:i:s');
            $taskhistory->created_at=date('Y-m-d H:i:s');
            $taskhistory->save();

            $taskhistory=new TaskHistory();
            $taskhistory->sprint_id=$task->sprint_id;
            $taskhistory->sprint__tasks_id=$task->id;
            $taskhistory->status_id=61;
            $taskhistory->date=date('Y-m-d H:i:s');
            $taskhistory->created_at=date('Y-m-d H:i:s');
            $taskhistory->save();
            
            

            if($requestData['type']=='dropoff'){

                MerchantIds::create( [ 'task_id' => $task->id,
                'merchant_order_num' => isset( $requestData['sprint']['merchant_order_num'] ) ? $requestData['sprint']['merchant_order_num'] : null,
                'end_time' => isset( $requestData['sprint']['end_time'] ) ? $requestData['sprint']['end_time'] : null,
                'start_time' => isset( $requestData['sprint']['start_time'] ) ? $requestData['sprint']['start_time'] : null,
                'tracking_id' => isset( $requestData['sprint']['tracking_id'] ) ? $requestData['sprint']['tracking_id'] : null,
                'address_line2' => isset( $requestData['location']['address_line2'] ) ? $requestData['location']['address_line2'] : null]);
            }
                
            $a['sprint']['id']=$sprint->id;
            return $a;
                     
        // }
        
        
        // catch (\Exception $e) {
            return false;
            // $PDO->rollback();
            // Log::write('error', (string) $e);
            // $this->setResponse(['message' =>$e->getMessage()], 400);
            // return $this->getResponse();
        // }

        
    }

  
    function __destruct() {
        if($this->filePath!=null)
        {
            unlink("public/".$this->filePath);
        }
       
      }

    
    
}