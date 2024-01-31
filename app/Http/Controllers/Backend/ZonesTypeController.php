<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\StoreSubadminRequest;

use App\Http\Requests\Backend\StoreZoneTypeRequest;
use App\Http\Requests\Backend\UpdateZoneTypeRequest;
use App\ZonesTypes;
use Config;

use Illuminate\Http\Request;


use App\User;

use Hash;

class ZonesTypeController extends BackendController
{


    public function getIndex()
    {

        $zoneType = ZonesTypes::where('deleted_at',null)->get();

        return backend_view( 'zonetype.index', compact('zoneType') );
    }



    public function edit($id)
    {
        $zonetype_id = base64_decode($id);
        $zoneType = ZonesTypes::find($zonetype_id);

        return backend_view( 'zonetype.edit', compact('zoneType') );
    }

    public function add()
    {
        return backend_view( 'zonetype.add');
    }

    public function create(StoreZoneTypeRequest $request, ZonesTypes $zonesType)
    {
        $postData = $request->all();

        $zonesType->create( $postData );

        session()->flash('alert-success', 'Zone type  has been created successfully!');
        return redirect( 'backend/zonestypes');

    }


    public function update(UpdateZoneTypeRequest $request, ZonesTypes $zoneTypes)
    {

      /*  $this->validate($request,[
            'title' => 'required|max:255',
            'amount'      => 'required|numeric|min:0',
        ]);*/
        $postData = $request->all();

        $zoneTypes->update($postData);

        session()->flash('alert-success', 'Zone Type has been updated successfully!');
        return redirect( 'backend/zonestypes');
    }

    public function destroy(ZonesTypes  $zoneTypes)
    {

        $zoneTypes->update(['deleted_at' => date('Y-m-d H:i:s')]);
       session()->flash('alert-success', 'Zone type has been deleted successfully!');
        return redirect( 'backend/zonestypes');
    }



}
