<?php

namespace App\Http\Controllers\Backend;


use Illuminate\Http\Request;

use App\XmlFailedOrders;
use App\CtcFailedOrders;
use App\Vendor;
use App\MainfestFields;
use App\Sprint;
use App\Http\Requests\Backend\CategoryRequest;
use Illuminate\Support\Facades\Request as FacadeRequest;
use App\Http\Controllers\Backend\BackendController;
use Illuminate\Support\Facades\Auth;

class FailedOrderController extends BackendController
{
    public function getAllCTCFailedOrder(Request $request)
    {
        $data = $request->all();
        if (empty($data)) {
            $failedorders = CtcFailedOrders::whereNotIn('vendor_id', array(477260, 477282))->whereNull('deleted_at')
                ->get(['id',
                    'tracking_num as tracking_num',
                    'customer_name as customer_name ',
                    'customer_number as customer_number',
                    'customer_email as customer_email',
                    'address as address',
                    'suite_number as suite_number',
                    'address_line_2 as address_line_2',
                    'merchant_order_number as merchant_order_number',
                    'vendor_id as vendor_id',
                    'confirm_signature as confirm_signature',
                    'start_time as start_time',
                    'end_time as end_time',
                    'notification_method as notification_method',
                    'weight as weight']);

                    $data = $failedorders;
        } else {
            $failedorders = CtcFailedOrders::whereNull('deleted_at');
            if (!empty($data['vendor_id'])) {
                $failedorders = $failedorders->where('vendor_id', '=', $data['vendor_id'])->whereNotIn('vendor_id', array(477260, 477282));

            }
            if (!empty($data['tracking_id'])) {
                $failedorders = $failedorders->where('tracking_num', '=', $data['tracking_id'])->whereNotIn('vendor_id', array(477260, 477282));
            }

            $data = $failedorders->get();
            
        }
        return backend_view( 'failedorder.ctc-failed-order', compact('data') );
      
    }
    
