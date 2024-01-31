<?php

namespace App\Http\Controllers\Backend;


use App\JoeyRoute;
use App\Task;
use App\Sprint;
use App\BoradlessDashboard;
use App\JoeyRouteLocations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MoveRouteController extends BackendController{
    /**
     * Get Route orders
     */
    public function getMoveRoute(Request $request){
        return backend_view('move_route.index');
    }

    public function postUpdateRouteDate(Request $request){

        $validator = Validator::make($request->all(),[
            'route_id' => 'required|exists:joey_routes,id'
        ]);

        if($validator->fails() == true){
            return back()->with('error','Invalid Route id');
        }

        $id = $request['route_id'];

        if (strpos($id,',') !== false) {
            $route_id = explode(',',$id);
            $routes = JoeyRoute::whereIn('id',$route_id)->pluck('date', 'id');
        }
        else{
            $routes = JoeyRoute::where('id',$id)->pluck('date', 'id');
        }

        foreach($routes as $RouteId => $date){
            if($date > date('Y-m-d H:i:s')){
                return back()->with('error','Route Date Already Updated!');
            }

            $updateDate = date('Y-m-d 17:00:00', strtotime( date('Y-m-d H:i:s') . " +1 days"));
            JoeyRoute::where('id', $RouteId)->update(['date' => $updateDate]);
        }


        return back()->with('success','Route Date Updated Successfully!');
    }

}