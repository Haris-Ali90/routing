<?php

namespace App\Http\Controllers\Backend;

use App\BoradlessDashboard;
use App\Classes\Fcm;
use App\CTCEntry;
use App\Post;
use App\Reason;
use App\RouteHistory;
use App\SprintConfirmation;
use App\StatusMap;
use App\TrackingImageHistory;
use App\UserDevice;
use App\UserNotification;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Backend\BackendController;
use Illuminate\Support\Facades\Auth;

use App\CtcVendor;
use App\JoeyRoute;
use App\Slots;
use App\TaskHistory;
use App\SprintHistory;
use App\SprintReattempt;
use App\MerchantIds;
use App\Sprint;
use App\Task;
use App\AmazonEntry;
use App\SlotsPostalCode;
use App\Teachers;
use App\Institute;
use App\Amazon;
use App\Claim;
use App\City;
use App\State;
use App\Location;
use App\LocationEnc;
use App\CoursesRequest;
use App\AddressApproval;
use date;
use DB;
use Carbon\Carbon;


use \JoeyCo\Laravel\Api\JsonRequest;
use JoeyCo\Laravel\Hub;
// use JoeyCo\Laravel\Sprint;
//use JoeyCo\Laravel\Task;
// use JoeyCo\Laravel\MerchantIds;
use JoeyCo\Laravel\JoeyHubRoute;
use JoeyCo\Laravel\JoeyPickRoute;
use JoeyCo\Laravel\JoeyPickRouteLocations;
use App\JoeyRouteLocations;
use \JoeyCo\Laravel\SprintSchedules;
use \JoeyCo\Laravel\SprintJoeySchedules;
use JoeyCo\Laravel\WalmartZoneRoutific;
use JoeyCo\Laravel\Joey;
use App\JobRoutes;
use \Laravel\View;
use \Laravel\Input;
//use Laravel\Redirect;
use Illuminate\Support\Facades\Redirect;
use Laravel\Session;
use \JoeyCo\Mapping\Routific\Client;



class AddressUpdateController extends BackendController
{
  public static $status = array("136" => "Client requested to cancel the order",
    "137" => "Delay in delivery due to weather or natural disaster",
    "118" => "left at back door",
    "117" => "left with concierge",
    "135" => "Customer refused delivery",
    "108" => "Customer unavailable-Incorrect address",
    "106" => "Customer unavailable - delivery returned",
    "107" => "Customer unavailable - Left voice mail - order returned",
    "109" => "Customer unavailable - Incorrect phone number",
    "142" => "Damaged at hub (before going OFD)",
    "143" => "Damaged on road - undeliverable",
    "144" => "Delivery to mailroom",
    "103" => "Delay at pickup",
    "139" => "Delivery left on front porch",
    "138" => "Delivery left in the garage",
    "114" => "Successful delivery at door",
    "113" => "Successfully hand delivered",
    "120" => "Delivery at Hub",
    "110" => "Delivery to hub for re-delivery",
    "111" => "Delivery to hub for return to merchant",
    "121" => "Out for delivery",
    "102" => "Joey Incident",
    "104" => "Damaged on road - delivery will be attempted",
    "105" => "Item damaged - returned to merchant",
    "129" => "Joey at hub",
    "128" => "Package on the way to hub",
    "140" => "Delivery missorted, may cause delay",
    "116" => "Successful delivery to neighbour",
    "132" => "Office closed - safe dropped",
    "101" => "Joey on the way to pickup",
    "32" => "Order accepted by Joey",
    "14" => "Merchant accepted",
    "36" => "Cancelled by JoeyCo",
    "124" => "At hub - processing",
    "38" => "Draft",
    "18" => "Delivery failed",
    "56" => "Partially delivered",
    "17" => "Delivery success",
    "68" => "Joey is at dropoff location",
    "67" => "Joey is at pickup location",
    "13" => "At hub - processing",
    "16" => "Joey failed to pickup order",
    "57" => "Not all orders were picked up",
    "15" => "Order is with Joey",
    "112" => "To be re-attempted",
    "131" => "Office closed - returned to hub",
    "125" => "Pickup at store - confirmed",
    "61" => "Scheduled order",
    "37" => "Customer cancelled the order",
    "34" => "Customer is editting the order",
    "35" => "Merchant cancelled the order",
    "42" => "Merchant completed the order",
    "54" => "Merchant declined the order",
    "33" => "Merchant is editting the order",
    "29" => "Merchant is unavailable",
    "24" => "Looking for a Joey",
    "23" => "Waiting for merchant(s) to accept",
    "28" => "Order is with Joey",
    "133" => "Packages sorted",
    "55" => "ONLINE PAYMENT EXPIRED",
    "12" => "ONLINE PAYMENT FAILED",
    "53" => "Waiting for customer to pay",
    "141" => "Lost package",
    "60" => "Task failure",
    "255" => 'Order Delay',
    '147' => 'Scanned at Hub',
    '148' => 'Scanned at Hub and labelled',
    '149' => 'pick from hub',
    '150' => 'drop to other hub',
      '153' => 'Miss sorted to be reattempt',
      '154' => 'Joey unable to complete the route', '155' => 'To be re-attempted tomorrow'
  );

    private $status_codes = [
        'completed'=>
            [
                "JCO_ORDER_DELIVERY_SUCCESS"=>17,
                "JCO_HAND_DELIEVERY" => 113,
                "JCO_DOOR_DELIVERY" => 114,
                "JCO_NEIGHBOUR_DELIVERY" => 116,
                "JCO_CONCIERGE_DELIVERY" => 117,
                "JCO_BACK_DOOR_DELIVERY" => 118,
                "JCO_OFFICE_CLOSED_DELIVERY" => 132,
                "JCO_DELIVER_GERRAGE" => 138,
                "JCO_DELIVER_FRONT_PORCH" => 139,
                "JCO_DEILVER_MAILROOM" => 144
            ],
        'return'=>
            [
                "JCO_ITEM_DAMAGED_INCOMPLETE" => 104,
                "JCO_ITEM_DAMAGED_RETURN" => 105,
                "JCO_CUSTOMER_UNAVAILABLE_DELIEVERY_RETURNED" => 106,
                "JCO_CUSTOMER_UNAVAILABLE_LEFT_VOICE" => 107,
                "JCO_CUSTOMER_UNAVAILABLE_ADDRESS" => 108,
                "JCO_CUSTOMER_UNAVAILABLE_PHONE" => 109,
                "JCO_HUB_DELIEVER_REDELIEVERY" => 110,
                "JCO_HUB_DELIEVER_RETURN" => 111,
                "JCO_ORDER_REDELIVER" => 112,
                "JCO_ORDER_RETURN_TO_HUB" => 131,
                "JCO_CUSTOMER_REFUSED_DELIVERY" => 135,
                "CLIENT_REQUEST_CANCEL_ORDER" => 136,
                "JCO_ON_WAY_PICKUP" => 101,
            ],

        'pickup'=>
            [
                "JCO_HUB_PICKUP"=>121
            ],

    ];


    public function statusmap($id)
  {
    $statusid = array("136" => "Client requested to cancel the order",
    "137" => "Delay in delivery due to weather or natural disaster",
    "118" => "left at back door",
    "117" => "left with concierge",
    "135" => "Customer refused delivery",
    "108" => "Customer unavailable-Incorrect address",
    "106" => "Customer unavailable - delivery returned",
    "107" => "Customer unavailable - Left voice mail - order returned",
    "109" => "Customer unavailable - Incorrect phone number",
    "142" => "Damaged at hub (before going OFD)",
    "143" => "Damaged on road - undeliverable",
    "144" => "Delivery to mailroom",
    "103" => "Delay at pickup",
    "139" => "Delivery left on front porch",
    "138" => "Delivery left in the garage",
    "114" => "Successful delivery at door",
    "113" => "Successfully hand delivered",
    "120" => "Delivery at Hub",
    "110" => "Delivery to hub for re-delivery",
    "111" => "Delivery to hub for return to merchant",
    "121" => "Pickup from Hub",
    "102" => "Joey Incident",
    "104" => "Damaged on road - delivery will be attempted",
    "105" => "Item damaged - returned to merchant",
    "129" => "Joey at hub",
    "128" => "Package on the way to hub",
    "140" => "Delivery missorted, may cause delay",
    "116" => "Successful delivery to neighbour",
    "132" => "Office closed - safe dropped",
    "101" => "Joey on the way to pickup",
    "32"  => "Order accepted by Joey",
    "14"  => "Merchant accepted",
    "36"  => "Cancelled by JoeyCo",
    "124" => "At hub - processing",
    "38"  => "Draft",
    "18"  => "Delivery failed",
    "56"  => "Partially delivered",
    "17"  => "Delivery success",
    "68"  => "Joey is at dropoff location",
    "67"  => "Joey is at pickup location",
    "13"  => "At hub - processing",
    "16"  => "Joey failed to pickup order",
    "57"  => "Not all orders were picked up",
    "15"  => "Order is with Joey",
    "112" => "To be re-attempted",
    "131" => "Office closed - returned to hub",
    "125" => "Pickup at store - confirmed",
    "61"  => "Scheduled order",
    "37"  => "Customer cancelled the order",
    "34"  => "Customer is editting the order",
    "35"  => "Merchant cancelled the order",
    "42"  => "Merchant completed the order",
    "54"  => "Merchant declined the order",
    "33"  => "Merchant is editting the order",
    "29"  => "Merchant is unavailable",
    "24"  => "Looking for a Joey",
    "23"  => "Waiting for merchant(s) to accept",
    "28"  => "Order is with Joey",
    "133" => "Packages sorted",
    "55"  => "ONLINE PAYMENT EXPIRED",
    "12"  => "ONLINE PAYMENT FAILED",
    "53"  => "Waiting for customer to pay",
    "141" => "Lost package",
    "60"  => "Task failure",
    "255" => 'Order Delay',
    "145" => 'Returned To Merchant',
    "146" => "Delivery Missorted, Incorrect Address",
    '147' => 'Scanned at Hub',
    '148' => 'Scanned at Hub and labelled',
    '149' => 'pick from hub',
    '150' => 'drop to other hub',
        '153' => 'Miss sorted to be reattempt',
        '154' => 'Joey unable to complete the route', '155' => 'To be re-attempted tomorrow');
    return $statusid[$id];
  }