    public function createCtcOrder(Request $request)
    {
        $data = $request->all();

    
            $id =  $data['id'];
            $data['name'] = trim(str_replace(array("\n", "\r"), '', $data['name']));
            $data['mob'] = trim(str_replace(array("\n", "\r"), '', $data['mob']));
            $data['email'] = trim(str_replace(array("\n", "\r"), '', $data['email']));
            $data['line'] = trim(str_replace(array("\n", "\r"), '', $data['line']));
            $data['line2'] = trim(str_replace(array("\n", "\r"), '', $data['line2']));
           
    
            $ctc_failed_orders = CtcFailedOrders::where('id', '=', $id)->first();
    
    
            $ctc_failed_orders->customer_name = $data["name"];
            $ctc_failed_orders->customer_email = $data["email"];
            $ctc_failed_orders->customer_number = $data["mob"];
            $ctc_failed_orders->address = $data["line"];
            $ctc_failed_orders->address_line_2 = $data["line2"];
            $ctc_failed_orders->save();
    
    
          
            $data_create = CtcFailedOrders::where('id', '=', $id)->first();
    
    
            
    
            $startTime = empty($data_create->start_time) ? time() : date('H:i', strtotime($data_create->start_time));
            $startTime = date('H:i', strtotime($startTime));
            $due = strtotime(date("Y-m-d $startTime"));
    
            $dueTime = new \DateTime();
    
            $dueTime->setTimestamp($due);
            $dueTime->modify("+1 day");
    
    
            $end_time = empty($data_create->end_time) ? time() : date('H:i', strtotime($data_create->end_time));
    
    
            $order_request_body = new \stdClass();
            $sprint = new \stdClass();
            $sprint->creator_id = $data_create->vendor_id;
            $sprint->tracking_id = $data_create->tracking_num;
            $sprint->end_time = $end_time;
            $sprint->start_time = $startTime;
            $sprint->due_time = strtotime($dueTime->format('y-m-d H:i:s'));
            $order_request_body->sprint = $sprint;
            $contact = new \stdClass();
            $contact->name = $data_create->customer_name;
            $contact->phone = $data_create->customer_number;
            $contact->email = $data_create->customer_email;
            $order_request_body->contact = $contact;
    
            $location = new \stdClass();
            $location->address = $data_create->address;
            $order_request_body->location = $location;
    
           
            $order_request_body->notification_method = 'none';
            $order_request_body->weight = $data_create->weight;
            $order_request_body->admin = '1';
            $order_request_body->here_api = '1';
            
            //$response1 = $this->OrderRequest($order_request_body,'create_order',"POST");
           
           // $response1 
           $response  = $this->OrderRequest($order_request_body,'create_order',"POST");
         
           //   $response = explode("<br", $response1);
                
           //    $response=json_decode($response[0],true);
              $response=json_decode($response,true);
           //    if($response==null)
           //    {
           //     return   response()->json(['status_code'=>400,"error"=>json_encode($response1)]);
           //    }
               
    
            if ($response['http']['code'] == 201 || $response['http']['code'] == 200) {
                if (!isset($response['response']['id'])) {
                    return response()->json(['status_code'=>400,'error'=>'Order could not create.Please update your data.']);
                 
                    
                } else {
    
                    CtcFailedOrders::where('id', '=', $data_create->id)->update(['deleted_at'=>date('Y-m-d H:i:s')]);
                   
                }
    
    
            } elseif ($response['http']['code'] == 400) {
    
                if (isset($response['response']['location']['postal_code'])) {
                    return response()->json(['status_code'=>400,'error'=>'Order could not create,postal code is invalid ']);
                  
                  
    
                } elseif (isset($response['response']['Contacts']['phone'])) {
                    return response()->json(['status_code'=>400,'error'=>'Order could not create,phone no is invalid']);
              
                 
                } elseif (isset($response['response']['contact']['email'])) {
                    return response()->json(['status_code'=>400,'error'=>'The email format is invalid']);
                   
                   
    
                } elseif (isset($response['response'])) {
                    
                    return response()->json(['status_code'=>400,'error'=>'Order could not create']);
                  
                   
    
                } else {
                    return response()->json(['status_code'=>400,'error'=>'Order could not create.Please update your data']);
            
              
    
                }
               
            } else {
                return response()->json(['status_code'=>400,'error'=>'Order could not create.Please update your data']);
            
               
    
               
            }
    
            return response()->json(['status_code'=>200,'success'=>'Order Create Successfully']);
            
             
    
    
        }

      
    
  
    public function getAllAmazonFailedOrder(Request $request)
    {
      
        if(empty($request->get('date')))
        {
            $date=date("Y-m-d");
        }
        else
        {
            $date=$request->get('date');
        }
        $data=XmlFailedOrders::join('mainfest_fields','mainfest_fields.trackingid','=','xml_failed_orders.tracking_id')
        ->whereNull('xml_failed_orders.deleted_at')
         ->where('xml_failed_orders.created_at','like',$date."%")
        ->whereNull('mainfest_fields.deleted_at');
        $vendor_id=null;
        if(!empty($request->get('vendor_id')))
        {
            $vendor_id=$request->get('vendor_id');
            $data=  $data->where('vendor_id','=',$request->get('vendor_id'));
        }
    
        $data=$data->get(['trackingid as tracking_id','mainfest_fields.id','customerordernumber as merchant_order_num',
        'consigneeaddressname','consigneeaddresscontactphone','consigneeaddressline1','consigneeaddressline2','consigneeaddressline3',
        'consigneeaddresszip','mainfest_fields.sprint_id' ]);
       
        return backend_view( 'failedorder.amazon-failed-order', compact('data','vendor_id') );
      
    }
 
