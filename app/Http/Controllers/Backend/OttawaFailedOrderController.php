<?php
namespace App\Http\Controllers\Backend;

/*updated by Muhammad Raqib @date 29/09/2022*/
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

class OttawaFailedOrderController extends BackendController{

    public function getAllBorderlessFailedOrder(Request $request)
    {
        $title="Ottawa Failed Orders";
        $borderless_vendor_ids=[477631,477629];
        $data = $request->all();
        if(($request->vendor_id==null &&  $request->tracking_id==null) || ($request->vendor_id=='' &&  $request->tracking_id=='')){
            $failedorders = BorderlessFailedOrders::
            whereIn('vendor_id',$borderless_vendor_ids)
                ->whereNull('deleted_at')
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
                    'sprint_id as sprint_id']);
                    $data = $failedorders;
        } else {
            $failedorders = BorderlessFailedOrders::whereNull('deleted_at');
            if (!empty($data['vendor_id'])) {
                if(!in_array($data['vendor_id'], $borderless_vendor_ids)) 
                {
                    $data=[];
                    return backend_view( 'testingfailedorder.ottawa-failed-order', compact('data','title') );
                }
                $failedorders = $failedorders->where('vendor_id', '=', $data['vendor_id']);
            }
            if (!empty($data['tracking_id'])) {
                $failedorders = $failedorders->where('tracking_num', '=', $data['tracking_id'])->
                whereIn('vendor_id',$borderless_vendor_ids);
            }
            $data = $failedorders->get();
        }
        return backend_view('testingfailedorder.ottawa-failed-order',compact('data','title'));
    }

    public function createBorderlessOrder(Request $request){
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


        } 
        elseif ($response['http']['code'] == 400) {

            if (isset($response['response']['location']['postal_code'])) {
                return response()->json(['status_code'=>400,'error'=>'Invalid Postal Code']);
            } 
            elseif (isset($response['response']['Contacts']['phone'])) {
                return response()->json(['status_code'=>400,'error'=>'Order Could Not Create,Phone No Is Invalid']);
            } 
            elseif (isset($response['response']['contact']['email'])) {
                return response()->json(['status_code'=>400,'error'=>'The Email Format Is Invalid']);
            } 
            elseif (isset($response['response'])) {
                return response()->json(['status_code'=>400,'error'=>$response['response']]);
            } 
            else {
                return response()->json(['status_code'=>400,'error'=>'Order Could Not Create.Please Update Your Data']);
            }
           
        } 
        else {
            return response()->json(['status_code'=>400,'error'=>'Order Could Not Create.Please Update Your Data']);
        }

        return response()->json(['status_code'=>200,'success'=>'Order Create Successfully']);

    }

    public function createAllBorderlessOrder(Request $request){
        $i=0;
        $ids= $request->get('ids');
        $data_creates = BorderlessFailedOrders::whereIn('id', $ids)->get();
        foreach($data_creates as $data_create){

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
                } 
                else {
                    $i++;
                    BorderlessFailedOrders::where('id', '=', $data_create->id)->update(['deleted_at'=>date('Y-m-d H:i:s'),'updated_by'=>Auth::guard('web')->user()->id]);               
                }
    
            } 

        }
        if($i!=0){
          return response()->json(['status_code'=>200,'success'=>"Order Created Successfully"]);
        }
        else{
          return response()->json(['status_code'=>400,'error'=>"Order Not Created!"]);    
        }
      
    }

    public function createBorderlessTask(Request $request){
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
        $location = $this->google_address($request->line);

        $data = array(
            'sprint' => $sprint,
            'contact' => $contact,
            'location' => $location,
            'is_failed' => $request->is_failed,
            'notification_method' => 'none'
        );

        $vendor_id_xml = $request->vendor_id;
        $order_detail = $this->dropoffTask($data);
        $sprint_id = $order_detail[1]['sprint'];
        //amazon dashbaord changes
        $task = Task::where('sprint_id', '=', $vendor_id_xml)->where('ordinal', '=', 2)->first(['id', 'status_id']);

        $store_name = Vendor::where('id', '=', $vendor_id_xml)->first();

        if (!isset($location['postal_code'])) {
            $response['failed_orders'][] = array(
                "tracking_id" => $request->tracking_num,
                "merchant_order_num" => $request->merchant_order_number,
                "reason" => 'Invalid dropoff address!.'
            );
            $data = BorderlessFailedOrders::create(['vendor_id' => $vendor_id_xml,
                'customer_name' => trim(str_replace(array("\n", "\r"), '', $request->name)),
                'customer_number' => trim(str_replace(array("\n", "\r"), '', $request->phone)),
                'tracking_num' => $request->tracking_num,
                'merchant_order_number' => $request->merchant_order_number,
                'customer_email' => trim(str_replace(array("\n", "\r"), '', $request->email)),
                'sprint_id' => $sprint_id,
                'reason' => 'Please provide a valid address',
                'address' => $request->line,]);
        } 
        else {

            $amazonorder['sprint_id'] = $sprint_id;
            $amazonorder['task_id'] = $order_detail['task']->id;
            $amazonorder['task_status_id'] = 61;
            $amazonorder['creator_id'] = $vendor_id_xml;
            $amazonorder['customer_name'] = trim(str_replace(array("\n", "\r"), '', $request->name));
            $amazonorder['weight'] = $request->weight;
            $amazonorder['tracking_id'] = $request->tracking_num;
            $amazonorder['address_line_1'] = $addressString;

            BoradlessDashboard::create($amazonorder);

            BorderlessFailedOrders::where('id','=',$request->id)->update(['deleted_at' => date('Y-m-d H:i:s')]);

            $response = ['message' => "Task has been successfully created", 'status' => 200];
            return json_encode($response);
        }
    } 

    public function OrderRequest($data,$url,$request){
       
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

    }
}