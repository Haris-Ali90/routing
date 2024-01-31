<?php

namespace App\Http\Controllers\Backend;

use Config;

use Illuminate\Http\Request;

// use App\Http\Requests;
use App\Http\Requests\Backend\CategoryRequest;
use Illuminate\Support\Facades\Request as FacadeRequest;
use App\Http\Controllers\Backend\BackendController;
use Illuminate\Support\Facades\Auth;
//use Validator;

use App\RoutingEngine;
use App\UserEntities;

class RouteRngineController extends BackendController
{
    public function getIndex()
    {
        $rountingControls = RoutingEngine::whereNull('deleted_at')->get();

        return backend_view('routeengine.index',compact('rountingControls'));
    }
    public function routingEngine(Request $request)
    {
        $routingEngine=routingEngine::find($request->id);
        $routingEngine->engine = $request->egine_iid;
        $routingEngine->save();
        return back()->with('success', 'Status Updated Successfully!');
    }

}