    public function createAmazonOrder(Request $request)
    {
        $data = $request->all();

    
            $id =  $data['id'];
            $data['name'] = trim(str_replace(array("\n", "\r"), '', $data['name']));
            $data['mob'] = trim(str_replace(array("\n", "\r"), '', $data['mob']));
            $data['line'] = trim(str_replace(array("\n", "\r"), '', $data['line']));
            $data['line2'] = trim(str_replace(array("\n", "\r"), '', $data['line2']));
            $data['line3'] = trim(str_replace(array("\n", "\r"), '', $data['line3']));
            $data['postal_code'] = trim(str_replace(array("\n", "\r"), '', $data['postal_code']));
           
    
            $order=MainfestFields::
        join('xml_failed_orders','xml_failed_orders.tracking_id','=','mainfest_fields.trackingID')->
        where('mainfest_fields.id','=',$id)->first(['trackingid as tracking_id','mainfest_fields.id','customerordernumber as merchant_order_num',
        'consigneeaddressname','consigneeaddresscontactphone','consigneeaddressline1','consigneeaddressline2','consigneeaddressline3',
        'consigneeaddresszip','mainfest_fields.sprint_id' ,'amzshipaddressusage','consigneeaddresszip','vendor_id']);
    
    
            $order->consigneeaddressname = $data["name"];
            $order->consigneeaddresscontactphone = $data["mob"];
            $order->consigneeaddressline1 = $data["line"];
            $order->consigneeaddressline2 = $data["line2"];
            $order->consigneeaddressline3=$data["line3"];
            $order->consigneeaddresszip=$data["postal_code"];
            $order->save();
    
           
    
    
                 $vendor = Vendor::find($order->vendor_id);
                $startTime = empty($vendor->attributes['order_start_time']) ? time() :
                date('H:i',strtotime($vendor->attributes['order_start_time']));
                $due = strtotime( date("Y-m-d "." 10:00" ) );
                $dueTime = new \DateTime();
              
                $dueTime->setTimestamp($due);
                $dueTime->modify("+28 hours");
                
                $end_time= $order->amzshipaddressusage == 'R' ? date('H:i',strtotime("21:00:00") ) : date('H:i',strtotime("16:00:00") );
                $order_request_body=[];
                $sprint =[];
                $sprint['creator_id'] =$order->vendor_id;
                
                $sprint['merchant_order_num']= $order->merchant_order_num;
                $sprint['tracking_id']= $order->tracking_id;
                $sprint['end_time']=$end_time;
                $sprint['start_time']=$startTime;
                $sprint['due_time']=strtotime($dueTime->format('y-m-d H:i:s'));
                $order_request_body['sprint'] =$sprint;
                $contact = [];
                $contact['name'] = $order->consigneeaddressname;
                $contact['phone'] = $order->consigneeaddresscontactphone;
                $contact['email'] = $order->consigneeaddresscontactemail ;
                $order_request_body['contact'] = $contact;
                // $order_request_body['location']['address']=$order->consigneeaddressline1;
                $order_request_body['location']=$this->canadian_postal_code($order->consigneeaddresszip);
                if(isset($order_request_body['location']['status_code']) && $order_request_body['location']['status_code']==403)
                {
                    return response()->json(['status_code'=>400,'error'=>'Order could not create,postal code is invalid ']);
                }
                $order_request_body['notification_method']='none';
                $order_request_body['admin']='1';
                $order_request_body['here_api'] ='1';
                $order_request_body['amazon']='1';
             
            // $response1 
            $response  = $this->OrderRequest($order_request_body,'create_order',"POST");
         
        //   $response = explode("<br", $response1);
             
        //    $response=json_decode($response[0],true);
           $response=json_decode($response,true);
        //    if($response==null)
        //    {
        //     return   response()->json(['status_code'=>400,"error"=>json_encode($response1)]);
        //    }
            
    
            if ($response['http']['code'] == 201 || $response['http']['code'] == 200) {
                if (!isset($response['response']['id'])) {
                    return response()->json(['status_code'=>400,'error'=>'Order could not create.Please update your data.']);
                 
                    
                } else {
                    XmlFailedOrders::where('tracking_id','=',trim($order->tracking_id))->update(['deleted_at'=>date('Y-m-d H:i:s')]);
                    MainfestFields::where('id','=',$id)->update(array('sprint_id'=>$response['response']['id']));
                    Sprint::where('id','=',$response['response']['id'])->update(array('direct_pickup_from_hub'=>1));
                   
                }
    
    
            } elseif ($response['http']['code'] == 400) {
    
                if (isset($response['response']['location']['postal_code'])) {
                    return response()->json(['status_code'=>400,'error'=>'Order could not create,postal code is invalid ']);
                  
                  
    
                } elseif (isset($response['response']['Contacts']['phone'])) {
                    return response()->json(['status_code'=>400,'error'=>'Order could not create,phone no is invalid']);
              
                 
                } elseif (isset($response['response']['contact']['email'])) {
                    return response()->json(['status_code'=>400,'error'=>'The email format is invalid']);
                   
                   
    
                } elseif (isset($response['response'])) {
                    
                    return response()->json(['status_code'=>400,'error'=>'Order could not create']);
                  
                   
    
                } else {
                    return response()->json(['status_code'=>400,'error'=>'Order could not create.Please update your data']);
            
              
    
                }
               
            } else {
                return response()->json(['status_code'=>400,'error'=>'Order could not create.Please update your data']);
            
               
    
               
            }
    
            return response()->json(['status_code'=>200,'success'=>'Order Create Successfully']);
            
             
    

      
    }


