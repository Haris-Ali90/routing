<?php

namespace App\Http\Controllers\Backend;
use App\Classes\AmazonXmlOrder;

use App\ProcessedXmlFiles;
use App\MainfestFields;
use App\VendorZone;
use App\SlotsPostalCode;
use App\MerchantIds;
use App\RoutingZones;
use App\Location;
use App\Sprint;
use App\Task;
use App\TaskHistory;
use App\SlotJob;
use App\Hub;
use App\Client;
use App\Slots;
use App\AmazonEntry;
use App\LocationUnencrypted;
use Illuminate\Http\Request;


class AmazonOrderController extends BackendController
{

     public function amazonOrderCreation()
    {

     
        return backend_view( 'amazonorder.index');
    }
    public function postAmazonOrderCreation(Request $request)
    {
        
        $file = $request->xmllFile;
        $AmazonXmlOrder=new AmazonXmlOrder($request->xmllFile,$request->hub);
        if(!$AmazonXmlOrder->validateXmlFile())
        {
            return back()->with('error', 'Only XML file allow to process');
        }
        if($AmazonXmlOrder->checkIfFileAlreadyProcessed())
        {
            return back()->with('error', 'XML file already processed');
        }
        $AmazonXmlOrder->setXmlFileContent();

        if (!$AmazonXmlOrder->getXmlFileContent())
        {
            return back()->with('error', 'No data found in file');

        }
        $Rresponse=$AmazonXmlOrder->post_xml_order();
        if($Rresponse['status_code']==200)
        {
            return back()->with('success', $Rresponse['success']);
        }
        else
        {
            return back()->with('error', $Rresponse['error']);
        }

    }

    public function manifestRoutes($id,Request $request)
    {
        $date=$request->get('date');
        if($date==null)
        {
            $date=date('Y-m-d');
        }
        if($id==16)
        {
            $vendor_id=477260;
        }
        else
        {
            $vendor_id=477282;
        }
        
        $date_change = date('Y-m-d', strtotime($date . ' -1 days'));

       $files= MainfestFields::
        where(\DB::raw("CONVERT_TZ(created_at,'UTC','America/Toronto')"),'like',$date_change."%")->
        where('vendor_id','=',$vendor_id)->
        distinct('manifestNumber')->
        get(['manifestNumber','warehouseLocationID']);
      
       $zoneRoutingData=[];
        return backend_view( 'amazonorder.manifestfile',compact('date','files','zoneRoutingData','vendor_id'));
    }
    public function manifestRoutesData(Request $request)
    {
        $mainfest_no=[];
        $mainfest_no=explode(',',$request->get('files'));
               
        $sprint_id=MainfestFields::whereIn('manifestNumber',$mainfest_no)->pluck('sprint_id')->toArray();
           
        $orders = [];
        if($request->get('vendor_id')=='477260')
        {
            $hub_id=16;
        }
        else
        {
            $hub_id=19;  
        }
         
        $sprint_id=Sprint::whereIn('id',$sprint_id)->whereNull('deleted_at')->pluck('id')->toArray();

        $total_orders_locations = Task::join("sprint__sprints", 'sprint__sprints.id', '=', 'sprint__tasks.sprint_id')
        ->where('sprint__tasks.type', '=', 'dropoff')
        ->whereIn('sprint__sprints.id', $sprint_id)
        ->whereNull('sprint__sprints.deleted_at')
        ->whereNull('sprint__tasks.deleted_at')
        ->pluck('location_id')->toArray();
       
        $not_in_route_locations =Task::join("sprint__sprints", 'sprint__sprints.id', '=', 'sprint__tasks.sprint_id')
        ->where('sprint__tasks.type', '=', 'dropoff')
        ->whereIn('sprint__sprints.id', $sprint_id)
        ->where('in_hub_route',0)
        ->whereNull('sprint__sprints.deleted_at')
        ->whereNull('sprint__tasks.deleted_at')
        ->whereIn('sprint__sprints.status_id',[61,13])
        ->pluck('location_id')->toArray();

        $zones= RoutingZones::where('zones_routing.hub_id','=',$hub_id)
        ->whereNull('is_custom_routing')
        ->whereNull('deleted_at')
        ->orderBy('zones_routing.id','DESC')->get();
        
        foreach ($zones as $zone)
        {
          
            $zone_postal_code=SlotsPostalCode::where('zone_id','=',$zone->id)->whereNull('deleted_at')->pluck('postal_code')->toArray();
            if(count($zone_postal_code)!=0)
            {
                
                $totalorders=0;
                $orders_not_route=[];
                foreach($zone_postal_code as $postals){
                    
                   $totalorders += LocationUnencrypted::where('locations.postal_code','like',$postals.'%')->whereIn('id',$total_orders_locations)->pluck('id')->count();
                  
                   $orders_not_route=array_merge($orders_not_route,LocationUnencrypted::where('locations.postal_code','like',$postals.'%')->whereIn('id',$not_in_route_locations)->pluck('id')->toArray()); 
                   
                }
                $vehicles = Slots::
                 where('zone_id', '=', $zone->id)->
                 join('vehicles', 'vehicles.id', '=', 'slots.vehicle')->
                 WhereNull('slots.deleted_at')->
                 get(['vehicles.name', 'slots.joey_count','custom_capacity']);
                 $joeyCount=0;
                 $custom_capacity=0;
                 $vehicles_data=null;
                 foreach($vehicles as $vehicle)
                 {
                    $joeyCount+=$vehicle->joey_count;
                    $custom_capacity+=$vehicle->custom_capacity;
                    if(isset($vehicles_data[$vehicle->name]))
                    {
                        $vehicles_data[$vehicle->name]++;
                    }
                    else
                    {
                        $vehicles_data[$vehicle->name]=1;
                    }
                 }
                 $vehicles=null;
                 foreach($vehicles_data as $key => $vehicle) {
                   $vehicles.=$key.": ".$vehicle ."<br>";
                  }

                   
                    $order['order_count']=$totalorders;
                    $order['not_in_route_ids']=$orders_not_route;
                    $order['not_in_route']= count($orders_not_route);
                    $order['zone_id']=$zone->id;
                    $order['zone_name']=$zone->title;
                    $order['joeycount']=$joeyCount;
                    $order['custom_capacity']=$custom_capacity;
                    $order['vehicles_data']= $vehicles;
                    $orders[]=$order;
                                   
            }
          
        }
      
        if(count($orders)==0)
        {
            return response()
            ->json(['status_code' => 400, 'orders' => $orders,'hub_id'=>$hub_id]); 
        }
        return response()
        ->json(['status_code' => 200, 'orders' => $orders,'hub_id'=>$hub_id]);
        //  dd($orders);
       
       
    }

