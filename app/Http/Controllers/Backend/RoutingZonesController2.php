<?php

namespace App\Http\Controllers\Backend;

use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Backend\BackendController;

use App\JoeyRoute;
use App\Slots;
use App\RoutingZones;
use App\Sprint;
use App\SlotsPostalCode;
use App\MicrohubZonesExternal;
use App\Teachers;
use App\Institute;
use App\Amazon;
use App\CoursesRequest;
use date;
use DB;
use Carbon\Carbon;
use App\ZonesTypes;
use DateTime;
use DateTimeZone;

use \JoeyCo\Laravel\Api\JsonRequest;
use JoeyCo\Laravel\Hub;
// use JoeyCo\Laravel\Sprint;
use JoeyCo\Laravel\Task;
use JoeyCo\Laravel\MerchantIds;
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
use Laravel\Redirect;
use Laravel\Session;
use \JoeyCo\Mapping\Routific\Client;


class RoutingZonesController2 extends BackendController
{


public function zonesdata(Request $request , $id)
    {
         $zones = RoutingZones::with('zoneType','hub')
        ->whereNull('deleted_at')
        ->where('hub_id',$id)
        ->whereNull('is_custom_routing')
        ->orderBy('id' , 'DESC')->get();
         $zoneType =ZonesTypes::whereNull('deleted_at')->get();
         $hubs = \App\Hub::whereNull('deleted_at')->get();
         return backend_view('zones.zonelist2', ['data'=> $zones, 'id'=> $id,'zoneType'=>$zoneType, 'hubs' => $hubs] );
    }
        public function create(Request $request)
        {
            $array=[];
          $k=0;
          foreach($request->get('postal') as $value )
          {
            if(!isset($array[$value]))
            {
              $array[$value]=1;
            }
            else
            {
              $k=1;
              break;
            }
            
          }
          if($k)
          {
            return back()->with('error','Duplicate postal are not allowed!');
          }
                  $zone = new RoutingZones();

                  $zone->hub_id = $request->input('hub_id');
                  $zone->title = $request->input('title');
                 // $zone->address = $request->input('address');
                  $zone->zone_type = $request->input('zone_type');
                  $zone->save();
//dd(count($request->input('postal')));
                  for ($i=0; $i <count($request->input('postal')) ; $i++) { 
                        
                        $slotPostalCode = new SlotsPostalCode();
                        $slotPostalCode->zone_id = $zone->id;
                        $slotPostalCode->postal_code = $request->input('postal')[$i];
                        $slotPostalCode->save();
                  
                  }
                  
                return back()->with('success','Zone Added Successfully!');
        }  


        public function get_update($id)
        {
                  $data=RoutingZones::where('id','=',$id)->first();
                  $dataPostalCode= SlotsPostalCode::whereNull('slots_postal_code.deleted_at')->where('zone_id','=',$id)->get();
                  $d=['data'=>$data, 'postalcodedata'=> $dataPostalCode];
                  return json_encode($d);
        }


        public function post_update(Request $request)
        {
            $array=[];
          $k=0;
          foreach($request->get('postal_code_edit') as $value )
          {
            if(!isset($array[$value]))
            {
              $array[$value]=1;
            }
            else
            {
              $k=1;
              break;
            }
            
          }
          if($k)
          {
            return back()->with('error','Duplicate postal are not allowed!');
          }
            $id = $request->input('id_time');
            $zoneupdate = RoutingZones::where('id', '=', $id)->first();

            $zoneupdate->title = $request->input('title_edit');
          //  $zoneupdate->address = $request->input('address_edit');
            $zone->zone_type = $request->input('zone_type');
            $zoneupdate->save();  



            SlotsPostalCode::where('zone_id', '=', $request->input('id_time'))->update(['deleted_at' => date('Y-m-d H:i:s')]);

            foreach ($request->input('postal_code_edit') as $value) {
                    $slotPostalCode_update = new SlotsPostalCode();
                    $slotPostalCode_update->zone_id = $request->input('id_time');
                    $slotPostalCode_update->postal_code = $value;
                    $slotPostalCode_update->save();
                 }



            return back()->with('success','Zone Updated Successfully!');

        } 





        public function get_detail($id)
        {
                  $data=RoutingZones::where('id','=',$id)->first();
                  $dataPostalCode= SlotsPostalCode::whereNull('slots_postal_code.deleted_at')->where('zone_id','=',$id)->get();
				  $zoneType =ZonesTypes::whereNull('deleted_at')->get();
                  $d=['data'=>$data, 'postalcodedata'=> $dataPostalCode,'zoneType'=>$zoneType];
                  return json_encode($d);
              
        }