  public function get_trackingid(Request $request)
  {
          $user=[];

        if(!empty($request->input('tracking_id')))
        {

            $id=$request->input('tracking_id');
            // dd(id)
            $user= MerchantIds::join('sprint__tasks','sprint__tasks.id','=','merchantids.task_id')->
            join('sprint__sprints','sprint__tasks.sprint_id','=','sprint__sprints.id') 
             ->where('sprint__tasks.type','=','dropoff');

              // dd($user);
            
            $user=$user->whereNull('sprint__sprints.deleted_at')
               ->where('merchantids.tracking_id','=',$id)->orderBy('merchantids.id','DESC')->take(1)
               ->get(array("sprint__sprints.id",\DB::raw("CONVERT_TZ(sprint__sprints.created_at,'UTC','America/Toronto') as created_at"),'sprint__sprints.status_id','merchantids.tracking_id'));
               
                if(empty($user))
                {
                    $user=[];
                }
              //dd($user);
        }
          return backend_view('searchorder',['data'=>$user]);
  }
  public function get_trackingorderdetails($sprintId)
  {
    $result= Sprint::join('sprint__tasks','sprint_id','=','sprint__sprints.id')
        ->leftJoin('merchantids','merchantids.task_id','=','sprint__tasks.id')
        ->leftJoin('joey_route_locations','joey_route_locations.task_id','=','sprint__tasks.id')
        ->leftJoin('joey_routes','joey_routes.id','=','joey_route_locations.route_id')
        ->leftJoin('joeys','joeys.id','=','joey_routes.joey_id')
        ->join('locations','sprint__tasks.location_id','=','locations.id')
        ->join('sprint__contacts','contact_id','=','sprint__contacts.id')
        ->leftJoin('vendors','creator_id','=','vendors.id')
        ->where('sprint__tasks.sprint_id','=',$sprintId)
        ->whereNull('joey_route_locations.deleted_at')
        ->orderBy('ordinal','DESC')->take(1)
        ->get(array('sprint__tasks.*','joey_routes.id as route_id',\DB::raw("CONVERT_TZ(joey_routes.date,'UTC','America/Toronto') as route_date"),'joey_route_locations.id as route_location_id','locations.address','locations.suite','locations.postal_code','sprint__contacts.name','sprint__contacts.phone','sprint__contacts.email',
        'joeys.first_name as joey_firstname','joeys.id as joey_id',
        'joeys.last_name as joey_lastname','vendors.first_name as merchant_firstname','vendors.last_name as merchant_lastname','vendors.name as vendor_name','merchantids.scheduled_duetime'
        ,'joeys.id as joey_id','merchantids.tracking_id','joeys.phone as joey_contact','joey_route_locations.ordinal as stop_number','merchantids.merchant_order_num','merchantids.address_line2','sprint__sprints.creator_id'));

        $i=0;

        $data = [];
        
        foreach($result as $tasks){
            $status2 = array();
            $status = array();
            $status1 = array();
           $data[$i] =  $tasks;
           $taskHistory= TaskHistory::where('sprint_id','=',$tasks->sprint_id)->WhereNotIn('status_id',[17,38])->orderBy('date')
           //->where('active','=',1)
           ->get(['status_id',\DB::raw("CONVERT_TZ(created_at,'UTC','America/Toronto') as created_at")]);
          
           $returnTOHubDate = SprintReattempt::
           where('sprint_reattempts.sprint_id','=' ,$tasks->sprint_id)->orderBy('created_at')
           ->first();
           
           if(!empty($returnTOHubDate))
           {
               $taskHistoryre= TaskHistory::where('sprint_id','=', $returnTOHubDate->reattempt_of)->WhereNotIn('status_id',[17,38])->orderBy('date')
               //->where('active','=',1)
               ->get(['status_id',\DB::raw("CONVERT_TZ(created_at,'UTC','America/Toronto') as created_at")]);
              
               foreach ($taskHistoryre as $history){
                
                 $status[$history->status_id]['id'] = $history->status_id;
                 if($history->status_id==13)
                 {
                    $status[$history->status_id]['description'] ='At hub - processing';
                 }
                 else
                 {
                    $status[$history->status_id]['description'] =$this->statusmap($history->status_id);
                 }
                 $status[$history->status_id]['created_at'] = $history->created_at;
              
                }

           }
           if(!empty($returnTOHubDate))
           {
            $returnTO2 = SprintReattempt::
            where('sprint_reattempts.sprint_id','=' , $returnTOHubDate->reattempt_of)->orderBy('created_at')
            ->first();
           
            if(!empty($returnTO2))
            {
                $taskHistoryre= TaskHistory::where('sprint_id','=',$returnTO2->reattempt_of)->WhereNotIn('status_id',[17,38])->orderBy('date')
                //->where('active','=',1)
                ->get(['status_id',\DB::raw("CONVERT_TZ(created_at,'UTC','America/Toronto') as created_at")]);
               
                foreach ($taskHistoryre as $history){
                 
                  $status2[$history->status_id]['id'] = $history->status_id;
                  if($history->status_id==13)
                  {
                     $status2[$history->status_id]['description'] ='At hub - processing';
                  }
                  else
                  {
                     $status2[$history->status_id]['description'] = $this->statusmap($history->status_id);
                  }
                  $status2[$history->status_id]['created_at'] = $history->created_at;
               
                 }

            }
           }
         
        //    dd($taskHistory);
        
        foreach ($taskHistory as $history) {

            if (in_array($history->status_id, [61, 13]) or in_array($history->status_id, [124, 125])) {
                $status1[$history->status_id]['id'] = $history->status_id;

                if ($history->status_id == 13) {
                    $status1[$history->status_id]['description'] = 'At hub - processing';
                } else {
                    $status1[$history->status_id]['description'] = $this->statusmap($history->status_id);
                }
                $status1[$history->status_id]['created_at'] = $history->created_at;

            }
            else{
                if ($history->created_at >= $tasks->route_date) {
                    $status1[$history->status_id]['id'] = $history->status_id;

                    if ($history->status_id == 13) {
                        $status1[$history->status_id]['description'] = 'At hub - processing';
                    } else {
                        $status1[$history->status_id]['description'] = $this->statusmap($history->status_id);
                    }
                    $status1[$history->status_id]['created_at'] = $history->created_at;
                }
            }
        }


         if($status!=null)
         {
         $sort_key = array_column($status, 'created_at');
         array_multisort($sort_key, SORT_ASC, $status);
         }
         if($status1!=null)
         {
          $sort_key = array_column($status1, 'created_at');
          array_multisort($sort_key, SORT_ASC, $status1);
         }
         if($status2!=null)
         {
          $sort_key = array_column($status2, 'created_at');
          array_multisort($sort_key, SORT_ASC, $status2);
         }

         $data[$i]['status']= $status;
         $data[$i]['status1']= $status1;
         $data[$i]['status2']=$status2;       
     $i++;
        }
      $reasons = Reason::all();
      $manualHistory=[];    
      if(isset($result[0])){
          $manualHistory=$this->getManualStatusData($result[0]->tracking_id);
      }    

        return backend_view('orderdetailswtracknigid',['data'=>$data,'reasons' => $reasons,'manualHistory' => $manualHistory]);
  }
  public function getManualStatusData($tracking_id)
  {
      // $tracking_id = !empty($request->get('tracking_id')) ? $request->get('tracking_id') : null;

      $query = TrackingImageHistory::where('tracking_id', $tracking_id)->orderBy('created_at','desc')->get();

      if(count($query)){
          foreach ($query as $key => $value) {

              $current_status = $value->status_id;
              if ($current_status == 13) {
                  $query[$key]->status_id= "At hub Processing";
              }else {
                  $query[$key]->status_id= self::$status[$current_status];
              }
              if (isset($value->attachment_path)) {
                  // $query[$key]->attachment_path= '<img onClick="ShowLightBox(this);" style = "width:50px;height:50px" src = "' . $value->attachment_path . '" />';
                  $query[$key]->attachment_path=$value->attachment_path;

              } else {
                  $query[$key]->attachment_path= '';
              }
              if (isset($value->reason)) {
                  $query[$key]->reason_id= $value->reason->title;
              } else {
                  $query[$key]->reason_id= '';
              }
              if ($value->created_at) {
                  $created_at = new \DateTime($value->created_at, new \DateTimeZone('UTC'));
                  $created_at->setTimeZone(new \DateTimeZone('America/Toronto'));
                  $query[$key]->created_at= $created_at->format('Y-m-d H:i:s');
              } else {
                  $query[$key]->created_at= '';
              }
              if (isset($value->user)) {
                  $query[$key]->user_id= $value->user->full_name;
              } else {
                  $query[$key]->user_id= '';
              }

          }
      }
      return $query;
  }
  public function get_trackingorderdetailsduplicate($sprintId){   

      $result= Sprint::join('sprint__tasks','sprint_id','=','sprint__sprints.id')
        ->leftJoin('merchantids','merchantids.task_id','=','sprint__tasks.id')
        ->leftJoin('joey_route_locations','joey_route_locations.task_id','=','sprint__tasks.id')
        ->leftJoin('joey_routes','joey_routes.id','=','joey_route_locations.route_id')
        ->leftJoin('joeys','joeys.id','=','joey_routes.joey_id')
        ->join('locations','sprint__tasks.location_id','=','locations.id')
        ->join('sprint__contacts','contact_id','=','sprint__contacts.id')
        ->leftJoin('vendors','creator_id','=','vendors.id')
        ->where('sprint__tasks.sprint_id','=',$sprintId)
        ->whereNull('joey_route_locations.deleted_at')
        ->orderBy('ordinal','DESC')->take(1)
        ->get(array('sprint__tasks.*','joey_routes.id as route_id','locations.address','sprint__contacts.name','sprint__contacts.phone','sprint__contacts.email'
        ,'joeys.first_name as joey_firstname',
        'joeys.last_name as joey_lastname','vendors.first_name as merchant_firstname','vendors.last_name as merchant_lastname','merchantids.scheduled_duetime','joeys.id as joey_id'));

           // dd($result);



        $i=0;

        $data = [];
        
        foreach($result as $tasks){
                $returnTO2='';
                $data[$i] = $tasks;

                $taskHistory= TaskHistory::where('sprint_id','=',$tasks->sprint_id)
                ->WhereNotIn('status_id',[17,38])->orderby('id')
                //->where('active','=',1)
                ->get(['status_id','created_at']);
              
                $returnTOHubDate = SprintReattempt::
                where('sprint_reattempts.sprint_id','=' ,$tasks->sprint_id)->orderby('created_at')
                ->first();
                $status = array();
                if(!empty($returnTOHubDate))
                {
                $taskHistoryre= TaskHistory::where('sprint_id','=', $returnTOHubDate->reattempt_of)
                ->WhereNotIn('status_id',[17,38])->orderby('id')
                //->where('active','=',1)
                ->get(['status_id','created_at']);

                foreach ($taskHistoryre as $history){

                $status[$history->status_id]['id'] = $history->status_id;
                if($history->status_id==13)
                {
                $status[$history->status_id]['description'] ='At hub - processing';
                }
                else
                {
                $status[$history->status_id]['description'] = $this->statusmap($history->status_id);
                //StatusMap::getDescription($history->status_id);
                }
                $status[$history->status_id]['created_at'] = date('Y-m-d H:i:s',strtotime($history->created_at)-14400);

                }
                $returnTO2 = SprintReattempt::
                where('sprint_reattempts.sprint_id','=' , $returnTOHubDate->reattempt_of)->orderby('created_at')
                ->first();
                }
               
                $status2 = array();
                if(!empty($returnTO2))
                {
                $taskHistoryre= TaskHistory::where('sprint_id','=',$returnTO2->reattempt_of)->WhereNotIn('status_id',[17,38])->orderby('id')
                //->where('active','=',1)
                ->get(['status_id','created_at']);

                foreach ($taskHistoryre as $history){

                $status2[$history->status_i]['id'] = $history->status_id;
                if($history->status_id==13)
                {
                $status2[$history->status_id]['description'] ='At hub - processing';
                }
                else
                {
                $status2[$history->status_id]['description'] =  $this->statusmap($history->status_id);
                }
                $status2[$history->status_id]['created_at'] = date('Y-m-d H:i:s',strtotime($history->created_at)-14400);

                }

                }

                //dd($taskHistory);
                $j=0;
                $status1 = array();
                foreach ($taskHistory as $history){

                $status1[$history->status_id]['id'] = $history->status_id;
                if($history->status_id==13)
                {
                $status1[$history->status_id]['description'] ='At hub - processing';
                }
                else
                {
                $status1[$history->status_id]['description'] =  $this->statusmap($history->status_id);
                }
                $status1[$history->status_id]['created_at'] = date('Y-m-d H:i:s',strtotime($history->created_at)-14400);

                }
                $data[$i]['status']= $status;
                $data[$i]['status1']= $status1;
                $data[$i]['status2']=$status2;


                $i++;
          }
          






      return backend_view('orderdetailswtracknigid',['data'=>$data]);
  }


