<?php

namespace App\Http\Controllers\Backend;

use Config;

use Illuminate\Http\Request;

// use App\Http\Requests;
use App\Http\Requests\Backend\CategoryRequest;
use Illuminate\Support\Facades\Request as FacadeRequest;
use App\Http\Controllers\Backend\BackendController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

use App\Sprint;
use App\Client;
use App\SlotJob;
use App\Hub;
use App\CustomRoutingFile;
use App\CustomRoutingTrackingId;
use App\Task;
use App\Vendor;
use App\MerchantIds;
use App\TaskHistory;
use App\ContactUncrypted;
use App\LocationUnencrypted;
use App\JoeyCapacityDetail;
use App\EnableRouteFile;
use App\EnableForRoutesTrackingId;
use App\AmazonEntry;
use App\RoutificJobTrackiingIds;
use App\StatusMap;
use App\SprintReattempt;

//use Validator;

use App\Zone;
use App\UserEntities;

class CustomRoutingBigBoxController extends BackendController
{

    public function getBigBoxJob(Request $request,$id)
    {
       
       
            $date=$request->get('date');
            $hub_id=$request->get('id');
            if(empty($date)){
                $date=date('Y-m-d');
            }
    
            $datas = SlotJob::leftJoin('zones_routing','zone_id','=','zones_routing.id')
            ->whereNull('slots_jobs.deleted_at')
            ->where('slots_jobs.created_at','like',$date.'%')
            ->where('slots_jobs.hub_id','=',$id)
            ->where('is_big_box','=',1)
            ->get(['job_id','title','status','slots_jobs.id','is_custom_route']);
                
          
        return backend_view('customroutingbigbox.routific_job',compact('datas','id'));
    }
    public function removeOrderInRoute(Request $request)
    {
        $orders=MerchantIds::join('sprint__tasks','sprint__tasks.id','=','merchantids.task_id')
        ->join('sprint__sprints','sprint__sprints.id','=','sprint__tasks.sprint_id')
        ->whereIn('tracking_id',json_decode($request->tracking_ids))
        ->where('sprint__sprints.in_hub_route','=',1)
        ->get(['merchantids.tracking_id']);
       
        if(count($orders)==0)
        {
            return response()->json(['status_code'=>400]);
        }
       foreach($orders as $order)
       {
            CustomRoutingTrackingId::
            where('tracking_id','=',$order->tracking_id)
            ->where('is_big_box','=',1)
            ->update(['deleted_at'=>date('Y-m-d H:i:s')]);
       
        }
       return response()->json(['status_code'=>200]);

    }
    public function getIndex(Request $request,$id)
    {
      
        $date=$request->get('date');

        if(empty($date)){
            $date=date('Y-m-d');
        }

        if($id==16)
        {
            $vendor=Vendor::
            where('id',477260)->get(['first_name','last_name','id']);
        }
        else if($id==19)
        {
            $vendor=Vendor::
            whereIn('id',[477282,476592,477340,477341,477342,477343,477344,477345,477346,477631,477629])->get(['first_name','last_name','id']);
        }
        else if($id==20)
        {
            $vendor=Vendor::
            where('id',476674)->get(['first_name','last_name','id']);
        }
        else
        {
            $vendor=Vendor::
            whereIn('id',[477607,477609,477613,477589,477641])->get(['first_name','last_name','id']);
        }
       
       $user= Auth::user();
       $tracking_id_data=CustomRoutingTrackingId::where('user_id','=',$user->id)
       ->where('hub_id','=',$id)
       ->whereNull('deleted_at')
       ->whereNotNull('tracking_id')
       ->where('is_big_box','=',1)
       ->where('tracking_id','!=','')
       ->get();
       $joey_route_detail=JoeyCapacityDetail::where('user_id','=',$user->id)->where('is_big_box','=',1)->where('hub_id','=',$id)->whereNull('deleted_at')
       ->get();
        $total_count=count($tracking_id_data);
        $valid_id= CustomRoutingTrackingId::where('user_id','=',$user->id)
        ->where('hub_id','=',$id)->where('valid_id','=',1)
        ->whereNull('deleted_at')
        ->whereNotNull('tracking_id')
        ->where('is_big_box','=',1)
        ->where('tracking_id','!=','')
        ->count();
        $ottawa_dash =[];
        $joey_route_detail_count=count($joey_route_detail);
        return backend_view( 'customroutingbigbox.index', compact('date','ottawa_dash','id','tracking_id_data','total_count','valid_id','vendor','joey_route_detail','joey_route_detail_count') );
    }
    public function addJoeyCount(Request $request)
    { 
       
        $user= Auth::user();
        $data=$request->all();
       
        $joey_capacity_detail=new JoeyCapacityDetail();
        $joey_capacity_detail->vehicle_id=$data['vehicle_id'];
        $joey_capacity_detail->user_id=$user->id;
        $joey_capacity_detail->hub_id=$data['hub_id'];
        $joey_capacity_detail->joeys_count=$data['joeys'];
        $joey_capacity_detail->is_big_box=1;
        $joey_capacity_detail->save();
       
        return response()->json(['status_code'=>200,'vehicle_id'=>$joey_capacity_detail->vehicle_id,'joeys_count'=>$joey_capacity_detail->joeys_count,'id'=>$joey_capacity_detail->id]);
    }
    public function deleteJoeyCount(Request $request)
    {
        JoeyCapacityDetail::where('id',$request->id)->update(['deleted_at'=>date("Y-m-d H:i:s")]);
        return response()->json(['status_code'=>200]);
    }
    public function getJoeyCountDetail(Request $request)
    {
        $joey_capacity_detail=JoeyCapacityDetail::where('id','=',$request->id)->first();

        return response()->json(['status_code'=>200,'vehicle_id'=>$joey_capacity_detail->vehicle_id,'joeys_count'=>$joey_capacity_detail->joeys_count,'id'=>$joey_capacity_detail->id]);
    }
    public function updateJoeyCountDetail(Request $request)
    {
        $joey_capacity_detail=JoeyCapacityDetail::where('id','=',$request->id)->first();
        $data=$request->all();
        $joey_capacity_detail->vehicle_id=$data['vehicle_id'];
        $joey_capacity_detail->joeys_count=$data['joeys'];
        $joey_capacity_detail->save();
        
        return response()->json(['status_code'=>200,'vehicle_id'=>$data['vehicle_id'],'joeys_count'=>$data['joeys'],'id'=>$joey_capacity_detail->id]);
    }
    public function removeTrackingid(Request $request)
    {
        $user= Auth::user();
        $id= CustomRoutingTrackingId::where('user_id','=',$user->id)->where('is_big_box','=',1)->where('tracking_id','=',$request->Tracking_id)->whereNull('deleted_at')->first();
      
       $id->deleted_at=date('Y-m-d H:i:s');
        $id->save();

        return  response()->json(['valid'=>$id->valid_id]);
    }
	 public function multipleRemoveTrackingid(Request $request)
    {
        $user= Auth::user();
         CustomRoutingTrackingId::where('user_id','=',$user->id)->where('is_big_box','=',1)->whereIn('tracking_id',$request->deleteId)->whereNull('deleted_at')->update(['deleted_at'=>date('Y-m-d H:i:s')]);
        return  response()->json();
    }