    public function get_count($hub_id, $date, $del_id)
    {

         //dd($id.'/'.$date.'/'.$del_id);
        $zones = RoutingZones::whereNull('deleted_at')->where('id', $del_id)->first();

        $SlotsPostalCode = SlotsPostalCode::where('zone_id', '=', $del_id)->WhereNull('slots_postal_code.deleted_at')->first([\DB::raw('group_concat(postal_code) as postals')]);
        $postals = "'" . str_replace(',', "','", $SlotsPostalCode->postals) . "'";
        $created_at = date("Y-m-d", strtotime('-1 day', strtotime($date)));
        $orders=null;
        $d_orders=null;

        if ($hub_id == 16) {
            $vendor = "477260";
            $condition = " AND CONVERT_TZ(sprint__sprints.created_at,'UTC','America/Toronto') LIKE '" . $created_at . "%' 
            AND CONVERT_TZ(sprint__tasks.created_at,'UTC','America/Toronto') LIKE '" . $created_at . "%'";
            $statusCond = "sprint__sprints.status_id IN(13,61)";

            $ordercountQury = "SELECT 
                            COUNT(sprint__sprints.id) AS counts,
                            SUM(CASE WHEN (in_hub_route = 0) AND (" . $statusCond . ")  THEN 1 ELSE 0 END) AS d_counts
                            FROM sprint__sprints 
                            join sprint__tasks ON(sprint_id=sprint__sprints.id  AND type='dropoff')
                            join merchantids on(task_id=sprint__tasks.id and tracking_id IS NOT NULL and tracking_id!='')
                            join locations on(location_id=locations.id)
                            WHERE creator_id IN(" . $vendor . ") 
                            AND SUBSTRING(locations.postal_code,1,3) IN (" . $postals . ")" . $condition;


            $ordercount = DB::select($ordercountQury);
            //  dd($ordercount);

            //  dd($d);




            $orders = $ordercount[0]->counts;

            $d_orders = $ordercount[0]->d_counts;

             } else if ($hub_id == 19) {

                        $ordercountQury1 = "SELECT 
                                        COUNT(sprint__sprints.id) AS counts,
                                        SUM(CASE WHEN (in_hub_route = 0) AND (sprint__sprints.status_id IN(13,61))  THEN 1 ELSE 0 END) AS d_counts
                                        FROM sprint__sprints 
                                        join sprint__tasks ON(sprint_id=sprint__sprints.id  AND type='dropoff')
                                        join merchantids on(task_id=sprint__tasks.id and tracking_id IS NOT NULL and tracking_id!='')
                                        join locations on(location_id=locations.id)
                                        WHERE creator_id IN(477282,476592) 
                                        AND SUBSTRING(locations.postal_code,1,3) IN (" . $postals . ")
                                        AND CONVERT_TZ(sprint__sprints.created_at,'UTC','America/Toronto') LIKE '" . $created_at . "%' 
                                        AND CONVERT_TZ(sprint__tasks.created_at,'UTC','America/Toronto') LIKE '" . $created_at . "%'
                                        #AND  CONVERT_TZ(merchantids.created_at,'UTC','America/Toronto') LIKE '" . $created_at . "%'
                                        ";

                        $amazonordercount = DB::select($ordercountQury1);


                        $ordercountQury2 = "SELECT 
                                        COUNT(sprint__sprints.id) AS counts,
                                        SUM(CASE WHEN in_hub_route = 0  THEN 1 ELSE 0 END) AS d_counts
                                        FROM sprint__sprints 
                                        join sprint__tasks ON(sprint_id=sprint__sprints.id  AND type='dropoff')
                                        join merchantids on(task_id=sprint__tasks.id and tracking_id IS NOT NULL and tracking_id!='')
                                        join locations on(location_id=locations.id)
                                        WHERE creator_id IN(477340,477341,477342,477343,477344,477345,477346,477631,477629) 
                                        AND SUBSTRING(locations.postal_code,1,3) IN (" . $postals . ")
                                        AND sprint__sprints.status_id IN(13,124,112)
                                        AND date(sprint__sprints.created_at) > '2022-07-31'";


            $ctcordercount = DB::select($ordercountQury2);

            $orders = $amazonordercount[0]->counts + $ctcordercount[0]->counts;
            $d_orders = $amazonordercount[0]->d_counts + $ctcordercount[0]->d_counts;


        }
        else if ($hub_id == 129){

            $vendor = "477607,477609,477613,477589,477641";

            $ordercountQury = "SELECT 
                            COUNT(sprint__sprints.id) AS counts,
                            SUM(CASE WHEN in_hub_route = 0 THEN 1 ELSE 0 END) AS d_counts
                            FROM sprint__sprints 
                            join sprint__tasks ON(sprint_id=sprint__sprints.id  AND type='dropoff')
                            join merchantids on(task_id=sprint__tasks.id and tracking_id IS NOT NULL and tracking_id!='')
                            join locations on(location_id=locations.id)
                            WHERE creator_id IN(".$vendor.") 
                            AND SUBSTRING(locations.postal_code,1,3) IN (".$postals.")
                            AND sprint__sprints.status_id IN(13,124,112)
                            AND date(sprint__sprints.created_at) > '2022-07-31'";

            $ordercount = DB::select($ordercountQury);
            $orders = $ordercount[0]->counts;
            $d_orders = $ordercount[0]->d_counts;

        }
        else{

            $vendor = "477542,477255,477254,477283,477284,477286,477287,477288,477289,477307,477308,477309,477310,477311,477312,477313,477314,477292,477294,477315,477317,477316,477295,477302,477303,477304,477305,477306,477296,477290,477297,477298,477299,477300,477320,477301,477318,477328,476294,477334,477335,477336,477337,477338,477339,477559,477625,477587,477621,477627,477635,477633,477661";

            $ordercountQury = "SELECT 
                            COUNT(sprint__sprints.id) AS counts,
                            SUM(CASE WHEN in_hub_route = 0 THEN 1 ELSE 0 END) AS d_counts
                            FROM sprint__sprints 
                            join sprint__tasks ON(sprint_id=sprint__sprints.id  AND type='dropoff')
                            join merchantids on(task_id=sprint__tasks.id and tracking_id IS NOT NULL and tracking_id!='')
                            join locations on(location_id=locations.id)
                            WHERE creator_id IN(".$vendor.") 
                            AND SUBSTRING(locations.postal_code,1,3) IN (".$postals.")
                            AND sprint__sprints.status_id IN(13,124,112)
                            AND date(sprint__sprints.created_at) > '2022-07-31'";

            $ordercount = DB::select($ordercountQury);
            $orders = $ordercount[0]->counts;
            $d_orders = $ordercount[0]->d_counts;

        }



        $joeyCount = Slots::where('zone_id', '=', $del_id)
            ->WhereNull('slots.deleted_at')
            ->sum('joey_count');


        $vehicleTyp = Slots::where('zone_id', '=', $del_id)->join('vehicles', 'vehicles.id', '=', 'slots.vehicle')
            ->WhereNull('slots.deleted_at')->get(['vehicles.name', 'slots.joey_count']);

      /*  if ($orders== null) {
            $orders = 0;
        }*/
        if($d_orders==null){
            $d_orders=0;
        }
        if($joeyCount==null){

            $joeyCount=0;
        }

        if($vehicleTyp->isEmpty()){
            $vehicleTyp[0]=['name'=>'','joey_count'=>''];
        }
       // dd($zones->id.'/'.$zones->title);


        $d = ['title'=>$zones->title,'id'=>$zones->id,'orders' => $orders, 'd_orders' => $d_orders, 'joeys_count' => $joeyCount, 'slots_detail' => $vehicleTyp];
          // dd($d);
        return json_encode($d);


    }