  public function updateaddress(Request $request){
    $sprint_id=$request->get('sprint_id');
    $statusId=$request->get('statusId');
    // $user= Auth::user();
    $task=MerchantIds::join('sprint__tasks','sprint__tasks.id','=','merchantids.task_id')->
	join('sprint__sprints','sprint__sprints.id','=','sprint__tasks.sprint_id')
	->where('sprint__sprints.id','=',$sprint_id)->
    //->whereNull('deleted_at')->
    where('sprint__tasks.type','=','dropoff')->
    whereNull('sprint__tasks.deleted_at')->
    whereNull('sprint__sprints.deleted_at')
    ->orderby('sprint__sprints.id','DESC')->first(['merchantids.tracking_id','merchantids.task_id','creator_id','sprint__tasks.sprint_id']);
    
      $tracking_id=$task->tracking_id;
      //entry into route_history
      $status = '';

      if(in_array($request->get('statusId'),$this->status_codes['completed']))
      {
          $status = 2;

      }elseif (in_array($request->get('statusId'),$this->status_codes['return'])){
          $status = 4;
      }
      elseif (in_array($request->get('statusId'),$this->status_codes['pickup'])){
          $status = 3;
      }
      $route =JoeyRouteLocations::join('joey_routes','joey_routes.id','=','joey_route_locations.route_id')
          ->where('joey_route_locations.task_id','=',$task->task_id)
          ->first(['joey_route_locations.id','joey_route_locations.route_id','joey_routes.joey_id','joey_route_locations.ordinal','joey_route_locations.task_id']);



      if(!empty($status)) {
          if(!empty($route)){

              $routehistory=new RouteHistory();
              $routehistory->route_id=$route->route_id;
              $routehistory->joey_id=$route->joey_id;
              $routehistory->status=$status;
              $routehistory->route_location_id=$route->id;
              $routehistory->task_id=$route->task_id;
              $routehistory->ordinal=$route->ordinal;
              $routehistory->type='Manual';
              $routehistory->updated_by=Auth::guard('web')->user()->id;

              $routehistory->save();
              if (isset($route->joey_id)) {
                  $deviceIds = UserDevice::where('user_id', $route->joey_id)->where('is_deleted_at','=',0)->pluck('device_token');
                  $subject = 'R-' . $route->route_id . '-' . $route->ordinal;
                  $message = 'Your order status has been changed to ' . $this->statusmap($request->get('statusId'));
                  Fcm::sendPush($subject, $message, 'ecommerce', null, $deviceIds);
                  $payload = ['notification' => ['title' => $subject, 'body' => $message, 'click_action' => 'ecommerce'],
                      'data' => ['data_title' => $subject, 'data_body' => $message, 'data_click_action' => 'ecommerce']];
                  $createNotification = [
                      'user_id' => $route->joey_id,
                      'user_type' => 'Joey',
                      'notification' => $subject,
                      'notification_type' => 'ecommerce',
                      'notification_data' => json_encode(["body" => $message]),
                      'payload' => json_encode($payload),
                      'is_silent' => 0,
                      'is_read' => 0,
                      'created_at' => date('Y-m-d H:i:s')
                  ];
                  UserNotification::create($createNotification);
              }
          }
      }



      if(!empty($task))
    {
		$requestData['order_id'] = $task->sprint_id;
      $ctc_vendor_id= CtcVendor::where('vendor_id','=',$task->creator_id)->first();
      $taskhistory=TaskHistory::where('sprint_id','=',$requestData['order_id'])->where('status_id','=',125)->first();
        if($taskhistory) {
            if ($taskhistory->status_id == $statusId) {
                return back()->with('success', 'Status Updated Successfully!');
            }
        }
          if($statusId==124 && !empty($ctc_vendor_id))
        { 
              $taskhistory=TaskHistory::where('sprint_id','=',$requestData['order_id'])->where('status_id','=',125)->first();
              if($taskhistory==null)
              {
                $pickupstoretime_date=new \DateTime();
                $pickupstoretime_date->modify('-2 minutes');
              
                $taskhistory=new TaskHistory();
                $taskhistory->sprint_id=$requestData['order_id'];
                $taskhistory->sprint__tasks_id=$task->task_id;
                // $taskhistory->user_email=$user->email;
                // $taskhistory->domain_name='routing';
                $taskhistory->status_id=125;
                $taskhistory->date = $pickupstoretime_date->format('Y-m-d H:i:s');
                $taskhistory->created_at = $pickupstoretime_date->format('Y-m-d H:i:s');
                $taskhistory->save();
              }
              
        }

      $delivery_status = [17,113,114,116,117,118,132,138,139,144,104,105,106,107,108,109,110,111,112,131,135,136];
          //[17,118,117,107,108,111,113,114,116];
      if (in_array($statusId, $delivery_status)) 
          {
            
            $taskhistory=TaskHistory::where('sprint_id','=',$requestData['order_id'])->where('status_id','=',121)->first();
            if($taskhistory==null)
            {
            
              $pickuptime_date=new \DateTime();
              $pickuptime_date->modify('-2 minutes');

              $taskhistory=new TaskHistory();
              $taskhistory->sprint_id=$requestData['order_id'];
              $taskhistory->sprint__tasks_id=$task->task_id;
              // $taskhistory->user_email=$user->email;
              // $taskhistory->domain_name='routing';
              $taskhistory->status_id=121;
              $taskhistory->date=$pickuptime_date->format('Y-m-d H:i:s');
              $taskhistory->created_at=$pickuptime_date->format('Y-m-d H:i:s');
              $taskhistory->save();

              if(!empty($route)){

                $routehistory=new RouteHistory();
                $routehistory->route_id=$route->route_id;
                $routehistory->joey_id=$route->joey_id;
                $routehistory->status=3;
                $routehistory->route_location_id=$route->id;
                $routehistory->task_id=$route->task_id;
                $routehistory->ordinal=$route->ordinal;
                $routehistory->created_at=$pickuptime_date->format('Y-m-d H:i:s');
                $routehistory->updated_at=$pickuptime_date->format('Y-m-d H:i:s');
                $routehistory->type='Manual';
                $routehistory->updated_by=Auth::guard('web')->user()->id;
      
                $routehistory->save();
      
              }

              // calling amazon update entry function 
              $this->updateAmazonEntry(121,$requestData['order_id']);
                $this->updateBorderLessDashboard(121,$requestData['order_id']);
                $this->updateCTCEntry(121,$requestData['order_id']);
                $this->updateClaims(121,$requestData['order_id']);
            }
      
        }
              Sprint::where('id','=',$requestData['order_id'])->update(['status_id'=>$statusId]);
              Task::where('id','=',$task->task_id)->update(['status_id'=>$statusId]);
            
              $taskhistory=new TaskHistory();
              $taskhistory->sprint_id=$requestData['order_id'];
              $taskhistory->sprint__tasks_id=$task->task_id;
              // $taskhistory->user_email=$user->email;
              // $taskhistory->domain_name='routing';
              $taskhistory->status_id=$statusId;
              $taskhistory->date=date('Y-m-d H:i:s');
              $taskhistory->created_at=date('Y-m-d H:i:s');
              $taskhistory->save();

               // calling amazon update entry function 
                $this->updateAmazonEntry($statusId,$requestData['order_id']);
                $this->updateBorderLessDashboard($statusId,$requestData['order_id']);
                $this->updateCTCEntry($statusId,$requestData['order_id']);
                $this->updateClaims($statusId,$requestData['order_id']);

        $createData = [
            'tracking_id' =>$tracking_id,
            'status_id' => $request->get('statusId'),
            'user_id' => auth()->user()->id,
            'domain' => 'routing'
        ];
        TrackingImageHistory::create($createData);

        // tested curl working
        // $curl = curl_init();
        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => 'https://heroku-test-store.myshopify.com/admin/api/2022-04/orders/4826005569751/cancel.json',
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'POST',
        //     CURLOPT_HTTPHEADER => array(
        //         'X-Shopify-Access-Token: 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'
        // ),
        // ));
        // $response = curl_exec($curl);
        // curl_close($curl);
        //echo $response;

    }
    return back()->with('success','Status Updated Successfully!');
  }
  
