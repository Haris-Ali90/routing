<?php

namespace App\Http\Controllers\Backend;

use App\AssignMiJob;
use App\Classes\Fcm;
use App\CTCEntry;
use App\Http\Requests\Backend\MidMileJobRequest;
use App\Hub;
use App\HubStore;
use App\CurrentHubOrder;
use App\Joey;
use App\JoeyRoute;
use App\JoeyRouteLocations;
use App\LogRoutes;
use App\MicroHubOrder;
use App\MiJob;
use App\MiJobDetail;
use App\RouteHistory;
use App\SlotJob;
use App\Sprint;
use App\Task;
use App\User;
use App\UserDevice;
use App\UserNotification;
use App\Vendor;
use App\Classes\MidMileClient;
use Illuminate\Http\Request;
use App\MiJobRoute;

class MiJobController extends BackendController
{
    public $test = array("136" => "Client requested to cancel the order",
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
        "255" =>"Order delay",
        "145"=>"Returned To Merchant",
        "146" => "Delivery Missorted, Incorrect Address",
        "147" => "Scanned at hub",
        "148" => "Scanned at Hub and labelled",
        "149" => "pick from hub",
        "150" => "drop to other hub",
        '153' => 'Miss sorted to be reattempt',
        '154' => 'Joey unable to complete the route', '155' => 'To be re-attempted tomorrow',
        "151" => "",
        "152" => "",
    );

    private $client;

    /**
     * Create a new controller instance.
     *
     * @param MidMileClient $client
     */
    public function __construct(MidMileClient $client)
    {
        $this->client = $client;
    }

    public function index(Request $request)
    {
        $miJobs = MiJob::whereNull('deleted_at')->get();
        $hubs = Hub::whereNull('deleted_at')->get();
        return backend_view('mi_job.index', compact('miJobs', 'hubs'));
    }

    public function create()
    {
        $hubs = Hub::whereNull('deleted_at')->get();
        $stores = Vendor::whereNull('deleted_at')->get();
        return backend_view('mi_job.add', compact('hubs', 'stores'));
    }

    public function jobAssign(Request $request)
    {
        $hubId = $request->get('hub_id');
        $jobId = $request->get('job_id');

        $exists = AssignMiJob::where('hub_id', $hubId)->where('mi_job_id', $jobId)->exists();
        if($exists == false){
            AssignMiJob::create([
                'hub_id' => $request->get('hub_id'),
                'mi_job_id' => $request->get('job_id')
            ]);
        }else{
            return 'This job is already assign this hub';
        }

        return 'successfully assign this job';

    }

    // multi hub first and mid mile 2022-06-09
    public function store(MidMileJobRequest $request)
    {
        // sort main table data
        $mainTableData = $request->except('vendor_id', 'hub_id', 'start_time', 'end_time');
        //store time in variables
        $startTime = $request->get('start_time');
        $endTime = $request->get('end_time');
        $ids = $request->get('ids');
        $startType = $request->get('start_type');

        $range = 0;
        $locationType = [];

        if($ids == null){
            return redirect()->route('mi.job.create')->with('error', 'Please set start and end time');
        }

        if($request->get('start_latitude') == 0 && $request->get('start_longitude') == 0){
            return redirect()->route('mi.job.create')->with('error', 'Please set actual address in address field');
        }

        //insert mi job data
        $miJobId = MiJob::create($mainTableData);

        // define final sorting data variable
        $key = 0;
        foreach ($startTime as $data) {

            $finalSortData = [
                'mi_job_id' => $miJobId->id,
                'locationid' => $ids[$key],
                'location_type' => $startType[$key],
                'type' => 'pickup',
                'start_time' => ($startTime[$key] == "") ? null : $startTime[$key],
                'end_time' => ($endTime[$key] == "") ? null : $endTime[$key],
            ];
            $key++;
            MiJobDetail::create($finalSortData);
        }

        // finally sorted array to store mi job details table
        $finalSortData2 = [
            'mi_job_id' => $miJobId->id,
            'locationid' => $request->get('end_hub_id'),
            'location_type' => 'hub',
            'type' => 'dropoff',
            'start_time' => ($request->get('drop_start_time') == "") ? null : $request->get('drop_start_time'),
            'end_time' => ($request->get('drop_end_time') == "") ? null : $request->get('drop_end_time'),
        ];

        MiJobDetail::create($finalSortData2);

        return redirect()->route('mi.jobs')->with('success', 'Job created successfully');
    }