    public function get_count2($hub_id,$zone_id, $date)
    {

         //dd($id.'/'.$date.'/'.$del_id);
        $zones = RoutingZones::whereNull('deleted_at')->where('id', $zone_id)->first();

        $SlotsPostalCode = SlotsPostalCode::where('zone_id', '=', $zone_id)->WhereNull('slots_postal_code.deleted_at')->pluck('postal_code')->toArray();

// dd($SlotsPostalCode);
        $postalcodes = implode("','",$SlotsPostalCode);
       
        $created_at = date("Y-m-d", strtotime('-1 day', strtotime($date)));
         
        if ($hub_id == 16) {

           $totalCounts = $this->amazonCount(477260,$created_at,$postalcodes);
           
        } 
        else if ($hub_id == 19) {

            $totalAmazonCounts = $this->amazonCount(477282,$created_at,$postalcodes);
            
            $vendor = "477340,477341,477342,477343,477344,477345,477346,477631,477629";
            $totalCtcCounts = $this->ctcCount($vendor,$postalcodes);
                        
            $totalCounts['orders'] = $totalAmazonCounts['orders'] + $totalCtcCounts['orders'];
            $totalCounts['not_in_route'] = $totalAmazonCounts['not_in_route'] + $totalCtcCounts['not_in_route'];

        }
        else if ($hub_id == 129) {

            $vendor = "477607,477609,477613,477589,477641";

            $totalCounts = $this->ctcCount($vendor,$postalcodes);

        }
        else if ($hub_id == 160) {

            $vendor = "477633,477625,477635";

            $totalCounts = $this->amazonCount($vendor,$created_at,$postalcodes);

        }
        else{

            $vendor = "477171,477542,476294,477254,477255,477283,477284,477286,477287,477288,477289,477290,477292,477294,477295,477296,477297,477298,477299,477300,477301,477302,477303,477304,477305,477306,477307,477308,477309,477310,477311,477312,477313,477314,477315,477316,477317,477318,477320,477328,477334,477335,477336,477337,477338,477339,477559,477625,477587,477621,477627,477635,477633,477661";
            $totalAmazonCounts = $this->amazonCount(477621,$created_at,$postalcodes);

            $totalCounts = $this->ctcCount($vendor,$postalcodes);
            $totalCounts['orders'] = $totalAmazonCounts['orders'] + $totalCounts['orders'];
            $totalCounts['not_in_route'] = $totalAmazonCounts['not_in_route'] + $totalCounts['not_in_route'];
        }

        $joeyCount = Slots::where('zone_id', '=',  $zone_id)
        ->WhereNull('slots.deleted_at')
        ->sum('joey_count');

        $vehicleTyp = Slots::where('zone_id', '=',  $zone_id)
        ->join('vehicles', 'vehicles.id', '=', 'slots.vehicle')
        ->WhereNull('slots.deleted_at')
        ->get(['vehicles.name', 'slots.joey_count']);

     
        if($totalCounts['not_in_route']==null){
            $d_orders=0;
        }
        if($joeyCount==null){

            $joeyCount=0;
        }

        if($vehicleTyp->isEmpty()){
            $vehicleTyp[0]=['name'=>'','joey_count'=>''];
        }
    
        $response = ['title'=>$zones->title,'id'=>$zones->id,'orders' => $totalCounts['orders'], 'd_orders' => $totalCounts['not_in_route'], 'joeys_count' => $joeyCount, 'slots_detail' => $vehicleTyp];

        return json_encode($response);


    }