  public function updateaddressapproval(Request $request){
    $user = Auth::user();
    $sprint_id=$request->get('sprint_id');
    $tracking_id=$request->get('tracking_id');
    $address=$request->get('resp_address');
    $resp_city=$request->get('resp_city');
    $resp_state=$request->get('resp_state');
    $resp_state_code=$request->get('resp_state_code');
    $resp_postal_code=$request->get('resp_postal_code');
    if($request->get('resp_lat')!=""){
        $latitude = $request->get('resp_lat') * 1000000;
        $latitudes = (int)$latitude;
    }
    
    if($request->get('resp_lng')!=""){
        $longi = $request->get('resp_lng') * 1000000;
        $longitudes = (int)$longi;
    }
    
    if(!isset($latitudes) || !isset($longitudes)){
        return back()->with('error','Please update address.');
    }

    $check_tracking_exists = AddressApproval::where('tracking_id',$tracking_id)->where('deleted_at',null)->pluck('tracking_id')->toArray();
    if(count($check_tracking_exists)>0){
        AddressApproval::where('tracking_id', '=', $tracking_id)
        ->update(array
            (
                'address' =>  $address,
                'lat' =>  $latitudes,
                'lng' =>  $longitudes,
                'city' =>  $resp_city,
                'state' =>  $resp_state,
                'state_code' =>  $resp_state_code,
                'postal_code' =>  $resp_postal_code,
                'user_id_requested' =>  $user->id,
                'is_approved' =>  0,
                'updated_at' =>  date('Y-m-d H:i:s'),
                'deleted_at' =>  NULL,
            )
        );
        return back()->with('success','Request again send for manager approval');
    }
    else{
        $address_approval =  new AddressApproval();
        $address_approval->sprint_id = $sprint_id;
        $address_approval->tracking_id = $tracking_id;
        $address_approval->address = $address;
        $address_approval->lat = $latitudes;
        $address_approval->lng = $longitudes;
        $address_approval->city = $resp_city;
        $address_approval->state = $resp_state;
        $address_approval->state_code = $resp_state_code;
        $address_approval->postal_code = $resp_postal_code;
        $address_approval->user_id_requested = $user->id;
        $address_approval->created_at = date('Y-m-d H:i:s');
        $address_approval->updated_at = date('Y-m-d H:i:s');
        $address_approval->save();
    }
    
    return back()->with('success','Request has been send to manager for approval.');
  }

  public function updateaddressapprovaladmin(Request $request){
    
    $tracking_data_for_address_approval = AddressApproval::where('deleted_at',null)->where('is_approved',0)->get();
    return backend_view('multipleaddressupdateapproval',['data'=>$tracking_data_for_address_approval]);
  }
  
