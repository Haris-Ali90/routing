<?php

namespace App\Http\Controllers\Backend;

use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Backend\BackendController;

use App\JoeyRoute;
use App\Slots;
use App\Sprint;
use App\SlotsPostalCode;
use App\Teachers;
use App\Institute;
use App\Amazon;
use App\CoursesRequest;
use date;
use DB;
use Carbon\Carbon;


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
use App\WMSlots;
use App\WMSlotsPostalCode;
use \JoeyCo\Mapping\Routific\Client;


class WMSlotsController extends BackendController
{
        public function wmSlotsData(Request $request , $id)
        {

                 $data = $request->input('date');
                 $slots = WMSlots::whereNull('deleted_at')->where('store_num','=',$id)->orderBy('id' , 'DESC')->get();

                 return backend_view('wmslots.slotlist', ['data'=> $slots, 'id'=> $id ] );
        }

        public function wmSlotCreate(Request $request)
        {

       
                  $slot = new WMSlots();

                  $slot->store_num = $request->input('store_num');
                  $slot->vehicle = $request->input('vehicle');
                  $slot->start_time = $request->input('start_time');
                  $slot->end_time = $request->input('end_time');
                  $slot->joey_count = $request->input('joey_count');
                  // $slot->orders_count = $request->input('orders_count');

                  $slot->save();
               
                return back()->with('success','Slot Added Successfully!');
        }  


        public function getUpdate($id)
        {
          
                  $data=WMSlots::where('id','=',$id)->first();
              

                  $d=['data'=>$data];
                
                   return json_encode($d);
        } 





        public function getDetail($id)
        {
                  $data=WMSlots::where('id','=',$id)->first();
                 
                  $d=['data'=>$data];
                

                  return json_encode($d);
              
        }  

        public function postUpdate(Request $request)
        {

            $id = $request->input('id_time');
            
            $slotsupdate = WMSlots::where('id', '=', $id)->first();
            
            $slotsupdate->vehicle = $request->input('vehicle_edit');
            $slotsupdate->start_time = $request->input('start_time_edit');
            $slotsupdate->end_time = $request->input('end_time_edit');
            $slotsupdate->joey_count = $request->input('joey_count_edit');
            // $slotsupdate->orders_count = $request->input('orders_count_edit');
            $slotsupdate->save();

          

          
            return back()->with('success','Slot Updated Successfully!');

        } 


  

        public function postDeleteslot(Request $request)
        {
            $id = $request->input('delete_id');
            WMSlots::where('id','=',$id)->update(['deleted_at'=>date('Y-m-d h:i:s')]);
            return redirect()->back()->with('success','Slot Deleted Successfully!');
        }


}