    public function edit(MiJob $mi_job)
    {
        $miJob = MiJob::with('jobDetails')->find($mi_job->id);

        $hubs = Hub::with('jobDetails')->whereNull('deleted_at')->get();
        $stores = Vendor::with('jobDetails')->whereNull('deleted_at')->get();

        return backend_view('mi_job.edit', compact('miJob','hubs', 'stores'));
    }

    public function detail(MiJob $mi_job)
    {
        $miJobDetail = MiJobDetail::where('mi_job_id', $mi_job->id)->whereNull('deleted_at')->get();
        return backend_view('mi_job.detail', compact('miJobDetail', 'mi_job'));
    }

    public function update(Request $request, MiJob $miJob)
    {

        // sort main table data
        $mainTableData = $request->except('vendor_id', 'hub_id', 'start_time', 'end_time');
        //store time in variables
        $startTime = $request->get('start_time');
        $endTime = $request->get('end_time');
        $ids = $request->get('ids');
        $startType = $request->get('start_type');
        // for inserting data set range of foreach
        $range = 0;
        $locationType = [];

        if($ids == null){
            return redirect()->route('mi.job.create')->with('error', 'Please set start and end time');
        }


        if($request->get('start_latitude') == 0 && $request->get('start_longitude') == 0){
            return redirect()->route('mi.job.edit', $miJob)->with('error', 'Please set actual address in address field');
        }


        //update mi job data
        $miJob->update($mainTableData);

        MiJobDetail::where('mi_job_id', $miJob->id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
        // define final sorting data variable

        $key = 0;
        foreach ($startTime as $data) {
            $finalSortData = [
                'mi_job_id' => $miJob->id,
                'locationid' => $ids[$key],
                'location_type' => $startType[$key],
                'type' => 'pickup',
                'start_time' => ($startTime[$key] == "") ? null : $startTime[$key],
                'end_time' => ($endTime[$key] == "") ? null : $endTime[$key],
            ];
            $key++;
            MiJobDetail::create($finalSortData);
        }

        // finally sorted array to store mi job details table
        $finalSortData2 = [
            'mi_job_id' => $miJob->id,
            'locationid' => $request->get('end_hub_id'),
            'location_type' => 'hub',
            'type' => 'dropoff',
            'start_time' => ($request->get('drop_start_time') == "") ? null : $request->get('drop_start_time'),
            'end_time' => ($request->get('drop_end_time') == "") ? null : $request->get('drop_end_time'),
        ];

        MiJobDetail::create($finalSortData2);

        return redirect()->route('mi.jobs')->with('success', 'Job updated successfully');
    }

    public function destroy($id)
    {

        MiJob::where('id',$id)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
        ]);