  public function updateaddressapprovaladminbtn(Request $request){
    $user= Auth::user();
    // states data
    $states_data = State::where('code', $request->resp_state_code)->where('country_id',43)->first();
    if(empty($states_data)){
        $state_id = DB::table('states')->insertGetId([
            'country_id' => '43',
            'tax_id'=> '1',
            'name' => $request->resp_state,
            'code' => $request->resp_state_code,
         ]);
    }
    else{
        $state_id = $states_data->id;
    }

    //cities data
    $cities_data = City::where('name', $request->resp_city)->where('country_id',43)->where('state_id',$state_id)->first();
    
    if(empty($cities_data)){
        $city_id= DB::table('cities')->insertGetId([
            'country_id' =>'43',
            'state_id' => $state_id,
            'name' =>$request->resp_city
        ]);
    }
    else{
        $city_id = $cities_data->id;
    }

    if($request->get('resp_lat')!=""){
        if(strpos($request->get('resp_lat'),".") !== false){
            $latitude = $request->get('resp_lat') * 1000000;
            $latitudes = (int)$latitude;
        }        
        else{
            $latitudes = $request->get('resp_lat');
        }
    }
    
    if($request->get('resp_lng')!=""){
        if(strpos($request->get('resp_lng'),".") !== false){
            $longitude = $request->get('resp_lng') * 1000000;
            $longitudes = (int)$longitude;
        }        
        else{
            $longitudes = $request->get('resp_lng');
        }
    }

    //locations data
    $location_data = Location::where('latitude','=', $latitudes)->where('longitude',$longitudes)->first(); // getting location id
    
    if($location_data === null){
        $key = 'c9e92bb1ffd642abc4ceef9f4c6b1b3aaae8f5291e4ac127d58f4ae29272d79d903dfdb7c7eb6e487b979001c1658bb0a3e5c09a94d6ae90f7242c1a4cac60663f9cbc36ba4fe4b33e735fb6a23184d32be5cfd9aa5744f68af48cbbce805328bab49c99b708e44598a4efe765d75d7e48370ad1cb8f916e239cbb8ddfdfe3fe';
        $iv ='f13c9f69097a462be81995330c7c68f754f0c6026720c16ad2c1f5f316452ee000ce71d64ed065145afdd99b43c0d632b1703fc6a6754284f5d19b82dc3697d664dc9f66147f374d46c94cf23a78f14f0c6823d1cbaa19c157b4cb81e106b79b11593dcddf675951bc07f54528fc8c03cf66e9c437595d1cac658a737ab1183f';
            
        $location = new Location();
        $location->address = $request->address;
        $location->city_id = $city_id;
        $location->state_id = $state_id;
        $location->country_id = 43;
        $location->postal_code = $request->resp_postal_code;
        $location->latitude = $latitudes;
        $location->longitude = $longitudes;
        $location->save();
        $location_id = $location->id;

        $enc_location = DB::table('locations_enc')->insert(
            array(
                'id' => $location_id,
                'address' => DB::raw("AES_ENCRYPT('".$request->address."', '".$key."', '".$iv."')"),
                'city_id' => $city_id,
                'state_id' => $state_id,
                'country_id' => '43',
                'postal_code' => DB::raw("AES_ENCRYPT('".$request->resp_postal_code."', '".$key."', '".$iv."')"),
                'latitude' => DB::raw("AES_ENCRYPT('".(int)$request->resp_lat ."', '".$key."', '".$iv."')"),
                'longitude' => DB::raw("AES_ENCRYPT('". (int)$request->resp_lng."', '".$key."', '".$iv."')"),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )
        );
    }
    else{
        $location_id = $location_data->id;
    }

    //updating location id in task 
    Task::where('sprint_id',$request->sprint_id)->where('type','dropoff')->update([
        'location_id'=>$location_id,
        'updated_at' => date('Y-m-d H:i:s')
    ]);

    //updating address in boradless dashboard
    BoradlessDashboard::where('tracking_id',$request->tracking_id)->update([
        'address_line_1' => $request->address,
        'updated_at' => date('Y-m-d H:i:s')
    ]);

    //updating address in merchantids
    MerchantIds::where('tracking_id',$request->tracking_id)->update([
        'address_line2' => $request->address,
        'updated_at' => date('Y-m-d H:i:s')
    ]);

    //updating address approval table
    AddressApproval::where('tracking_id', '=', $request->tracking_id)
        ->update(array
            (
                'deleted_at' =>  date('Y-m-d H:i:s'),
                'user_id_approved_by' =>  $user->id,
            )
        );
    $address_approval =  new AddressApproval();
    $address_approval->sprint_id = $request->sprint_id;
    $address_approval->tracking_id = $request->tracking_id;
    $address_approval->address = $request->address;
    $address_approval->lat = $latitudes;
    $address_approval->lng = $longitudes;
    $address_approval->city = $request->resp_city;
    $address_approval->state = $request->resp_state;
    $address_approval->state_code = $request->resp_state_code;
    $address_approval->postal_code = $request->resp_postal_code;
    $address_approval->is_approved = 1;
    $address_approval->user_id_approved_by = $user->id;
    $address_approval->created_at = date('Y-m-d H:i:s');
    $address_approval->updated_at = date('Y-m-d H:i:s');
    $address_approval->deleted_at = date('Y-m-d H:i:s');
    $address_approval->save();

    return back()->with('success','Address has been updated.');
  }

  public function updateaddressdecline(Request $request){
    $user = Auth::user();
    $decline_reqeust = AddressApproval::where('tracking_id',$request->del_tracking_id)
    ->update(array
            (
                'user_id_approved_by' => $user->id,
                'updated_at' =>  date('Y-m-d H:i:s'),
                'deleted_at' =>  date('Y-m-d H:i:s'),
            )
        );
        return back()->with('success','Request decline send back for address change');
  }

  public function get_multipletrackingid(Request $request)
  {
        // dd($request->has_file
        $tracking_ids=trim($request->input('tracking_id'));
        $tracking_ids=str_replace("'","",$tracking_ids);
        $tracking_ids=str_replace('"',"",$tracking_ids);
        $merchant_order_no=trim($request->input('merchant_order_no'));
        $merchant_order_no=str_replace("'","",$merchant_order_no);
        $merchant_order_no=str_replace('"',"",$merchant_order_no);
        $phone_no=trim($request->input('phone_no'));
        $phone_no=str_replace("'","",$phone_no);
        $phone_no=str_replace('"',"",$phone_no);
        $orders=[];

        if(!empty($tracking_ids) || !empty($merchant_order_no) || !empty($phone_no) )
        {
            $user= MerchantIds::join('sprint__tasks','sprint__tasks.id','=','merchantids.task_id')
            ->join('sprint__sprints','sprint__tasks.sprint_id','=','sprint__sprints.id')
            ->join('locations','sprint__tasks.location_id','=','locations.id')
            ->join('sprint__contacts','contact_id','=','sprint__contacts.id')
            ->where('sprint__tasks.type','=','dropoff')
            ->whereNull('sprint__sprints.deleted_at');
            if(!empty($tracking_ids))
          {
            $user = $user->whereNotNull('merchantids.tracking_id');
            if (strpos($tracking_ids,',') !== false) {

              $id=explode(",",$tracking_ids);
            }
            else
            {
              $id=explode("\n",$tracking_ids);
            
            }
            $i=0;
            $ids=[];
            foreach($id as $trackingid)
            {
              if(!empty(trim($trackingid)))
              {
                  $pattern = "/^[a-zA-Z0-9@#$&*_-]*/i";
                  preg_match($pattern,trim($trackingid),$matche);
                  $ids[$i]= $matche[0];
                  $i++;
              }
              
            }

            if(!empty($ids))
            {
              $user=$user->whereIn('merchantids.tracking_id',$ids);
            }
          }
          

           if(!empty($merchant_order_no))
           {
            if(!empty($merchant_order_no))
            {
              if (strpos($merchant_order_no,',') !== false) {

                $merchant_order_no=explode(",",$merchant_order_no);
              }
              else
              {
                $merchant_order_no=explode("\n",$merchant_order_no);
              
              }
              $i=0;
              $ids=[];
              foreach($merchant_order_no as $id)
              {
                if(!empty(trim($id)))
                {
                  $merchant_orders_no[$i]=trim($id);
                $i++;
                }
                
              }

              if(!empty($merchant_orders_no))
              {
                $user=$user->whereIn('merchantids.merchant_order_num',$merchant_orders_no);
              }
            }
            
           }
           if(!empty($phone_no))
           {
            if(!empty($phone_no))
            {
              if (strpos($phone_no,',') !== false) {

                $phone_no=explode(",",$phone_no);
              }
              else
              {
                $phone_no=explode("\n",$phone_no);
              
              }
              $i=0;
              $customers_phone_no=[];
              foreach($phone_no as $id)
              {
                if(!empty(trim($id)))
                {
                  
                  $customers_phone_no[$i]=(str_contains(trim($id), '+') )? trim($id) : "+".trim($id);
            
                $i++;
                }
                
              }

              if(!empty($customers_phone_no))
              {
                $user=$user->whereIn('sprint__contacts.phone',$customers_phone_no);
              }
            }
            
           }
          $orders=$user->orderBy('merchantids.id','DESC')
             ->get(array("sprint__sprints.id",'sprint__sprints.creator_id','sprint__sprints.status_id',\DB::raw("CONVERT_TZ(sprint__sprints.created_at,'UTC','America/Toronto') as created_at"),'merchantids.tracking_id','merchantids.merchant_order_num','sprint__contacts.phone','locations.address','locations.suite','merchantids.address_line2'));
                $i=0;
                foreach($orders as $order)
                {
                 
                  if($orders[$i]->status_id==17 && $orders[$i]->creator_id!=477260 && $orders[$i]->creator_id!=477282 )
                  {
                    
                      $status_history=TaskHistory::where('sprint_id','=',$orders[$i]->id)->
                                                  //  where('status_id','!=',17)->
                                                   whereIn('status_id',[114,116,117,118,132,138,139,144,113])->
                                                   orderby('id','DESC')->
                                                   first();
                  
                      if(!empty($status_history))
                      {
                        $orders[$i]->status_id=$status_history->status_id;
                      }
                   
                    
                  }
                  $i++;
                }
             
             
              if(empty($orders))
              {
                  $orders=[];
              }
               // dd($user);
      }
          return backend_view('multipleaddressupdate',['data'=>$orders]);
  }


