<?php

namespace App\Http\Controllers\Backend;


use App\TrackingImageHistory;
use App\Task;
use App\Sprint;
use App\BoradlessDashboard;
use App\JoeyRouteLocations;
use Illuminate\Http\Request;



class ManualRouteController extends BackendController{
    /**
     * Get Route orders
     */
    public function getManualRoute(Request $request){
        return backend_view('manualRoute.index');
    }

    public function postUpdateManualRoute(Request $request){
        // dd($request);
        $id = $request['route_id'];
        if (strpos($id,',') !== false) {
            $route_id = explode(',',$id);
            $routes = JoeyRouteLocations::whereIn('route_id',$route_id)->pluck('task_id');
        }
        else{
            $routes = JoeyRouteLocations::where('route_id',$id)->pluck('task_id');
        }
        
        #Defined status of tasks
        $sprint_task = Task::whereIn('id',$routes)->whereIn('status_id',[133,121])->pluck('id','sprint_id');
        $check = 0;
        $update_count = array(); 
        foreach($sprint_task as $sprint => $task){
            $check = 1;
            Task::where('id',$task)->update(['status_id'=>112]);
            Sprint::where('id',$sprint)->update(['status_id'=>112, 'in_hub_route'=>0]);
            BoradlessDashboard::where('task_id',$task)->update(['task_status_id'=>112]);
            $update_count [] = $sprint;
        }
        #Define status and conditions for status 124
        $sprint_task = Task::whereIn('id',$routes)->whereIn('status_id',[124])->pluck('id','sprint_id');
        foreach($sprint_task as $sprint => $task){
            $check = 1;
            Sprint::where('id',$sprint)->update(['in_hub_route'=>0]);
            $update_count [] = $sprint;
        }
        #Define status and conditions for status 61
        $sprint_task = Task::whereIn('id',$routes)->whereIn('status_id',[61])->pluck('id','sprint_id');
        foreach($sprint_task as $sprint => $task){
            $check = 1;
            $creator_id = Sprint::where('id',$sprint)->first()->creator_id;
            if($creator_id == 477621){
                Sprint::where('id',$sprint)->update(['in_hub_route'=>0]);
            }
            else{
                Task::where('id',$task)->update(['status_id'=>124]);
                Sprint::where('id',$sprint)->update(['status_id'=>124, 'in_hub_route'=>0]);
                BoradlessDashboard::where('task_id',$task)->update(['task_status_id'=>124]);
            }
            $update_count [] = $sprint;
        }

        if($check == 1){
            return back()->with('success',count($update_count).' orders Updated Successfully!'); 
        }
        else{
            return back()->with('error','No continue status found in this route!'); 
        }
    }

    public function postUpdateManualRouteView(Request $request){
        $sprint_id = $request['sprint_id'];
        $task_id = $request['task_id'];
        $status_id = $request['status_id'];
        $update_count = array();
        $check = 0;
        $creator_id = Sprint::where('id',$sprint_id)->first()->creator_id;
        if($creator_id == 477621){
            if($status_id == 61){
                Sprint::where('id',$sprint_id)->update(['in_hub_route'=>0]);
                $check = 1;
            }
            else if($status_id == 124 || $status_id == 125 || $status_id == 24){
                Task::where('id',$task_id)->update(['status_id'=>124]);
                Sprint::where('id',$sprint_id)->update(['status_id'=>124, 'in_hub_route'=>0]);
                BoradlessDashboard::where('task_id',$task_id)->update(['task_status_id'=>124]);
                $check = 1;
            }
            else{
                Task::where('id',$task_id)->update(['status_id'=>112]);
                Sprint::where('id',$sprint_id)->update(['status_id'=>112, 'in_hub_route'=>0]);
                BoradlessDashboard::where('task_id',$task_id)->update(['task_status_id'=>112]);
                $check = 1;
            }
        }
        else{
            if($status_id == 61 || $status_id == 124 || $status_id == 125 || $status_id == 24){
                Task::where('id',$task_id)->update(['status_id'=>124]);
                Sprint::where('id',$sprint_id)->update(['status_id'=>124, 'in_hub_route'=>0]);
                BoradlessDashboard::where('task_id',$task_id)->update(['task_status_id'=>124]);
                $check = 1;
            }
            else{
                Task::where('id',$task_id)->update(['status_id'=>112]);
                Sprint::where('id',$sprint_id)->update(['status_id'=>112, 'in_hub_route'=>0]);
                BoradlessDashboard::where('task_id',$task_id)->update(['task_status_id'=>112]);
                $check = 1;
            }
        }
       
        $update_count [] = $sprint_id;        
        if($check == 1){
            return back()->with('success',$this->numberTowords(count($update_count)).' Orders Updated Successfully!'); 
        }
        
    }

