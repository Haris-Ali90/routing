<?php

namespace App\Http\Controllers\Backend;

use App\Hub;
use App\HubStore;
use App\HubVendorDistance;
use App\HubZones;
use App\Vendor;
use App\Zone;
use App\ZoneVendorRelationship;
use App\RoutingZones;
use Illuminate\Http\Request;

class HubStoresController extends BackendController
{

    // get all hubs with zones
    public function index()
    {
        $hubs = Hub::with('zone')->whereNull('deleted_at')->get();
        return backend_view('hub_stores.index', compact('hubs'));
    }

    // calculate hub to vendor distance
    public function createHubAndVendorDistance($hubId)
    {
        //get all hub zones
        $zones = HubZones::where('hub_id', $hubId)->whereNull('deleted_at')->get();

        //get vendor ids by zone ids
        $vendors = [];
        foreach ($zones as $zone) {
            $getVendorIds = ZoneVendorRelationship::where('zone_id', $zone->zone_id)->pluck('vendor_id');
            foreach ($getVendorIds as $getVendorId) {
                $vendors[] = $getVendorId;
            }
        }


//        dd($vendors);

        //get all hubs and vendors
        $hubsData = Hub::whereNull('deleted_at')->get();
        $vendorsData = Vendor::whereNull('deleted_at')->whereIn('id', $vendors)->get();

        //calculate distance and return hubId, vendorId, distance, and vendorName
        $hubVendorDistanceData = [];
        foreach ($vendorsData as $vendor) {
            foreach ($hubsData as $hub) {

                $hubLatitude = (float)substr($hub->hub_latitude, 0, 8) / 1000000;
                $hubLongitude = (float)substr($hub->hub_longitude, 0, 9) / 1000000;
                $vendorLatitude = (float)substr($vendor->latitude, 0, 8) / 1000000;
                $vendorLongitude = (float)substr($vendor->longitude, 0, 9) / 1000000;

                $vendorDistance = $this->get_distance_between_points($hubLatitude, $hubLongitude, $vendorLatitude, $vendorLongitude);
                $hubVendorDistanceData[] = [
                    'hub_id' => $hub->id,
                    'vendor_id' => $vendor->id,
                    'distance' => $vendorDistance
                ];
            }
        }

        $distance = [];
        foreach ($hubVendorDistanceData as $data) {
            if ($data['hub_id'] == $hubId) {
                if ($data['distance'] <= 10) {
                    $vendors = Vendor::whereNull('deleted_at')->find($data['vendor_id']);
                    $distance[] = [
                        'hub_id' => $data['hub_id'],
                        'vendor_id' => $data['vendor_id'],
                        'vendor_name' => $vendors->first_name . ' ' . $vendors->last_name,
                        'distance' => round($data['distance'], 2)

                    ];
                }
            }
        }

        if(empty($vendors)){
            $vendorsAlready = Vendor::whereNull('deleted_at')->get();

            foreach($vendorsAlready as $vendorAl){
                $distance[] = [
                    'hub_id' => $hubId,
                    'vendor_id' => $vendorAl->id,
                    'vendor_name' => $vendorAl->first_name . ' ' . $vendorAl->last_name,
                    'distance' =>0
                ];
            }
            return $distance;
        }else{
            return $distance;
        }


    }

    // create hub stores function
    public function hubStores($hub)
    {
        return backend_view('hub_stores.add', compact('hub'));
    }

    //calculate distance
    public function get_distance_between_points($latitude1, $longitude1, $latitude2, $longitude2)
    {
        $meters = $this->get_meters_between_points($latitude1, $longitude1, $latitude2, $longitude2);
        $kilometers = $meters / 1000;
        $miles = $meters / 1609.34;
        $yards = $miles * 1760;
        $feet = $miles * 5280;
        return $kilometers;
    }

    public function get_meters_between_points($latitude1, $longitude1, $latitude2, $longitude2)
    {
        if (($latitude1 == $latitude2) && ($longitude1 == $longitude2)) {
            return 0;
        } // distance is zero because they're the same point
        $p1 = deg2rad($latitude1);
        $p2 = deg2rad($latitude2);
        $dp = deg2rad($latitude2 - $latitude1);
        $dl = deg2rad($longitude2 - $longitude1);
        $a = (sin($dp / 2) * sin($dp / 2)) + (cos($p1) * cos($p2) * sin($dl / 2) * sin($dl / 2));
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $r = 6371008; // Earth's average radius, in meters
        $d = $r * $c;
        return $d; // distance, in meters
    }

    public function hubStoresCreate(Request $request)
    {

        HubStore::where('hub_id', $request->get('hub_id'))->update(['deleted_at' => date('Y-m-d H:i:s')]);
        foreach ($request->get('vendor_id') as $vendorId) {
            HubStore::create([
                'hub_id' => $request->get('hub_id'),
                'vendor_id' => $vendorId,
            ]);
        }

        return redirect()->route('hub.list.zones')->with('success', 'hub store add successfully');
    }

    public function attachZones($id)
    {

        $hubs = Hub::with('zone')->find($id);
        $zones = RoutingZones::whereNull('deleted_at')->get();
        return  backend_view('hub_stores.addzones', compact('hubs', 'zones', 'id'));
    }

    public function attachZonesUpdate(Request $request)
    {
        HubZones::where('hub_id',$request->get('hub_id'))->update(['deleted_at' => date('Y-m-d H:i:s')]);
        foreach ($request->get('zone_id') as $zoneId){
            HubZones::create([
                'hub_id' => $request->get('hub_id'),
                'zone_id' => $zoneId,
            ]);
        }
        return redirect()->route('hub.list.zones')->with('success', 'hub store add successfully');
    }
}