  public function get_multiOrderUpdates(Request $request){
      return backend_view('multipleupdateorder',['data'=>[]]);
  }

  public function post_multiOrderUpdates(Request $request)
  {
        $k=0;
          $user=[];
          $id = $request->input('tracking_id');
        if (strpos($id,',') !== false) {
          $id=explode(",",$id);
        
            }
            else
            {
              $id=explode("\n",$id);
            
            }

          $requestData['status_id']=$request->input('status_id');
          // $user= Auth::user();
        
          foreach($id as $trackingid){
              $pattern = "/^[a-zA-Z0-9@#$&*_-]*/i";
              preg_match($pattern,trim($trackingid),$match);
            $trackingid=$match[0];
           $task=MerchantIds::join('sprint__tasks','sprint__tasks.id','=','merchantids.task_id')->
			join('sprint__sprints','sprint__sprints.id','=','sprint__tasks.sprint_id')
			->where('merchantids.tracking_id','=',$trackingid)->
			//->whereNull('deleted_at')->
			whereNull('sprint__tasks.deleted_at')->
			whereNull('sprint__sprints.deleted_at')
			->orderby('sprint__sprints.id','DESC')->first(['merchantids.task_id','creator_id','sprint__tasks.sprint_id']);
           
        
            if(empty($task)){
              continue;
            }


              //entry in route history
              $status = '';

              if(in_array($requestData['status_id'],$this->status_codes['completed']))
              {
                  $status = 2;

              }elseif (in_array($requestData['status_id'],$this->status_codes['return'])){
                  $status = 4;
              }
              elseif (in_array($requestData['status_id'],$this->status_codes['pickup'])){
                  $status = 3;
              }


              //entering data in route_history
              $route =JoeyRouteLocations::join('joey_routes','joey_routes.id','=','joey_route_locations.route_id')
                  ->where('joey_route_locations.task_id','=',$task->task_id)
                  ->first(['joey_route_locations.id','joey_route_locations.route_id','joey_routes.joey_id','joey_route_locations.ordinal','joey_route_locations.task_id']);


              if(!empty($status)){

                  if(!empty($route)) {
                      $routehistory = new RouteHistory();
                      $routehistory->route_id = $route->route_id;
                      $routehistory->joey_id = $route->joey_id;
                      $routehistory->status = $status;
                      $routehistory->route_location_id = $route->id;
                      $routehistory->task_id = $route->task_id;
                      $routehistory->ordinal = $route->ordinal;
                      $routehistory->type = 'Manual';
                      $routehistory->updated_by = Auth::guard('web')->user()->id;
                      $routehistory->save();

                      if (isset($route->joey_id)) {
                          $deviceIds = UserDevice::where('user_id', $route->joey_id)->where('is_deleted_at','=',0)->pluck('device_token');
                          $subject = 'R-' . $route->route_id . '-' . $route->ordinal;
                          $message = 'Your order status has been changed to ' . $this->statusmap($request->input('status_id'));
                          Fcm::sendPush($subject, $message, 'ecommerce', null, $deviceIds);
                          $payload = ['notification' => ['title' => $subject, 'body' => $message, 'click_action' => 'ecommerce'],
                              'data' => ['data_title' => $subject, 'data_body' => $message, 'data_click_action' => 'ecommerce']];
                          $createNotification = [
                              'user_id' => $route->joey_id,
                              'user_type' => 'Joey',
                              'notification' => $subject,
                              'notification_type' => 'ecommerce',
                              'notification_data' => json_encode(["body" => $message]),
                              'payload' => json_encode($payload),
                              'is_silent' => 0,
                              'is_read' => 0,
                              'created_at' => date('Y-m-d H:i:s')
                          ];
                          UserNotification::create($createNotification);
                      }
                  }
              }


            if(!empty($task->task_id)){
				 $requestData['order_id'] = $task->sprint_id;
         $taskhistory=TaskHistory::where('sprint_id','=',$requestData['order_id'])->where('status_id','=',125)->first();
         $k=1;
                if($taskhistory) {
                    if ($taskhistory->status_id == $requestData['status_id']) {

                        continue;
                    }
                }
              
              $ctc_vendor_id= CtcVendor::where('vendor_id','=',$task->creator_id)->first();
              if($requestData['status_id']==124 && !empty($ctc_vendor_id))
            {
                  $taskhistory=TaskHistory::where('sprint_id','=',$requestData['order_id'])->where('status_id','=',125)->first();
                  if($taskhistory==null)
                  {
                    $taskhistory=new TaskHistory();
                    $taskhistory->sprint_id=$requestData['order_id'];
                    $taskhistory->sprint__tasks_id=$task->task_id;
                    // $taskhistory->user_email=$user->email;
                    // $taskhistory->domain_name='routing';
                    $taskhistory->status_id=125;
                    $taskhistory->date=date('Y-m-d H:i:s');
                    $taskhistory->created_at=date('Y-m-d H:i:s');
                    $taskhistory->save();
                  }
                  
            }
              
              $delivery_status = [17,113,114,116,117,118,132,138,139,144,104,105,106,107,108,109,110,111,112,131,135,136];
            
              if (in_array($requestData['status_id'], $delivery_status)) {
                
                  $taskhistory=TaskHistory::where('sprint_id','=',$requestData['order_id'])->where('status_id','=',121)->first();
                  if($taskhistory==null)
                  {

                    $pickuptime_date=new \DateTime();
                    $pickuptime_date->modify('-2 minutes');

                    $taskhistory=new TaskHistory();
                    $taskhistory->sprint_id=$requestData['order_id'];
                    $taskhistory->sprint__tasks_id=$task->task_id;
                    // $taskhistory->user_email=$user->email;
                    // $taskhistory->domain_name='routing';
                    $taskhistory->status_id=121;
                    $taskhistory->date=$pickuptime_date->format('Y-m-d H:i:s');
                    $taskhistory->created_at=$pickuptime_date->format('Y-m-d H:i:s');
                    $taskhistory->save();


                    if(!empty($route)){

                      $routehistory=new RouteHistory();
                      $routehistory->route_id=$route->route_id;
                      $routehistory->joey_id=$route->joey_id;
                      $routehistory->status=3;
                      $routehistory->route_location_id=$route->id;
                      $routehistory->task_id=$route->task_id;
                      $routehistory->ordinal=$route->ordinal;
                      $routehistory->created_at=$pickuptime_date->format('Y-m-d H:i:s');
                      $routehistory->updated_at=$pickuptime_date->format('Y-m-d H:i:s');
                      $routehistory->updated_by=Auth::guard('web')->user()->id;
                      $routehistory->type='Manual';
                      $routehistory->save();
            
                    }

                    // calling amazon update entry function 
                   $this->updateAmazonEntry(121,$requestData['order_id']);
                      $this->updateBorderLessDashboard(121,$requestData['order_id']);
                      $this->updateCTCEntry(121,$requestData['order_id']);
                    $this->updateClaims(121,$requestData['order_id']);

                    
                  }
                 
              }
             
                  Sprint::where('id','=',$requestData['order_id'])->update(['status_id'=>$requestData['status_id']]);
             

              Task::where('sprint_id','=',$requestData['order_id'])->update(['status_id'=>$requestData['status_id']]);
              
              $taskhistory=new TaskHistory();
              $taskhistory->sprint_id=$requestData['order_id'];
              $taskhistory->sprint__tasks_id=$task->task_id;
              // $taskhistory->user_email=$user->email;
              // $taskhistory->domain_name='routing';
              $taskhistory->status_id=$requestData['status_id'];
              $taskhistory->date=date('Y-m-d H:i:s');
              $taskhistory->created_at=date('Y-m-d H:i:s');
              $taskhistory->save();
            
                 // calling amazon update entry function 
                 $this->updateAmazonEntry($requestData['status_id'],$requestData['order_id']);
                $this->updateBorderLessDashboard($requestData['status_id'],$requestData['order_id']);
                $this->updateCTCEntry($requestData['status_id'],$requestData['order_id']);
                $this->updateClaims($requestData['status_id'],$requestData['order_id']);

                $createData = [
                    'tracking_id' =>$trackingid,
                    'status_id' => $requestData['status_id'],
                    'user_id' => auth()->user()->id,
                    'domain' => 'routing'
                ];
                TrackingImageHistory::create($createData);

            }

            }
            if($k==0)
            {
              return back()->with('error','Invalid Tracking Id!');
            }
            return back()->with('success','Status Updated Successfully!');
  }
  public function updateAmazonEntry($status_id,$order_id,$imageUrl=null)
  {
              if($status_id==133)
              {
                    // Get amazon enteries data from tracking id and check if the data exist in database and if exist update the sort date of the tracking id and status of that tracking id.  
                    $amazon_enteries =AmazonEntry::where('sprint_id','=',$order_id)->whereNull('deleted_at')->first();
                    if($amazon_enteries!=null)
                    {
                        
                        $amazon_enteries->sorted_at=date('Y-m-d H:i:s');
                        $amazon_enteries->task_status_id=133;
                        $amazon_enteries->order_image=$imageUrl;
                        $amazon_enteries->save();

                    }
              }
              elseif($status_id==121)
              {
                $amazon_enteries =AmazonEntry::where('sprint_id','=',$order_id)->whereNull('deleted_at')->first();
                if($amazon_enteries!=null)
                {
                    $amazon_enteries->picked_up_at=date('Y-m-d H:i:s');
                    $amazon_enteries->task_status_id=121;
                    $amazon_enteries->order_image=$imageUrl;
                    $amazon_enteries->save();
    
                }
              }
              elseif(in_array($status_id,[17,113,114,116,117,118,132,138,139,144]))
              {
                $amazon_enteries =AmazonEntry::where('sprint_id','=',$order_id)->whereNull('deleted_at')->first();
                if($amazon_enteries!=null)
                {
                    $amazon_enteries->delivered_at=date('Y-m-d H:i:s');
                    $amazon_enteries->task_status_id=$status_id;
                    $amazon_enteries->order_image=$imageUrl;
                    $amazon_enteries->save();
    
                }
              }
              elseif(in_array($status_id,[104,105,106,107,108,109,110,111,112,131,135,136,101,102,103,140]))
              {
                $amazon_enteries =AmazonEntry::where('sprint_id','=',$order_id)->whereNull('deleted_at')->first();
                if($amazon_enteries!=null)
                {
                    $amazon_enteries->returned_at=date('Y-m-d H:i:s');
                    $amazon_enteries->task_status_id=$status_id;
                    $amazon_enteries->order_image=$imageUrl;
                    $amazon_enteries->save();
    
                }
              }
      
  }


