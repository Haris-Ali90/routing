<?php

namespace App\Http\Controllers\Backend;

use App\Post;
use App\Vehicle;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Backend\BackendController;

use App\JoeyRoute;
use App\Slots;
use App\SlotsPostalCode;
use App\Teachers;
use App\Institute;
use App\Amazon;
use App\CoursesRequest;
use date;
use DB;
use Carbon\Carbon;
use App\Sprint;



class SlotsController extends BackendController
{

        public function zoneSlots($zoneid){
                $slots = Slots::whereNull('deleted_at')->
                where('zone_id','=',$zoneid)
                ->orderBy('id' , 'DESC')->get();
                return json_encode($slots);
        }

        public function slotsdata($id, $zoneid)
        {
                 $slots = Slots::whereNull('deleted_at')->where('hub_id','=',$id)->where('zone_id','=',$zoneid)->orderBy('id' , 'DESC')->get();
                 return backend_view('slots.slotlist', ['data'=> $slots, 'id'=> $id, 'zoneid'=> $zoneid] );
        }

        public function create(Request $request)
        {


                  $slot = new Slots();

                  $slot->hub_id = $request->input('hub_id');
                  $slot->zone_id = $request->input('zone_id');
                  $slot->vehicle = $request->input('vehicle');
                  $slot->start_time = $request->input('start_time');
                  $slot->end_time = $request->input('end_time');
                  $slot->joey_count = $request->input('joey_count');
                  $slot->custom_capacity = $request->input('custom_capacity');
                  // $slot->orders_count = $request->input('orders_count');
                  $slot->save();
                 // foreach ($request->input('postal_code') as $value)
                 //  {
                 //    $slotPostalCode = new SlotsPostalCode();
                 //    $slotPostalCode->slot_id = $slot->id;
                 //    $slotPostalCode->postal_code = $value;
                 //    $slotPostalCode->save();
                 //  }

                return back()->with('success','Slot Added Successfully!');
        }

        public function createSlot(Request $request){

            $slot = new Slots();
            $slot->hub_id = $request->input('hub_id');
            $slot->zone_id = $request->input('zone_id');
            $slot->vehicle = $request->input('vehicle');
            $slot->start_time = $request->input('start_time');
            $slot->end_time = $request->input('end_time');
            $slot->joey_count = $request->input('joey_count');
            $slot->custom_capacity = $request->input('custom_capacity');
            $slot->save();

            $vehicleTyp = Slots::where('zone_id', '=',  $request->input('zone_id'))
                ->join('vehicles', 'vehicles.id', '=', 'slots.vehicle')
                ->WhereNull('slots.deleted_at')
                ->get(['vehicles.name', 'slots.joey_count']);

            $countJoey = Slots::where('zone_id', '=',  $request->input('zone_id'))
                ->join('vehicles', 'vehicles.id', '=', 'slots.vehicle')
                ->WhereNull('slots.deleted_at')
                ->get();

            $joeyCount = 0;
            foreach($countJoey as $count){
                $joeyCount += $count->joey_count;
            }

            if($vehicleTyp->isEmpty()){
                $vehicleTyp[0]=['name'=>'','joey_count'=>''];
            }

            $response = ['joeys_count' => $joeyCount, 'slots_detail' => $vehicleTyp];

            return json_encode($response);

        }


        public function get_update($id)
        {
                  $data=Slots::where('id','=',$id)->first();
                  // $dataPostalCode= SlotsPostalCode::whereNull('slots_postal_code.deleted_at')->where('slot_id','=',$id)->get();

                  $d=['data'=>$data];
                  
                   return json_encode($d);
        } 





        public function get_detail($id)
        {
                  $data=Slots::where('id','=',$id)->first();
                  // $dataPostalCode= SlotsPostalCode::whereNull('slots_postal_code.deleted_at')->where('slot_id','=',$id)->get();
                  $d=['data'=>$data];
                

                  return json_encode($d);
              
        }  

        public function post_update(Request $request)
        {

            $id = $request->input('id_time');

            $slotsupdate = Slots::where('id', '=', $id)->first();

            $slotsupdate->vehicle = $request->input('vehicle_edit');
            $slotsupdate->start_time = $request->input('start_time_edit');
            $slotsupdate->end_time = $request->input('end_time_edit');
            $slotsupdate->joey_count = $request->input('joey_count_edit');
            $slotsupdate->custom_capacity = $request->input('custom_capacity_edit');
            // $slotsupdate->orders_count = $request->input('orders_count_edit');
            $slotsupdate->save();

            // SlotsPostalCode::where('slot_id', '=', $request->input('id_time'))->delete();

            // foreach ($request->input('postal_code_edit') as $value) {
            //         $slotPostalCode_update = new SlotsPostalCode();
            //         $slotPostalCode_update->slot_id = $request->input('id_time');
            //         $slotPostalCode_update->postal_code = $value;
            //         $slotPostalCode_update->save();
            //      }

            return back()->with('success','Slot Updated Successfully!');

        } 


