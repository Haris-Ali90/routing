<?php

namespace App\Http\Controllers\Backend;

use App\AmazonEntry;
use App\Classes\Client;
use App\Classes\Fcm;
use App\Hub;
use App\HubStore;
use App\Joey;
use App\JoeyJobSchedule;
use App\JoeyRoute;
use App\JoeyRouteLocations;
use App\Location;
use App\LogRoutes;
use App\MicroHubPostalCodes;
use App\RouteHistory;
use App\RoutingZones;
use App\SlotJob;
use App\Slots;
use App\Sprint;
use App\Task;
use App\UserDevice;
use App\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MidMileController extends BackendController
{

    private $client;

    /**
     * Create a new controller instance.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function index()
    {
        $hubs = Hub::whereNull('deleted_at')->get();

        return backend_view('midmile.index', compact('hubs'));
    }
    
    public function createJobId()
    {
        $hubId = auth()->user()->hub_id;
        $from = date('Y-m-d').' 00:00:00';
        $to = date('Y-m-d').' 23:59:59';
        $payload=[];
        $sprints = Sprint::with('vendor', 'vendor.Location')->where('status_id', 127)->whereBetween('created_at', [$from, $to])->get();



        foreach($sprints as $key => $sprint){
            $hubStores = HubStore::where('vendor_id', $sprint->creator_id)->whereNull('deleted_at')->pluck('hub_id');
            if($hubStores){
                $hub = Hub::whereNull('deleted_at')->whereIn('id',$hubStores)->first();
                if(isset($hub->address)){
                    $visits['order_'.$sprint->id]['pickup'] = [
                        "location" => [
                            "address" => $hub->address,
                            "lat" => ($hub->hub_latitude) ? substr($hub->hub_latitude, 0, 8) / 1000000 : 'N/A',
                            "lng" => ($hub->hub_longitude) ? substr($hub->hub_longitude, 0, 9) / 1000000: 'N/A',
                        ],
                        "end" => '13:00',
                        "duration" => 10,
                    ];
                }else{
                    continue;
                }
            }

            $tasks = $sprint->dropoffTask()->get();
            foreach($tasks as $task){
                if($task->taskMerchant == null){
                    return response()->json( ['status_code'=>400,"error"=>'Task not available']);
                }
                $location = Location::find($task->location_id);
                $postal = substr($location->postal_code,0,3);
                $postalCodes = MicroHubPostalCodes::where('postal_code', $postal)->first();

                $hubDropoff = Hub::whereNull('deleted_at')->find($postalCodes->hub_id);
                $visits['order_'.$sprint->id]['dropoff'] = [
                    "location" => [
                        "address" => $hubDropoff->address,
                        "lat" => ($hubDropoff->hub_latitude) ? substr($hubDropoff->hub_latitude, 0, 8) / 1000000 : 'N/A',
                        "lng" => ($hubDropoff->hub_longitude) ? substr($hubDropoff->hub_longitude, 0, 9) / 1000000: 'N/A',
                    ],
                    "duration" => 10,
                ];
            }
        }

        $microHub = Hub::where('id','=',$hubId)->first();
        // get address bu url encode
        $address = urlencode($microHub->address);
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
        //joey slots count

        $joeycounts=Slots::join('vehicles','slots.vehicle','=','vehicles.id')
            ->where('slots.hub_id','=',$hubId)
            ->where('slots.mile_type', '=', 2)
            ->whereNull('slots.deleted_at')
            ->get(['vehicles.capacity','vehicles.min_visits','slots.start_time','slots.end_time','slots.hub_id','slots.joey_count','custom_capacity']);



        if(count($joeycounts)<1){
            return response()->json( ['status_code'=>400,"error"=>'No slot in this hub']);
        }
        $j=0;
        foreach($joeycounts as $joe){
            if(!empty($joe->joey_count)){
                $joeycount= $joe->joey_count;
            }
            if(!isset($joeycount) || empty($joeycount)){
                return response()->json( ['status_code'=>400,"error"=>'Joey count should be greater than 1 in slot']);
            }


            for($i=1;$i<=$joeycount;$i++){
                if(empty($joe->custom_capacity)){
                    $capacity = $joe->capacity;
                }
                else{
                    $capacity = $joe->custom_capacity;
                }
                $shifts["joey_".$j] = array(
                    "start_location" => array(
                        "id" => $j,
                        "name" => $microHub->address,
                        "lat" => $hubLat,
                        "lng" => $hubLong
                    ),
                    "shift_start" => date('H:i',strtotime($joe->start_time)),
                    "shift_end" => date('H:i',strtotime($joe->end_time)),
                    "capacity" => $capacity,
                    "min_visits_per_vehicle" => $joe->min_visits
                );
                $j++;
            }
        }
        $payload = array(
            "visits" => $visits,
            "fleet" => $shifts,
        );

        $res = json_encode($payload);
        $result = $this->client->getJobId($res);

        if (!empty($result->error)) {
            return json_encode([
                "status" => "Route Creation Error",
                "output" => $result->error
            ]);
        }

        $slotjob  = new  SlotJob();
        $slotjob->job_id=$result->job_id;
        $slotjob->hub_id=$hubId;
        $slotjob->engine = 2;
        $slotjob->mile_type = 2;
        $slotjob->unserved=null;
        $slotjob->save();

        return response()->json( ['status_code'=>200,"success"=> 'Request Submitted Job_id '.$result->job_id]);

    }

    public function getMidMileJobList(Request $request){

        $hubId = auth()->user()->hub_id;
        $date=$request->get('date');
        $hub_id=$request->get('id');
        if(empty($date)){
            $date=date('Y-m-d');
        }
        $lastMileJobs = $this->getRoutificJob($date,$hubId);
        return backend_view('midmile.job.list',compact('lastMileJobs','hubId'));
    }

    public function getRoutificJob($date,$id){

        $datas = SlotJob::whereNull('slots_jobs.deleted_at')
            ->where('slots_jobs.created_at','like',$date.'%')
            ->where('slots_jobs.hub_id','=',$id)
            ->where('slots_jobs.mile_type','=',2)
            ->get(['job_id','status','slots_jobs.id','engine']);

        return $datas;
    }

    public function getMidMileOrderCount($hub_id, $date)
    {
        $hubs = Hub::whereNull('deleted_at')->where('id', $hub_id)->first();
        $vendorIds = HubStore::where('hub_id', $hub_id)->WhereNull('deleted_at')->pluck('vendor_id');
        $created_at = date("Y-m-d", strtotime('-1 day', strtotime($date)));

        $sprints = Task::join('sprint__sprints','sprint__tasks.sprint_id','=','sprint__sprints.id')
            ->join('locations','sprint__tasks.location_id','=','locations.id')
            ->whereIn('sprint__sprints.creator_id',$vendorIds)
            ->where('type','=','pickup')
//            ->where('ordinal', '=', 1)
            ->whereIn('sprint__sprints.status_id',[127])
            ->take(2000)
            ->pluck('sprint__sprints.id');


        $joeyCount = Slots::where('hub_id', '=',  $hub_id)
            ->WhereNull('slots.deleted_at')
            ->where('mile_type',2)
            ->sum('joey_count');

        $vehicleTyp = Slots::where('hub_id', '=',  $hub_id)
            ->join('vehicles', 'vehicles.id', '=', 'slots.vehicle')
            ->WhereNull('slots.deleted_at')
            ->where('mile_type',2)
            ->get(['vehicles.name', 'slots.joey_count']);

        if($joeyCount==null){
            $joeyCount=0;
        }

        if($vehicleTyp->isEmpty()){
            $vehicleTyp[0]=['name'=>'','joey_count'=>''];
        }

        $response = ['title'=>$hubs->title,'id'=>$hubs->id,'orders' => count($sprints), 'joeys_count' => $joeyCount, 'slots_detail' => $vehicleTyp];

        return json_encode($response);


    }

    // get slots list data and view
    public function slotsListData($id)
    {
        $slots = Slots::whereNull('deleted_at')->where('hub_id','=',$id)->where('mile_type',2)->orderBy('id' , 'DESC')->get();
        return backend_view('midmile.slot.index', ['data'=> $slots, 'id'=> $id] );
    }

    // store first mile slots data
    public function storeMidMileSlot(Request $request)
    {
        $slot = new Slots();
        $slot->hub_id = $request->input('hub_id');
        $slot->vehicle = $request->input('vehicle');
        $slot->start_time = $request->input('start_time');
        $slot->end_time = $request->input('end_time');
        $slot->joey_count = $request->input('joey_count');
        $slot->custom_capacity = $request->input('custom_capacity');
        $slot->mile_type = 2;
        $slot->save();
        return back()->with('success','Slot Added Successfully!');
    }

    //get data of edit options
    public function getMidMileEditSlot($id)
    {
        $data=Slots::where('id','=',$id)->first();
        $d=['data'=>$data];
        return json_encode($d);
    }

    //first mile slot update
    public function midMileSlotUpdate(Request $request)
    {
        $id = $request->input('id_time');
        $slotsupdate = Slots::where('id', '=', $id)->first();
        $slotsupdate->vehicle = $request->input('vehicle_edit');
        $slotsupdate->start_time = $request->input('start_time_edit');
        $slotsupdate->end_time = $request->input('end_time_edit');
        $slotsupdate->joey_count = $request->input('joey_count_edit');
        $slotsupdate->custom_capacity = $request->input('custom_capacity_edit');
        $slotsupdate->save();
        return back()->with('success','Slot Updated Successfully!');

    }

    //delete first mile slot
    public function midMileSlotDelete(Request $request)
    {
        $id = $request->input('delete_id');
        Slots::where('id','=',$id)->update(['deleted_at'=>date('Y-m-d h:i:s')]);
        return redirect()->back()->with('success','slot Deleted Successfully!');
    }

    //get detail of slot
    public function getDetailOfMidMileSlot($id)
    {
        $data=Slots::where('id','=',$id)->first();
        $d=['data'=>$data];
        return json_encode($d);
    }

    public function createRouteForMidMile($id){

//        $url= "/jobs";

        $apiResponse = $this->client->getJobResponseByJobId($id);

//        $client = new Client($url);
//        $client->setJobID($id);
//        $apiResponse = $client->getJobResults();

//        dd($apiResponse->output);

//        return back()->with('error','Routes creation is in process');

        $job=SlotJob::where('job_id','=',$id)->first();

        SlotJob::where('job_id','=',$job->job_id)->update(['status'=>$apiResponse['status']]);

        if($apiResponse['status']=='finished'){

            $solution = $apiResponse['output']['solution'];

            if($apiResponse['output']['num_unserved'] > 0){
                return json_encode([
                    "status" => "Route Creation Error",
                    "output"=>$apiResponse['output']['num_unserved'] .' orders is un served'
                ]);
            }

            if(!empty($solution)){

                foreach ($solution as $key => $value){

                    if(count($value)>1){

                        $Route = new JoeyRoute();

                        //$Route->joey_id = $key;
                        $Route->date =date('Y-m-d H:i:s');
                        $Route->hub = $job->hub_id;
                        $Route->zone = $job->zone_id;
                        // $Route->total_travel_time=$apiResponse['output']['total_travel_time'];
                        if(isset($apiResponse['output']['total_working_time'])){
                            $Route->total_travel_time=$apiResponse['output']['total_working_time'];
                        }
                        else{
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
                        $Route->mile_type = 1;
                        $Route->save();

                        for($i=0;$i<count($value);$i++){
                            if($i>0){

//                                var_dump($value[$i]['location_id']);

                                JoeyRouteLocations::where('task_id','=',$value[$i]['location_id'])->update(['deleted_at'=>date('Y-m-d H:i:s')]);

                                $routeLoc = new JoeyRouteLocations();
                                $routeLoc->route_id = $Route->id;
                                $routeLoc->ordinal = $i;
                                $routeLoc->task_id = $value[$i]['location_id'];

                                if(isset($value[$i]['distance']) && !empty($value[$i]['distance'])){
                                    $routeLoc->distance = $value[$i]['distance'];
                                }

                                if(isset($value[$i]['arrival_time']) && !empty($value[$i]['arrival_time'])){
                                    $routeLoc->arrival_time = $value[$i]['arrival_time'];
                                    if(isset($value[$i]['finish_time'])){
                                        $routeLoc->finish_time = $value[$i]['finish_time'];
                                    }
                                }
                                $routeLoc->save();

//                                dd($value[$i]['location_id']);
//
//                                $sprint = Task::where('id','=',$value[$i]['location_id'])->first();
//
//                                Sprint::where('id','=',$sprint->sprint_id)->update(['in_hub_route'=>1]);

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
    }

    // delete job of first mile
    public function deleteMidMileJob(Request $request){

        SlotJob::where('id','=',$request->get('delete_id'))->update(['status'=>'finished','deleted_at'=>date('Y-m-d h:i:s')]);
        return redirect()->back();
    }

    public function midMileRoutesList(Request $request)
    {
        date_default_timezone_set("America/Toronto");

        if(empty($request->input('date'))){
            $date = date('Y-m-d');
        }
        else{
            $date = $request->input('date');
        }

        $countQry = "SELECT route_id,joey_routes.joey_id,joey_routes.`date`,
        CONCAT(zones_routing.title,'(',joey_routes.zone,')') AS zone,
        COUNT(joey_route_locations.id) AS counts,
        SUM(CASE WHEN sprint__sprints.status_id in(17,113,114,116,117,118,132,138,139,144,104,105,106,107,108,109,110,111,112,131,135,136) THEN 0 ELSE 1 END) AS d_counts,
        SUM(joey_route_locations.distance) AS distance,
        SUM(CASE WHEN sprint__sprints.status_id in(17,113,114,116,117,118,132,138,139,144,104,105,106,107,108,109,110,111,112,131,135,136) THEN 0 ELSE joey_route_locations.distance END) AS d_distance,
        SEC_TO_TIME(SUM(TIME_TO_SEC(finish_time)-TIME_TO_SEC(arrival_time))) AS duration,
        SEC_TO_TIME(SUM(CASE WHEN sprint__sprints.status_id in(17,113,114,116,117,118,132,138,139,144,104,105,106,107,108,109,110,111,112,131,135,136) THEN 0 ELSE TIME_TO_SEC(finish_time)-TIME_TO_SEC(arrival_time) END)) AS d_duration
        FROM joey_route_locations 
        JOIN sprint__tasks ON(task_id=sprint__tasks.id) 
        JOIN sprint__sprints ON(sprint_id=sprint__sprints.id) 
        JOIN joey_routes ON(route_id=joey_routes.id) 
        JOIN locations ON(location_id=locations.id)
        LEFT JOIN  zones_routing ON (zones_routing.id=joey_routes.zone AND zones_routing.`deleted_at` IS NULL)
        WHERE joey_routes.date LIKE '".$date."%'
        AND joey_routes.`mile_type` = 2
        AND sprint__tasks.`deleted_at` IS NULL
        AND joey_route_locations.`deleted_at` IS NULL 
        #AND zones_routing.`deleted_at` IS NULL
        AND joey_routes.deleted_at IS NULL GROUP BY route_id";


        $counts = DB::select($countQry);

//        dd($countQry->Sql());
        return backend_view('midmile.route.list',compact('counts'));
    }

    public function getRouteDetail($routeId)
    {
        $routes = JoeyRouteLocations::join('sprint__tasks','task_id','=','sprint__tasks.id')
            ->join('sprint__contacts','contact_id','=','sprint__contacts.id')
            ->join('locations','location_id','=','locations.id')
            ->where('route_id','=',$routeId)
            ->whereNull('joey_route_locations.deleted_at')
            ->orderBy('joey_route_locations.ordinal')
            ->get(['type','route_id','joey_route_locations.ordinal','sprint_id','name','phone','email','address','postal_code','latitude','longitude','distance']);


        $hub = Hub::find(auth()->user()->hub_id);

        return json_encode(['routes'=>$routes, 'hub' => $hub]);
    }

    public function midMileRouteEdit($routeId,$hubId){

        $route = $this->hubRouteEdit($routeId);
        return backend_view('midmile.route.edit',['route'=>$route,'hub_id'=>$hubId,"route_id"=>$routeId]);

    }

    public function hubRouteEdit($routeId){

        $route = JoeyRouteLocations::join('sprint__tasks','joey_route_locations.task_id','=','sprint__tasks.id')
            ->Join('merchantids','merchantids.task_id','=','sprint__tasks.id')
            ->join('locations','location_id','=','locations.id')
            ->join('sprint__sprints','sprint_id','=','sprint__sprints.id')
            // ->whereNotIn('sprint__sprints.status_id',[36,17])
            ->where('route_id','=',$routeId)
            ->whereNull('joey_route_locations.deleted_at')
            ->whereNull('sprint__sprints.deleted_at')
            ->whereNotNull('merchantids.tracking_id')
            ->orderBy('joey_route_locations.ordinal','asc')
            ->get([
                'joey_route_locations.id',
                'merchantids.merchant_order_num',
                'joey_route_locations.task_id',
                'merchantids.tracking_id',
                'sprint_id',
                'type',
                'due_time',
                'etc_time',
                'address',
                'postal_code',
                'joey_route_locations.arrival_time',
                'joey_route_locations.finish_time',
                'joey_route_locations.distance',
                'sprint__sprints.status_id',
                'joey_route_locations.is_transfered',
                'joey_route_locations.ordinal'
            ]);

        return $route;

    }

    public function RouteTransfer(Request $request){

        $routedata= JoeyRoute::where('id',$request->input('route_id'))->first();
        // dd($request->input('joey_id'));
        $joey_id=$routedata->joey_id;
        $routedata->joey_id=$request->input('joey_id');
        $routedata->save();

        // amazon entry data updated for joey tranfer in route
        $joey_data=Joey::where('id','=',$request->input('joey_id'))->first();
        AmazonEntry::where('route_id','=',$request->get('route_id'))->
        whereNUll('deleted_at')->whereNull('delivered_at')->whereNotIn('task_status_id',[104,105,106,107,108,109,110,111,112,131,135,136,101,102,103])->
        update(['joey_id'=>$request->input('joey_id'),'joey_name'=>$joey_data->first_name." ".$joey_data->last_name]);

        if($joey_id==null)
        {
            $route_history =new  RouteHistory();
            $route_history->route_id=$request->input('route_id');
            $route_history->joey_id=$request->input('joey_id');
            $route_history->route_location_id=NULL;
            $route_history->status=0;
            $route_history->save();
        }
        else
        {
            $route_history =new  RouteHistory();
            $route_history->route_id=$request->input('route_id');
            $route_history->joey_id=$request->input('joey_id');
            $route_history->route_location_id=NULL;
            $route_history->status=1;
            $route_history->save();
        }

        return response()->json(['status' => '1', 'body' => ['route_id'=>$request->route_id,'joey_id'=>$request->joey_id]]);

    }

    public function RouteMap($route_id){

        $routes = JoeyRouteLocations::join('sprint__tasks','task_id','=','sprint__tasks.id')
            ->join('locations','location_id','=','locations.id')
            ->where('route_id','=',$route_id)
            ->whereNull('joey_route_locations.deleted_at')
            ->orderBy('joey_route_locations.ordinal')
            ->get(['type','route_id','joey_route_locations.ordinal','sprint_id','address','postal_code','latitude','longitude']);

        $i=0;
        $data=[];

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

    public function reRoute($hubId,$routeId){

        $route = JoeyRouteLocations::join('sprint__tasks','joey_route_locations.task_id','=','sprint__tasks.id')
            ->join('locations','location_id','=','locations.id')
            ->join('merchantids','merchantids.task_id','=','joey_route_locations.task_id')
            ->whereNull('joey_route_locations.deleted_at')
            ->where('route_id','=',$routeId)
//            ->whereNotIn('status_id',[17,36])
            ->get(['joey_route_locations.task_id','sprint_id','address','latitude','longitude','due_time','etc_time']);

        if($route->count()<1){
            return "No order to route";
        }

        foreach($route as $routeLoc){

            $lat[0] = substr($routeLoc->latitude, 0, 2);
            $lat[1] = substr($routeLoc->latitude, 2);
            $latitude=$lat[0].".".$lat[1];

            $long[0] = substr($routeLoc->longitude, 0, 3);
            $long[1] = substr($routeLoc->longitude, 3);
            $longitude=$long[0].".".$long[1];

            $orders[$routeLoc->task_id]= array(
                "location" => array(
                    "name" => $routeLoc->address,
                    "lat" => $latitude,
                    "lng" => $longitude
                ),
                "start" => "09:00",
                "end" => "21:00",
                "load" => 1,
                "duration" => 2
            );
        }

        $hubPick = Hub::find($hubId);
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
        else{
            $error = new LogRoutes();
            $error->error = 'hub address or format is incorrect';
            $error->save();

            // $this->setResponse('hub address or format is incorrect',400);
            // return $this->getResponse();

            echo '<script>alert("hub address or format is incorrect")</script>';
            echo "<script> window.history.back(); </script>";

        }

        $joey['joey'] = array(
            "start_location" => array(
                "id" => 1,
                "name" => $hubPick->address,
                "lat" => $hubLat,
                "lng" => $hubLong
            ),
            "shift_start" => '09:00',
            "shift_end" => '21:00'
        );

        $options = array(
            "shortest_distance" => true,
            "polylines" => true
        );

        $payload = array(
            "visits" => $orders,
            "fleet" => $joey,
            "options" => $options
        );

        $client = new Client( '/pdp-long' );
        $client->setData($payload);
        $apiResponse= $client->send();

        if(!empty($apiResponse->solution)){
            foreach($apiResponse->solution as $solution){
                for($i=1;$i<count($solution);$i++){
                    JoeyRouteLocations::where('task_id','=',$solution[$i]->location_id)->update(['deleted_at' => date('Y-m-d H:i:s')]);

                    $routeLoc = new JoeyRouteLocations();
                    $routeLoc->route_id = $routeId;
                    $routeLoc->ordinal = $i;
                    $routeLoc->task_id = $solution[$i]->location_id;
                    $routeLoc->arrival_time = $solution[$i]->arrival_time;
                    $routeLoc->finish_time = $solution[$i]->finish_time;
                    $routeLoc->distance = $solution[$i]->distance;
                    $routeLoc->save();
                }
            }
            return "Route R-".$routeId." Rerouted Successfully";
        }

        return "Reroute FAILED";
    }

    public function midMileDeleteRoute($routeId){

        $route= JoeyRoute::where('id',$routeId)->first();
        if ($route){
            if (isset($route->joey_id)) {
                $deviceIds = UserDevice::where('user_id', $route->joey_id)->pluck('device_token');
                $subject = 'Deleted Route ' . $routeId;
                $message = 'Your route has been deleted ';
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

        JoeyRoute::where('id',$routeId)->update(['deleted_at'=>date('y-m-d H:i:s')]);
        return  "Route R-".$routeId." deleted Successfully";

    }

    public function getMidMileRouteHistory($id)
    {
        $routeData = $this->getRouteHistory($id);
        return backend_view('midmile.route.history',['routes'=>$routeData,'route_id'=>$id]);
    }

    public function getRouteHistory($id)
    {
        $routeData=RouteHistory::join('joeys','route_history.joey_id','=','joeys.id')
            ->leftjoin('merchantids','merchantids.task_id','=','route_history.task_id')
            ->leftjoin('dashboard_users','route_history.updated_by','=','dashboard_users.id')
            ->where('route_history.route_id','=',$id)
            ->whereNull('route_history.deleted_at')
            ->orderBy('route_history.created_at')->
            get(['route_history.id','route_history.route_id','route_history.status','route_history.joey_id','route_history.route_location_id',\DB::raw("CONVERT_TZ(route_history.created_at,'UTC','America/Toronto') as created_at")
                ,'route_history.ordinal','joeys.first_name','joeys.last_name','merchantids.tracking_id','route_history.type','route_history.updated_by','dashboard_users.full_name']);

        return $routeData;
    }

}