    public function sprintImageUpload(Requests\Backend\UploadImageRequest $request)
    {
        $postData = $request->all();

        $image_base64 =  base64_encode(file_get_contents($_FILES['sprint_image']['tmp_name']));

        $task=MerchantIds::join('sprint__tasks','sprint__tasks.id','=','merchantids.task_id')
            ->join('sprint__sprints','sprint__sprints.id','=','sprint__tasks.sprint_id')
            ->where('sprint__sprints.id','=',$postData['sprint_id'])
            ->where('sprint__tasks.type','=','dropoff')
            ->first(['sprint__tasks.id','sprint__tasks.sprint_id','sprint__tasks.ordinal','sprint__sprints.creator_id','merchantids.tracking_id']);

        $route_data=JoeyRoute::join('joey_route_locations','joey_route_locations.route_id','=','joey_routes.id')
            ->where('joey_route_locations.task_id','=',$task->id)
            ->whereNull('joey_route_locations.deleted_at')
            ->first(['joey_route_locations.id','joey_routes.joey_id','joey_route_locations.route_id','joey_route_locations.ordinal']);

        if(empty($route_data)) {
            session()->flash('alert-warning', 'Joey not assigned yet. Image cannot be uploaded.!');
            return Redirect::to('backend/search/orders/trackingid/'.$task->sprint_id.'/details');
        }
        $taskhistory=TaskHistory::where('sprint_id','=',$postData['sprint_id'])->where('status_id','=',125)->first();
        if($taskhistory) {
            if ($taskhistory->status_id == $postData['status_id']) {
                session()->flash('alert-success', 'Image Uploaded');
                return Redirect::to('backend/search/orders/trackingid/' . $task->sprint_id . '/details');
            }
        }
        $data = ['image' =>  $image_base64];//$base64Data];
        $response =  $this->sendData('POST', '/',  $data );

        // checking responce
        if(!isset($response->url))
        {
            session()->flash('alert-warning', 'File cannot be uploaded due to server error!');
            return Redirect::to('backend/search/orders/trackingid/'.$task->sprint_id.'/details');
        }

        $attachment_path =   $response ->url;





       /* $taskHistoryRecord = [
            'sprint__tasks_id' =>$task->id,
            'sprint_id' => $task->sprint_id,
            'status_id' => $postData['status_id'],
            'date' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),

        ];
        TaskHistory::create( $taskHistoryRecord );*/
        $taskhistoryCreate = new TaskHistory();
        $taskhistoryCreate->sprint_id =  $task->sprint_id;
        $taskhistoryCreate->sprint__tasks_id = $task->id;
        $taskhistoryCreate->status_id = $postData['status_id'];
        $taskhistoryCreate->date = date('Y-m-d H:i:s');
        $taskhistoryCreate->created_at = date('Y-m-d H:i:s');
        $taskhistoryCreate->save();

        $status = '';

        if(in_array($postData['status_id'],$this->status_codes['completed']))
        {
            $status = 2;

        }elseif (in_array($postData['status_id'],$this->status_codes['return'])){
            $status = 4;
        }
        elseif (in_array($postData['status_id'],$this->status_codes['pickup'])){
            $status = 3;
        }


        $route_data=JoeyRoute::join('joey_route_locations','joey_route_locations.route_id','=','joey_routes.id')
            ->where('joey_route_locations.task_id','=',$task->id)
            ->whereNull('joey_route_locations.deleted_at')
            ->first(['joey_route_locations.id','joey_routes.joey_id','joey_route_locations.route_id','joey_route_locations.ordinal','joey_route_locations.task_id']);

        if(!empty($route_data))
        {
            $routeHistoryRecord = [
                'route_id' =>$route_data->route_id,
                'route_location_id' => $route_data->id,
                'ordinal' => $route_data->ordinal,
                'joey_id'=>  $route_data->joey_id,
                'task_id'=>$task->id,
                'status'=> $status,
                'type'=>'Manual',
                'updated_by'=>auth()->user()->id,
            ];
            RouteHistory::create($routeHistoryRecord);
        }
        $statusDescription= StatusMap::getDescription($postData['status_id']);
        $updateData = [
            'ordinal' => $task->ordinal,
            'task_id' => $task->id,
            'joey_id' =>$route_data->joey_id,
            'name' => $statusDescription,
            'title' => $statusDescription,
            'confirmed' => 1,
            'input_type' => 'image/jpeg',
            'attachment_path' => $attachment_path
        ];
        SprintConfirmation::create($updateData);


        if(!empty($task->id)) {
            $order_id = $task->sprint_id;
            $ctc_vendor_id = CtcVendor::where('vendor_id', '=', $task->creator_id)->first();
            if ($postData['status_id']== 124 && !empty($ctc_vendor_id)) {
                $taskhistory = TaskHistory::where('sprint_id', '=', $order_id)->where('status_id', '=', 125)->first();
                if ($taskhistory == null) {

                    $pickupstoretime_date=new \DateTime();
                    $pickupstoretime_date->modify('-2 minutes');

                    $taskhistory = new TaskHistory();
                    $taskhistory->sprint_id = $order_id;
                    $taskhistory->sprint__tasks_id = $task->id;

                    $taskhistory->status_id = 125;
                    $taskhistory->date = $pickupstoretime_date->format('Y-m-d H:i:s');
                    $taskhistory->created_at = $pickupstoretime_date->format('Y-m-d H:i:s');
                    $taskhistory->save();
                }

            }

            $delivery_status = [17, 113, 114, 116, 117, 118, 132, 138, 139, 144, 104, 105, 106, 107, 108, 109, 110, 111, 112, 131, 135, 136];

            if (in_array($postData['status_id'], $delivery_status)) {

                $taskhistory = TaskHistory::where('sprint_id', '=', $order_id)->where('status_id', '=', 121)->first();
                if ($taskhistory == null) {

                    $pickuptime_date=new \DateTime();
                    $pickuptime_date->modify('-2 minutes');

                    $taskhistory = new TaskHistory();
                    $taskhistory->sprint_id = $order_id;
                    $taskhistory->sprint__tasks_id = $task->id;
                    $taskhistory->status_id = 121;
                    $taskhistory->date=$pickuptime_date->format('Y-m-d H:i:s');
                    $taskhistory->created_at=$pickuptime_date->format('Y-m-d H:i:s');
                    $taskhistory->save();


                    if(!empty($route_data)){

                        $routehistory=new RouteHistory();
                        $routehistory->route_id=$route_data->route_id;
                        $routehistory->joey_id=$route_data->joey_id;
                        $routehistory->status=3;
                        $routehistory->route_location_id=$route_data->id;
                        $routehistory->task_id=$route_data->task_id;
                        $routehistory->ordinal=$route_data->ordinal;
                        $routehistory->created_at=$pickuptime_date->format('Y-m-d H:i:s');
                        $routehistory->updated_at=$pickuptime_date->format('Y-m-d H:i:s');
                        $routehistory->type='Manual';
                        $routehistory->updated_by=Auth::guard('web')->user()->id;

                        $routehistory->save();

                    }
                    $this->updateAmazonEntry(121,$order_id);
                    $this->updateBorderLessDashboard(121,$order_id);
                    $this->updateCTCEntry(121,$order_id);
                    $this->updateClaims(121,$order_id);

                }

            }
        }

        Task::where('id','=',$task->id)->update(['status_id'=>$postData['status_id']]);
        Sprint::where('id','=',$task->sprint_id)->whereNull('deleted_at')->update(['status_id'=>$postData['status_id']]);

        $this->updateAmazonEntry($postData['status_id'],$task->sprint_id,$attachment_path);
        $this->updateBorderLessDashboard($postData['status_id'],$task->sprint_id,$attachment_path);
        $this->updateCTCEntry($postData['status_id'],$task->sprint_id,$attachment_path);
        $this->updateClaims($postData['status_id'],$task->sprint_id,$attachment_path);


        $createData = [
            'tracking_id' => $task->tracking_id,
            'status_id' => $postData['status_id'],
            'user_id' => auth()->user()->id,
            'attachment_path' => $attachment_path,
            'reason_id' => $postData['reason_id'],
            'domain' => 'routing'
        ];
        TrackingImageHistory::create($createData);

        if (isset($route_data->joey_id)) {
            $deviceIds = UserDevice::where('user_id', $route_data->joey_id)->where('is_deleted_at','=',0)->pluck('device_token');
            $subject = 'R-' . $route_data->route_id . '-' . $route_data->ordinal;
            $message = 'Your order status has been changed to ' . $this->statusmap($postData['status_id']);
            Fcm::sendPush($subject, $message, 'ecommerce', null, $deviceIds);

            $payload = ['notification' => ['title' => $subject, 'body' => $message, 'click_action' => 'ecommerce'],
                'data' => ['data_title' => $subject, 'data_body' => $message, 'data_click_action' => 'ecommerce']];
            $createNotification = [
                'user_id' => $route_data->joey_id,
                'user_type' => 'Joey',
                'notification' => $subject,
                'notification_type' => 'ecommerce',
                'notification_data' => json_encode(["body" => $message]),
                'payload' => json_encode($payload),
                'is_silent' => 0,
                'is_read' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ];
            UserNotification::create($createNotification);
        }
        session()->flash('alert-success', 'Image Uploaded');
        return Redirect::to('backend/search/orders/trackingid/'.$task->sprint_id.'/details');

    }