    public function amazonCount($vendor,$created_at,$postals){

        $orders=0;
        $d_orders=0;

        $start_dt = new DateTime($created_at." 00:00:00", new DateTimezone('America/Toronto'));
        $start_dt->setTimeZone(new DateTimezone('UTC'));
        $start = $start_dt->format('Y-m-d H:i:s');

        $end_dt = new DateTime($created_at." 23:59:59", new DateTimezone('America/Toronto'));
        $end_dt->setTimeZone(new DateTimezone('UTC'));
        $end = $end_dt->format('Y-m-d H:i:s');

      //foreach($postals as $postalcode){

        $ordercountQury = "SELECT 
                        COUNT(sprint__sprints.id) AS counts,
                        SUM(CASE WHEN (in_hub_route = 0) AND (sprint__tasks.status_id IN(61,24,13))  THEN 1 ELSE 0 END) AS d_counts
                        FROM sprint__sprints 
                        join sprint__tasks ON(sprint_id=sprint__sprints.id)
                        join merchantids on(task_id=sprint__tasks.id  and tracking_id IS NOT NULL and tracking_id!='')
                        join locations on(location_id=locations.id)
                        WHERE creator_id IN(" . $vendor . ")
                        AND sprint__sprints.is_reattempt = 0 
                        AND sprint__sprints.deleted_at IS NULL 
                        AND sprint__sprints.status_id != 36
                        AND SUBSTR(locations.postal_code,1,3) IN ('" . $postals . "')
                        #AND sprint__tasks.created_at > '" . $start . "'
                        #AND sprint__tasks.created_at < '" . $end . "'
                        ";


        $ordercount = DB::select($ordercountQury);

        $orders += $ordercount[0]->counts;
        $d_orders += $ordercount[0]->d_counts;

      //} 
                        
      return array('orders'=>$orders,'not_in_route'=>$d_orders);

    }

    public function ctcCount($vendor,$postals){

        $orders=0;
        $d_orders=0;

      //foreach($postals as $postalcode){

        $ordercountQury = "SELECT 
        COUNT(sprint__sprints.id) AS counts,
        SUM(CASE WHEN in_hub_route = 0  THEN 1 ELSE 0 END) AS d_counts
        FROM sprint__sprints 
        join sprint__tasks ON(sprint_id=sprint__sprints.id)
        join merchantids on(task_id=sprint__tasks.id and tracking_id IS NOT NULL and tracking_id!='')
        join locations on(location_id=locations.id)
        WHERE creator_id IN(".$vendor.")
        AND SUBSTR(locations.postal_code,1,3) IN ('" . $postals . "')
        AND sprint__sprints.status_id IN(13,124,112)
        AND sprint__sprints.is_reattempt = 0
        AND sprint__sprints.deleted_at IS NULL 
        AND date(sprint__sprints.created_at) > '2022-09-31'";

        $ordercount = DB::select($ordercountQury);

        $orders += $ordercount[0]->counts;
        $d_orders += $ordercount[0]->d_counts;

      //} 
                        
      return array('orders'=>$orders,'not_in_route'=>$d_orders);

    }

