<?php

namespace App\Http\Controllers\Backend;

use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\Backend\HelpRequest;
// use App\Http\Requests;
use Illuminate\Support\Facades\Request as FacadeRequest;
use App\Http\Controllers\Backend\BackendController;
//use Validator;

use App\Cms;



class CmsController extends BackendController {

    public function getIndex() {

        $getcms = Cms::get();
        return backend_view('cms.index', compact('getcms'));
    }

    public function edit(Cms $cms) 
    {
//        $cms = Cms::get();
        $cms = Cms::where('id',$cms->id)->first();
      return backend_view('cms.edit', compact('cms'));
    }
    
    public function update(HelpRequest $request,Cms $cms) {

        $data = $request->all();
        $cms->update($data);
        session()->flash('alert-success', 'Cms has been updated successfully!');
        return redirect('backend/cms');
    }

    public function destroy(Help $help) {

        $help->delete();

        session()->flash('alert-success', 'Help has been deleted successfully!');
        return redirect('backend/helps');
    }



}