    public function sendData($method, $uri, $data=[] ) {
        $host ='assets.joeyco.com';

        $json_data = json_encode($data);
        $headers = [
            'Accept-Encoding: utf-8',
            'Accept: application/json; charset=UTF-8',
            'Content-Type: application/json; charset=UTF-8',
            // 'Accept-Language: ' . $locale->getLangCode(),
            'User-Agent: JoeyCo',
            'Host: ' . $host,
        ];

        if (!empty($json_data) ) {

            $headers[] = 'Content-Length: ' . strlen($json_data);

        }


        $url = 'https://' . $host . $uri;


        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if (strlen($json_data) > 2) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        }

        // $file=env('APP_ENV');
        //   dd(env('APP_ENV') === 'local');
        if (env('APP_ENV') === 'local') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        } else {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        set_time_limit(0);

        $this->originalResponse = curl_exec($ch);

        $error = curl_error($ch);


        // dd([$this->originalResponse,$error,$this->response]);
        curl_close($ch);

        if (empty($error)) {


            $this->response = explode("\n", $this->originalResponse);

            $code = explode(' ', $this->response[0]);
            $code = $code[1];

            $this->response = $this->response[count($this->response) - 1];
            $this->response = json_decode($this->response);

            if (json_last_error() != JSON_ERROR_NONE) {

                $this->response = (object) [
                    'copyright' => 'Copyright © ' . date('Y') . ' JoeyCo Inc. All rights reserved.',
                    'http' => (object) [
                        'code' => 500,
                        'message' => json_last_error_msg(),
                    ],
                    'response' => new \stdClass()
                ];
            }
        }
        else{
            dd(['error'=> $error,'responce'=>$this->originalResponse]);
        }

        return $this->response;
    }


    public function  updateCTCEntry($status_id,$order_id,$imageUrl=null)
    {
        if($status_id==133)
        {
            // Get ctc enteries data from tracking id and check if the data exist in database and if exist update the sort date of the tracking id and status of that tracking id.
            $ctc_entries =CTCEntry::where('sprint_id','=',$order_id)->whereNull('deleted_at')->first();
            if($ctc_entries!=null)
            {

                $ctc_entries->sorted_at=date('Y-m-d H:i:s');
                $ctc_entries->task_status_id=133;
                $ctc_entries->order_image=$imageUrl;
                $ctc_entries->save();

            }
        }
        elseif($status_id==121)
        {
            $ctc_entries =CTCEntry::where('sprint_id','=',$order_id)->whereNull('deleted_at')->first();
            if($ctc_entries!=null)
            {
                $ctc_entries->picked_up_at=date('Y-m-d H:i:s');
                $ctc_entries->task_status_id=121;
                $ctc_entries->order_image=$imageUrl;
                $ctc_entries->save();

            }
        }
        elseif(in_array($status_id,[17,113,114,116,117,118,132,138,139,144]))
        {
            $ctc_entries =CTCEntry::where('sprint_id','=',$order_id)->whereNull('deleted_at')->first();
            if($ctc_entries!=null)
            {
                $ctc_entries->delivered_at=date('Y-m-d H:i:s');
                $ctc_entries->task_status_id=$status_id;
                $ctc_entries->order_image=$imageUrl;
                $ctc_entries->save();

            }
        }
        elseif(in_array($status_id,[104,105,106,107,108,109,110,111,112,131,135,136,101,102,103,140,143]))
        {
            $ctc_entries =CTCEntry::where('sprint_id','=',$order_id)->whereNull('deleted_at')->first();
            if($ctc_entries!=null)
            {
                $ctc_entries->returned_at=date('Y-m-d H:i:s');
                $ctc_entries->task_status_id=$status_id;
                $ctc_entries->order_image=$imageUrl;
                $ctc_entries->save();

            }
        }

    }
    public function updateClaims($sprint_status_id,$sprint_id,$imageUrl=null)
    {
        $updateData = [
            'sprint_status_id'=>$sprint_status_id,
            ];
        if ($imageUrl != null)
        {
            $updateData['image'] = $imageUrl;
        }
        Claim::where('sprint_id',$sprint_id)->update($updateData);
    }

    public function updateBorderLessDashboard($status_id,$order_id,$imageUrl=null)
    {
        if($status_id==133)
        {
            // Get amazon enteries data from tracking id and check if the data exist in database and if exist update the sort date of the tracking id and status of that tracking id.
            $borderless_dashboard =BoradlessDashboard::where('sprint_id','=',$order_id)->whereNull('deleted_at')->first();
            if($borderless_dashboard!=null)
            {

                $borderless_dashboard->sorted_at=date('Y-m-d H:i:s');
                $borderless_dashboard->task_status_id=133;
                $borderless_dashboard->order_image=$imageUrl;
                $borderless_dashboard->save();

            }
        }
        elseif($status_id==121)
        {
            $borderless_dashboard =BoradlessDashboard::where('sprint_id','=',$order_id)->whereNull('deleted_at')->first();
            if($borderless_dashboard!=null)
            {
                $borderless_dashboard->picked_up_at=date('Y-m-d H:i:s');
                $borderless_dashboard->task_status_id=121;
                $borderless_dashboard->order_image=$imageUrl;
                $borderless_dashboard->save();

            }
        }
        elseif(in_array($status_id,[17,113,114,116,117,118,132,138,139,144]))
        {
            $borderless_dashboard =BoradlessDashboard::where('sprint_id','=',$order_id)->whereNull('deleted_at')->first();
            if($borderless_dashboard!=null)
            {
                $borderless_dashboard->delivered_at=date('Y-m-d H:i:s');
                $borderless_dashboard->task_status_id=$status_id;
                $borderless_dashboard->order_image=$imageUrl;
                $borderless_dashboard->save();

            }
        }
        elseif(in_array($status_id,[104,105,106,107,108,109,110,111,112,131,135,136,101,102,103,140]))
        {
            $borderless_dashboard =BoradlessDashboard::where('sprint_id','=',$order_id)->whereNull('deleted_at')->first();
            if($borderless_dashboard!=null)
            {
                $borderless_dashboard->returned_at=date('Y-m-d H:i:s');
                $borderless_dashboard->task_status_id=$status_id;
                $borderless_dashboard->order_image=$imageUrl;
                $borderless_dashboard->save();

            }
        }

    }
}
