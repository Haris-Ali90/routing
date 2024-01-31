<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\ReattemptScanOrderRequest;
use App\JoeyRouteLocations;
use App\MerchantIds;
use App\Sprint;
use App\Task;
use Illuminate\Http\Request;

class ManualSortedTrackingController extends BackendController
{
    public function index(Request $request)
    {
        //Getting request Data
        $exists = 0;
        $data=true;
        $trackingId=0;
        if($request->get('tracking_id')){
            $trackingId = $request->get('tracking_id');
        }

        if (strpos($trackingId,',') !== false) {
            $tracking_id = explode(',',$trackingId);
            $routeData = JoeyRouteLocations::join('merchantids','merchantids.task_id','=','joey_route_locations.task_id')
                ->join('sprint__tasks','sprint__tasks.id','=','merchantids.task_id')
                ->whereIn('tracking_id',$tracking_id)
                ->whereNotIn('sprint__tasks.status_id', [36])
                ->whereNull('joey_route_locations.deleted_at')
                ->groupBy('merchantids.tracking_id')
                ->get(['joey_route_locations.id','joey_route_locations.created_at','sprint__tasks.status_id','sprint__tasks.sprint_id','joey_route_locations.task_id','joey_route_locations.route_id','joey_route_locations.ordinal','merchant_order_num','tracking_id','joey_route_locations.is_transfered']);
        }
        else{
            $routeData = JoeyRouteLocations::join('merchantids','merchantids.task_id','=','joey_route_locations.task_id')
                ->join('sprint__tasks','sprint__tasks.id','=','merchantids.task_id')
                ->where('tracking_id','=',$trackingId)
                ->whereNotIn('sprint__tasks.status_id', [36])
                ->whereNull('joey_route_locations.deleted_at')
                ->groupBy('merchantids.tracking_id')
                ->get(['joey_route_locations.id','joey_route_locations.created_at','sprint__tasks.status_id','sprint__tasks.sprint_id','joey_route_locations.task_id','joey_route_locations.route_id','joey_route_locations.ordinal','merchant_order_num','tracking_id','joey_route_locations.is_transfered']);
        }

        if($routeData){
            foreach ($routeData as $route){
                if($route->status_id == 61 || $route->status_id == 124){
                    $exists =1;
                }
                if($route->status_id == 133 && $request->has('tracking_id')){
                    $data=false;
                }
            }
        }

        return backend_view('manual_sorted_tracking.index', compact('routeData', 'exists', 'data'));
    }

    public function singleMarked(Request $request)
    {
        $merchantRecord = MerchantIds::whereNull('deleted_at')->where('tracking_id', $request->tracking_id)->get();
        foreach($merchantRecord as $merchant){
            $sprintId = Task::where('id', $merchant->task_id)->pluck('sprint_id');
            $sprint = Sprint::whereIn('id', $sprintId)->update(['status_id' => 133]);
            $task = Task::where('id', $merchant->task_id)->update(['status_id' => 133]);
        }
        return json_encode(['status' => 200, 'message' => 'package sorted marked successfully']);

    }

    public function multipleMarkedTrackingIds(Request $request)
    {
        $request_data = $request->data;
        foreach($request_data as $key => $single_request) {
            $merchantRecord = MerchantIds::whereNull('deleted_at')->where('tracking_id', $single_request['tracking_id'])->get();
            foreach($merchantRecord as $merchant){
                $sprintId = Task::where('id', $merchant->task_id)->pluck('sprint_id');
                $sprint = Sprint::whereIn('id', $sprintId)->update(['status_id' => 133]);
                $task = Task::where('id', $merchant->task_id)->update(['status_id' => 133]);
            }
        }
        return json_encode(['status' => 200, 'message' => 'package sorted marked successfully']);
    }
}