    public function postUpdateManualRouteViewMultiple(Request $request){
        $sprint_data = Task::whereIn('sprint__tasks.id',$request['checked_task_ids'])
        ->join('sprint__sprints', 'sprint__sprints.id', '=', 'sprint__tasks.sprint_id')
        ->get(['sprint__sprints.id as sprintId','sprint__tasks.id as taskId','creator_id','sprint__sprints.status_id as sprintStatus']);
        $check = 0;
        foreach($sprint_data as $key => $val){
            if($val->creator_id == 477621){
                if($val->sprintStatus == 61){
                    Sprint::where('id',$val->sprintId)->update(['in_hub_route'=>0]);
                    $check = 1;
                }
                else if($val->sprintStatus == 124 || $val->sprintStatus == 125 || $val->sprintStatus == 24){
                    Task::where('id',$val->taskId)->update(['status_id'=>124]);
                    Sprint::where('id',$val->sprintId)->update(['status_id'=>124, 'in_hub_route'=>0]);
                    BoradlessDashboard::where('task_id',$val->taskId)->update(['task_status_id'=>124]);
                    $check = 1;
                }
                else{
                    Task::where('id',$val->taskId)->update(['status_id'=>112]);
                    Sprint::where('id',$val->sprintId)->update(['status_id'=>112, 'in_hub_route'=>0]);
                    BoradlessDashboard::where('task_id',$val->taskId)->update(['task_status_id'=>112]);
                    $check = 1;
                }
            }
            else{
                if($val->sprintStatus == 61 || $val->sprintStatus == 124 || $val->sprintStatus == 125 || $val->sprintStatus == 24){
                    Task::where('id',$val->taskId)->update(['status_id'=>124]);
                    Sprint::where('id',$val->sprintId)->update(['status_id'=>124, 'in_hub_route'=>0]);
                    BoradlessDashboard::where('task_id',$val->taskId)->update(['task_status_id'=>124]);
                    $check = 1;
                }
                else{
                    Task::where('id',$val->taskId)->update(['status_id'=>112]);
                    Sprint::where('id',$val->sprintId)->update(['status_id'=>112, 'in_hub_route'=>0]);
                    BoradlessDashboard::where('task_id',$val->taskId)->update(['task_status_id'=>112]);
                    $check = 1;
                }                   
            }
            $update_count [] = $val->sprintId;
        }
        if($check == 1){
            return array('success',$this->numberTowords(count($update_count)).' Orders Updated Successfully!'); 
        }
    }

    public function numberTowords($num)
    { 
        $ones = array( 
            1 => "One",
            2 => "Two",
            3 => "Three",
            4 => "Four",
            5 => "Five",
            6 => "Six",
            7 => "Seven",
            8 => "Eight",
            9 => "Nine",
            10 => "Ten",
            11 => "Eleven",
            12 => "Twelve",
            13 => "Thirteen",
            14 => "Fourteen",
            15 => "Fifteen",
            16 => "Sixteen",
            17 => "Seventeen",
            18 => "Eighteen",
            19 => "Nineteen"
        ); 
        $tens = array( 
            1 => "Ten",
            2 => "Twenty",
            3 => "Thirty",
            4 => "Forty",
            5 => "Fifty",
            6 => "Sixty",
            7 => "Seventy",
            8 => "Eighty",
            9 => "Ninety"
        ); 
        $hundreds = array( 
            "Hundred", 
            "Thousand", 
            "Million", 
            "Billion", 
            "Trillion", 
            "Quadrillion" 
        ); //limit t quadrillion 
        $num = number_format($num,2,".",","); 
        $num_arr = explode(".",$num); 
        $wholenum = $num_arr[0]; 
        $decnum = $num_arr[1]; 
        $whole_arr = array_reverse(explode(",",$wholenum)); 
        krsort($whole_arr); 
        $rettxt = ""; 
        foreach($whole_arr as $key => $i){ 
            if($i < 20){ 
                $rettxt .= $ones[$i]; 
            }
            elseif($i < 100){ 
                $rettxt .= $tens[substr($i,0,1)]; 
                $rettxt .= " ".$ones[substr($i,1,1)]; 
            }
            else{ 
                $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
                $rettxt .= " ".$tens[substr($i,1,1)]; 
                $rettxt .= " ".$ones[substr($i,2,1)]; 
            } 
            if($key > 0){ 
                $rettxt .= " ".$hundreds[$key]." "; 
            } 
        } 
        if($decnum > 0){ 
            $rettxt .= " and "; 
            if($decnum < 20){ 
                $rettxt .= $ones[$decnum]; 
            }
            elseif($decnum < 100){ 
                $rettxt .= $tens[substr($decnum,0,1)]; 
                $rettxt .= " ".$ones[substr($decnum,1,1)]; 
            } 
        } 
    return $rettxt; 
    } 

}
