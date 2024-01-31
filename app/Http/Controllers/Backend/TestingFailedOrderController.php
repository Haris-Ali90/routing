<?php

namespace App\Http\Controllers\Backend;


use Illuminate\Http\Request;

use App\XmlFailedOrders;
use App\CtcFailedOrders;
use App\Vendor;
use App\MainfestFields;
use App\Sprint;
use App\AmazonEnteries;
use App\Task;
use App\BorderlessFailedOrders;
use App\BoradlessDashboard;

use App\City;
use App\Location;
use App\MerchantIds;
use App\SprintContacts;
use App\State;

use App\Http\Requests\Backend\CategoryRequest;
use Illuminate\Support\Facades\Request as FacadeRequest;
use App\Http\Controllers\Backend\BackendController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TestingFailedOrderController extends BackendController
{
    public function getAllOttawaCTCFailedOrder(Request $request)
    {
        $title="CTC Ottawa Failed Orders";
        $ottawa_vendor_ids=[477340,477341,477342,477343,477344,477345,477346];
        $data = $request->all();
        if (  $request->vendor_id==null &&  $request->tracking_id==null ) {
            $failedorders = CtcFailedOrders::
            whereIn('vendor_id',$ottawa_vendor_ids)->
            whereNull('deleted_at')
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
                if(!in_array($data['vendor_id'], $ottawa_vendor_ids)) 
                {
                    $data=[];
                    return backend_view( 'testingfailedorder.ctc-failed-order', compact('data','title') );
                }
                $failedorders = $failedorders->where('vendor_id', '=', $data['vendor_id']);
            }
            if (!empty($data['tracking_id'])) {
                $failedorders = $failedorders->where('tracking_num', '=', $data['tracking_id'])->
                whereIn('vendor_id',$ottawa_vendor_ids);
            }
            $data = $failedorders->get();
        }
        return backend_view( 'testingfailedorder.ctc-failed-order', compact('data','title') );
    }
    public function getAlltorontoCTCFailedOrder(Request $request)
    {
        $title="CTC Toronto Failed Orders";
        $toronto_vendor_ids=[477171,477255,477254,477283,477284,477286,477287,477288,477289,477307,477308,477309,477310,477311,477312,477313,477314,477292,477294,477315,477317,477316,477295,477302,477303,477304,477305,477306,477296,477290,477297,477298,477299,477300,477320,477301,477318,477627,477621,477625,477587,477559,477633];
        $data = $request->all();
        
        if ($request->vendor_id==null &&  $request->tracking_id=="") {
          
            $failedorders = CtcFailedOrders::
            whereIn('vendor_id',$toronto_vendor_ids)->
            whereNull('deleted_at')
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
                if(!in_array($data['vendor_id'], $toronto_vendor_ids)) 
                {
                  
                    $data=[];
                    return backend_view( 'testingfailedorder.ctc-failed-order', compact('data','title') );
                }
               
                $failedorders = $failedorders->where('vendor_id', '=', $data['vendor_id']);

            }
            if (!empty($data['tracking_id'])) {
                $failedorders = $failedorders->where('tracking_num', '=', $data['tracking_id'])->
                whereIn('vendor_id',$toronto_vendor_ids);
            }

            $data = $failedorders->get();
            
        }
       
        return backend_view( 'testingfailedorder.ctc-failed-order', compact('data','title') );
    }
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
        return backend_view( 'testingfailedorder.ctc-failed-order', compact('data') );
      
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
            
            //$response1 = $this->OrderRequest($order_request_body,'create_order',"POST");
           
           // $response1 
           $response  = $this->OrderRequest($order_request_body,'create_order_custom_route',"POST");
         
           //   $response = explode("<br", $response1);
                
           //    $response=json_decode($response[0],true);
              $response=json_decode($response,true);
           //    if($response==null)
           //    {
           //     return   response()->json(['status_code'=>400,"error"=>json_encode($response1)]);
           //    }
               
    
            if ($response['http']['code'] == 201 || $response['http']['code'] == 200) {
                if (!isset($response['response']['id'])) {
                    return response()->json(['status_code'=>400,'error'=>'Order Could Not Create.Please Update Your Data.']);
                 
                    
                } else {
    
                    CtcFailedOrders::where('id', '=', $data_create->id)->update(['deleted_at'=>date('Y-m-d H:i:s'),'updated_by'=>Auth::guard('web')->user()->id]);
                   
                }
    
    
            } elseif ($response['http']['code'] == 400) {
    
                if (isset($response['response']['location']['postal_code'])) {
                    return response()->json(['status_code'=>400,'error'=>'Invalid Postal Code']);
                  
                  
    
                } elseif (isset($response['response']['Contacts']['phone'])) {
                    return response()->json(['status_code'=>400,'error'=>'Order Could Not Create,Phone No Is Invalid']);
              
                 
                } elseif (isset($response['response']['contact']['email'])) {
                    return response()->json(['status_code'=>400,'error'=>'The Email Format Is Invalid']);
                   
                   
    
                } elseif (isset($response['response'])) {
                    
                    return response()->json(['status_code'=>400,'error'=>$response['response']]);
                  
                   
    
                } else {
                    return response()->json(['status_code'=>400,'error'=>'Order Could Not Create.Please Update Your Data']);
            
              
    
                }
               
            } else {
                return response()->json(['status_code'=>400,'error'=>'Order Could Not Create.Please Update Your Data']);
            
               
    
               
            }
    
            return response()->json(['status_code'=>200,'success'=>'Order Create Successfully']);
            
             
    
    
        }

      
    
  
     public function getAllAmazonFailedOrder(Request $request)
    {
        $title="Montreal Failed Order";
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
        ->whereNull('mainfest_fields.deleted_at')
        ->where('vendor_id','=',477260);
    
        $data=$data->get(['trackingid as tracking_id','mainfest_fields.id','customerordernumber as merchant_order_num',
        'consigneeaddressname','consigneeaddresscontactphone','consigneeaddressline1','consigneeaddressline2','consigneeaddressline3',
        'consigneeaddresszip','mainfest_fields.sprint_id' ]);
       
        return backend_view( 'testingfailedorder.amazon-failed-order', compact('data','vendor_id','title') );
      
    }
    public function getAllAmazonOttawaFailedOrder(Request $request)
    {
        $title="Ottawa Failed Order";
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
        ->whereNull('mainfest_fields.deleted_at')->where('vendor_id','=',477282);
    
        $data=$data->get(['trackingid as tracking_id','mainfest_fields.id','customerordernumber as merchant_order_num',
        'consigneeaddressname','consigneeaddresscontactphone','consigneeaddressline1','consigneeaddressline2','consigneeaddressline3',
        'consigneeaddresszip','mainfest_fields.sprint_id' ]);
       
        return backend_view( 'testingfailedorder.amazon-failed-order', compact('data','vendor_id','title') );
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
    
           
                $amazon_enteries=new AmazonEnteries();
                $amazon_enteries->creator_id=$order->vendor_id;
                $amazon_enteries->tracking_id=$order->tracking_id;
                $amazon_enteries->address_line_1=$data["line"];
                $amazon_enteries->address_line_2=$data["line2"];
                $amazon_enteries->address_line_3=$data["line3"];
                 $vendor = Vendor::find($order->vendor_id);
                $startTime = empty($vendor->attributes['order_start_time']) ? date("H:i",time()) :
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

                $order_request_body['location']=$this->get_address_using_hereapi($order->consigneeaddressline1,$order->consigneeaddresszip);

                if(!isset($order_request_body['location']['postal_code']))
                {
                    $order_request_body['location']=$this->canadian_postal_code($order->consigneeaddresszip);
                }

                if(isset($order_request_body['location']['status_code']) && $order_request_body['location']['status_code']==403)
                {
                    return response()->json(['status_code'=>400,'error'=>'Invalid Postal Code']);
                }
                $order_request_body['notification_method']='none';
                $order_request_body['admin']='1';
                $order_request_body['amazon']='1';
             
            // $response1 
            
            $response  = $this->OrderRequest($order_request_body,'create_order_custom_route',"POST");
           
         
        //   $response = explode("<br", $response1);
             
        //    $response=json_decode($response[0],true);
           $response=json_decode($response,true);
        //    if($response==null)
        //    {
        //     return   response()->json(['status_code'=>400,"error"=>json_encode($response1)]);
        //    }
            
    
            if ($response['http']['code'] == 201 || $response['http']['code'] == 200) {
                if (!isset($response['response']['id'])) {
                    return response()->json(['status_code'=>400,'error'=>'Order Could Not Create.Please Update Your Data.']);
                 
                    
                } else {
                    $amazon_enteries->sprint_id=$response['response']['id'];
                    $task_data=Task::join('locations','locations.id','=','sprint__tasks.location_id')
                    ->where('sprint__tasks.sprint_id','=',$response['response']['id'])
                    ->where('type','=','dropoff')->first(['locations.address','sprint__tasks.id','sprint__tasks.status_id']);
                    if($task_data!=null)
                    {
                        $amazon_enteries->task_id=$task_data->id;
                        $amazon_enteries->task_status_id=$task_data->status_id;
                        $amazon_enteries->address_line_2=$amazon_enteries->address_line_1;
                        $amazon_enteries->address_line_1=$task_data->address;
                    }
                    $amazon_enteries->save();
                    XmlFailedOrders::where('tracking_id','=',trim($order->tracking_id))->update(['deleted_at'=>date('Y-m-d H:i:s'),'updated_by'=>Auth::guard('web')->user()->id]);
                    MainfestFields::where('id','=',$id)->update(array('sprint_id'=>$response['response']['id']));
                    Sprint::where('id','=',$response['response']['id'])->update(array('direct_pickup_from_hub'=>1));
                   
                }
    
    
            } elseif ($response['http']['code'] == 400) {
    
                if (isset($response['response']['location']['postal_code'])) {
                    return response()->json(['status_code'=>400,'error'=>'Invalid Postal Code']);
                  
                  
    
                } elseif (isset($response['response']['Contacts']['phone'])) {
                    return response()->json(['status_code'=>400,'error'=>'Order Could Not Create,Phone No Is Invalid']);
              
                 
                } elseif (isset($response['response']['contact']['email'])) {
                    return response()->json(['status_code'=>400,'error'=>'The Email Format Is Invalid']);
                   
                   
    
                } elseif (isset($response['response'])) {
                    
                    return response()->json(['status_code'=>400,'error'=>$response['response']]);
                  
                   
    
                } else {
                    return response()->json(['status_code'=>400,'error'=>'Order Could Not Create.Please Update Your Data']);
            
              
    
                }
               
            } else {
                return response()->json(['status_code'=>400,'error'=>'Order Could Not Create.Please Update Your Data']);
            
               
    
               
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
          
      
        $amazon_enteries=new AmazonEnteries();
        $amazon_enteries->creator_id=$data->vendor_id;
        $amazon_enteries->tracking_id=$data->tracking_id;
        $amazon_enteries->address_line_1=$data->consigneeaddressline1;
        $amazon_enteries->address_line_2=$data->consigneeaddressline2;
        $amazon_enteries->address_line_3=$data->consigneeaddressline3;
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
        
        // $response1 
        $response  = $this->OrderRequest($order_request_body,'create_order_custom_route',"POST");
         
        //   $response = explode("<br", $response1);
             
        //    $response=json_decode($response[0],true);
           $response=json_decode($response,true);
        //    if($response==null)
        //    {
        //     return   response()->json(['status_code'=>400,"error"=>json_encode($response1)]);
        //    }
            
        if($response['http']['code']==201)
        {$i=1;
          $j++;
         
          if(!empty($response))
          {
            if(isset($response['id']))
            {
                $amazon_enteries->sprint_id=$response['response']['id'];
                $task_data=Task::join('locations','locations.id','=','sprint__tasks.location_id')
                ->where('sprint__tasks.sprint_id','=',$response['response']['id'])
                ->where('type','=','dropoff')->first(['locations.address','sprint__tasks.id','sprint__tasks.status_id']);
                if($task_data!=null)
                {
                    $amazon_enteries->task_id=$task_data->id;
                    $amazon_enteries->task_status_id=$task_data->status_id;
                    $amazon_enteries->address_line_2=$amazon_enteries->address_line_1;
                    $amazon_enteries->address_line_1=$task_data->address;
                }
                $amazon_enteries->save();
                XmlFailedOrders::where('tracking_id','=',trim($data->tracking_id))->update(['deleted_at'=>date('Y-m-d H:i:s'),'updated_by'=>Auth::guard('web')->user()->id]);
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
     
        return response()->json(['status_code'=>400,'error'=>"Order Not Created!"]);
        
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
           
           $response  = $this->OrderRequest($order_request_body,'create_order_custom_route',"POST");
        
              $response=json_decode($response,true);
         
            if ($response['http']['code'] == 201 || $response['http']['code'] == 200) {
                if (!isset($response['response']['id'])) {
                    return response()->json(['status_code'=>400,'error'=>'Order could not create.Please update your data.']);
                 
                    
                } else {
                    $i++;
                    CtcFailedOrders::where('id', '=', $data_create->id)->update(['deleted_at'=>date('Y-m-d H:i:s'),'updated_by'=>Auth::guard('web')->user()->id]);
                   
                }
    
    
            } 
               
  
              
        }
        if($i!=0)
        {
       
          return response()->json(['status_code'=>200,'success'=>"Order Created Successfully"]);
          
        
        }
        else
        {
       
          return response()->json(['status_code'=>400,'error'=>"Order Not Created!"]);
          
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
                    $completeAddress['division_long'] = $addressComponent[$i]['long_name'];
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
/*For New  Google validation Address*/
    public function google_address_validate($address){
//        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}components=country:canada&key=AIzaSyDTK4viphUKcrJBSuoidDqRhVA4AWnHOo0";
        $url = "https://addressvalidation.googleapis.com/v1:validateAddress?key=AIzaSyDTK4viphUKcrJBSuoidDqRhVA4AWnHOo0";
        $data_array= ["address"=>[
                    "revision"=> 0,
                    "regionCode"=> "",
                    "languageCode"=> "",
                    "postal_code"=> '',
                    "administrativeArea"=> "",
                    "locality"=> "",
                    "addressLines"=> [
                        $address
                    ]]];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_array));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $resp = json_decode($response, true);

            $completeAddress = [];
            if($resp['result']['verdict']['inputGranularity'] == 'PREMISE'){

                if(isset($resp['result']['address']['formattedAddress'])) {
                    $completeAddress['address'] = $resp['result']['address']['formattedAddress'];
                }
                if(isset($resp['result']['geocode']['location']))
                {
                    $completeAddress['lat']=$resp['result']['geocode']['location']['latitude'];
                    $completeAddress['lng']=$resp['result']['geocode']['location']['longitude'];
                }
                if(isset($resp['result']['address']['postalAddress']['postalCode']))
                { $completeAddress['postal_code']=$resp['result']['address']['postalAddress']['postalCode'];}
                if(isset($resp['result']['address']['postalAddress']['locality']))
                {
                    $completeAddress['city']=$resp['result']['address']['postalAddress']['locality'];
                }
                if(isset($resp['result']['address']['postalAddress']))
                {
                    $completeAddress['region']=$resp['result']['address']['postalAddress']['regionCode'];
                }
                if(isset($resp['result']['address']['postalAddress']['addressLines']))
                {
                    $completeAddress['route']=$resp['result']['address']['postalAddress']['addressLines'][0];
                }
                if(isset($resp['result']['address']['addressComponents'][0]['componentName']['text']))
                {
                    $completeAddress['street']=$resp['result']['address']['addressComponents'][0]['componentName']['text'];
                }
                if(isset( $resp['result']['address']['addressComponents'][6]['componentName']['text'])) {
                    $completeAddress['divsion'] = $resp['result']['address']['addressComponents'][6]['componentName']['text'];
                }

                return $completeAddress;
            }
            else{
                return 0;

            }


    }

    public function get_address_using_hereapi($address,$postalcode=null){

           
        $address = urlencode($address);
        $postalcode=urlencode(str_replace(' ','',$postalcode));
 
        // hereapi map geocode api url
        if($postalcode==null)
        {
            $url = "https://autocomplete.search.hereapi.com/v1/geocode?q={$address}&apiKey=G3ltf0YIlhIQxtGbWkI0jL_29xDDCZXy_ra88Mmhrn4";
        }
        else
        {
            $url = "https://autocomplete.search.hereapi.com/v1/geocode?qq=postalCode={$postalcode};country=canada&q={$address}&apiKey=G3ltf0YIlhIQxtGbWkI0jL_29xDDCZXy_ra88Mmhrn4";
        }
        
        // get the json response
        $resp_json = file_get_contents($url);
        
        $completeAddress=null;

        // decode the json
        $resp = json_decode($resp_json, true);
     
        $i=0;
        $maxscore=null;
        $maxscoreaddres=null;
     
        foreach($resp['items'] as $address)
        {
            if($address['address']['countryCode']=="CAN")
            {
                $completeAddress=$address['address'];
                $completeAddress['address']=$address['address']['label'];
                $completeAddress['postal_code']=$address['address']['postalCode'];
                // $completeAddress['house_number']=$address['address']['houseNumber'];
                $completeAddress['country']="CA";
               
                if(isset($address['access'])){
                    $completeAddress['lat']=$address['access'][0]['lat'];
                    $completeAddress['lng']=$address['access'][0]['lng'];
                }
                else {
                    $completeAddress['lat']=$address['position']['lat'];
                    $completeAddress['lng']=$address['position']['lng'];
                }

                unset($completeAddress['label']);
                if($maxscore==null)
                {
                    $maxscoreaddres=$completeAddress;
                    $maxscore=$address['scoring']['queryScore'];
                }
                else
                {
                    if($maxscore<$address['scoring']['queryScore'])
                    {
                        $maxscoreaddres=$completeAddress;
                        $maxscore=$address['scoring']['queryScore'];
                    }
                }
                

            }
        
        }
      
        $completeAddress=  $maxscoreaddres;
       
        // response status will be 'OK', if able to geocode given address
        if($completeAddress!=null)
        {
            return $completeAddress;
        }
        else{
        // throw new GenericException($resp['status'],403);
        return 0;
        }
        
        
    }

    public function getAllBorderlessFailedOrder(Request $request)
    {
        $title="Toronto Failed Orders";
        $borderless_vendor_ids=[477542,477559,477587,477641,477518,477621,477625,477633];
        $data = $request->all();
        if($request->vendor_id==null &&  $request->tracking_id==null){
            $failedorders = BorderlessFailedOrders::
            whereIn('vendor_id',$borderless_vendor_ids)->
            whereNull('deleted_at')
            ->orderBy('created_at','DESC')
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
                    'weight as weight',
                    'sprint_id as sprint_id',
                    'created_at']);

                    $data = $failedorders;
        } else {
            $failedorders = BorderlessFailedOrders::whereNull('deleted_at');
            if (!empty($data['vendor_id'])) {
                if(!in_array($data['vendor_id'], $borderless_vendor_ids)) 
                {
                    $data=[];
                    return backend_view( 'testingfailedorder.borderless-failed-order', compact('data','title') );
                }
                $failedorders = $failedorders->where('vendor_id', '=', $data['vendor_id']);
            }
            if (!empty($data['tracking_id'])) {
                $failedorders = $failedorders->where('tracking_num', '=', $data['tracking_id'])->
                whereIn('vendor_id',$borderless_vendor_ids);
            }
            $data = $failedorders->get();
        }
        return backend_view('testingfailedorder.borderless-failed-order',compact('data','title'));
    }

    public function createBorderlessOrder(Request $request)
    {
        $data = $request->all();

    
        $id =  $data['id'];
        $data['name'] = trim(str_replace(array("\n", "\r"), '', $data['name']));
        $data['mob'] = trim(str_replace(array("\n", "\r"), '', $data['mob']));
        $data['email'] = trim(str_replace(array("\n", "\r"), '', $data['email']));
        $data['line'] = trim(str_replace(array("\n", "\r"), '', $data['line']));
        $data['line2'] = trim(str_replace(array("\n", "\r"), '', $data['line2']));
       

        $data_create = BorderlessFailedOrders::where('id', '=', $id)->first();


        $data_create->customer_name = $data["name"];
        $data_create->customer_email = $data["email"];
        $data_create->customer_number = $data["mob"];
        $data_create->address = $data["line"];
        $data_create->address_line_2 = $data["line2"];
        $data_create->save();

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
      
        $response  = $this->OrderRequest($order_request_body,'create_order_custom_route',"POST");
     
        $response=json_decode($response,true);
     

        if ($response['http']['code'] == 201 || $response['http']['code'] == 200) {
            if (!isset($response['response']['id'])) {
                return response()->json(['status_code'=>400,'error'=>'Order Could Not Create.Please Update Your Data.']);
             
                
            } else {

                BorderlessFailedOrders::where('id', '=', $data_create->id)->update(['deleted_at'=>date('Y-m-d H:i:s'),'updated_by'=>Auth::guard('web')->user()->id]);
               
            }


        } elseif ($response['http']['code'] == 400) {

            if (isset($response['response']['location']['postal_code'])) {
                return response()->json(['status_code'=>400,'error'=>'Invalid Postal Code']);
              
              

            } elseif (isset($response['response']['Contacts']['phone'])) {
                return response()->json(['status_code'=>400,'error'=>'Order Could Not Create,Phone No Is Invalid']);
          
             
            } elseif (isset($response['response']['contact']['email'])) {
                return response()->json(['status_code'=>400,'error'=>'The Email Format Is Invalid']);
               
               

            } elseif (isset($response['response'])) {
                
                return response()->json(['status_code'=>400,'error'=>$response['response']]);
              
               

            } else {
                return response()->json(['status_code'=>400,'error'=>'Order Could Not Create.Please Update Your Data']);
        
          

            }
           
        } else {
            return response()->json(['status_code'=>400,'error'=>'Order Could Not Create.Please Update Your Data']);
        
           

           
        }

        return response()->json(['status_code'=>200,'success'=>'Order Create Successfully']);
        
    
    }
    public function createAllBorderlessOrder(Request $request)
    {
        $i=0;
        $ids= $request->get('ids');
        $data_creates = BorderlessFailedOrders::whereIn('id', $ids)->get();
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
           
           $response  = $this->OrderRequest($order_request_body,'order/create',"POST");
        
              $response=json_decode($response,true);
         
            if ($response['http']['code'] == 201 || $response['http']['code'] == 200) {
                if (!isset($response['response']['id'])) {
                    return response()->json(['status_code'=>400,'error'=>'Order could not create.Please update your data.']);
                 
                    
                } else {
                    $i++;
                    BorderlessFailedOrders::where('id', '=', $data_create->id)->update(['deleted_at'=>date('Y-m-d H:i:s'),'updated_by'=>Auth::guard('web')->user()->id]);
                   
                }
    
    
            } 
               
  
              
        }
        if($i!=0)
        {
       
          return response()->json(['status_code'=>200,'success'=>"Order Created Successfully"]);
          
        
        }
        else
        {
       
          return response()->json(['status_code'=>400,'error'=>"Order Not Created!"]);
          
        }
      
  
    }

