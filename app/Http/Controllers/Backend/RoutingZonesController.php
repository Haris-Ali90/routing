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
use App\CustomRoutingTrackingId;
use App\Amazon;
use date;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use \JoeyCo\Laravel\Api\JsonRequest;
use JoeyCo\Laravel\Hub;

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


class RoutingZonesController extends BackendController
{
        public function zonesdata(Request $request , $id)
        {

                 $zones = RoutingZones::whereNull('deleted_at')->where('hub_id',$id)->whereNull('is_custom_routing')->orderBy('id' , 'DESC')->get();
                 return backend_view('zones.zonelist', ['data'=> $zones, 'id'=> $id] );
        }
        public function custom_routing_zonesdata(Request $request , $id)
        {
    
                 $zones = RoutingZones::whereNull('deleted_at')->where('hub_id',$id)->where('is_custom_routing','=',1)->orderBy('id' , 'DESC')->get();
                $date=date("Y-m-d");
                 return backend_view('zones.customzonelist', ['data'=> $zones, 'id'=> $id,'date'=>$date] );
        }
        //custom_routing_zonesdata
        public function custom_routing_create(Request $request)
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
            return back()->with('error','Duplicate postal codes are not allowed!');
          }
          $zone = new RoutingZones();
    
          $zone->hub_id = $request->input('hub_id');
          $zone->title = $request->input('title');
          $zone->is_custom_routing=1;
         // $zone->address = $request->input('address');
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

        public function create(Request $request)
        {

                  $zone = new RoutingZones();

                  $zone->hub_id = $request->input('hub_id');
                  $zone->title = $request->input('title');
                 // $zone->address = $request->input('address');
                 $zone->zone_type =   $request->input('zone_type');
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
            return back()->with('error','Duplicate postal codes are not allowed!');
          }
            $id = $request->input('id_time');
            $zoneupdate = RoutingZones::where('id', '=', $id)->first();

            $zoneupdate->title = $request->input('title_edit');
            $zoneupdate->zone_type = $request->input('zone_type');
          //  $zoneupdate->address = $request->input('address_edit');
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
                  $d=['data'=>$data, 'postalcodedata'=> $dataPostalCode];
                  return json_encode($d);
              
        }  

        public function post_deletezone(Request $request)
        {
            $id = $request->input('delete_id');
            RoutingZones::where('id','=',$id)->update(['deleted_at'=>date('Y-m-d h:i:s')]);
            return redirect()->back()->with('success','Zone Deleted Successfully!');
        }
        public function customZoneOrderCount($hub_id, $del_id)
        {
           $user= Auth::user();
          $zones = RoutingZones::whereNull('deleted_at')->where('id', $del_id)->first();
          
          $postals = SlotsPostalCode::where('zone_id', '=', $del_id)->WhereNull('slots_postal_code.deleted_at')->pluck('postal_code')->toArray();
         
            $tracking_ids=CustomRoutingTrackingId::where('hub_id','=',$hub_id)
            ->whereIn(\DB::raw('SUBSTRING(custom_routing_tracking_id.postal_code,1,3)'),$postals)
            ->whereNotNull('tracking_id')->
            where('user_id','=',$user->id)->
            where('is_inbound','=',0)->
            where('valid_id','=',1)->
            whereNull('deleted_at')->
            pluck('tracking_id')->
            toArray();
          
           
    
            if ($hub_id == 16) {
                $vendor = "477260";
                $ordercountQury = Sprint::join('sprint__tasks','sprint__tasks.sprint_id','=','sprint__sprints.id')
                                  ->join('merchantids','merchantids.task_id','=','sprint__tasks.id')
                                  ->whereIn('merchantids.tracking_id',$tracking_ids)
                                  ->whereNull('sprint__sprints.deleted_at')
                                  ->where('creator_id','=',$vendor)->count();
            
                $orders = $ordercountQury;
                $d_orders = 0;
                
    
                 } else if ($hub_id == 19) {
                   $vendor=[476592,477282,477340,477341,477342,477343,477344,477345,477346,477631,477629];
                   $ordercountQury=Sprint::join('sprint__tasks','sprint__tasks.sprint_id','=','sprint__sprints.id')
                  ->join('merchantids','merchantids.task_id','=','sprint__tasks.id')
                  ->whereIn('merchantids.tracking_id',$tracking_ids)
                  ->whereNull('sprint__sprints.deleted_at')
                  ->whereNotNull('merchantids.tracking_id')
                  ->whereIn('creator_id',$vendor)->count();
                            
    
                $orders =$ordercountQury ;
                $d_orders = 0;
    
    
            }
            else{
    
                $vendor = [477255,477254,477283,477284,477286,477287,477288,477289,477307,477308,477309,477310,477311,477312,477313,477314,477292,477294,477315,477317,477316,477295,477302,477303,477304,477305,477306,477296,477290,477297,477298,477299,477300,477320,477301,477318,477328,476294,477334,477335,477336,477337,477338,477339,477559,477625,477587,477589,477641,477621,477627,477635,477633,477661];
    
                $ordercountQury=Sprint::join('sprint__tasks','sprint__tasks.sprint_id','=','sprint__sprints.id')
                ->join('merchantids','merchantids.task_id','=','sprint__tasks.id')
                ->whereIn('merchantids.tracking_id',$tracking_ids)
                ->whereNull('sprint__sprints.deleted_at')
                ->whereNotNull('merchantids.tracking_id')
                ->whereIn('creator_id',$vendor)->count();
                          
  
              $orders =$ordercountQury ;
              $d_orders = 0;
             
    
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

}