    public function get_count_test($hub_id, $date, $del_id)
    {


        $zones = RoutingZones::whereNull('deleted_at')->where('id', $del_id)->first();

        $SlotsPostalCode = SlotsPostalCode::where('zone_id', '=', $del_id)->WhereNull('slots_postal_code.deleted_at')->first([\DB::raw('group_concat(postal_code) as postals')]);

        $postals = "'" . str_replace(',', "','", $SlotsPostalCode->postals) . "'";

        $created_at = date("Y-m-d", strtotime('-1 day', strtotime($date)));
        $orders=null;
        $d_orders=null;

        if ($hub_id == 16) {

            $sprints = \App\Task::join('locations','location_id','=','locations.id')
                ->where(\DB::raw("CONVERT_TZ(sprint__tasks.created_at,'UTC','America/Toronto')"),'like',$created_at."%")
                ->where('type','=','dropoff')
                ->whereIn(\DB::raw('SUBSTRING(locations.postal_code,1,3)'),[$postals])
                ->orderBy('locations.postal_code')
                ->take(2000)
                ->get();
            dd($sprints);

            $allsprintIds = \DB::table('sprint__sprints')->where('sprint__sprints.creator_id',477260)
                ->whereIn('sprint__sprints.status_id',[61,13])
                ->where(\DB::raw("CONVERT_TZ(sprint__sprints.created_at,'UTC','America/Toronto')"),'like',$date."%")
                ->pluck('id');

            dd($allsprintIds);
            $taskIds = \DB::table('sprint__tasks')->whereIn('sprint_id',$allsprintIds)
                ->where('type','=','dropoff')
                ->pluck('id');

            $sprints = \App\Task::join('locations','location_id','=','locations.id')
                ->whereIn('sprint__tasks.id',$taskIds)
                ->whereIn(\DB::raw('SUBSTRING(locations.postal_code,1,3)'),[$postals])
                ->orderBy('locations.postal_code')
                ->take(2000)
                ->get();

            $count = 0;
            $d_count = 0;
            foreach($sprints as $sprint) {
                if($sprint->taskMerchant) {

                    $count = $count + 1;
                    if (in_array($sprint->status, [61, 13]) && $sprint->taskSprint->in_hub_route == 0) {
                        $d_count = $d_count + 1;
                    }
                }
            }

            $orders = $count;

            $d_orders = $d_count;

        } else if ($hub_id == 19) {

            $ordercountQury1 = "SELECT 
                                        COUNT(sprint__sprints.id) AS counts,
                                        SUM(CASE WHEN (in_hub_route =0) AND (sprint__sprints.status_id IN(13,61))  THEN 1 ELSE 0 END) AS d_counts
                                        FROM sprint__sprints 
                                        join sprint__tasks ON(sprint_id=sprint__sprints.id  AND type='dropoff')
                                        join merchantids on(task_id=sprint__tasks.id and tracking_id IS NOT NULL and tracking_id!='')
                                        join locations on(location_id=locations.id)
                                        WHERE creator_id IN(477282) 
                                        AND SUBSTRING(locations.postal_code,1,3) IN (" . $postals . ")
                                        AND CONVERT_TZ(sprint__sprints.created_at,'UTC','America/Toronto') LIKE '" . $created_at . "%' 
                                        AND CONVERT_TZ(sprint__tasks.created_at,'UTC','America/Toronto') LIKE '" . $created_at . "%'
                                        #AND  CONVERT_TZ(merchantids.created_at,'UTC','America/Toronto') LIKE '" . $created_at . "%'
                                        ";

            $amazonordercount = DB::select($ordercountQury1);


            $ordercountQury2 = "SELECT 
                                        COUNT(sprint__sprints.id) AS counts,
                                        SUM(CASE WHEN in_hub_route = 0  THEN 1 ELSE 0 END) AS d_counts
                                        FROM sprint__sprints 
                                        join sprint__tasks ON(sprint_id=sprint__sprints.id  AND type='dropoff')
                                        join merchantids on(task_id=sprint__tasks.id and tracking_id IS NOT NULL and tracking_id!='')
                                        join locations on(location_id=locations.id)
                                        WHERE creator_id IN(477340,477341,477342,477343,477344,477345,477346,477631,477629) 
                                        AND SUBSTRING(locations.postal_code,1,3) IN (" . $postals . ")
                                        AND sprint__sprints.status_id IN(13,124,112)
                                        AND date(sprint__sprints.created_at) > '2022-07-31'";


            $ctcordercount = DB::select($ordercountQury2);

            $orders = $amazonordercount[0]->counts + $ctcordercount[0]->counts;
            $d_orders = $amazonordercount[0]->d_counts + $ctcordercount[0]->d_counts;


        }
        else if ($hub_id == 129) {
            $vendor = "477607,477609,477613,477589,477641";

            $ordercountQury = "SELECT 
                            COUNT(sprint__sprints.id) AS counts,
                            SUM(CASE WHEN in_hub_route = 0 THEN 1 ELSE 0 END) AS d_counts
                            FROM sprint__sprints 
                            join sprint__tasks ON(sprint_id=sprint__sprints.id  AND type='dropoff')
                            join merchantids on(task_id=sprint__tasks.id and tracking_id IS NOT NULL and tracking_id!='')
                            join locations on(location_id=locations.id)
                            WHERE creator_id IN(".$vendor.") 
                            AND SUBSTRING(locations.postal_code,1,3) IN (".$postals.")
                            AND sprint__sprints.status_id IN(13,124,112)
                            AND date(sprint__sprints.created_at) > '2022-07-31'";

            $ordercount = DB::select($ordercountQury);
            $orders = $ordercount[0]->counts;
            $d_orders = $ordercount[0]->d_counts;
        }
        else{

            $vendor = "477542,477255,477254,477283,477284,477286,477287,477288,477289,477307,477308,477309,477310,477311,477312,477313,477314,477292,477294,477315,477317,477316,477295,477302,477303,477304,477305,477306,477296,477290,477297,477298,477299,477300,477320,477301,477318,477328,476294,477334,477335,477336,477337,477338,477339,477559,477625,477587,477621,477627,477635,477633,477661";

            $ordercountQury = "SELECT 
                            COUNT(sprint__sprints.id) AS counts,
                            SUM(CASE WHEN in_hub_route = 0 THEN 1 ELSE 0 END) AS d_counts
                            FROM sprint__sprints 
                            join sprint__tasks ON(sprint_id=sprint__sprints.id  AND type='dropoff')
                            join merchantids on(task_id=sprint__tasks.id and tracking_id IS NOT NULL and tracking_id!='')
                            join locations on(location_id=locations.id)
                            WHERE creator_id IN(".$vendor.") 
                            AND SUBSTRING(locations.postal_code,1,3) IN (".$postals.")
                            AND sprint__sprints.status_id IN(13,124,112)
                            AND date(sprint__sprints.created_at) > '2022-07-31'";

            $ordercount = DB::select($ordercountQury);
            $orders = $ordercount[0]->counts;
            $d_orders = $ordercount[0]->d_counts;

        }



        $joeyCount = Slots::where('zone_id', '=', $del_id)
            ->WhereNull('slots.deleted_at')
            ->sum('joey_count');


        $vehicleTyp = Slots::where('zone_id', '=', $del_id)->join('vehicles', 'vehicles.id', '=', 'slots.vehicle')
            ->WhereNull('slots.deleted_at')->get(['vehicles.name', 'slots.joey_count']);

        /*  if ($orders== null) {
              $orders = 0;
          }*/
        if($d_orders==null){
            $d_orders=0;
        }
        if($joeyCount==null){

            $joeyCount=0;
        }

        if($vehicleTyp->isEmpty()){
            $vehicleTyp[0]=['name'=>'','joey_count'=>''];
        }
        // dd($zones->id.'/'.$zones->title);


        $d = ['title'=>$zones->title,'id'=>$zones->id,'orders' => $orders, 'd_orders' => $d_orders, 'joeys_count' => $joeyCount, 'slots_detail' => $vehicleTyp];

        return json_encode($d);


    }