    public function manifestRouteCreate(Request $request)
    {
            $zoneId=$request->get('zone_id');
            $hub_id=$request->get('hub_id');
            $orders=[];
            $locations=LocationUnencrypted::whereIn('id',explode(',',$request->get('not_in_route_ids')))->get();
        
            foreach($locations as $location)
            {
                      $task=$location->LocationTask;
                      $sprint=$task->getSprint;

                      $lat[0] = substr($location->latitude, 0, 2);
                      $lat[1] = substr($location->latitude, 2);
                      $latitude = $lat[0] . "." . $lat[1];
          
                      $long[0] = substr($location->longitude, 0, 3);
                      $long[1] = substr($location->longitude, 3);
                      $longitude = $long[0] . "." . $long[1];
          
                      if (empty($location->city_id) || $location->city_id == NULL)
                      {
                          $dropoffAdd = LocationUnencrypted::canadian_address($location->address . ',' . $location->postal_code . ',canada');
                          $latitude = $dropoffAdd['lat'];
                          $longitude = $dropoffAdd['lng'];
                      }
          
                      $orders[$sprint->id] = array(
                          "location" => array(
                              "name" => $location->address,
                              "lat" => $latitude,
                              "lng" => $longitude
                          ) ,
                          "load" => 1,
                          "duration" => 2
                      );

            }
          
            
           $joeycounts=Slots::join('vehicles','slots.vehicle','=','vehicles.id')
           ->where('slots.zone_id','=',$zoneId)
           ->whereNull('slots.deleted_at')
           ->get(['vehicles.capacity','vehicles.min_visits','slots.start_time','slots.end_time','slots.hub_id','slots.joey_count','custom_capacity']);
        //    ->get(['vehicles.id', 'vehicles.capacity', 'custom_joey_detail.joeys_count']);
        return response()
        ->json($this->createJobId($orders,$hub_id,$joeycounts,$zoneId));
        //    dd($this->createJobId($orders,$hub_id,$joeycounts));
    }

  

    public function createJobId($orders, $hub_id, $joeycounts,$zoneId)
    {

        
        $hubPick = Hub::where('id', '=', $hub_id)->first();
        $address = urlencode($hubPick->address);
        // google map geocode api url
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyDTK4viphUKcrJBSuoidDqRhVA4AWnHOo0";

        // get the json response
        $resp_json = file_get_contents($url);

        // decode the json
        $resp = json_decode($resp_json, true);

        // response status will be 'OK', if able to geocode given address
        if ($resp['status'] == 'OK')
        {
            $hubLat = $resp['results'][0]['geometry']['location']['lat'];
            $hubLong = $resp['results'][0]['geometry']['location']['lng'];
        }
        $i=0;
        foreach($joeycounts as $joe){
            if(!empty($joe->joey_count)){
                $joeycount= $joe->joey_count;
            }
            if(!isset($joeycount) || empty($joeycount)){
                return response()->json( ['status_code'=>400,"error"=>'Joey Count should be greater than 1 in slot']);
            
                
            }
            for($j=0;$j<$joeycount;$j++){
                if(empty($joe->custom_capacity)){
                    $capacity = $joe->capacity; 
                }
                else{
                    $capacity = $joe->custom_capacity;
                }
                $shifts["joey_".$i] = array(
                    "start_location" => array(
                        "id" => $i,
                        "name" => $hubPick->address,
                        "lat" => $hubLat,
                        "lng" => $hubLong 
                    ),
                    "shift_start" => date('H:i',strtotime($joe->start_time)),
                    "shift_end" => date('H:i',strtotime($joe->end_time)),
                    "capacity" =>  $capacity,
                    "min_visits_per_vehicle" => $joe->min_visits
                );
        
                $i++;
            }
            
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

        $client = new Client('/vrp-long');

        $client->setData($payload);
        $apiResponse = $client->send();

        if (!empty($apiResponse->error))
        {
            return ['error' => $apiResponse->error, "status_code" => 400];

        }

        $slotjob = new SlotJob();
        $slotjob->job_id = $apiResponse->job_id;
        $slotjob->hub_id = $hub_id;
        $slotjob->zone_id = $zoneId;
        $slotjob->unserved = null;
        // $slotjob->is_custom_route = 1;
        $slotjob->save();

        

        return ['Job_id' => $apiResponse->job_id, 'status_code' => 200];

    }
   
}
