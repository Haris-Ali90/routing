<?php


namespace App\Http\Controllers\Backend;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

use App\Http\Requests;
use App\Http\Controllers\Backend\BackendController;

use App\StoreName;
use App\JoeyRoute;
use App\Teachers;
use App\Institute;
use App\Amazon;
use App\CoursesRequest;
use date;
use DB;
use Carbon\Carbon;

use App\WMSlotJob;
use \JoeyCo\Laravel\Api\JsonRequest;
use App\Hub;
use App\Sprint;
use App\Task;
use App\MerchantIds;
use App\JoeyHubRoute;
use App\JoeyPickRoute;
use App\JoeyPickRouteLocations;
use App\JoeyRouteLocations;
use App\Slots;
use App\SlotsPostalCode;
use App\SlotJob;
use App\SprintSchedules;
use App\SprintJoeySchedules;
use App\WalmartZoneRoutific;
use App\Joey;
use App\DispatchData;
use App\JobRoutes;
use App\LogRoutes;
use \Laravel\View;
use \Laravel\Input;
// use Laravel\Redirect;
use Laravel\Session;
use App\Client;
use App\WMSlots;
use App\WMJoeyRoute;
use App\WMJoeyRouteLocations;

class WMRoutificController extends BackendController {

    public function __construct() {
        define('TOP_NAV_SELECTED', 'dispatch');
    } 
    public function getStore()
    {
        $store_data=StoreName::whereNull('deleted_at')->get();
        
        return backend_view('wmstore.index',['stores'=>$store_data]);
    }
    public function routeDetails($routeId){
    
        $routes = WMJoeyRouteLocations::join('sprint__tasks','task_id','=','sprint__tasks.id')
        ->leftJoin('merchantids','merchantids.task_id','=','sprint__tasks.id')
        ->join('sprint__contacts','contact_id','=','sprint__contacts.id')
        ->join('locations','location_id','=','locations.id')
        ->where('route_id','=',$routeId)
        ->whereNull('wm_joey_route_locations.deleted_at')
        ->orderBy('wm_joey_route_locations.ordinal')
        ->get(['sprint__tasks.type','route_id','wm_joey_route_locations.ordinal','sprint_id','merchant_order_num','tracking_id','name','phone','email','address',
        'postal_code','latitude','longitude','wm_joey_route_locations.distance']);
        
       
        return json_encode($routes);

    } 
    public function wmRoutificControls(Request $request){
       

        if(empty($request->input('date'))){
            $date = date('Y-m-d');
        }
        else{
            $date = $request->input('date');
        }
       
        $routes =  WMJoeyRoute::join('wm_joey_route_locations','route_id','=','wm_joey_routes.id')
        ->join('sprint__tasks','sprint__tasks.id','=','wm_joey_route_locations.task_id')
         ->join('sprint__sprints','sprint_id','=','sprint__sprints.id')
         ->leftJoin('joeys','wm_joey_routes.joey_id','=','joeys.id')
         ->leftJoin('store_name','store_name.store_num','=','sprint__sprints.store_num')
         ->whereNotIn('sprint__sprints.status_id',[36])
         ->whereNull('sprint__sprints.deleted_at')
         ->whereNull('wm_joey_routes.deleted_at')
         ->whereNull('wm_joey_route_locations.deleted_at')
         ->where('wm_joey_routes.date','like',$date."%")
        ->distinct()
        ->get(['wm_joey_routes.joey_id as joey_id','wm_joey_routes.date','wm_joey_routes.id as route_id','first_name','last_name','wm_joey_routes.total_travel_time',
        'wm_joey_routes.total_distance','sprint__sprints.store_num','store_name.store_name']);
       
        $countQry = "SELECT route_id,
        COUNT(*) AS counts,
        SUM(CASE WHEN sprint__sprints.status_id = 17 THEN 0 ELSE 1 END) AS d_counts,
        SUM(wm_joey_route_locations.distance) AS distance,
        SUM(CASE WHEN sprint__sprints.status_id = 17 THEN 0 ELSE wm_joey_route_locations.distance END) AS d_distance,
        SEC_TO_TIME(SUM(TIME_TO_SEC(finish_time)-TIME_TO_SEC(arrival_time))) AS duration,
        SEC_TO_TIME(SUM(CASE WHEN sprint__sprints.status_id = 17 THEN 0 ELSE TIME_TO_SEC(finish_time)-TIME_TO_SEC(arrival_time) END)) AS d_duration
        FROM wm_joey_route_locations 
        JOIN sprint__tasks ON(task_id=sprint__tasks.id) 
        JOIN sprint__sprints ON(sprint_id=sprint__sprints.id) 
        JOIN wm_joey_routes ON(route_id=wm_joey_routes.id) 
        where wm_joey_routes.date LIKE '".$date."%'
        AND sprint__tasks.`deleted_at` IS NULL AND sprint__sprints.`deleted_at` IS NULL 
        AND wm_joey_route_locations.`deleted_at` IS NULL 
        AND wm_joey_routes.deleted_at IS NULL GROUP BY route_id";

        $counts = DB::select($countQry);
      
       //dd($counts);
        return backend_view('wmstore.wm-routifc',compact('routes','counts'));

    }
    public function wmCreateJobId(Request $request)
    {
       
            $sprints = Task::join('sprint__sprints','sprint__tasks.sprint_id','=','sprint__sprints.id')
            ->join('locations','location_id','=','locations.id')
            ->whereIn('ordinal',[1,2])
           //->whereIn('creator_id','=',477115)
         //  ->where('sprint__sprints.created_at','like',$request->input('date')."%")
           ->where('sprint__sprints.store_num','=',$request->input('store_id'))
          //->where(\DB::raw("CONVERT_TZ(due_time,'UTC','America/Toronto')"),'like',$request->input('create_date')."%")
         ->whereNull('sprint__sprints.in_hub_route')
           ->whereIn('sprint__sprints.status_id',[61,24]);

            $sprints = $sprints->distinct()
            ->get(['sprint__tasks.type','sprint__tasks.sprint_id','sprint__tasks.id as task_id','creator_id','sprint__tasks.due_time','sprint__tasks.etc_time',
            'address','locations.latitude','locations.longitude']);
        
            if( count($sprints)==0 ){
                return back()->with('error','No Orders in selected Store');
       
            }

            foreach($sprints as $sprint){
            
                
                $lat[0] = substr($sprint->latitude, 0, 2);
                $lat[1] = substr($sprint->latitude, 2);
                $latitude = $lat[0].".".$lat[1];
        
                $long[0] = substr($sprint->longitude, 0, 3);
                $long[1] = substr($sprint->longitude, 3);
                $longitude = $long[0].".".$long[1];
                
                $start = date('H:i',$sprint->due_time);
                
                $end =date('H:i',$sprint->etc_time);
             
                if($start > $end){
                    $end = $start;
                }

                $orders[$sprint->sprint_id][$sprint->type]= array(
                    "location" => array(
                        "name" => (string)$sprint->task_id,
                        "lat" => $latitude,
                        "lng" => $longitude
                    ),
                
                   // "start" => $start,
                   // "end" => $end,
                    "load" => 2
                  // "duration" => 2
                );
                
            }

    
            $hubPick=StoreName::where('store_num','=',
            $request->input('store_id'))->first();
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
            $joeycounts=WMSlots::join('vehicles','wm_slots.vehicle','=','vehicles.id')
            ->where('wm_slots.store_num',
            //$slot_id
            $request->input('store_id'))->whereNull('wm_slots.deleted_at')
            ->first(['vehicles.capacity','vehicles.min_visits','wm_slots.start_time','wm_slots.end_time','wm_slots.joey_count']);
    
            if(empty($joeycounts))
            {
                return back()->with('error','No Slot is Created for this Store!');
            }
                
                for($i=1;$i<=$joeycounts->joey_count;$i++){
    
                    $shifts[$i] = array(
                        "start_location" => array(
                            "id" => $i,
                            "name" => $hubPick->address,
                            "lat" => $hubLat,
                            "lng" => $hubLong 
                        ),
                        "shift_start" => date('H:i',strtotime($joeycounts->start_time)),
                        "shift_end" => date('H:i',strtotime($joeycounts->end_time)),
                        "capacity" => $joeycounts->capacity,
                        "min_visits_per_vehicle" => $joeycounts->min_visits
                        //$joeycounts->min_visits
                    );
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
  
           
         $client = new Client( '/pdp-long' );
         $client->setData($payload); 
         $apiResponse= $client->send();
     
         if(!empty($apiResponse->error)){
    
             $error = new LogRoutes(); 
             $error->error = $apiResponse->error;
             $error->save();
    
             return back()->with('error',$apiResponse->error);
         }
    
         $job = new WMSlotJob();
         $job->job_id = $apiResponse->job_id;
         $job->store_num = $request->input('store_id');
         $job->date = $request->input('date');
         $job->status = null;
         $job->save();
         return back()->with('success',"Request Submited Job_id ".$apiResponse->job_id);
        
    }
    public function getWMRoutificJob(Request $request)
    {

        $date=$request->get('date');
     
        if(empty($date)){
            $date=date('Y-m-d');
        }

        $datas =WMSlotJob::join('store_name','store_name.store_num','=','wm_slots_jobs.store_num')->whereNull('wm_slots_jobs.deleted_at')->where('wm_slots_jobs.created_at','like',$date.'%')
        ->get(['wm_slots_jobs.id','wm_slots_jobs.job_id','wm_slots_jobs.status','store_name.store_name','store_name.store_num']);
            
        return backend_view('wmslots.wmroutificjob',compact('datas'));
    }
    public function deleteWMRoutificJob(Request $request)
    {
      
        WMSlotJob::where('id','=',$request->input('delete_id'))->update(['deleted_at'=>date('Y-m-d H:i:s')]);
        return back()->with('success','Job Id deleted Successfully!');
    }
    public function wmCreateRoute($id)
    {
       
        $url= "/jobs";

        $client = new Client($url);
        $client->setJobID($id);
        $apiResponse = $client->getJobResults();
        
        $job=WMSlotJob::where('job_id','=',$id)->first();
       
        WMSlotJob::where('job_id','=',$job->job_id)->update(['status'=>$apiResponse['status']]);

        if($apiResponse['status']=='finished'){

        $solution = $apiResponse['output']['solution'];

        if(!empty($solution)){

        foreach ($solution as $key => $value){

        if(count($value)>1){

           // WMJoeyRoute::where('joey_id','=',$key)->update(['deleted_at'=>date('Y-m-d H:i:s')]);

        $Route = new WMJoeyRoute();

       // $Route->joey_id = $key;
        $Route->date =date('Y-m-d H:i:s');
        $Route->store_num = $job->store_num;

        // $Route->total_travel_time=$apiResponse['output']['total_travel_time'];
        if(isset($apiResponse['output']['total_working_time']))
        {
        $Route->total_travel_time=$apiResponse['output']['total_working_time'];
        }
        else
        {
        $Route->total_travel_time=0;
        }
        if(isset($apiResponse['output']['total_distance']))
        {
        $Route->total_distance=$apiResponse['output']['total_distance'];
        }
        else
        {
        $Route->total_distance=0;
        }

        $Route->save();

        //Joey::where('id','=',$key)->update(['has_route'=>1]);

        for($i=0;$i<count($value);$i++){
        if($i>0){

            WMJoeyRouteLocations::where('task_id','=',$value[$i]['location_name'])->update(['deleted_at'=>date('Y-m-d H:i:s')]);

        $routeLoc = new WMJoeyRouteLocations();
        $routeLoc->route_id = $Route->id;
        $routeLoc->ordinal = $i;
        $routeLoc->task_id = $value[$i]['location_name'];
        $routeLoc->distance = $value[$i]['distance'];
        if(isset($value[$i]['arrival_time']) && !empty($value[$i]['arrival_time'])){
        $routeLoc->arrival_time = $value[$i]['arrival_time'];
        $routeLoc->finish_time = $value[$i]['finish_time'];
        $routeLoc->type = $value[$i]['type'];
        }
        $routeLoc->save();
      
        $sprint = Task::where('id','=',$value[$i]['location_name'])->first();
        if(!empty($sprint))
        {
            Sprint::where('id','=',$sprint->sprint_id)->update(['in_hub_route'=>1]);
        }
       

        }
        }
        }
        }

        }

        }

        else{

        $error = new LogRoutes();
        $error->error = $job->job_id." is in ".$apiResponse['status'];
        $error->save();

        return back()->with('error','Routes creation is in process');
        }
        return back()->with('success','Route Created Successfully!');

    }
    public function deleteStore(Request $request)
    {
       
        StoreName::where('store_num','=',$request->input('delete_id'))->update(['deleted_at'=>date('Y-m-d H:i:s')]);
        return back()->with('success','Store deleted  Successfully!');
    }

    public function wmRouteMap($route_id){

        $routes = WMJoeyRouteLocations::join('sprint__tasks','task_id','=','sprint__tasks.id')
       ->join('locations','location_id','=','locations.id')
       ->where('route_id','=',$route_id)
       ->whereNull('wm_joey_route_locations.deleted_at')
       ->orderBy('wm_joey_route_locations.ordinal')
       ->get(['sprint__tasks.type','route_id','wm_joey_route_locations.ordinal','sprint_id','address','postal_code','latitude','longitude']);
       
       $i=0;
       foreach($routes as $route){
        
        $data[] = $route;
        
        $lat[0] = substr($route->latitude, 0, 2);
        $lat[1] = substr($route->latitude, 2);
        $data[$i]['latitude'] = floatval($lat[0].".".$lat[1]);

        $long[0] = substr($route->longitude, 0, 3);
        $long[1] = substr($route->longitude, 3);
        $data[$i]['longitude'] = floatval($long[0].".".$long[1]);
        $i++;

       }
       return json_encode($data);
    }

    public function wmremainigRouteMap($route_id){

        $routes = WMJoeyRouteLocations::join('sprint__tasks','task_id','=','sprint__tasks.id')
       ->join('locations','location_id','=','locations.id')
       ->where('route_id','=',$route_id)
       ->whereNull('wm_joey_route_locations.deleted_at')
       ->whereNotIn('status_id',[17])
       ->orderBy('wm_joey_route_locations.ordinal')
       ->get(['sprint__tasks.type','route_id','wm_joey_route_locations.ordinal','sprint_id','address','postal_code','latitude','longitude']);
      
       $i=0;
       foreach($routes as $route){
        
        $data[] = $route;
       
        $lat[0] = substr($route->latitude, 0, 2);
        $lat[1] = substr($route->latitude, 2);
        $data[$i]['latitude'] = floatval($lat[0].".".$lat[1]);

        $long[0] = substr($route->longitude, 0, 3);
        $long[1] = substr($route->longitude, 3);
        $data[$i]['longitude'] = floatval($long[0].".".$long[1]);
        $i++;

       }
      
       return json_encode($data);
    }
    public function getWMLocationMap(Request $request)
    {
       $date=$request->input('date');
       
        
        //$date=date('Y-m-d',strtotime("-3 day", strtotime($date)));
        $datas=WMJoeyRoute::
       where('wm_joey_routes.date','like',$date."%")
       ->whereNUll('deleted_at')
       ->get(['wm_joey_routes.id as route_id']);
        $value=[];
        $i=0;
        $key=[];
        foreach($datas as $data)
        {
         
           $location= WMJoeyRouteLocations::join('sprint__tasks','sprint__tasks.id','=','wm_joey_route_locations.task_id')
            ->join('locations','locations.id','=','sprint__tasks.location_id')
             ->where('wm_joey_route_locations.route_id','=',$data->route_id)
             ->get(['locations.longitude','locations.latitude','sprint__tasks.sprint_id','locations.address','wm_joey_route_locations.ordinal']);
           if(!empty( $location))
           {
            $key[]=$data->route_id;
           }
           
            $j=0;
                foreach($location as $loc)
                {
                    $lat[0] = substr($loc->latitude, 0, 2);
                    $lat[1] = substr($loc->latitude, 2);
                    $value['data'][$i][$j]['latitude'] = floatval($lat[0].".".$lat[1]);
            
                    $long[0] = substr($loc->longitude, 0, 3);
                    $long[1] = substr($loc->longitude, 3);
                    $value['data'][$i][$j]['longitude'] = floatval($long[0].".".$long[1]);
    
                   
                    $value['data'][$i][$j]['sprint_id']=$loc->sprint_id;
                    $value['data'][$i][$j]['address']=$loc->address;
                    $value['data'][$i][$j]['route_id']=$data->route_id.'-'.$loc->ordinal;
                    $value['data'][$i][$j]['type']=$loc->type;
                    $j++;
                }
            //     $i=0;
            //     $k=0;
            //     for($i=0;$i<5;$i++){
            //     for($j=0;$j<5;$j++)
            //     {
            //         $value[$i][$j]['longitude']=-79.627221+$k;
            //         $value[$i][$j]['latitude']=43.630173+$k;
            //         $value[$i][$j]['route_id']=$i;
            //         $value[$i][$j]['sprint_id']=$j;
            //         $value[$i][$j]['address']='5030 Maingate Dr';
            //         $k++;
    
            //     }
            // }
            $i++;
        }
        
        $value['key']=$key;
      
            return json_encode($value);
    }
    public function getWMRouteMapLocation(Request $request)
    {
        $value=[];
        $ids=$request->input('ids');
        $i=0;
        foreach($ids as $id)
        {
            
           $location= WMJoeyRouteLocations::join('sprint__tasks','sprint__tasks.id','=','wm_joey_route_locations.task_id')
            ->join('sprint__sprints','sprint__sprints.id','=','sprint__tasks.sprint_id')
            ->join('locations','locations.id','=','sprint__tasks.location_id')

             ->where('wm_joey_route_locations.route_id','=',$id)
             ->get(['locations.longitude','locations.latitude','sprint__tasks.sprint_id','locations.address','wm_joey_route_locations.type','wm_joey_route_locations.ordinal']);
           
         
            $j=0;

                foreach($location as $loc)
                {
                    $lat[0] = substr($loc->latitude, 0, 2);
                $lat[1] = substr($loc->latitude, 2);
                $value['data'][$i][$j]['latitude'] = floatval($lat[0].".".$lat[1]);
        
                $long[0] = substr($loc->longitude, 0, 3);
                $long[1] = substr($loc->longitude, 3);
                $value['data'][$i][$j]['longitude'] = floatval($long[0].".".$long[1]);

               
                $value['data'][$i][$j]['sprint_id']=$loc->sprint_id;
                $value['data'][$i][$j]['address']=$loc->address;
                    $value['data'][$i][$j]['route_id']=$id."-".$loc->ordinal;
                    $value['data'][$i][$j]['type']=$loc->type;
                    $j++;
                }
            $i++;
        }
           
            return json_encode($value);
      
    } 
    public function wmOrderDelete(Request $request)
    {
    Sprint::where('id','=',$request->input('delete_id'))->update(['deleted_at'=>date('Y-m-d H:i:s')]);
    return redirect()->back()->with('success', 'Order deleted Successfully!');
    }
    public function wmRouteTransfer(Request $request)
    {
        WMJoeyRoute::where('id',$request->input('route_id'))->update(['joey_id'=>$request->input('joey_id')]);
        return redirect()->back()->with('success', 'your message,here');
    }
    public function wmDeleteRoute($id)
    {
      
        WMJoeyRoute::where('id','=',$id)->update(['deleted_at'=>date("Y-m-d H:i:s")]);
        return  'Route Deleted Successfully!';
    }
    public function wmRouteEdit($routeId){

        $route = WMJoeyRouteLocations::join('sprint__tasks','wm_joey_route_locations.task_id','=','sprint__tasks.id')
        ->leftJoin('merchantids','merchantids.task_id','=','sprint__tasks.id')
        ->join('locations','location_id','=','locations.id')
        ->join('sprint__sprints','sprint_id','=','sprint__sprints.id')
        ->whereNull('sprint__sprints.deleted_at')
        ->whereNotIn('sprint__sprints.status_id',[36,17])
        ->where('route_id','=',$routeId)
        ->whereNull('wm_joey_route_locations.deleted_at')
		//->whereNotNull('merchantids.tracking_id')
        ->orderBy('wm_joey_route_locations.ordinal','asc')
        ->get(['wm_joey_route_locations.id','merchantids.merchant_order_num','wm_joey_route_locations.task_id','merchantids.tracking_id',
        'sprint__sprints.id as sprint_id','sprint__tasks.type','start_time','end_time','address','postal_code'
        ,'wm_joey_route_locations.arrival_time','wm_joey_route_locations.finish_time',
        'wm_joey_route_locations.distance']);
      
        
        return backend_view('wmstore.edit-wm-route',['route'=>$route,'id'=>$routeId]);

    }
}