    public function postCreateRoute(Request $request)
    {
        $orders=[];
        $hub_id=$request->hub_id;
        $user= Auth::user();
        $joey_route_detail=JoeyCapacityDetail::join('vehicles','vehicles.id','=','custom_joey_detail.vehicle_id')
        ->where('user_id','=',$user->id)->where('hub_id','=',$hub_id)->whereNull('deleted_at')->where('is_big_box','=',1)
        ->get(['vehicles.id','vehicles.capacity','custom_joey_detail.joeys_count']);
     
        $tracking_ids=CustomRoutingTrackingId::where('user_id','=',$user->id)
        ->where('hub_id','=',$hub_id)
        ->whereNull('deleted_at')
        ->whereNotNull('tracking_id')
        ->where('is_big_box','=',1)
        ->where('tracking_id','!=','')
        ->pluck('tracking_id');

        $sprints= MerchantIds::join('sprint__tasks','sprint__tasks.id','=','merchantids.task_id')
        ->join("sprint__sprints",'sprint__sprints.id','=','sprint__tasks.sprint_id')
        ->join('locations','location_id','=','locations.id')
        ->where('sprint__tasks.type','=','dropoff')
        ->whereIn('merchantids.tracking_id',$tracking_ids)
        ->get(['start_time','end_time','sprint__sprints.creator_id','sprint__tasks.id','sprint__tasks.sprint_id','due_time','address','locations.latitude','locations.longitude','locations.postal_code',
        'locations.city_id']);
 
        foreach($sprints as $sprint)
        {
         if(in_array($sprint->creator_id,["477282","477260",'476592']))
         {
             $date = date("Y-m-d")." 17:00:00";
             $date = date('Y-m-d H:i:s', strtotime($date . ' -1 days'));
             Sprint::where('id','=',$sprint->sprint_id)->update(['status_id'=>61,"in_hub_route"=>0,"created_at"=>$date]);
             Task::where('id','=',$sprint->id)->update(['status_id'=>61]);
            //  $taskhistory=new TaskHistory();
            //  $taskhistory->sprint_id=$sprint->sprint_id;
            //  $taskhistory->sprint__tasks_id=$sprint->id;
            //  $taskhistory->status_id=61;
            //  $taskhistory->save();
          
         }
         else
         {
             
             Sprint::where('id','=',$sprint->sprint_id)->update(['status_id'=>124,"in_hub_route"=>0]);
             Task::where('id','=',$sprint->id)->update(['status_id'=>124]);
			 $checkforstatus=TaskHistory::where('sprint_id','=',$sprint->sprint_id)->where('status_id','=',125)->first();
             $isReattempt=SprintReattempt::where('sprint_id','=',$sprint->sprint_id)->first();
     
                    
     
             if(!$checkforstatus && $isReattempt==null)
             {
				$pickupstoretime_date=\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
               	$pickupstoretime_date->modify('-2 minutes');
				$taskhistory=new TaskHistory();
				$taskhistory->sprint_id=$sprint->sprint_id;
				$taskhistory->sprint__tasks_id=$sprint->id;
				$taskhistory->status_id=125;
                $taskhistory->created_at = $pickupstoretime_date->format('Y-m-d H:i:s');
                $taskhistory->date = $pickupstoretime_date->format('Y-m-d H:i:s');
				$taskhistory->save();
				}
			  $pickupstoretime_date=\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
              $pickupstoretime_date->modify('-1 minutes');
              $taskhistory=new TaskHistory();
              $taskhistory->sprint_id=$sprint->sprint_id;
              $taskhistory->sprint__tasks_id=$sprint->id;
              $taskhistory->status_id=124;
              $taskhistory->created_at = $pickupstoretime_date->format('Y-m-d H:i:s');
              $taskhistory->date = $pickupstoretime_date->format('Y-m-d H:i:s');
              $taskhistory->save();
            
         } 
         
 
        
        $latitude = $sprint->latitude/1000000;
        $longitude = $sprint->longitude/1000000;
     
         if(empty($sprint->city_id) || $sprint->city_id==NULL){
             $dropoffAdd = $this->canadian_address($sprint->address.','.$sprint->postal_code.',canada');
            if(!empty($dropoffAdd)){
                $latitude = $dropoffAdd['lat'];
                $longitude = $dropoffAdd['lng'];
            }
             
         }
 
         $start = $sprint->start_time;    
         $end = $sprint->end_time;
         
         $orders[$sprint->id]= array(
             "location" => array(
                 "name" => $sprint->address,
                 "lat" => $latitude,
                 "lng" => $longitude
             ),
             //"start" => $start,
             //"end" => $end,
             "load" => 1,
             "duration" => 2
         );
       
        }
        $job_id= $this->createJobId($orders,$hub_id,$joey_route_detail);
        if($job_id['status_code']==200){
        //  CustomRoutingTrackingId::
        //  where('user_id','=',$user->id)->where('hub_id','=',$hub_id)->whereNull('deleted_at')->whereIn('tracking_id',$tracking_ids)->update(['deleted_at'=>date("Y-m-d H:i:s")]);
         return response()->json(['status_code'=>200,'Job_id'=>$job_id['Job_id']]);
        }
        else
        {
         return response()->json(['status_code'=>400,'Job_id'=>Null,"error"=>$job_id['error']]);
        }
      
    }
   