    // function for the count
    public function order_count(Request $request, $id,$date){

        $created_at = date("Y-m-d", strtotime('-1 day', strtotime($date)));

        if ($id == 16) {
            $ordercountQury =  "SELECT 
            COUNT(id) AS counts,
            SUM(CASE WHEN (in_hub_route = 0) AND (sprint__sprints.status_id IN(13,61))  THEN 1 ELSE 0 END) AS d_counts
            FROM sprint__sprints 
            WHERE creator_id IN(477260)
            AND CONVERT_TZ(sprint__sprints.created_at,'UTC','America/Toronto') LIKE '" . $created_at . "%'";

            $ordercount = DB::select($ordercountQury);
        
            $orders = $ordercount[0]->counts;

            $d_orders = $ordercount[0]->d_counts;

        } 
        else if ($id == 19) {

          $ordercountQury1 = "SELECT 
          COUNT(id) AS counts,
          SUM(CASE WHEN (in_hub_route = 0) AND (sprint__sprints.status_id IN(13,61))  THEN 1 ELSE 0 END) AS d_counts
          FROM sprint__sprints
          WHERE creator_id IN(477282)
          AND CONVERT_TZ(sprint__sprints.created_at,'UTC','America/Toronto') LIKE '" . $created_at . "%'";
         
          $amazonordercount = DB::select($ordercountQury1);

          $ordercountQury2 = "SELECT 
          COUNT(id) AS counts,
          SUM(CASE WHEN in_hub_route = 0  THEN 1 ELSE 0 END) AS d_counts
          FROM sprint__sprints 
          WHERE creator_id IN(477340,477341,477342,477343,477344,477345,477346,477631,477629)
          AND sprint__sprints.status_id IN(13,124,112)
          AND date(sprint__sprints.created_at) > '2022-07-31'";


          $ctcordercount = DB::select($ordercountQury2);

          $orders = $amazonordercount[0]->counts + $ctcordercount[0]->counts;
          $d_orders = $amazonordercount[0]->d_counts + $ctcordercount[0]->d_counts;


        }
        else if($id == 129){

            $vendor = "477607,477609,477613,477589,477641";
  
            $ordercountQury = "SELECT 
            COUNT(id) AS counts,
            SUM(CASE WHEN in_hub_route = 0 THEN 1 ELSE 0 END) AS d_counts
            FROM sprint__sprints
            WHERE creator_id IN(".$vendor.")
            AND sprint__sprints.status_id IN(13,124,112)
            AND date(sprint__sprints.created_at) > '2022-07-31'";
  
            $ordercount = DB::select($ordercountQury);
            $orders = $ordercount[0]->counts;
            $d_orders = $ordercount[0]->d_counts;
  
          }
        else{

          $vendor = "477542,477255,477254,477283,477284,477286,477287,477288,477289,477307,477308,477309,477310,477311,477312,477313,477314,477292,477294,477315,477317,477316,477295,477302,477303,477304,477305,477306,477296,477290,477297,477298,477299,477300,477320,477301,477318,477328,476294,477334,477335,477336,477337,477338,477339,477559,477625,477587,477621,477627,477635,477633,477661";

          $ordercountQury = "SELECT 
          COUNT(id) AS counts,
          SUM(CASE WHEN in_hub_route = 0 THEN 1 ELSE 0 END) AS d_counts
          FROM sprint__sprints
          WHERE creator_id IN(".$vendor.")
          AND sprint__sprints.status_id IN(13,124,112)
          AND date(sprint__sprints.created_at) > '2022-07-31'";

          $ordercount = DB::select($ordercountQury);
          $orders = $ordercount[0]->counts;
          $d_orders = $ordercount[0]->d_counts;

        }

        $data = ['orders' => $orders, 'd_orders' => $d_orders];
        return json_encode($data);

    }


