<?php

namespace App\Http\Controllers\Backend;

use App\CustomRoutingTrackingId;
use App\Http\Requests\Backend\ReattemptScanOrderRequest;
use App\Hub;
use App\JoeyRouteLocations;
use App\MerchantIds;
use App\RoutingZones;
use App\SlotsPostalCode;
use App\Sprint;
use App\Task;
use App\Zone;
use Illuminate\Http\Request;

class AssigningFsaController extends BackendController
{
    public function index(Request $request)
    {
        $trackingIds = CustomRoutingTrackingId::where('valid_id', 1)->where('is_inbound', 1)->pluck('tracking_id');
        $postalCodes = MerchantIds::join('sprint__tasks', 'sprint__tasks.id', '=', 'merchantids.task_id')
            ->join('sprint__sprints', 'sprint__sprints.id', '=', 'sprint__tasks.sprint_id')
            ->join('locations', 'locations.id', '=', 'sprint__tasks.location_id')
            ->where('sprint__tasks.status_id', 124)
            ->where('sprint__sprints.status_id', 124)
            ->whereIn('tracking_id', $trackingIds)
            ->pluck('locations.postal_code');

        $breakAblePostalCodes=[];
        foreach($postalCodes as $postalCode){
            $breakAblePostalCodes[] = substr($postalCode,0,3);
        }

        $uniqueOrderPostalCodes = array_unique($breakAblePostalCodes);
        $checkPostalCodeExists = SlotsPostalCode::WhereNull('slots_postal_code.deleted_at')->whereIn('postal_code', $uniqueOrderPostalCodes)->pluck('postal_code')->toArray();

        $Codes=[];
        foreach($uniqueOrderPostalCodes as $Code){
           if(!in_array($Code, $checkPostalCodeExists)){
               $Codes[] = $Code;
           }
        }

        $hubs = Hub::WhereNull('deleted_at')->get();

        return backend_view('assigning_fsa.postal_codes_list', compact('Codes', 'hubs'));

    }

    public function zoneListByHubId(Request $request)
    {
        return RoutingZones::whereNull('deleted_at')->whereNull('is_custom_routing')->where('hub_id',$request->get('id'))->get();
    }

    public function assigningPostalCode(Request $request)
    {
        $slotPostalCodes = SlotsPostalCode::create([
            'zone_id' => $request->get('zone_id'),
            'postal_code' => $request->get('postal_code'),
        ]);
        return json_encode(['status' => 200, 'message' => 'add postal code successfully']);
    }


}