    public function createJobId($orders,$hub_id,$joey_route_detail)
    {
        

        $hubPick = Hub::where('id','=',$hub_id)->first();
        $address = urlencode($hubPick->address);
        // google map geocode api url
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyDTK4viphUKcrJBSuoidDqRhVA4AWnHOo0";

        // get the json response
        $resp_json = file_get_contents($url);

        // decode the json
        $resp = json_decode($resp_json, true);
        
        // response status will be 'OK', if able to geocode given address
        if($resp['status']=='OK'){
                $hubLat = $resp['results'][0]['geometry']['location']['lat'];
                $hubLong = $resp['results'][0]['geometry']['location']['lng'];
        }
        $shifts= array();
        $k=1;
        foreach($joey_route_detail as $joey_route)
        {
            for($i=1;$i<=$joey_route->joeys_count;$i++){

        
                $shifts["joey_".$k] = array(
                    "start_location" => array(
                        "id" => $i,
                        "name" => $hubPick->address,
                        "lat" => $hubLat,
                        "lng" => $hubLong 
                    ),
                   //  "shift_start" =>"10:00" ,
                   //  "shift_end" =>"15:00",
                    "capacity" => $joey_route->capacity
                   //  ,
                   //  "min_visits_per_vehicle" => $joe->min_visits
                );
                $k++;
            }
        }

        if(empty($shifts)){
            return ['error'=>'Please set Joeys vehicle details to continue',"status_code"=>400];
        }

     $options = array(
        "shortest_distance" => true,
        "polylines" => true
       );
    
      $payload = array(
        "visits" => $orders,
        "fleet" => $shifts,
        "options" => $options
      );

      $client = new Client( '/vrp-long' );
    
      $client->setData($payload); 
      $apiResponse= $client->send();
      
      if(!empty($apiResponse->error)){      
        return ['error'=>$apiResponse->error,"status_code"=>400];
       
      }


        
    
    //   $job = new SlotJob();
    //   $job->job_id = $apiResponse->job_id;
    //   $job->hub_id =$hub_id;
    //   $job->date = date("Y-m-d H:i:s");
    //   $job->status = null;
    // //   $job->vendor_id=0;
    //   $job->visits_count=count($orders);
    //   $job->fleet_count=count($shifts);
    //   $job->save();
      $slotjob  = new  SlotJob();
      $slotjob->job_id = $apiResponse->job_id;
      $slotjob->hub_id =$hub_id;
      $slotjob->zone_id = null;
      $slotjob->unserved = null;
	  $slotjob->is_custom_route = 1;
      $slotjob->is_big_box=1;
      $slotjob->engine=1;
      $slotjob->save();

    return ['Job_id'=>$apiResponse->job_id,'status_code'=>200];

    }

    public function canadian_address($address){
        
        if(substr($address,-1)==' '){
            $postal_code = substr($address,-8,-1);
        }
        else {
        $postal_code = substr($address,-7);
        }
        
        if(substr($postal_code, 0, 1)==' '|| substr($postal_code, 0, 1)==','){
            $postal_code = substr($postal_code,-6);
        }

        if(substr($postal_code,-1)==' '){
            $postal_code = substr($postal_code,0,6);
        }

        $address1 =  substr($address,0,-7);

        //parsing address for suite-Component
        $address = explode(' ',trim($address));
        $address[0] = str_replace('-',' ', $address[0]);
        $address = implode(" ",$address);
        // url encode the address
        
        $address = urlencode($address);
        // google map geocode api url
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyDTK4viphUKcrJBSuoidDqRhVA4AWnHOo0";


        // get the json response
        $resp_json = file_get_contents($url);

        // decode the json
        $resp = json_decode($resp_json, true);
        
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
                if($addressComponent[$i]['types'][0] == 'postal_code' && $addressComponent[$i]['short_name']!=$postal_code){
                    $completeAddress['postal_code'] =$postal_code;
                }
            }