    public function post_deletezone(Request $request){
            $id = $request->input('delete_id');
            RoutingZones::where('id','=',$id)->update(['deleted_at'=>date('Y-m-d h:i:s')]);
            return redirect()->back()->with('success','Zone Deleted Successfully!');
        }

    public function attachZonesMicrohub(Request $request)
    {
        MicrohubZonesExternal::where('zone_id',$request->get('attach_zone_id'))->update(['deleted_at' => date('Y-m-d H:i:s')]);
        MicrohubZonesExternal::create([
            'zone_id' => $request->get('attach_zone_id'),
            'hub_id' => $request->get('microhub'),
        ]);
        return redirect()->back()->with('success', 'MicroHub attached successfully');
    }



    /*Added By Muhammad Raqib
         @date 30/09/2022*/
//list show

    public function viewlist($hub_id,$zone_id, $date)
    {
        $orders=0;
        $d_orders=0;
        $zones = RoutingZones::whereNull('deleted_at')->where('id', $zone_id)->first();
        $SlotsPostalCode = SlotsPostalCode::where('zone_id', '=', $zone_id)->WhereNull('slots_postal_code.deleted_at')->pluck('postal_code')->toArray();
        $postalcodes = implode("','",$SlotsPostalCode);
        $created_at = date("Y-m-d", strtotime('-1 day', strtotime($date)));
        $start_dt = new DateTime($created_at." 00:00:00", new DateTimezone('America/Toronto'));
        $start_dt->setTimeZone(new DateTimezone('UTC'));
        $start = $start_dt->format('Y-m-d H:i:s');
        $end_dt = new DateTime($created_at." 23:59:59", new DateTimezone('America/Toronto'));
        $end_dt->setTimeZone(new DateTimezone('UTC'));
        $end = $end_dt->format('Y-m-d H:i:s');
        if ($hub_id == 16) {


            $vendor = "477260";
            $ordercountQury = "SELECT 
                        merchantids.tracking_id
                        FROM sprint__sprints 
                        join sprint__tasks ON(sprint_id=sprint__sprints.id)
                        join merchantids on(task_id=sprint__tasks.id  and tracking_id IS NOT NULL and tracking_id!='')
                        join locations on(location_id=locations.id)
                        WHERE creator_id IN(" . $vendor . ") 
                        AND SUBSTR(locations.postal_code,1,3) IN ('" . $postalcodes . "')
                        And sprint__sprints.in_hub_route = 0
                        AND sprint__tasks.created_at > '" . $start . "'
                        AND sprint__tasks.created_at < '" . $end . "'";

            $ordercount1 = DB::select($ordercountQury);
            $orders = $ordercount1;

        }
        else if ($hub_id == 19) {
            $vendor = "477282";
            $ordercountQury = "SELECT 
                        merchantids.tracking_id
                        FROM sprint__sprints 
                        join sprint__tasks ON(sprint_id=sprint__sprints.id)
                        join merchantids on(task_id=sprint__tasks.id  and tracking_id IS NOT NULL and tracking_id!='')
                        join locations on(location_id=locations.id)
                        WHERE creator_id IN(" . $vendor . ") 
                        AND SUBSTR(locations.postal_code,1,3) IN ('" . $postalcodes . "')
                        And sprint__sprints.in_hub_route = 0
                        AND sprint__tasks.created_at > '" . $start . "'
                        AND sprint__tasks.created_at < '" . $end . "'";

            $ordercount2 = DB::select($ordercountQury);
            $orders = $ordercount2;

            $vendor = "477340,477341,477342,477343,477344,477345,477346,477631,477629";

            $ordercountQury = "SELECT 
                                merchantids.tracking_id
                                FROM sprint__sprints 
                                join sprint__tasks ON(sprint_id=sprint__sprints.id)
                                join merchantids on(task_id=sprint__tasks.id and tracking_id IS NOT NULL and tracking_id!='')
                                join locations on(location_id=locations.id)
                                WHERE creator_id IN(".$vendor.")
                                AND SUBSTR(locations.postal_code,1,3) IN ('" . $postalcodes . "')
                                AND sprint__sprints.status_id IN(13,124,112)
                                And sprint__sprints.in_hub_route = 0
                                AND date(sprint__sprints.created_at) > '2022-07-31'";

            $ordercount3 = DB::select($ordercountQury);
            $orders = $ordercount3;

        }
        else if ($hub_id == 129) {

            $vendor = "477607,477609,477613,477589,477641";

            $ordercountQury = "SELECT 
                                merchantids.tracking_id
                                FROM sprint__sprints 
                                join sprint__tasks ON(sprint_id=sprint__sprints.id)
                                join merchantids on(task_id=sprint__tasks.id and tracking_id IS NOT NULL and tracking_id!='')
                                join locations on(location_id=locations.id)
                                WHERE creator_id IN(".$vendor.")
                                AND SUBSTR(locations.postal_code,1,3) IN ('" . $postalcodes . "')
                                AND sprint__sprints.status_id IN(13,124,112)
                                And sprint__sprints.in_hub_route = 0
                                AND date(sprint__sprints.created_at) > '2022-07-31'";
            $ordercount4 = DB::select($ordercountQury);
            $orders = $ordercount4;
        }
        else{

            $vendor = "477542,476294,477254,477255,477283,477284,477286,477287,477288,477289,477290,477292,477294,477295,477296,477297,477298,477299,477300,477301,477302,477303,477304,477305,477306,477307,477308,477309,477310,477311,477312,477313,477314,477315,477316,477317,477318,477320,477328,477334,477335,477336,477337,477338,477339,477559,477625,477587,477621,477627,477635,477633,477661";

            $ordercountQury = "SELECT 
                                merchantids.tracking_id
                                FROM sprint__sprints 
                                join sprint__tasks ON(sprint_id=sprint__sprints.id)
                                join merchantids on(task_id=sprint__tasks.id and tracking_id IS NOT NULL and tracking_id!='')
                                join locations on(location_id=locations.id)
                                WHERE creator_id IN(".$vendor.")
                                AND SUBSTR(locations.postal_code,1,3) IN ('" . $postalcodes . "')
                                AND sprint__sprints.status_id IN(13,124,112)
                                And sprint__sprints.in_hub_route = 0
                                AND date(sprint__sprints.created_at) > '2022-07-31'";
            $ordercount5 = DB::select($ordercountQury);
            $orders = $ordercount5;
        }

        $joeyCount = Slots::where('zone_id', '=',  $zone_id)
            ->WhereNull('slots.deleted_at')
            ->sum('joey_count');

        $vehicleTyp = Slots::where('zone_id', '=',  $zone_id)
            ->join('vehicles', 'vehicles.id', '=', 'slots.vehicle')
            ->WhereNull('slots.deleted_at')
            ->get(['vehicles.name', 'slots.joey_count']);

        if($joeyCount==null){

            $joeyCount=0;
        }

        if($vehicleTyp->isEmpty()){
            $vehicleTyp[0]=['name'=>'','joey_count'=>''];
        }

        $response = ['title'=>$zones->title,'id'=>$zones->id,'orders' => $orders, 'joeys_count' => $joeyCount, 'slots_detail' => $vehicleTyp];

        return json_encode($response);

    }

}
