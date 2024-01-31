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

use App\Area;
use App\Zone;
use App\UserEntities;

class AreaController extends BackendController
{
    public function getIndex()
    {
        $area = Area::with('zone')->get();
        /*dd($area);*/

        return backend_view( 'area.index')->with('area',$area);
    }

    public function edit(Area $area)
    {
        return backend_view('area.edit', compact('area'));
    }

    public function add()
    {
        return backend_view('area.add');
    }

    public function create(Request $request)
    {
        $data = $request->all();
       /*if ($request->hasFile('product_image')) {
            $imageName =  \Illuminate\Support\Str::random(12) . '.' . $request->file('product_image')->getClientOriginalExtension();
            $path = public_path(Config::get('constants.front.dir.areaPicPath'));
            $request->file('product_image')->move($path, $imageName);

            $data['product_image'] = $imageName;
        }
        else
        {
            $imageName="default.png";
            $data['product_image'] = $imageName;
            
        }*/
        
        Area::create( $data );

        session()->flash('alert-success', 'Area has been created successfully!');
            return redirect( 'backend/area/add');
    }

    public function update(Request $request, Area $area)
    {
        $data = $request->all();
        /*if ($request->hasFile('product_image')) {
            $imageName =  \Illuminate\Support\Str::random(12) . '.' . $request->file('product_image')->getClientOriginalExtension();
            $path = public_path(Config::get('constants.front.dir.areaPicPath'));
            $request->file('product_image')->move($path, $imageName);

            $data['product_image'] = $imageName;
        }*/
        $area->update( $data );

        session()->flash('alert-success', 'Area has been updated successfully!');
        return redirect( 'backend/area/edit/' . $area->id );
    }

    public function destroy(Area $area)
    {   
        $id = $area->id ;   
        $area->delete();
        Area::where('id',$id)->delete();

        session()->flash('alert-success', 'Area has been deleted successfully!');
        return redirect( 'backend/area' );
    }

}
