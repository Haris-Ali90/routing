<?php

namespace App\Http\Controllers\Backend;

use App\Complain;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Backend\CategoryRequest;
use Illuminate\Support\Facades\Request as FacadeRequest;
use App\Http\Controllers\Backend\BackendController;


class ComplainController extends BackendController
{

    /**
     * Register Complain
     * Muhammad Raqib
     * @date 11/10/2022
     */
    public function index(Request $request){

        return backend_view('complain.register');
    }
    /**
     * Send/Post Complain
     * Muhammad Raqib
     * @date 11/10/2022
     */
    public function create(Request $request){
        $complain_post = $request->all();
        $complain = new Complain();
        $complain->type = $complain_post['reason'];
        $complain->joey_id = Auth::user()->id;
        $complain->description = $complain_post['complain_data'];
        $complain->save();
        return back()->with('success','Complain Added Successfully!');
    }
    /*end*/

}