            if (array_key_exists('subpremise', $completeAddress)) {
                $completeAddress['suite'] = $completeAddress['subpremise'];
                unset($completeAddress['subpremise']);
            }
            else {
                $completeAddress['suite'] = '';
            }
        
            if($resp['results'][0]['formatted_address'] == $address1){
                $completeAddress['address'] = $resp['results'][0]['formatted_address'];
            }
            else{
                $completeAddress['address'] = $address1;
            }

            
            
            $completeAddress['lat'] = $resp['results'][0]['geometry']['location']['lat'];
            $completeAddress['lng'] = $resp['results'][0]['geometry']['location']['lng'];

            unset($completeAddress['administrative_area_level_2']);
            unset($completeAddress['street_number']);
        
            
            return $completeAddress;

        }
        else{
        //  throw new GenericException($resp['status'],403);
        }


    }

    public function postCreateOrder(Request $request)
    {

        
        
        $data['name'] =trim(str_replace(array("\n", "\r"), '', $request->name));
        $data['phone'] =trim(str_replace(array("\n", "\r"), '', $request->phone));
        $data['address'] =trim(str_replace(array("\n", "\r"), '', $request->address));
         $data['postal_code'] =trim(str_replace(array("\n", "\r"), '', $request->postal_code));
        $data['vendor_id'] =trim(str_replace(array("\n", "\r"), '', $request->vendor_id));
        $data['tracking_id'] =trim(str_replace(array("\n", "\r"), '', $request->tracking_Id)); 
      
        $vendor = Vendor::find($data['vendor_id']);
         
          $startTime = empty($vendor->attributes['order_start_time']) ? time() :
           date('H:i',strtotime($vendor->attributes['order_start_time']));
           $startTime="10:00";
          $due = strtotime( date("Y-m-d $startTime" ) );
          $dueTime = new \DateTime();
          $dueTime->setTimestamp($due);
          $dueTime->modify("+1 day");
          
          $end_time= date('H:i',strtotime("21:00:00") );
          $d = new \stdClass();
          $sprint = new \stdClass();
          $sprint->creator_id =$data['vendor_id'];
        //   $sprint->merchant_order_num= $data->merchant_order_num;
          $sprint->tracking_id= $data['tracking_id'];
          $sprint->end_time=$end_time;
          $sprint->start_time=$startTime;
          $sprint->due_time=strtotime($dueTime->format('y-m-d H:i:s'));
          $d->sprint = $sprint;
          $contact = new \stdClass();
          $contact->name = $data['name'];
          $contact->phone = $data['phone'];
          $d->contact = $contact;

          $location = new \stdClass();
          

          $dropoffAdd = $data['address']." ".$data['postal_code'];
         
          $googleAddress=$this->google_address($data['address'],$data['postal_code']);
        
          if($googleAddress==0)
          {
            return   response()->json(['status_code'=>400,"error"=>"Invalid Address"]);
          }
         
         
          if(!isset($googleAddress['postal_code']) || !isset($googleAddress['address']))
          {
            return   response()->json(['status_code'=>400,"error"=>"Invalid Address"]);
          }

          $location->address=$dropoffAdd;
       
          $d->location=$location;
          
          $notification_method = new \stdClass();
          $d->notification_method='none';
          $d->admin='1'; 
          $d->here_api='1'; 
          $HTTP_RAW_POST_DATA='$HTTP_RAW_POST_DATA';
          $amazon_enteries=null;
          if(in_array($data['vendor_id'],[477260,477282,476592]))
          {
            $amazon_enteries=new AmazonEntry();
            $amazon_enteries->creator_id=$data['vendor_id'];
            $amazon_enteries->tracking_id=$data['tracking_id'];
            $amazon_enteries->address_line_1=$data['address'];
            $amazon_enteries->address_line_2=$data['address'];
            $amazon_enteries->address_line_3=$data['address'];
          }
          $response = $this->OrderRequest($d,'create_order_custom_route',"POST");

         
             
           $response=json_decode($response,true);
           if($response==null)
           {
            return   response()->json(['status_code'=>400,"error"=>json_encode($response)]);
           }
          if($response['http']['code']===400)
            {
                  
              
                    return    response()->json(['status_code'=>400,"error"=>json_encode($response['response'])]);
            
            }
            if($response['http']['code']===201 || $response['http']['code']===200)
            {
               
               if(isset($response['response']['id']))
               {
                   
              $tracking_id_data=  CustomRoutingTrackingId::where('tracking_id','=', $data['tracking_id'] )->where('is_big_box','=',1)->whereNull('deleted_at')->first();
           
              $tracking_id= MerchantIds::
              join('sprint__tasks','sprint__tasks.id','=','merchantids.task_id')
            ->join('sprint__sprints',"sprint__sprints.id",'=','sprint__tasks.sprint_id')
            ->join('locations','locations.id','=',"location_id")
            ->join('sprint__contacts','sprint__contacts.id','=','contact_id')
            ->where('sprint__tasks.type','=','dropoff')
            ->where('tracking_id','=',$data['tracking_id'])->first(['sprint__sprints.creator_id','locations.address','locations.postal_code','sprint__tasks.id',
            'sprint__tasks.status_id','sprint__tasks.sprint_id'
            ,'sprint__contacts.name','sprint__contacts.phone','merchantids.tracking_id','merchantids.task_id']);
     
                 $tracking_id_data->valid_id=1;
                 $tracking_id_data->vendor_id=$tracking_id->creator_id;
                 $tracking_id_data->name=$tracking_id->name;
                 $tracking_id_data->contact_no=$tracking_id->phone;
                 $tracking_id_data->address=$tracking_id->address;
                 $tracking_id_data->postal_code=$tracking_id->postal_code;
                 $tracking_id_data->is_big_box=1;
                 $tracking_id_data->save();

                 if(in_array($tracking_id->creator_id,[477542,477340,477341,477342,477343,477344,477345,477346,477255,477254,477283,477284,477286,477287,477288,477289,477307,477308,477309,477310,
                 477311,477312,477313,477314,477292,477294,477315,477317,477316,477295,477302,477303,477304,477305,477306,477296,477290,477297,
                 477298,477299,477300,477320,477301,477318,477328,476294,477334,477335,477336,477337,477338,477339,477171,477559,477625,477607,477587,477621,477627,477631,477629,477635,477633,477661]))
                 {
                  
                      
                      $pickupstoretime_date=new \DateTime();
                      $pickupstoretime_date->modify('+1 minutes');
     
                     $taskhistory=new TaskHistory();
                     $taskhistory->sprint_id=$tracking_id->sprint_id;
                     $taskhistory->sprint__tasks_id=$tracking_id->id;
                     $taskhistory->status_id=125;
                     $taskhistory->created_at = $pickupstoretime_date->format('Y-m-d H:i:s');
                     $taskhistory->date = $pickupstoretime_date->format('Y-m-d H:i:s');
                     $taskhistory->save();
                     
                     $pickupstoretime_date=new \DateTime();
                      $pickupstoretime_date->modify('+2 minutes');
                    $taskhistory=new TaskHistory();
                    $taskhistory->sprint_id=$tracking_id->sprint_id;
                    $taskhistory->sprint__tasks_id=$tracking_id->id;
                    $taskhistory->status_id=124;
                    $taskhistory->created_at= $pickupstoretime_date->format('Y-m-d H:i:s');
                    $taskhistory->date= $pickupstoretime_date->format('Y-m-d H:i:s');
                    $taskhistory->save();

                     $date=$tracking_id_data->route_enable_date." 17:00:00";
                     Sprint::where('id','=',$tracking_id->sprint_id)->update(['status_id'=>124,"in_hub_route"=>0]);
                     Task::where('id','=',$tracking_id->task_id)->update(['status_id'=>124]);
                     
                 } 
                 else
                 {
                 
                     $date=$tracking_id_data->route_enable_date." 17:00:00";
                     $date = date('Y-m-d H:i:s', strtotime($date . ' -1 days'));
                     Sprint::where('id','=',$tracking_id->sprint_id)->update(['status_id'=>61,"in_hub_route"=>0,"created_at"=>$date]);
                     Task::where('id','=',$tracking_id->task_id)->update(['status_id'=>61,'created_at'=>$date]);
     
                 }
                  

                 if($tracking_id!=null && $amazon_enteries!=null)
                 {
                     $amazon_enteries->sprint_id=$response['response']['id'];
                     $amazon_enteries->task_id=$tracking_id->id;
                     $amazon_enteries->task_status_id=$tracking_id->status_id;
                     $amazon_enteries->address_line_2=$amazon_enteries->address_line_1;
                     $amazon_enteries->address_line_1=$tracking_id->address;
					 $amazon_enteries->is_custom_route=1;
                     $amazon_enteries->save();
                 }
              
                 return response()->json(['status_code'=>200,"message"=>"Order Created",
                 "data"=>["tracking_id"=>$tracking_id_data->tracking_id,"vendor_id"=>$tracking_id_data->vendor_id,"name"=>$tracking_id_data->name,
                 "phone"=>$tracking_id_data->contact_no,"address"=>$tracking_id_data->address,"postal_code"=>$tracking_id_data->postal_code,
                 "route_enable_date"=>$tracking_id_data->route_enable_date,
                 "valid"=>$tracking_id_data->valid_id]]);
          
               }
               else
               {
                return  response()->json(['status_code'=>400,"error"=>json_encode($response['response'])]);
               }

               
            }

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
    }
    public function isInRoute(Request $request)
    {
        $track = str_replace(",", "", trim($request->tracking_id));
        // $user= Auth::user();
        // $request->tracking_id= trim($request->tracking_id);


        //  $routificJobTrackiingId=RoutificJobTrackiingIds::where('tracking_id','=',$request->tracking_id)->first();
        //  if($routificJobTrackiingId)
        //  {
        //      if($routificJobTrackiingId->deleted_at==null)
        //      {
        //          return response()->json( ['status_code'=>400,"error"=>"Tracking Id is in Job Process and Job id is this ".$routificJobTrackiingId->job_id.". <br> Are you sure want to scan again this Tracking Id."]);
        //      }
        //      else
        //      {
        //          return response()->json( ['status_code'=>400,"error"=>"Tracking Id is in route. <br> Are you sure want to scan again this tracking id."]);
        //      }
        //  }

         

         $tracking_id_data=CustomRoutingTrackingId::
        //  join('dashboard_users','dashboard_users.id','=','custom_routing_tracking_id.user_id')->
        //  join('merchantids','merchantids.tracking_id','=','custom_routing_tracking_id.tracking_id')->
        //  join('sprint__tasks','sprint__tasks.id','=','merchantids.task_id')->
         //where('is_big_box','=',0)->
         where('valid_id','=',1)->
         where('custom_routing_tracking_id.tracking_id','=',$track)->
         whereNull('custom_routing_tracking_id.deleted_at');
          $tracking_id_order_count=$tracking_id_data->count();  
          $tracking_id_data=$tracking_id_data->where('is_big_box','=',0)->orderBy('id','desc')->first();
      if( $tracking_id_data!=null && $tracking_id_order_count==1)
      {
          $dropoffTask=$tracking_id_data->merchantid->dropoffTask;
          $scanUser=$tracking_id_data->scanUser;
          return response()->json( ['status_code'=>400,"error"=>"<br>Tracking Id : <b> {$track}</b>.<hr><br>Tracking Id Status : " .StatusMap::getDescription($dropoffTask->status_id). ".<hr><br>Tracking Id Scanned by {$scanUser->full_name} ({$scanUser->id}).<hr><br>Tracking Id already Scanned in Custom Routing.<hr><br> Tracking Id Scanned Date : ". date('Y-m-d', strtotime($tracking_id_data->created_at))]);
      }
            // if($tracking_id_data)
            // {
            //     return response()->json( ['status_code'=>400,"error"=>"Tracking Id is already scaned by other user. <br> Are you sure want to scan again this tracking id."]);
            // }

           
         return response()->json( ['status_code'=>200]);
    
    }
   

    public function getTrackingIdDetail(Request $request)
    {
        $track = str_replace(",", "", trim($request->tracking_id));
        $user= Auth::user();
        $exist=1;
        $tracking_id_data=CustomRoutingTrackingId::where('user_id','=',$user->id)->where('is_big_box','=',1)->where('tracking_id','=',trim($track))->
        where('hub_id','=',trim($request->hub_id))->whereNull('deleted_at')->first();
       
        
        $tracking_id= MerchantIds::
          join('sprint__tasks','sprint__tasks.id','=','merchantids.task_id')
        ->join('sprint__sprints',"sprint__sprints.id",'=','sprint__tasks.sprint_id')
        ->join('locations','locations.id','=',"location_id")
        ->join('sprint__contacts','sprint__contacts.id','=','contact_id')
        ->where('sprint__tasks.type','=','dropoff')
        ->whereNull('sprint__tasks.deleted_at')
        ->whereNull('sprint__sprints.deleted_at')
        ->where('tracking_id','=',trim($track))->first(['sprint__sprints.creator_id','locations.address','locations.postal_code'
        ,'sprint__contacts.name','sprint__contacts.phone','merchantids.tracking_id','sprint__sprints.id','merchantids.task_id']);
 
         if($tracking_id !=null)
         {
            if($request->hub_id==16)
            {
                if($tracking_id->creator_id!=477260)
                {
                    return response()->json( ['status_code'=>404,"error"=>"Tracking Id does not belong to this city."]);
                }
            }
            elseif($request->hub_id==19)
            {
                if(!in_array($tracking_id->creator_id,[477340,477341,477342,477343,477344,477345,477346,477282,476592,477631,477629]))
                {
                    return response()->json( ['status_code'=>404,"error"=>"Tracking Id does not belong to this city."]);
                }
            }
            elseif($request->hub_id==17)
            {
                if(!in_array($tracking_id->creator_id,[477542,477255,477254,477283,477284,477286,477287,477288,477289,477307,477308,477309,477310,
                477311,477312,477313,477314,477292,477294,477315,477317,477316,477295,477302,477303,477304,477305,477306,477296,477290,477297,
                477298,477299,477300,477320,477301,477318,477328,476294,477334,477335,477336,477337,477338,477339,477171,477559,477625,477607,477587,477621,477627,477635,477633,477661]))
                {
                    return response()->json( ['status_code'=>404,"error"=>"Tracking Id does not belong to this city."]);
                }
               
            }

             // checking return and Delivered status
             $checkReturnDeliveredStatus=TaskHistory::where('sprint_id','=',$tracking_id->id)->
            whereIn('status_id',[101,102,103,104,105,106,107,108,109,110,111,112,131,135,136,143,17,113,114,116,117,118,132,138,139,144])->OrderBy('id','DESC')->
            first();

            if($checkReturnDeliveredStatus!=null)
            {

               if(in_array($checkReturnDeliveredStatus->status_id, [101,102,103,104,105,106,107,108,109,110,111,112,131,135,136,143]))
               {
                  /* return response()
                   ->json(['status_code' => 404, "error" => "Tracking Id has a return status. Please create reattempt first."]);*/
               }
        
               if(in_array($checkReturnDeliveredStatus->status_id, [17,113,114,116,117,118,132,138,139,144]))
               {
                  /* return response()
                           ->json(['status_code' => 404, "error" => "This order is already delivered."]);*/
               }
           
            }
            if($tracking_id_data==null)
            {
                $tracking_id_data=new CustomRoutingTrackingId();
                $tracking_id_data->user_id= $user->id;
                $tracking_id_data->tracking_id= trim($track);
                $tracking_id_data->hub_id= trim($request->hub_id);
                $tracking_id_data->is_big_box=1;
                $tracking_id_data->route_enable_date=$request->date;
                $tracking_id_data->save();
                $exist=0;
         
            } 

            if(in_array($tracking_id->creator_id,[477542,477340,477341,477342,477343,477344,477345,477346,477255,477254,477283,477284,477286,477287,477288,477289,477307,477308,477309,477310,
            477311,477312,477313,477314,477292,477294,477315,477317,477316,477295,477302,477303,477304,477305,477306,477296,477290,477297,
            477298,477299,477300,477320,477301,477318,477328,476294,477334,477335,477336,477337,477338,477339,477171,477559,477625,477607,477587,477621,477627,477631,477629,477635,477633,477661]))
            {
                
              
                $checkforstatus = TaskHistory::where('sprint_id', '=', $tracking_id->id)
                ->where('status_id', '=', 125)
                ->first();

                // checking if order is Reattempt
                $isReattempt=SprintReattempt::where('sprint_id','=',$tracking_id->id)->first();
                $pickupstoretime_date=\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                $pickupstoretime_date->modify('+1 minutes');
                if (!$checkforstatus && $isReattempt==null)
                {
                    $taskhistory = new TaskHistory();
                    $taskhistory->sprint_id = $tracking_id->id;
                    $taskhistory->sprint__tasks_id = $tracking_id->task_id;
                    $taskhistory->status_id = 125;
                    $taskhistory->created_at = $pickupstoretime_date->format('Y-m-d H:i:s');
                     $taskhistory->date = $pickupstoretime_date->format('Y-m-d H:i:s');
                    $taskhistory->save();
                }
                	$pickupstoretime_date=\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                    $pickupstoretime_date->modify('+2 minutes');
                    $taskhistory = new TaskHistory();
                    $taskhistory->sprint_id = $tracking_id->id;
                    $taskhistory->sprint__tasks_id = $tracking_id->task_id;
                    $taskhistory->status_id = 124;
                    $taskhistory->created_at = $pickupstoretime_date->format('Y-m-d H:i:s');
                    $taskhistory->date = $pickupstoretime_date->format('Y-m-d H:i:s');
                    $taskhistory->save();


                $date=$request->date." 17:00:00";
                Sprint::where('id','=',$tracking_id->id)->update(['status_id'=>124,"in_hub_route"=>0]);
                Task::where('id','=',$tracking_id->task_id)->update(['status_id'=>124]);
                
            } 
            else
            {
            
                $date=$request->date." 17:00:00";
                $date = date('Y-m-d H:i:s', strtotime($date . ' -1 days'));
                Sprint::where('id','=',$tracking_id->id)->update(['status_id'=>61,"in_hub_route"=>0,"created_at"=>$date]);
                Task::where('id','=',$tracking_id->task_id)->update(['status_id'=>61,'created_at'=>$date]);

            }
             
            Sprint::where('id','=',$tracking_id->id)->update(['in_hub_route'=>0]);
             $tracking_id_data->valid_id=1;
             $tracking_id_data->vendor_id=$tracking_id->creator_id;
             $tracking_id_data->name=$tracking_id->name;
             $tracking_id_data->contact_no=$tracking_id->phone;
             $tracking_id_data->address=$tracking_id->address;
             $tracking_id_data->postal_code=$tracking_id->postal_code;
             $tracking_id_data->route_enable_date=$request->date;
             $tracking_id_data->save();
             return response()->json( ['status_code'=>200,"data"=>["tracking_id"=>trim($track),"vendor_id"=>$tracking_id->creator_id,
             "name"=>$tracking_id->name,'phone'=>$tracking_id->phone,'address'=>$tracking_id->address,'postal_code'=>$tracking_id->postal_code,"route_enable_date"=>$tracking_id_data->route_enable_date,'valid'=>1,'vendor'=>[],"exist"=>$exist]]);
         }
         else
         {
            if($tracking_id_data==null)
            {
                $tracking_id_data=new CustomRoutingTrackingId();
                $tracking_id_data->user_id= $user->id;
                $tracking_id_data->tracking_id= trim($track);
                $tracking_id_data->hub_id= trim($request->hub_id);
                $tracking_id_data->is_big_box=1;
                $tracking_id_data->route_enable_date=$request->date;
                $tracking_id_data->save();
                $exist=0;
         
            } 

             $tracking_id_data->valid_id=0;
             $tracking_id_data->route_enable_date=$request->date;
             $tracking_id_data->save();
             return response()->json( ['status_code'=>200,"data"=>["tracking_id"=>trim($track),"vendor_id"=>"","route_enable_date"=>$tracking_id_data->route_enable_date,
             "name"=>"",'phone'=>"",'address'=>"",'postal_code'=>"",'valid'=>0,"vendor"=>[],"exist"=>$exist]]);
         }
       
 
    }
    public function google_address($address,$postal_code)
    {

        $address = urlencode($address);
        $postal_code = urlencode($postal_code);
      
        // google map geocode api url
        $url ="https://maps.googleapis.com/maps/api/geocode/json?address={$address}components=country:canada|postal_code:$postal_code&key=AIzaSyDTK4viphUKcrJBSuoidDqRhVA4AWnHOo0"; 
        // "https://maps.googleapis.com/maps/api/geocode/json?address={$address}components=country:canada&key=AIzaSyDTK4viphUKcrJBSuoidDqRhVA4AWnHOo0";

        // get the json response
        $resp_json = file_get_contents($url);

        // decode the json
        $resp = json_decode($resp_json, true);
        
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
    public function editOrder(Request $request)
    {
        $user= Auth::user();
        $data=$request->all();
        $orderData=MerchantIds::join('sprint__tasks','sprint__tasks.id','=','merchantids.task_id')
        ->where('merchantids.tracking_id',$data['tracking_id'])
        ->where('sprint__tasks.type','=','dropoff')
        ->first(['contact_id','location_id','sprint__tasks.sprint_id']);
        $contactData=ContactUncrypted::where('id',$orderData->contact_id)->first();
        $contactData->name=$data['name'];
        $contactData->phone=$data['phone'];
        $contactData->save();
       
        $locationData=LocationUnencrypted::where('id',$orderData->location_id)->first();
        $pattern = "/^[A-Za-z]{1}+$/";
        if(preg_match($pattern,$data['address']))
        {
            return response()->json( ['status_code'=>400,"error"=>"Invalid Address.","data"=>["tracking_id"=>null,"vendor_id"=>null,
            "name"=>null,'phone'=>null,'address'=>null,'postal_code'=>null,'valid'=>1,'vendor'=>[],"exist"=>1]]);
         
        }

        $pattern = "/^[0-9 ]+$/";
        if(preg_match($pattern,$data['address']))
        {
            
            return response()->json( ['status_code'=>400,"error"=>"Invalid Address.","data"=>["tracking_id"=>null,"vendor_id"=>null,
            "name"=>null,'phone'=>null,'address'=>null,'postal_code'=>null,'valid'=>1,'vendor'=>[],"exist"=>1]]);
        }
        $pattern = "/^[A-Za-z ]+$/";
        if(!preg_match($pattern,$data['name']))
        {
            return response()->json( ['status_code'=>400,"error"=>"Invalid Customer Name.","data"=>["tracking_id"=>null,"vendor_id"=>null,
            "name"=>null,'phone'=>null,'address'=>null,'postal_code'=>null,'valid'=>1,'vendor'=>[],"exist"=>1]]);
       
        }
      
        $pattern = "/^[0-9]+$/";
        if(!preg_match($pattern,$data['phone']))
        {
            return response()->json( ['status_code'=>400,"error"=>"Invalid Customer Phone No.","data"=>["tracking_id"=>null,"vendor_id"=>null,
            "name"=>null,'phone'=>null,'address'=>null,'postal_code'=>null,'valid'=>1,'vendor'=>[],"exist"=>1]]);
       
        }
        
        $googleAddress=$this->google_address($data['address'],$data['postal_code']);
     
        if($googleAddress==0)
        {
            return response()->json( ['status_code'=>400,"data"=>["tracking_id"=>null,"vendor_id"=>null,
            "name"=>null,'phone'=>null,'address'=>null,'postal_code'=>null,'valid'=>1,'vendor'=>[],"exist"=>1]]);
        }
        
        if(!isset($googleAddress['postal_code']) || !isset($googleAddress['address']))
        {
            return response()->json( ['status_code'=>400,"data"=>["tracking_id"=>null,"vendor_id"=>null,
            "name"=>null,'phone'=>null,'address'=>null,'postal_code'=>null,'valid'=>1,'vendor'=>[],"exist"=>1]]);
        }

        $locationData->address=$googleAddress['address'];
        $locationData->postal_code=$googleAddress['postal_code'];
        
        // $locationData->latitude =$googleAddress['lat'];
        // $locationData->longitude =$googleAddress['lat'];
        $locationData->latitude =(int)str_replace(".","",$googleAddress['lat']);
        $locationData->longitude =(int)str_replace(".","",$googleAddress['lng']);
        $locationData->save();

        // $locationData->city_id  =
        // $locationData->state_id =
        // $locationData->country_id =
        // dd($data);

        $tracking_id_data=CustomRoutingTrackingId::where('user_id','=',$user->id)->where('is_big_box','=',1)->where('tracking_id','=',$data['tracking_id'])->whereNull('deleted_at')->first();
        $tracking_id_data->name=$data['name'];
        $tracking_id_data->contact_no=$data['phone'];
        $tracking_id_data->address=$googleAddress['address'];
        $tracking_id_data->postal_code=$googleAddress['postal_code'];
        $tracking_id_data->save();
        // amazon entry address updated
        $amazon_enteries =AmazonEntry::where('sprint_id','=',$orderData->sprint_id)->whereNull('deleted_at')->first();
        if($amazon_enteries!=null)
        {
            $amazon_enteries->address_line_3=$amazon_enteries->address_line_2;
            $amazon_enteries->address_line_2=$amazon_enteries->address_line_1;
            $amazon_enteries->address_line_1=$googleAddress['address'];
            $amazon_enteries->save();
        }

        return response()->json( ['status_code'=>200,"data"=>["tracking_id"=>$data['tracking_id'],"vendor_id"=>$tracking_id_data->vendor_id,"route_enable_date"=>$tracking_id_data->route_enable_date,
        "name"=>$data['name'],'phone'=>$data['phone'],'address'=>$googleAddress['address'],'postal_code'=>$googleAddress['postal_code'],'valid'=>1,'vendor'=>[],"exist"=>1]]);

    }
    
   
    
   
   
}