//    public function createBorderlessTask(Request $request)
//    {
//        if(isset($request->end_time)){
//            if(empty($request->end_time) || $request->end_time == ""){
//                $request->end_time =date('H:i',strtotime("21:00:00") );
//            }
//        }
//        if(isset($request->start_time)){
//            if(empty($request->start_time) || $request->start_time == ""){
//                $request->start_time = date('H:i');
//            }
//        }
//
//        $sprint = array(
//            'merchant_order_number' => $request->merchant_order_number,
//            'start_time' => $request->start_time,
//            'end_time' => $request->end_time,
//            'tracking_id' => $request->tracking_num,
//            'sprint_id' => $request->sprint_id
//        );
//        $contact = array(
//            'name' => (string)trim(str_replace(array("\n", "\r"), '', $request->name)),
//            'email' => (string)trim(str_replace(array("\n", "\r"), '', $request->email)),
//            'phone' => (string)trim(str_replace(array("\n", "\r"), '', $request->phone)),
//        );
//
//        $dropoffAddress = null;
//        $is_failed = 0;
//        $addressString = null;
//        $addressString = (string)trim(str_replace(array("\n", "\r"), '', $request->line));
//
//        $condition = true;
//        while ($condition) {
//            $address = $this->addressParser($addressString); // function defined in address parser
//            if ($address == $addressString) {
//                $condition = false;
//            } else {
//                $addressString = $address;
//            }
//        }
//        $location = $this->google_address($request->line);
//
//        $data = array(
//            'sprint' => $sprint,
//            'contact' => $contact,
//            'location' => $location,
//            'is_failed' => $request->is_failed,
//            'notification_method' => 'none'
//        );
//        $vendor_id_xml = $request->vendor_id;
//        $store_name = Vendor::where('id', '=', $vendor_id_xml)->first();
//        $sprint_id = $data['sprint']['sprint_id'];
//        //amazon dashbaord changes
//        $task = Task::where('sprint_id', '=', $sprint_id)->where('ordinal', '=', 2)->first(['id', 'status_id']);
//        if (!isset($location['postal_code'])) {
//            $response['failed_orders'][] = array(
//                "tracking_id" => $request->tracking_num,
//                "merchant_order_num" => $request->merchant_order_number,
//                "reason" => 'Invalid dropoff address!.'
//            );
//
//            BorderlessFailedOrders::where('tracking_num','=',$request->tracking_num)
//            ->update([
//                    'vendor_id' => $vendor_id_xml,
//                    'customer_name' => trim(str_replace(array("\n", "\r"), '', $request->name)),
//                    'customer_number' => trim(str_replace(array("\n", "\r"), '', $request->phone)),
//                    'merchant_order_number' => $request->merchant_order_number,
//                    'customer_email' => trim(str_replace(array("\n", "\r"), '', $request->email)),
//                    'sprint_id' => $sprint_id,
//                    'response' => 'Please provide a valid address',
//                    'address' => $request->line,
//                ]);
//            // $data = BorderlessFailedOrders::create(['vendor_id' => $vendor_id_xml,
//            //     'customer_name' => trim(str_replace(array("\n", "\r"), '', $request->name)),
//            //     'customer_number' => trim(str_replace(array("\n", "\r"), '', $request->phone)),
//            //     'tracking_num' => $request->tracking_num,
//            //     'merchant_order_number' => $request->merchant_order_number,
//            //     'customer_email' => trim(str_replace(array("\n", "\r"), '', $request->email)),
//            //     'sprint_id' => $sprint_id,
//            //     'response' => 'Please provide a valid address',
//            //     'address' => $request->line,]);
//                $response = ['error' => "Please correct address info to create this order.", 'status' => 400];
//                return json_encode($response);
//        } else {
//
//            if(empty($task) || is_null($task)){
//                $order_detail = $this->dropoffTask($data);
//                $amazonorder['sprint_id'] = $sprint_id;
//                $amazonorder['task_id'] = $order_detail['task']->id;
//                $amazonorder['task_status_id'] = 61;
//                $amazonorder['eta_time'] = $order_detail['task']->eta_time;
//                $amazonorder['creator_id'] = $vendor_id_xml;
//                $amazonorder['store_name'] = $store_name->name;
//                $amazonorder['customer_name'] = trim(str_replace(array("\n", "\r"), '', $request->name));
//                $amazonorder['weight'] = $request->weight;
//                $amazonorder['tracking_id'] = $request->tracking_num;
//                $amazonorder['address_line_1'] = $addressString;
//                // $sprint_id = $order_detail[1]['sprint'];
//                BoradlessDashboard::create($amazonorder);
//
//                BorderlessFailedOrders::where('tracking_num','=',$request->tracking_num)->update(['deleted_at' => date('Y-m-d H:i:s')]);
//
//                $response = ['message' => "Task has been successfully created", 'status' => 200];
//                return json_encode($response);
//            }
//            else{
//                BorderlessFailedOrders::where('tracking_num','=',$request->tracking_num)->update(['deleted_at' => date('Y-m-d H:i:s')]);
//                $response = ['message' => "Task has already been created", 'status' => 200];
//                return json_encode($response);
//            }
//
//        }
//    }

    public function createBorderlessTask(Request $request)
    {
        if(isset($request->end_time)){
            if(empty($request->end_time) || $request->end_time == ""){
                $request->end_time =date('H:i',strtotime("21:00:00") );
            }
        }
        if(isset($request->start_time)){
            if(empty($request->start_time) || $request->start_time == ""){
                $request->start_time = date('H:i');
            }
        }

        $sprint = array(
            'merchant_order_number' => $request->merchant_order_number,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'tracking_id' => $request->tracking_num,
            'sprint_id' => $request->sprint_id
        );
        $contact = array(
            'name' => (string)trim(str_replace(array("\n", "\r"), '', $request->name)),
            'email' => (string)trim(str_replace(array("\n", "\r"), '', $request->email)),
            'phone' => (string)trim(str_replace(array("\n", "\r"), '', $request->phone)),
        );

        // getting pickup location of the sprint
        $pickup_loc_id = Task::where('sprint_id',$request->sprint_id)->where('type','=','pickup')->first();
        $pickupAddress = Location::where('id',$pickup_loc_id->location_id)->first();

        $dropoffAddress = null;
        $is_failed = 0;
        $addressString = null;
        $addressString = (string)trim(str_replace(array("\n", "\r"), '', $request->line));

        $condition = true;
        while ($condition) {
            $address = $this->addressParser($addressString); // function defined in address parser
            if ($address == $addressString) {
                $condition = false;
            } else {
                $addressString = $address;
            }
        }
        $pickup_location = $this->google_address($pickupAddress->address);
        $location = $this->google_address_validate($addressString);
        if($location == 0)
        {
            $response = ['error' => "Invalid Address.", 'status' => 400];
            return json_encode($response);
        }
        $data = array(
            'sprint' => $sprint,
            'contact' => $contact,
            'location' => $location,
            'is_failed' => $request->is_failed,
            'notification_method' => 'none'
        );
        $vendor_id_xml = $request->vendor_id;
        $store_name = Vendor::where('id', '=', $vendor_id_xml)->first();
        $sprint_id = $data['sprint']['sprint_id'];
        //amazon dashbaord changes

        $task = Task::where('sprint_id', '=', $sprint_id)->where('ordinal', '=', 2)->first(['id', 'status_id']);
        $dist = $this->calculate_distance($pickup_location,$location,"K");
        if(!empty($dist)){
            $d1=($dist)*0.001;
            if($d1>130){
                $is_failed = 1;
                $response['failed_orders'][] = array(
                    "tracking_id" => $request->tracking_num,
                    "merchant_order_num" => $request->merchant_order_number,
                    "reason" => 'Invalid dropoff address!.'
                );

                BorderlessFailedOrders::where('tracking_num','=',$request->tracking_num)
                    ->update([
                        'vendor_id' => $vendor_id_xml,
                        'customer_name' => trim(str_replace(array("\n", "\r"), '', $request->name)),
                        'customer_number' => trim(str_replace(array("\n", "\r"), '', $request->phone)),
                        'merchant_order_number' => $request->merchant_order_number,
                        'customer_email' => trim(str_replace(array("\n", "\r"), '', $request->email)),
                        'sprint_id' => $sprint_id,
                        'response' => 'Please provide a valid address',
                        'address' => $request->line,
                    ]);

                $response = ['error' => "Distance between pickup and drop off is greater than 100 km.", 'status' => 400];
                return json_encode($response);
            }
            else{
                if(empty($task) || is_null($task)){
                    $order_detail = $this->dropoffTask($data);
                    $amazonorder['sprint_id'] = $sprint_id;
                    $amazonorder['task_id'] = $order_detail['task']->id;
                    $amazonorder['task_status_id'] = 61;
                    $amazonorder['eta_time'] = $order_detail['task']->eta_time;
                    $amazonorder['creator_id'] = $vendor_id_xml;
                    $amazonorder['store_name'] = $store_name->name;
                    $amazonorder['customer_name'] = trim(str_replace(array("\n", "\r"), '', $request->name));
                    $amazonorder['weight'] = $request->weight;
                    $amazonorder['tracking_id'] = $request->tracking_num;
                    $amazonorder['address_line_1'] = $addressString;
                    // $sprint_id = $order_detail[1]['sprint'];
                    BoradlessDashboard::create($amazonorder);

                    BorderlessFailedOrders::where('tracking_num','=',$request->tracking_num)->update(['deleted_at' => date('Y-m-d H:i:s')]);

                    $response = ['message' => "Task has been successfully created", 'status' => 200];
                    return json_encode($response);
                }
                else{
                    BorderlessFailedOrders::where('tracking_num','=',$request->tracking_num)->update(['deleted_at' => date('Y-m-d H:i:s')]);
                    $response = ['message' => "Task has already been created", 'status' => 200];
                    return json_encode($response);
                }
            }
        }
    }
    // Function for sprint for drop off address
    private function iniSprint2($sprint)
    {
        // check if sprint is null
        if ($sprint !== null) {
            if (isset($sprint['sprint_id'])) {
                $sprint['id'] = Sprint::find($sprint['sprint_id']);
            }

            return array("sprint" => $sprint['sprint_id']);
        } else {
            $sprint['status_id'] = 61;
            $sprint['deleted_at'] = null;
            $sprint['is_cc_preauthorized'] = 0;

            if (!array_key_exists('is_sameday', $sprint)) {
                $sprint['is_sameday'] = 0;
            }

            if (!array_key_exists('merchant_order_num', $sprint)) {
                $sprint['merchant_order_num'] = 0;
            }
            //$sprint = Sprint::create($sprint);
            return $sprint;
        }
    }

    // Function for dropoff task
    private function dropoffTask($dropoffData)
    {
        $dropoffData['type'] = 'dropoff';

        if(!isset($dropoffData['location']['city'])){
            $dropoffData['location']['city'] = $dropoffData['location']['administrative_area_level_3'];
        }

        // checking if dropoff is being failed
        if ($dropoffData['is_failed'] == 0) {

            $dropOffResponse = $this->processTask2($dropoffData);
            $task = new Task();
            $task->sprint_id = $dropoffData['sprint']['sprint_id'];
            $task->status_id = 61;
            $task->ordinal = 2;
            $task->type = 'dropoff';
            $task->due_time = strtotime(date('Y-m-d H:i:s'));
            $task->eta_time = strtotime(date('Y-m-d H:i:s'));
            $task->etc_time = strtotime(date('Y-m-d H:i:s'));
            $task->save();
            // $task = Task::create();// creating sprint Task
            $state = State::where('name', '=', $dropoffData['location']['division_long'])->first();

            if (empty($state)) {
                $state_id = DB::table('states')->insertGetId([
                    'country_id' => '43',
                    'tax_id' => '1',
                    'name' => $dropoffData['location']['division_long'],
                    'code' => $dropoffData['location']['division'],
                ]);

            } else {
                $state_id = State::where('name', '=', $dropoffData['location']['division_long'])->first()->id;
            }
            $city = City::where('name', '=', $dropoffData['location']['city'])->first();
            if (empty($city)) {
                $city_id = DB::table('cities')->insertGetId([
                    'country_id' => '43',
                    'state_id' => $state_id,
                    'name' => $dropoffData['location']['city']
                ]);
            } else {
                $city_id = City::where('name', '=', $dropoffData['location']['city'])->first()->id;
            }
            $key = 'c9e92bb1ffd642abc4ceef9f4c6b1b3aaae8f5291e4ac127d58f4ae29272d79d903dfdb7c7eb6e487b979001c1658bb0a3e5c09a94d6ae90f7242c1a4cac60663f9cbc36ba4fe4b33e735fb6a23184d32be5cfd9aa5744f68af48cbbce805328bab49c99b708e44598a4efe765d75d7e48370ad1cb8f916e239cbb8ddfdfe3fe';
            $iv = 'f13c9f69097a462be81995330c7c68f754f0c6026720c16ad2c1f5f316452ee000ce71d64ed065145afdd99b43c0d632b1703fc6a6754284f5d19b82dc3697d664dc9f66147f374d46c94cf23a78f14f0c6823d1cbaa19c157b4cb81e106b79b11593dcddf675951bc07f54528fc8c03cf66e9c437595d1cac658a737ab1183f';
            $task['pin'] = (string)rand(1000, 9999);
            //$task['sprint_id'] = $dropOffResponse[1]['sprint']->id;

            /**
             * sprint id jo ap uthaogay wo is jaga rkhdena         $task['sprint_id']
             */

            $task['sprint_id'] = $dropoffData['sprint']['sprint_id'];
            $task['ordinal'] = 2;
            $task['location_id'] = Location::where('latitude', '=', ($dropoffData['location']['lat'] * 1000000))->where('longitude', ($dropoffData['location']['lng'] * 1000000))->first(); // getting location id
            if ($task['location_id'] === null) {
                // create location if not exists
                $task['location_id'] = Location::create(["address" => $dropoffData['location']['address'],
                    "city_id" => $city_id,
                    "state_id" => $state_id,
                    "country_id" => '43',
                    "postal_code" => $dropoffData['location']['postal_code'],
                    "buzzer" => "",
                    "suite" => "",
                    "latitude" => (float)$dropoffData['location']['lat'] * 1000000,
                    "longitude" => (float)$dropoffData['location']['lng'] * 1000000,
                    "location_type" => '',
                ]);

                $enc_location = DB::table('locations_enc')->insert(
                    array(
                        'address' => DB::raw("AES_ENCRYPT('" . $dropoffData['location']['address'] . "', '" . $key . "')"),
                        'city_id' => $city_id,
                        'state_id' => $state_id,
                        'country_id' => '43',
                        'postal_code' => DB::raw("AES_ENCRYPT('" . $dropoffData['location']['postal_code'] . "', '" . $key . "')"),
                        'latitude' => DB::raw("AES_ENCRYPT('" . ($dropoffData['location']['lat'] * 1000000) . "', '" . $key . "')"),
                        'longitude' => DB::raw("AES_ENCRYPT('" . ($dropoffData['location']['lng'] * 100000) . "', '" . $key . "')"),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'type' => $dropoffData['type']
                    )
                );
            }
            // if email and phone empty
            if (empty($dropoffData['contact']['email']) && empty($dropoffData['contact']['phone'])) {
                $task['contact_id'] = SprintContacts::where('name', '=', $dropoffData['contact']['name'])->first()->id; // getting contact id
                if ($task['contact_id'] === null) {
                    $task['contact_id'] = SprintContacts::create($dropoffData['contact'])->id;
                } else {
                    $task['contact_id'] = SprintContacts::where('name', '=', $dropoffData['contact']['name'])->first()->id; // getting contact id
                }
            }
            else{
                //checking email
                $task['contact_id'] = SprintContacts::where('email','=',$dropoffData['contact']['email'])
                ->where('name','=',$dropoffData['contact']['name'])
                ->where('phone','=',$dropoffData['contact']['phone'])
                ->first(); // getting contact id
                // if email is null
                if($task['contact_id']===null){
                    // creating new contact  and return
                    $task['contact_id'] = SprintContacts::create($dropoffData['contact'])->id;
                    $enc_contact = DB::table('contacts_enc')->insert(
                        array(
                            'id' => $task['contact_id'],
                            'name' => DB::raw("AES_ENCRYPT('".$dropoffData['contact']['name']."', '".$key."', '".$iv."')"),
                            'email' => DB::raw("AES_ENCRYPT('".$dropoffData['contact']['email']."', '".$key."', '".$iv."')"),
                            'phone' => DB::raw("AES_ENCRYPT('".$dropoffData['contact']['phone']."', '".$key."', '".$iv."')"),
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        )
                    );
                }
                else{
                    $task['contact_id'] = $task['contact_id']->id; // getting contact id
                }
            }

            $updatingSprintId = Task::where('id', '=', $task->id)
                ->update(array
                (
                    'pin' => $task['pin'],
                    'location_id' => $task['location_id']->id,
                    'contact_id' => $task['contact_id'],
                 ));

            MerchantIds::create(['task_id' => $task->id,
                'merchant_order_num' => isset($dropoffData['sprint']['merchant_order_number']) ? $dropoffData['sprint']['merchant_order_number'] : null,
                'end_time' => isset($dropoffData['sprint']['end_time']) ? $dropoffData['sprint']['end_time'] : null,
                'start_time' => isset($dropoffData['sprint']['start_time']) ? $dropoffData['sprint']['start_time'] : null,
                'tracking_id' => isset($dropoffData['sprint']['tracking_id']) ? $dropoffData['sprint']['tracking_id'] : null,
                'address_line2' => isset($dropoffData['location']['address']) ? $dropoffData['location']['address'] : null]);
            $dropOffResponse['task'] = $task;
            return $dropOffResponse;

        }

    }

    // Process task function for dropoff address
    private function processTask2($request_data)
    {
        // Checking location and contact if exists
        try {
            $response = $this->isXmlOrderValid2($request_data['location'], $request_data['sprint'], $request_data['contact']);
            if ($response) {
                return $response;
            } else {

                $response = json_encode(array("status" => 400, "message" => "Invalid address or contact info."));
                return $response;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    // Checking if xml order is valid for dropoff address
    private function isXmlOrderValid2($location, $sprint, $contact)
    {
        try {
            return array($this->initializeLocation($location), $this->iniSprint2($sprint), $this->initializeContact($contact['name']), true);

        } catch (\Exception $e) {
            return false;
        }
    }

    // Checking location is valid
    private function initializeLocation($location)
    {
        if (empty($location)) {
            if (isset($location['id'])) {
                $location = Location::find($location['id']);
            } else {
                $location = new Location();
            }
        }
        return $location;
    }

    // Checking contact is valid
    private function initializeContact($contact)
    {
        if (empty($contact)) {
            if (isset($contact['id'])) {
                $contact = ContactEnc::find($contact['id']);
            } else {
                $contact = new ContactEnc();
            }
        }
        return $contact;
    }

    // function to validate address
    public function addressParser($address)
    {
        $pattern[] = "/^PH[0-9]+/";
        $pattern[] = "/^[0-9]+\s*-\s*[0-9]+/";
        $pattern[] = "/\sApt[0-9]+/";
        $pattern[] = "/^[0-9]+\s[0-9]+/";
        $pattern[] = "/(Apt|Apartment|Unit)\#\s*[0-9]+/";

        $result = preg_replace($pattern[0], '', $address);
        if ($result != $address) {
            return $result;
        }

        $result = preg_replace($pattern[2], '', $address);
        if ($result != $address) {
            return $result;
        }

        $result = preg_replace($pattern[4], '', $address);

        if ($result != $address) {
            return $result;
        }

        if (preg_match($pattern[1], $address)) {
            $result = preg_replace("/^[0-9]+\s*-\s*/", '', $address);
            return $result;
        }

        if (preg_match($pattern[3], $address)) {
            $result = preg_replace("/^[0-9]+\s/", '', $address);
            return $result;
        }

        return $address;

    }
    private function calculate_distance($addressFrom, $addressTo,$unit){
        // Get latitude and longitude from the geodata
        $latitudeFrom    = $addressFrom['lat'];
        $longitudeFrom    = $addressFrom['lng'];
        $latitudeTo        = $addressTo['lat'];
        $longitudeTo    = $addressTo['lng'];

        // Calculate distance between latitude and longitude
        $theta    = $longitudeFrom - $longitudeTo;
        $dist    = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
        $dist    = acos($dist);
        $dist    = rad2deg($dist);
        $miles    = $dist * 60 * 1.1515;

        // returning distance in meteres
        return round($miles * 1.609344 * 1000, 2);

    }

}