    public function OrderRequest($data,$url,$request)
    {
       
        $json_data = json_encode($data);

       

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.joeyco.com/'.$url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $request,
        CURLOPT_POSTFIELDS =>$json_data,
        CURLOPT_HTTPHEADER =>  array(
            'Content-Type: application/json'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
      
            // $json_data = json_encode($data);
            // $curl = curl_init();

            // curl_setopt_array($curl, array(
            // CURLOPT_URL => 'https://api.staging.joeyco.com/'.$url,
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            // CURLOPT_CUSTOMREQUEST => 'POST',
            // CURLOPT_POSTFIELDS =>$json_data,
            // CURLOPT_HTTPHEADER => array(
            //     'Content-Type: application/json',
            //     'Authorization: Basic amNvcGFrOjZjZjBiNDZmZjNiZWI0YzM5MDIxOGJjZWM2NzI1MWM4',
            //     'Token: lUHgkFjbO6JFe8Dc1RBSRjLABY5JeFCerhXescn12w8=',
            //     'Cookie: bellerophon=63901591a258f7e2bade0bce515ec96d; vinylethylene=YHSi3sIBbfDuoB1V6wipMjLBgiInuEdoOo8AaoSk; nothofagus=BSrM1zsn3lgi3b95%2BRxt6T2TgKg5JIDJSh7X9Q2Jz85LgSGtcBBO1eaPWVIaTGJ2Ajyeu3bN9WXmN8KHRslC3%2FsFUO0kUsrqK7MCUJVJOkEeiicNoywj6Ab2NNLrwzcSQ61qZ6i0Uk9URHOppMUOuaChhbUfnUANYAqwM2csf7aEtOegIK9%2BntTdcaW1FEh29o4%2BTZJy8hesk6PNbvifY6JNtXOqmh%2B3PEJ1XTFVY9CLBVdjcRUKMgcupga1kEHIS1i1GA0Q6Zg8I6VxbnsXkHvz2VzH1iso%2Fe5CtYOaLtELbL6KvLd7ILp1sKZ%2B5pEn9qDc%2FuHhG0jzUBuVtpIS6g%3D%3D'
            //   ),
            // ));
            // dd($curl);
            // $response = curl_exec($curl);
            // dd($response );
            // curl_close($curl);
            // return $response;



    }

    //Create Order of multiple tracking_id
    public function createAllOrder(Request $request)
    { $i=0;$j=0;
      $ids= $request->get('ids');
      $k=count($ids);
      foreach($ids as $id)
      {
        $data=MainfestFields::
        join('xml_failed_orders','xml_failed_orders.tracking_id','=','mainfest_fields.trackingID')->
        where('mainfest_fields.id','=',$id)->first(['trackingid as tracking_id','mainfest_fields.id','customerordernumber as merchant_order_num',
        'consigneeaddressname','consigneeaddresscontactphone','consigneeaddressline1','consigneeaddressline2','consigneeaddressline3',
        'consigneeaddresszip','mainfest_fields.sprint_id' ,'vendor_id']);
          
      
        $vendor = Vendor::find($data->vendor_id);
        $startTime = empty($vendor->attributes['order_start_time']) ? time() :
         date('H:i',strtotime($vendor->attributes['order_start_time']));
        $due = strtotime( date("Y-m-d "."10:00" ) );
        $dueTime = new \DateTime();
        //$dueTime->setTimezone( $vendor->getTimeZone() ); 
        $dueTime->setTimestamp($due);
        $dueTime->modify("+28 hours");
        
        $end_time= $data->amzshipaddressusage == 'R' ? date('H:i',strtotime("21:00:00") ) : date('H:i',strtotime("16:00:00") );
        $order_request_body=[];
        $sprint =[];
        $sprint['creator_id'] =$data->vendor_id;
     
        $sprint['merchant_order_num']= $data->merchant_order_num;
        $sprint['tracking_id']= $data->tracking_id;
        $sprint['end_time']=$end_time;
        $sprint['start_time']=$startTime;
        $sprint['due_time']=strtotime($dueTime->format('y-m-d H:i:s'));
        $order_request_body['sprint'] =$sprint;
        $contact = [];
        $contact['name'] = $data->consigneeaddressname;
        $contact['phone'] = $data->consigneeaddresscontactphone;
        $contact['email'] = $data->consigneeaddresscontactemail ;
        $order_request_body['contact'] = $contact;
        // $order_request_body['location']['address']=$this->canadian_postal_code($data->consigneeaddresszip);
        //selectedaddres
        if($request->get('selectedaddres')==1)
        {
            $order_request_body['location']=$this->canadian_postal_code($data->consigneeaddresszip);
           
        }
        else
        {
            $order_request_body['location']=$this->google_address($data->consigneeaddressline1);
        }
      
        $order_request_body['notification_method']='none';
        $order_request_body['admin']='1';
        $order_request_body['amazon']='1';
        $order_request_body['here_api']='1';
        
        // $response1 
        $response  = $this->OrderRequest($order_request_body,'create_order',"POST");
         
        //   $response = explode("<br", $response1);
             
        //    $response=json_decode($response[0],true);
           $response=json_decode($response,true);
        //    if($response==null)
        //    {
        //     return   response()->json(['status_code'=>400,"error"=>json_encode($response1)]);
        //    }
            
        if(isset($response['http']['code']) && $response['http']['code']==201)
        {$i=1;
          $j++;
          XmlFailedOrders::where('tracking_id','=',trim($data->tracking_id))->update(['deleted_at'=>date('Y-m-d H:i:s')]);
          if(!empty($response))
          {
            if(isset($response['id']))
            {
              MainfestFields::where('id','=',$id)->update(array('sprint_id'=>$response['response']['id']));
             Sprint::where('id','=',$response['response']['id'])->update(array('direct_pickup_from_hub'=>1));
            }
          }

        }    
     
             

            
      }
      if($i==1)
      {
     
        return response()->json(['status_code'=>200,'success'=>"Order Created Successfully"]);
        
      
      }
      else
      {
     
        return response()->json(['status_code'=>400,'error'=>"Order not created!"]);
        
      }
    
   

    }

    public function canadian_postal_code($postal_code)
        {
          $postal_code=trim($postal_code);
        $postal_code=str_replace(" ","",$postal_code);
            // google map geocode api url
            $url="https://maps.googleapis.com/maps/api/geocode/json?components=postal_code:{$postal_code}|country:CA&key=AIzaSyDTK4viphUKcrJBSuoidDqRhVA4AWnHOo0";
           // $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyDTK4viphUKcrJBSuoidDqRhVA4AWnHOo0";
    
            // get the json response
            $resp_json = file_get_contents($url);
    
            // decode the json
            $resp = json_decode($resp_json, true);
          //   dd($resp['results'][0]['formatted_address']);
            // response status will be 'OK', if able to geocode given address
            if($resp['status']=='OK'){
    
                $completeAddress = [];
                $addressComponent = $resp['results'][0]['address_components'];
    
                // get the important data
    
                for ($i=0; $i < sizeof($addressComponent); $i++) {
                    if ($addressComponent[$i]['types'][0] == 'administrative_area_level_1') {
                        $completeAddress['division'] = $addressComponent[$i]['short_name'];
                    }
                    elseif ($addressComponent[$i]['types'][0] == 'locality') {
                        $completeAddress['city'] = $addressComponent[$i]['short_name'];
                    }
                    else {
                        $completeAddress[$addressComponent[$i]['types'][0]] = $addressComponent[$i]['short_name'];
                    }
                    if($addressComponent[$i]['types'][0] == 'postal_code'
                    // && $addressComponent[$i]['short_name']==$address
                     ){
                        $completeAddress['postal_code'] =$addressComponent[$i]['short_name'];
                    }
                }
    
                if (array_key_exists('subpremise', $completeAddress)) {
                    $completeAddress['suite'] = $completeAddress['subpremise'];
                    unset($completeAddress['subpremise']);
                }
                else {
                    $completeAddress['suite'] = '';
                }
             
                //if($resp['results'][0]['formatted_address'] == $address1){
                    $completeAddress['address'] = $resp['results'][0]['formatted_address'];
              //   }
              //   else{
              //       $completeAddress['address'] = $address1;
              //   }
    
                
                
                $completeAddress['lat'] = $resp['results'][0]['geometry']['location']['lat'];
                $completeAddress['lng'] = $resp['results'][0]['geometry']['location']['lng'];
    
                unset($completeAddress['administrative_area_level_2']);
                unset($completeAddress['street_number']);
             
               
                return $completeAddress;
    
            }
            else{
                
                return ['status_code'=>403,'error'=>$resp['status']];
               // throw new GenericException($resp['status'],403);
            }
    
    
        }


        public function createAllCtcOrder(Request $request)
    {
        $i=0;
        $ids= $request->get('ids');
        $data_creates = CtcFailedOrders::whereIn('id', $ids)->get();
        foreach($data_creates as $data_create)
        {

            $startTime = empty($data_create->start_time) ? time() : date('H:i', strtotime($data_create->start_time));
            $startTime = date('H:i', strtotime($startTime));
            $due = strtotime(date("Y-m-d $startTime"));
    
            $dueTime = new \DateTime();
    
            $dueTime->setTimestamp($due);
            $dueTime->modify("+1 day");
    
    
            $end_time = empty($data_create->end_time) ? time() : date('H:i', strtotime($data_create->end_time));
    
    
            $order_request_body = new \stdClass();
            $sprint = new \stdClass();
            $sprint->creator_id = $data_create->vendor_id;
            $sprint->tracking_id = $data_create->tracking_num;
            $sprint->end_time = $end_time;
            $sprint->start_time = $startTime;
            $sprint->due_time = strtotime($dueTime->format('y-m-d H:i:s'));
            $order_request_body->sprint = $sprint;
            $contact = new \stdClass();
            $contact->name = $data_create->customer_name;
            $contact->phone = $data_create->customer_number;
            $contact->email = $data_create->customer_email;
            $order_request_body->contact = $contact;
    
            $location = new \stdClass();
            $location->address = $data_create->address;
            $order_request_body->location = $location;
    
           
            $order_request_body->notification_method = 'none';
            $order_request_body->weight = $data_create->weight;
            $order_request_body->admin = '1';
            $order_request_body->here_api = '1';
           
           $response  = $this->OrderRequest($order_request_body,'create_order',"POST");
        
              $response=json_decode($response,true);
         
            if ($response['http']['code'] == 201 || $response['http']['code'] == 200) {
                if (!isset($response['response']['id'])) {
                    return response()->json(['status_code'=>400,'error'=>'Order could not create.Please update your data.']);
                 
                    
                } else {
                    $i++;
                    CtcFailedOrders::where('id', '=', $data_create->id)->update(['deleted_at'=>date('Y-m-d H:i:s')]);
                   
                }
    
    
            } 
               
  
              
        }
        if($i!=0)
        {
       
          return response()->json(['status_code'=>200,'success'=>"Order Created Successfully"]);
          
        
        }
        else
        {
       
          return response()->json(['status_code'=>400,'error'=>"Order not created!"]);
          
        }
      
  
    }


    public function google_address($address){
        $address = urlencode($address);
        // google map geocode api url
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}components=country:canada&key=AIzaSyDTK4viphUKcrJBSuoidDqRhVA4AWnHOo0";


        // get the json response
        $resp_json = file_get_contents($url);

        // decode the json
        $resp = json_decode($resp_json, true);
        //dd($resp['status']);
        // response status will be 'OK', if able to geocode given address
        if($resp['status']=='OK'){

            $completeAddress = [];
            $addressComponent = $resp['results'][0]['address_components'];

            // get the important data

            for ($i=0; $i < sizeof($addressComponent); $i++) {
                if ($addressComponent[$i]['types'][0] == 'administrative_area_level_1') 
                {
                    $completeAddress['division'] = $addressComponent[$i]['short_name'];
                }
                elseif ($addressComponent[$i]['types'][0] == 'locality') {
                    $completeAddress['city'] = $addressComponent[$i]['short_name'];
                }
                else {
                    $completeAddress[$addressComponent[$i]['types'][0]] = $addressComponent[$i]['short_name'];
                }
                if($addressComponent[$i]['types'][0] == 'postal_code'){
                    $completeAddress['postal_code'] = $addressComponent[$i]['short_name'];
                }
            }

            if (array_key_exists('subpremise', $completeAddress)) {
                $completeAddress['suite'] = $completeAddress['subpremise'];
                unset($completeAddress['subpremise']);
            }
            else {
                $completeAddress['suite'] = '';
            }
         
            
            $completeAddress['address'] = $resp['results'][0]['formatted_address'];             
            
            $completeAddress['lat'] = $resp['results'][0]['geometry']['location']['lat'];
            $completeAddress['lng'] = $resp['results'][0]['geometry']['location']['lng'];

            unset($completeAddress['administrative_area_level_2']);
            
            return $completeAddress;
        
        }
        else{
          //  throw new GenericException($resp['status'],403);
          return 0;
        }
 
 
    }
}