        public function post_deleteslot(Request $request)
        {
            $id = $request->input('delete_id');
            Slots::where('id','=',$id)->update(['deleted_at'=>date('Y-m-d h:i:s')]);
            return redirect()->back()->with('success','slot Deleted Successfully!');
        }

        public function getPostalCodes($hubId){
               
                date_default_timezone_set('America/Toronto');
               
                $currentdate = date('y-m-d');
                $date = date('Y-m-d', strtotime($currentdate. ' -1 days'));
               
                // $postals = Sprint::join('sprint__tasks','sprint_id','=','sprint__sprints.id')
                // ->join('merchantids','task_id','=','sprint__tasks.id')
                // ->join('locations','location_id','=','locations.id');
                if ($hubId == 16) 
                {
                        $postals = Sprint::join('sprint__tasks','sprint_id','=','sprint__sprints.id')
                        ->join('merchantids','task_id','=','sprint__tasks.id')
                        ->join('locations','location_id','=','locations.id');
                      
                        $postals =  $postals->whereIn('creator_id',[477260])
                        ->where(\DB::raw("CONVERT_TZ(sprint__sprints.created_at,'UTC','America/Toronto')"),'like',$date."%")
                        ->where('in_hub_route',0) 
                        ->whereIn('sprint__sprints.status_id',[61,13]);
                        $postals = $postals->whereNotNull('tracking_id')
                        ->where('tracking_id','!=','')
                        ->distinct()
                        ->get([\DB::raw('SUBSTRING(locations.postal_code,1,3) as postal')]);

                }
                if ($hubId == 19) 
                {
                        $amazon = Sprint::join('sprint__tasks','sprint_id','=','sprint__sprints.id')
                        ->join('merchantids','task_id','=','sprint__tasks.id')
                        ->join('locations','location_id','=','locations.id')
                        ->whereIn('creator_id',[477282])
                        ->where(\DB::raw("CONVERT_TZ(sprint__sprints.created_at,'UTC','America/Toronto')"),'like',$date."%")
                        ->where('in_hub_route',0) 
                        ->whereIn('sprint__sprints.status_id',[61,13])
                        ->whereNotNull('tracking_id')
                        ->where('tracking_id','!=','')
                        ->distinct()
                        ->get([\DB::raw('SUBSTRING(locations.postal_code,1,3) as postal')])->toArray();

                        $ctc = Sprint::join('sprint__tasks','sprint_id','=','sprint__sprints.id')
                        ->join('merchantids','task_id','=','sprint__tasks.id')
                        ->join('locations','location_id','=','locations.id')
                        ->whereIn('creator_id',[477340,477341,477342,477343,477344,477345])
                        ->where('in_hub_route',0) 
                        ->whereIn('sprint__sprints.status_id',[124])
                        ->whereNotNull('tracking_id')
                        ->where('tracking_id','!=','')
                        ->distinct()
                        ->get([\DB::raw('SUBSTRING(locations.postal_code,1,3) as postal')])->toArray();

                        $postals = array_merge($amazon,$ctc);
                       
                        
                }
                if ($hubId == 17)
                {    
                        $postals = Sprint::join('sprint__tasks','sprint_id','=','sprint__sprints.id')
                        ->join('merchantids','task_id','=','sprint__tasks.id')
                        ->join('locations','location_id','=','locations.id');

                       $postals = $postals->whereIn('creator_id',[477255,477254,477283,477284,477286,477287,477288,477289,477307,477308,477309,477310,477311,477312,477313,477314,477292,477294,477315,477317,477316,477295,477302,477303,477304,477305,477306,477296,477290,477297,477298,477299,477300,477320,477301,477318,477334,477335,477336,477337,477338,477339,477434])
                       ->where('in_hub_route',0) 
                       ->whereIn('sprint__sprints.status_id',[124]);
                      
                       $postals = $postals->whereNotNull('tracking_id')
                        ->where('tracking_id','!=','')
                        ->distinct()
                        ->get([\DB::raw('SUBSTRING(locations.postal_code,1,3) as postal')]);
                }
               
                // $postals = $postals->whereNotNull('tracking_id')
                // ->where('tracking_id','!=','')
                // ->distinct()
                // ->get([\DB::raw('SUBSTRING(locations.postal_code,1,3) as postal')]);

                return backend_view('zones.postal-codes', ['data'=> $postals] );
        }


}