        MiJobDetail::where('mi_job_id', $id)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('mi.jobs')->with('error', 'Job deleted successfully');
    }

    public function getHubName(Request $request)
    {
        $hub = Hub::find($request->get('id'));
        return json_encode([
            "id" => $hub->id,
            "title" => $hub->title,
        ]);
    }

    public function getVendorName(Request $request)
    {
        $vendor = Vendor::find($request->get('id'));
        return json_encode([
            "id" => $vendor->id,
            "title" => $vendor->name,
        ]);
    }

    public function route(Request $request)
    {
        $jobId = $request->get('job_id');
        $date = $request->get('create_date');

        $miJobs = MiJob::join('mi_job_details', 'mi_job_details.mi_job_id', '=', 'mi_jobs.id')
            ->where('mi_jobs.id', $jobId)
            ->whereNull('mi_job_details.deleted_at')
            ->get(['mi_jobs.*', 'mi_jobs.type as mid_mile_type', 'mi_job_details.*']);

        $hubId = 0;
        $payload = [];
        $visits=[];
        $fleets=[];
        $mileType='';
        $sprintOrderCount=0;
        $hubOrderCount=0;

        foreach ($miJobs as $key => $miJob) {
            if ($miJob->type == 'pickup') {
                if ($miJob->location_type == 'store') {

                    $mileType=$miJob->location_type;
                    $vendor = Vendor::find($miJob->locationid);

                    $sprint = Sprint::where('creator_id', $miJob->locationid)
                        ->whereIn('status_id', [61,24])
                        ->whereNull('deleted_at')
                        ->count();

                    $sprintOrderCount += $sprint;

                    if($sprintOrderCount > 0){
                        if(isset($vendor)){
                            if($vendor->location){
                                $lat[0] = substr($vendor->location->latitude, 0, 2);
                                $lat[1] = substr($vendor->location->latitude, 2);
                                $latitude = $lat[0] . "." . $lat[1];

                                $long[0] = substr($vendor->location->longitude, 0, 3);
                                $long[1] = substr($vendor->location->longitude, 3);
                                $longitude = $long[0] . "." . $long[1];

                                $visits[$miJob->locationid] = [
                                    "location" => [
                                        "name" => $vendor->business_address,
                                        "lat" => $latitude,
                                        "lng" => $longitude,
                                    ],
                                    "duration" => 10,
                                ];
                                if($miJob->start_time != null){
                                    $visits[$miJob->locationid]['start'] = date('H:i',strtotime($miJob->start_time));
                                }
                                if($miJob->end_time != null){
                                    $visits[$miJob->locationid]['end'] = date('H:i',strtotime($miJob->end_time));
                                }
                            }
                        }
                    }
                }

                if ($miJob->location_type == 'hub') {

                    $mileType=$miJob->location_type;
                    $user = User::where('hub_id', $miJob->locationid)->pluck('id');

                    $hubids = MicroHubOrder::getHubIds($miJob->locationid,$user);

                    $microHubOrder = MicroHubOrder::whereHas('sprint', function($query){
                        $query->whereIn('status_id', [148])->whereNotIn('status_id', [36]);
                    })->where('is_my_hub', 0)
                        ->whereIn('scanned_by',$user)
                        ->whereNull('deleted_at')
                        ->count();

                    $sprintIds = CurrentHubOrder::where('hub_id', $miJob->locationid)->where('is_actual_hub', 0)->pluck('sprint_id');
                    $hubBundleOther = MicroHubOrder::whereHas('sprint', function($query) {
                        $query->where('status_id', 150)->whereNotIn('status_id', [36]);
                    })->whereIn('sprint_id',$sprintIds)->count();

                    $hubOrderCount += $microHubOrder + $hubBundleOther;

                    if($hubOrderCount > 0){

                        $hub = Hub::find($miJob->locationid);
                        if(isset($hub)){
                            if(in_array($miJob->locationid, $hubids)) {
                                $visits[$miJob->locationid] = [
                                    "location" => [
                                        "name" => $hub->address,
                                        "lat" => $hub->hub_latitude,
                                        "lng" => $hub->hub_longitude,
                                    ],
                                    "duration" => 10,
                                ];

                                if ($miJob->start_time != null) {
                                    $visits[$miJob->locationid]['start'] = date('H:i', strtotime($miJob->start_time));
                                }
                                if ($miJob->end_time != null) {
                                    $visits[$miJob->locationid]['end'] = date('H:i', strtotime($miJob->end_time));
                                }
                            }
                        }
                    }

                }

            }
            if ($miJob->type == 'dropoff') {
                $hub = Hub::find($miJob->locationid);
                $fleets[$miJob->locationid] = array(
                    "start_location" => array(
                        "name" => $miJob->start_address,
                        "lat" => $miJob->start_latitude,
                        "lng" => $miJob->start_longitude
                    ),
                    "end_location" => array(
                        "name" => $hub->address,
                        "lat" => $hub->hub_latitude,
                        "lng" => $hub->hub_longitude
                    ),
                    "shift_start" => date('H:i',strtotime($miJob->start_time)),
                    "shift_end" => date('H:i',strtotime($miJob->end_time)),
                );
                $hubId = $hub->id;
            }
        }

        if($sprintOrderCount == 0 && $hubOrderCount == 0){
            return json_encode([
                "status" => "Route Creation Error",
                "output"=> 'No order in this job'
            ]);
        }

        $payload = array(
            "visits" => $visits,
            "fleet" => $fleets,
        );

        $res = json_encode($payload);
        $result = $this->client->getJobId($res);

        if(isset($result->solution)){
            $solution = $result->solution;
            if($result->num_unserved > 0){
                return json_encode([
                    "status" => "Route Creation Error",
                    "output"=> 'Something went wrong, please contact your administrator'
                ]);
            }
            if(!empty($solution)){
                foreach ($solution as $key => $value){
                    if(count($value)>1){

                        $miJobDetail = MiJobDetail::where('location_type', 'store')->where('mi_job_id', $jobId)->first();
                        $routeType = 2;
                        if(isset($miJobDetail)){
                            if($miJobDetail->location_type == 'store'){
                                $routeType = 4;
                            }
                        }

                        $Route = new JoeyRoute();
                        $Route->date =date('Y-m-d H:i:s');
                        $Route->hub = $hubId;
                        if(isset($result->total_working_time)){
                            $Route->total_travel_time=$result->total_working_time;
                        }
                        else{
                            $Route->total_travel_time=0;
                        }
                        if(isset($result->total_distance))
                        {
                            $Route->total_distance=$result->total_distance;
                        }
                        else
                        {
                            $Route->total_distance=0;
                        }
                        $Route->mile_type = $routeType;
                        $Route->save();

                        MiJobRoute::create([
                            'route_id' => $Route->id,
                            'mi_job_id' => $jobId,
                        ]);

                        for($i=0;$i<count($value);$i++){
                            if($i>0){

                                $routeLoc = new JoeyRouteLocations();
                                $routeLoc->route_id = $Route->id;
                                $routeLoc->ordinal = $i;
                                $routeLoc->task_id = $value[$i]->location_id;

                                if(isset($value[$i]->distance) && !empty($value[$i]->distance)){
                                    $routeLoc->distance = $value[$i]->distance;
                                }

                                if(isset($value[$i]->arrival_time) && !empty($value[$i]->arrival_time)){
                                    $routeLoc->arrival_time = $value[$i]->arrival_time;
                                    if(isset($value[$i]->finish_time)){
                                        $routeLoc->finish_time = $value[$i]->finish_time;
                                    }
                                }
                                $routeLoc->save();

                            }
                        }

                    }
                }
                return response()->json(['status_code' => 200, "success" => 'Route has been created successfully']);
            }
        }else{
            return json_encode([
                "status" => "Route Creation Error",
                "output"=> "Something went wrong, please contact your administrator"
            ]);
        }



    }

    public function createJob(Request $request)
    {
        $date=$request->get('date');
        if(empty($date)){
            $date=date('Y-m-d');
        }
        $miJobs = $this->getRoutificJob($date);
        return backend_view('mi_job.job.list',compact('miJobs'));
    }

    public function getRoutificJob($date){

        $datas = SlotJob::whereNull('slots_jobs.deleted_at')
            ->where('slots_jobs.created_at','like',$date.'%')
            ->where('slots_jobs.mile_type','=',4)
            ->get(['job_id','status','slots_jobs.id','engine']);

        return $datas;
    }

    public function createRoute($id){

        $apiResponse = $this->client->getJobResponseByJobId($id);

        if($apiResponse['status'] == 'finished'){
            $solution = $apiResponse['output']['solution'];

            if($apiResponse['output']['num_unserved'] > 0){
                return json_encode([
                    "status" => "Route Creation Error",
                    "output"=> $apiResponse['output']['num_unserved'] .' locations unserved'
                ]);
            }

            $job=SlotJob::where('job_id','=',$id)->first();
            SlotJob::where('job_id','=',$job->job_id)->update(['status'=>$apiResponse['status']]);

//            dd($solution);

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
                        $Route->mile_type = 4;
                        $Route->save();

                        for($i=0;$i<count($value);$i++){
                            if($i>0){

                                //JoeyRouteLocations::where('task_id','=',$value[$i]['location_id'])->update(['deleted_at'=>date('Y-m-d H:i:s')]);

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

                            }
                        }

                    }
                }
                return json_encode([
                    "output"=> 'Route Created Successfully',
                    "status" => 200
                ]);
            }
        }
        else{

            $error = new LogRoutes();
            $error->error = $id." is in ".$apiResponse['status'];
            $error->save();
            return back()->with('error','Routes creation is in process');
        }

    }

    public function deleteMiJob(Request $request){

        SlotJob::where('id','=',$request->get('delete_id'))->update(['status'=>'finished','deleted_at'=>date('Y-m-d h:i:s')]);
        return redirect()->back()->with('success', 'job deleted successfully');
    }

    public function miJobRoutesList(Request $request)
    {
        date_default_timezone_set("America/Toronto");

        if(empty($request->input('date'))){
            $date = date('Y-m-d');
        }
        else{
            $date = $request->input('date');
        }


        $routes = JoeyRoute::join('joey_route_locations','joey_route_locations.route_id' ,'=', 'joey_routes.id')
            ->Leftjoin('joeys', 'joeys.id', '=', 'joey_routes.joey_id')
            ->whereNull('joey_route_locations.deleted_at')
            ->whereNull('joey_routes.deleted_at')
            ->whereIn('mile_type',[4,2])
            ->where('date', 'LIKE', $date.'%')
            ->groupBy('joey_route_locations.route_id')
            ->get();

//        dd($routes);

        return backend_view('mi_job.route.list',compact('routes'));
    }

    public function getRouteDetail(Request $request, $routeId)
    {

        if(empty($request->input('date'))){
            $date = date('Y-m-d');
        }
        else{
            $date = $request->input('date');
        }

        // get all tasks ids in joey locations table
        $taskIds = JoeyRouteLocations::where('route_id',$routeId)->pluck('task_id')->toArray();

        // get last drop off task id
        $lastLocationId = JoeyRouteLocations::where('route_id',$routeId)->pluck('task_id')->last();

        $miJobRoute = MiJobRoute::where('route_id', $routeId)->first();

        $miJobLocationId = MiJobDetail::where('type', 'pickup')->where('mi_job_id', $miJobRoute->mi_job_id)->whereIn('locationid', $taskIds)->pluck('locationid')->toArray();

        $startHub = MiJob::find($miJobRoute->mi_job_id);
        $scannedBy = User::whereIn('hub_id', $miJobLocationId)->pluck('id')->toArray();
        //get sprint ids against ids variable
        $hubBundles = MicroHubOrder::whereHas('sprint', function($query){
            $query->where('status_id', 148)->whereNotIn('status_id', [36])->whereNull('deleted_at');
        })->where('is_my_hub', 0)
            ->whereIn('scanned_by', $scannedBy)
            ->whereNull('deleted_at')
//            ->where('created_at', 'LIKE', $date.'%')
            ->groupBy('hub_id')
            ->pluck('sprint_id')
            ->toArray();

        $sprintIds = CurrentHubOrder::whereIn('hub_id', $miJobLocationId)->where('is_actual_hub', 0)->pluck('sprint_id');

        $otherHubBundles = MicroHubOrder::whereHas('sprint', function($query) {
                $query->whereIn('status_id', [150])->whereNotIn('status_id', [36])->whereNull('deleted_at');
         })->whereIn('sprint_id',$sprintIds)
//            ->whereDate('created_at', 'LIKE', $date.'%')
            ->whereNull('deleted_at')
            ->groupBy('bundle_id')
            ->pluck('sprint_id')
            ->toArray();



        $microhubBundle = array_merge($hubBundles, $otherHubBundles);
        $hubBundlesData=[];
        $uniqueSprintId = array_unique($microhubBundle);

        foreach ($uniqueSprintId as $hubBundle){
            $orderActualHub = MicroHubOrder::where('sprint_id', $hubBundle)->first();

            $hub = Hub::find($orderActualHub['hub_id']);
            $microHubOrderCount = MicroHubOrder::where('is_my_hub', 0)->where('bundle_id', $orderActualHub['bundle_id'])->count();
            $hubBundlesData[] =[
                'id' => 'MMB-'.$orderActualHub['hub_id'],
                'bundle_id' => $orderActualHub['bundle_id'],
                'reference_no' => 'MR-'.$miJobRoute->mi_job_id,
                'hub_name' => $hub->title,
                'address' => $hub->address,
                'latitude' => $hub->hub_latitude,
                'longitude' => $hub->hub_longitude,
                'no_of_order' => $microHubOrderCount
            ];
        }

        //get last dropOff hub
        $hub = Hub::find($lastLocationId);

        return json_encode(['routes'=>$hubBundlesData, 'hub' => $hub, 'pickUpHub' => $startHub, 'reference_id' => $miJobRoute->mi_job_id]);

    }

    //edit page of routes
    public function miJobRouteEdit(Request $request, $routeId){

        $route = $this->hubRouteEdit($routeId, $request);
        return backend_view('mi_job.route.edit',['route'=>$route,"route_id"=>$routeId]);

    }

    //get data of route for edit page
    public function hubRouteEdit($routeId, $request){

        if(empty($request->input('date'))){
            $date = date('Y-m-d');
        }
        else{
            $date = $request->input('date');
        }

        // get all tasks ids in joey locations table
        $taskIds = JoeyRouteLocations::where('route_id',$routeId)->pluck('task_id')->toArray();
        // get last drop off task id
//        $lastLocationId = JoeyRouteLocations::where('route_id',$routeId)->pluck('task_id')->last();
        $miJobRoute = MiJobRoute::where('route_id', $routeId)->first();
        $miJobLocationId = MiJobDetail::where('mi_job_id', $miJobRoute->mi_job_id)->whereIn('locationid', $taskIds)->pluck('locationid')->toArray();

//        $startHub = MiJob::find($miJobRoute->mi_job_id);
        $scannedBy = User::whereIn('hub_id', $miJobLocationId)->pluck('id')->toArray();
        //get sprint ids against ids variable
        $hubBundles = MicroHubOrder::whereHas('sprint', function($query){
            $query->where('status_id', 148)->whereNotIn('status_id', [36])->whereNull('deleted_at');
        })->where('is_my_hub', 0)
            ->whereIn('scanned_by', $scannedBy)
            ->whereNull('deleted_at')
//            ->where('created_at', 'LIKE', $date.'%')
            ->groupBy('hub_id')
            ->pluck('sprint_id')
            ->toArray();

        $sprintIds = CurrentHubOrder::whereIn('hub_id', $miJobLocationId)->where('is_actual_hub', 0)->pluck('sprint_id');

        $otherHubBundles = MicroHubOrder::whereHas('sprint', function($query) {
            $query->whereIn('status_id', [150])->whereNotIn('status_id', [36])->whereNull('deleted_at');
        })->whereIn('sprint_id',$sprintIds)
//            ->whereDate('created_at', 'LIKE', $date.'%')
            ->whereNull('deleted_at')
            ->groupBy('bundle_id')
            ->pluck('sprint_id')
            ->toArray();

        $microhubBundle = array_merge($hubBundles, $otherHubBundles);

//        $sprints = Sprint::whereIn('creator_id', $taskIds)
//            ->where('status_id', 61)
//            ->whereNotIn('status_id', [36])
//            ->where('created_at', 'LIKE', $date.'%')
//            ->whereNull('deleted_at')
//            ->pluck('id')
//            ->toArray();
//
//        $vendorSprint=[];
//        foreach($sprints as $sprint){
//            $vendorSprint[] = [
//                'vendor_id' =>$sprint->creator_id,
//            ];
//        }
//
//        $microhubBundle = array_merge($hubBundles, $otherHubBundles);
//        $uniqueSprintId = array_unique($microhubBundle);
        $hubBundlesData=[];

        foreach ($microhubBundle as $hubBundle){
            $orderActualHub = MicroHubOrder::where('sprint_id', $hubBundle)->first();

            $hub = Hub::find($orderActualHub['hub_id']);
            $microHubOrderCount = MicroHubOrder::where('is_my_hub', 0)->where('bundle_id', $orderActualHub['bundle_id'])->count();
            $hubBundlesData[] =[
                'id' => 'MMB-'.$orderActualHub['hub_id'],
                'bundle_id' => $orderActualHub['bundle_id'],
                'reference_no' => 'MR-'.$miJobRoute->mi_job_id,
                'hub_id' => $orderActualHub['hub_id'],
                'hub_name' => $hub->title,
                'address' => $hub->address,
                'latitude' => $hub->hub_latitude,
                'longitude' => $hub->hub_longitude,
                'no_of_order' => $microHubOrderCount
            ];
        }

        return $hubBundlesData;

    }

    public function routeTransfer(Request $request)
    {
        $routedata= JoeyRoute::where('id',$request->input('route_id'))->first();

        $joey_id=$routedata->joey_id;
        $routedata->joey_id=$request->input('joey_id');
        $routedata->save();

        // amazon entry data updated for joey tranfer in route
        $joey_data=Joey::where('id','=',$request->input('joey_id'))->first();
        // AmazonEntry::where('route_id','=',$request->get('route_id'))->
        //              whereNUll('deleted_at')->whereNull('delivered_at')->whereNotIn('task_status_id',[104,105,106,107,108,109,110,111,112,131,135,136,101,102,103])->
        //              update(['joey_id'=>$request->input('joey_id'),'joey_name'=>$joey_data->first_name." ".$joey_data->last_name]);

        $task_ids=JoeyRouteLocations::where('route_id','=',$request->get('route_id'))->whereNull('deleted_at')->pluck('task_id');

        $ctcEntriesSprintId=CTCEntry::whereIn('task_id',$task_ids)
            ->whereNUll('deleted_at')
            ->whereNotIn('task_status_id',[104,105,106,107,108,109,110,111,112,131,135,136,101,102,103])
            ->pluck('sprint_id');
        if ($ctcEntriesSprintId) {
            CTCEntry::whereIn('sprint_id',$ctcEntriesSprintId)->
            update(['joey_id'=>$request->input('joey_id'),'joey_name'=>$joey_data->first_name." ".$joey_data->last_name]);
        }
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

        $deviceIds = UserDevice::where('user_id',$request->input('joey_id'))->pluck('device_token');
        $subject = 'New Route '.$request->input('route_id');
        $message = 'You have assigned new route';
        Fcm::sendPush($subject, $message,'ecommerce',null, $deviceIds);
        $payload =['notification'=> ['title'=> $subject,'body'=> $message,'click_action'=> 'ecommerce'],
            'data'=> ['data_title'=> $subject,'data_body'=> $message,'data_click_action'=> 'ecommerce']];
        $createNotification= [
            'user_id' => $request->input('joey_id'),
            'user_type'  => 'Joey',
            'notification'  => $subject,
            'notification_type'  => 'ecommerce',
            'notification_data'  => json_encode(["body"=> $message]),
            'payload'            => json_encode($payload),
            'is_silent'          => 0,
            'is_read'            => 0,
            'created_at'         => date('Y-m-d H:i:s')
        ];
        UserNotification::create($createNotification);

        if($joey_id != null)
        {
            if ($joey_id != $request->input('joey_id'))
            {
                $deviceIds = UserDevice::where('user_id',$joey_id)->where('is_deleted_at', 0)->pluck('device_token');
                $subject = 'Route Transferred '.$request->input('route_id');
                $message = 'Your route has been transferred to another joey';
                Fcm::sendPush($subject, $message,'ecommerce',null, $deviceIds);
                $payload =['notification'=> ['title'=> $subject,'body'=> $message,'click_action'=> 'ecommerce'],
                    'data'=> ['data_title'=> $subject,'data_body'=> $message,'data_click_action'=> 'ecommerce']];
                $createNotification= [
                    'user_id' => $joey_id,
                    'user_type'  => 'Joey',
                    'notification'  => $subject,
                    'notification_type'  => 'ecommerce',
                    'notification_data'  => json_encode(["body"=> $message]),
                    'payload'            => json_encode($payload),
                    'is_silent'          => 0,
                    'is_read'            => 0,
                    'created_at'         => date('Y-m-d H:i:s')
                ];
                UserNotification::create($createNotification);
            }
        }

        return response()->json(['status' => '1', 'body' => ['route_id'=>$request->route_id,'joey_id'=>$request->joey_id]]);

    }

    public function RouteMap(Request $request, $route_id){

        if(empty($request->input('date'))){
            $date = date('Y-m-d');
        }
        else{
            $date = $request->input('date');
        }
        // get all tasks ids in joey locations table
        $miJobId = MiJobRoute::where('route_id', $route_id)->pluck('mi_job_id');
        $miJobDetails = MiJobDetail::whereIn('mi_job_id', $miJobId)->get();
        $i=0;
        $data=[];
        foreach($miJobDetails as $miJobDetail){
            if($miJobDetail->type == 'pickup'){
                if($miJobDetail->location_type == 'store'){
                    $vendor = Vendor::whereNull('deleted_at')->find($miJobDetail->locationid);

                    $name = $vendor->name;
                    $address = $vendor->business_address;

                    $lat[0] = substr($vendor->latitude, 0, 2);
                    $lat[1] = substr($vendor->latitude, 2);
                    $dataLatitude = floatval($lat[0].".".$lat[1]);

                    $long[0] = substr($vendor->longitude, 0, 3);
                    $long[1] = substr($vendor->longitude, 3);
                    $dataLongitude = floatval($long[0].".".$long[1]);

                    if($vendor->business_address == null){
                        $address = $vendor->location->address;

                        $lat[0] = substr($vendor->location->latitude, 0, 2);
                        $lat[1] = substr($vendor->location->latitude, 2);
                        $dataLatitude = floatval($lat[0].".".$lat[1]);

                        $long[0] = substr($vendor->location->longitude, 0, 3);
                        $long[1] = substr($vendor->location->longitude, 3);
                        $dataLongitude = floatval($long[0].".".$long[1]);
                    }
                }
                if($miJobDetail->location_type == 'hub'){
                    $hub = Hub::whereNull('deleted_at')->find($miJobDetail->locationid);
                    $name = $hub->title;
                    $address = $hub->address;
                    $dataLatitude = $hub->hub_latitude;
                    $dataLongitude = $hub->hub_longitude;
                }
            }
            if($miJobDetail->type == 'dropoff'){
                if($miJobDetail->location_type == 'hub'){
                    $hub = Hub::whereNull('deleted_at')->find($miJobDetail->locationid);
                    $name = $hub->title;
                    $address = $hub->address;
                    $dataLatitude = $hub->hub_latitude;
                    $dataLongitude = $hub->hub_longitude;
                }
            }


            $data[$i]['latitude'] = $dataLatitude;
            $data[$i]['longitude'] = $dataLongitude;
            $data[$i]['address'] = $address;
            $data[$i]['id'] = $miJobDetail->locationid;
            $data[$i]['name'] = $name;
            $data[$i]['type'] = $miJobDetail->type;
            $i++;
        }

        return json_encode($data);
    }

    public function miJobDeleteRoute($routeId){

        $route= JoeyRoute::where('id',$routeId)->first();
        if ($route){
            if (isset($route->joey_id)) {
                $deviceIds = UserDevice::where('user_id', $route->joey_id)->where('is_deleted_at', 0)->pluck('device_token');
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

    public function miJobRouteHistory($id)
    {
        $routeData = $this->getRouteHistory($id);
        return backend_view('mi_job.route.history',['routes'=>$routeData,'route_id'=>$id]);
    }

    public function getRouteHistory($id)
    {
        $routeData=RouteHistory::join('joeys','route_history.joey_id','=','joeys.id')
            ->leftjoin('merchantids','merchantids.task_id','=','route_history.task_id')
            ->leftjoin('dashboard_users','route_history.updated_by','=','dashboard_users.id')
            ->where('route_history.route_id','=',$id)
            ->whereNull('route_history.deleted_at')
            ->orderBy('route_history.created_at')->
            get(['route_history.id','route_history.route_id','route_history.status','route_history.joey_id','route_history.route_location_id','route_history.created_at'
                ,'route_history.ordinal','joeys.first_name','joeys.last_name','merchantids.tracking_id','route_history.type','route_history.updated_by','dashboard_users.full_name']);

        return $routeData;
    }

    public function orderDetail(Request $request, $hubId, $bundleId)
    {
        $date = date('Y-m-d');

        $microHubBundle = MicroHubOrder::where('is_my_hub', 0)->where('bundle_id',$bundleId)->whereNull('deleted_at')->get();

        $data=[];
        foreach($microHubBundle as $hubOrder){
            $sprint = Sprint::with('sprintTask', 'sprintTask.merchantIds')
                ->whereHas('sprintTask', function ($query){
                    $query->where('type', 'dropoff');
                })->whereNull('deleted_at')->find($hubOrder->sprint_id);

            $hub = Hub::whereNull('deleted_at')->find($hubOrder->hub_id);

            $trackingId='';
            $merchantOrderNo='';
            if (isset($sprint->sprintTask)) {
                foreach($sprint->sprintTask as $task){
                    if($task->type == 'dropoff'){
                        if(isset($task->merchantIds)){
                            $trackingId = ($task->merchantIds->tracking_id) ? $task->merchantIds->tracking_id : '';
                            $merchantOrderNo = ($task->merchantIds->merchant_order_num) ? $task->merchantIds->merchant_order_num : '';
                        }
                    }
                }
            }

            $data[] = [
                'id' => $hubOrder->id,
                'bundle_id' => 'MMB-'.$hub->id,
                'hub_name' => $hub->title,
                'hub_address' => $hub->address,
                'sprint_id' => 'CR-'.$hubOrder->sprint_id,
                'tracking_id' => $trackingId,
                'merchant_order_no' => $merchantOrderNo,
                'status_id' => $sprint->status_id,
            ];
        }

        return json_encode(['details'=>$data, 'statuses' => $this->test]);
    }

}
