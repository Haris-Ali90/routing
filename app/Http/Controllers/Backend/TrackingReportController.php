<?php

namespace App\Http\Controllers\Backend;


use App\AmazonEnteries;

use App\Classes\RestAPI;
use App\CtcVendor;
use App\CustomRoutingTrackingId;
use App\MainfestFields;
use App\Sprint;
use App\Task;
use App\TaskHistory;
use App\TrackingNote;
use App\XmlFailedOrders;
use Illuminate\Http\Request;
use App\JoeyRoute;
use App\MerchantIds;
use Illuminate\Support\Facades\DB;


class TrackingReportController extends BackendController
{
    public static $status = array("136" => "Client requested to cancel the order",
        "137" => "Delay in delivery due to weather or natural disaster",
        "118" => "left at back door",
        "117" => "left with concierge",
        "135" => "Customer refused delivery",
        "108" => "Customer unavailable-Incorrect address",
        "106" => "Customer unavailable - delivery returned",
        "107" => "Customer unavailable - Left voice mail - order returned",
        "109" => "Customer unavailable - Incorrect phone number",
        "142" => "Damaged at hub (before going OFD)",
        "143" => "Damaged on road - undeliverable",
        "144" => "Delivery to mailroom",
        "103" => "Delay at pickup",
        "139" => "Delivery left on front porch",
        "138" => "Delivery left in the garage",
        "114" => "Successful delivery at door",
        "113" => "Successfully hand delivered",
        "120" => "Delivery at Hub",
        "110" => "Delivery to hub for re-delivery",
        "111" => "Delivery to hub for return to merchant",
        "121" => "Out for delivery",
        "102" => "Joey Incident",
        "104" => "Damaged on road - delivery will be attempted",
        "105" => "Item damaged - returned to merchant",
        "129" => "Joey at hub",
        "128" => "Package on the way to hub",
        "140" => "Delivery missorted, may cause delay",
        "116" => "Successful delivery to neighbour",
        "132" => "Office closed - safe dropped",
        "101" => "Joey on the way to pickup",
        "32" => "Order accepted by Joey",
        "14" => "Merchant accepted",
        "36" => "Cancelled by JoeyCo",
        "124" => "At hub - processing",
        "38" => "Draft",
        "18" => "Delivery failed",
        "56" => "Partially delivered",
        "17" => "Delivery success",
        "68" => "Joey is at dropoff location",
        "67" => "Joey is at pickup location",
        "13" => "At hub - processing",
        "16" => "Joey failed to pickup order",
        "57" => "Not all orders were picked up",
        "15" => "Order is with Joey",
        "112" => "To be re-attempted",
        "131" => "Office closed - returned to hub",
        "125" => "Pickup at store - confirmed",
        "61" => "Scheduled order",
        "37" => "Customer cancelled the order",
        "34" => "Customer is editting the order",
        "35" => "Merchant cancelled the order",
        "42" => "Merchant completed the order",
        "54" => "Merchant declined the order",
        "33" => "Merchant is editting the order",
        "29" => "Merchant is unavailable",
        "24" => "Looking for a Joey",
        "23" => "Waiting for merchant(s) to accept",
        "28" => "Order is with Joey",
        "133" => "Packages sorted",
        "55" => "ONLINE PAYMENT EXPIRED",
        "12" => "ONLINE PAYMENT FAILED",
        "53" => "Waiting for customer to pay",
        "141" => "Lost package",
        "60" => "Task failure",
        "145" => 'Returned To Merchant',
        "146" => "Delivery Missorted, Incorrect Address",
        '153' => 'Miss sorted to be reattempt',
        '154' => 'Joey unable to complete the route', '155' => 'To be re-attempted tomorrow');
    private $status_codes = [
        'completed' =>
            [
                "JCO_ORDER_DELIVERY_SUCCESS" => 17,
                "JCO_HAND_DELIEVERY" => 113,
                "JCO_DOOR_DELIVERY" => 114,
                "JCO_NEIGHBOUR_DELIVERY" => 116,
                "JCO_CONCIERGE_DELIVERY" => 117,
                "JCO_BACK_DOOR_DELIVERY" => 118,
                "JCO_OFFICE_CLOSED_DELIVERY" => 132,
                "JCO_DELIVER_GERRAGE" => 138,
                "JCO_DELIVER_FRONT_PORCH" => 139,
                "JCO_DEILVER_MAILROOM" => 144
            ],
        'return' =>
            [
                "JCO_ITEM_DAMAGED_INCOMPLETE" => 104,
                "JCO_ITEM_DAMAGED_RETURN" => 105,
                "JCO_CUSTOMER_UNAVAILABLE_DELIEVERY_RETURNED" => 106,
                "JCO_CUSTOMER_UNAVAILABLE_LEFT_VOICE" => 107,
                "JCO_CUSTOMER_UNAVAILABLE_ADDRESS" => 108,
                "JCO_CUSTOMER_UNAVAILABLE_PHONE" => 109,
                "JCO_HUB_DELIEVER_REDELIEVERY" => 110,
                "JCO_HUB_DELIEVER_RETURN" => 111,
                "JCO_ORDER_REDELIVER" => 112,
                "JCO_ORDER_RETURN_TO_HUB" => 131,
                "JCO_CUSTOMER_REFUSED_DELIVERY" => 135,
                "CLIENT_REQUEST_CANCEL_ORDER" => 136,
                "JCO_ON_WAY_PICKUP" => 101,
                "JCO_INCIDENT" => 102,
                "JCO_DELAY_PICKUP" => 103,
            ],

        'pickup' =>
            [
                "JCO_HUB_PICKUP" => 121
            ],

    ];


    public function statusmap($id)
    {
        $statusid = array("136" => "Client requested to cancel the order",
            "137" => "Delay in delivery due to weather or natural disaster",
            "118" => "left at back door",
            "117" => "left with concierge",
            "135" => "Customer refused delivery",
            "108" => "Customer unavailable-Incorrect address",
            "106" => "Customer unavailable - delivery returned",
            "107" => "Customer unavailable - Left voice mail - order returned",
            "109" => "Customer unavailable - Incorrect phone number",
            "142" => "Damaged at hub (before going OFD)",
            "143" => "Damaged on road - undeliverable",
            "144" => "Delivery to mailroom",
            "103" => "Delay at pickup",
            "139" => "Delivery left on front porch",
            "138" => "Delivery left in the garage",
            "114" => "Successful delivery at door",
            "113" => "Successfully hand delivered",
            "120" => "Delivery at Hub",
            "110" => "Delivery to hub for re-delivery",
            "111" => "Delivery to hub for return to merchant",
            "121" => "Pickup from Hub",
            "102" => "Joey Incident",
            "104" => "Damaged on road - delivery will be attempted",
            "105" => "Item damaged - returned to merchant",
            "129" => "Joey at hub",
            "128" => "Package on the way to hub",
            "140" => "Delivery missorted, may cause delay",
            "116" => "Successful delivery to neighbour",
            "132" => "Office closed - safe dropped",
            "101" => "Joey on the way to pickup",
            "32" => "Order accepted by Joey",
            "14" => "Merchant accepted",
            "36" => "Cancelled by JoeyCo",
            "124" => "At hub - processing",
            "38" => "Draft",
            "18" => "Delivery failed",
            "56" => "Partially delivered",
            "17" => "Delivery success",
            "68" => "Joey is at dropoff location",
            "67" => "Joey is at pickup location",
            "13" => "At hub - processing",
            "16" => "Joey failed to pickup order",
            "57" => "Not all orders were picked up",
            "15" => "Order is with Joey",
            "112" => "To be re-attempted",
            "131" => "Office closed - returned to hub",
            "125" => "Pickup at store - confirmed",
            "61" => "Scheduled order",
            "37" => "Customer cancelled the order",
            "34" => "Customer is editting the order",
            "35" => "Merchant cancelled the order",
            "42" => "Merchant completed the order",
            "54" => "Merchant declined the order",
            "33" => "Merchant is editting the order",
            "29" => "Merchant is unavailable",
            "24" => "Looking for a Joey",
            "23" => "Waiting for merchant(s) to accept",
            "28" => "Order is with Joey",
            "133" => "Packages sorted",
            "55" => "ONLINE PAYMENT EXPIRED",
            "12" => "ONLINE PAYMENT FAILED",
            "53" => "Waiting for customer to pay",
            "141" => "Lost package",
            "60" => "Task failure",
            "255" => 'Order Delay',
            "145" => 'Returned To Merchant',
            "146" => "Delivery Missorted, Incorrect Address",
            '153' => 'Miss sorted to be reattempt',
            '154' => 'Joey unable to complete the route', '155' => 'To be re-attempted tomorrow');
        return $statusid[$id];
    }


    public function getTrackingReport(Request $request)
    {
        $ctcVendorIds = CtcVendor::pluck('vendor_id')->toArray();
        $tracking_ids = trim($request->input('tracking_id'));
        $list = [];
        $ids = [];
        if (!empty($tracking_ids)) {
            if (!empty($tracking_ids)) {
                if (strpos($tracking_ids, ',') !== false) {

                    $id = explode(",", $tracking_ids);
                } else {
                    $id = explode("\n", $tracking_ids);

                }
                $i = 0;

                foreach ($id as $trackingid) {
                    if (!empty(trim($trackingid))) {
                        $pattern = "/^[a-zA-Z0-9@#$&*_-]*/i";
                        preg_match($pattern, trim($trackingid), $matche);
                        $ids[$i] = $matche[0];
                        $i++;
                    }

                }
            }
        }
        $trackingList = [];
        if (!empty($ids)) {
            $i = 0;

            foreach ($ids as $id) {
                if (!in_array($id, $trackingList)) {
                    $trackind_check = MerchantIds::where('tracking_id', $id)->first();
                    if ($trackind_check) {
                        $custome_route = CustomRoutingTrackingId::where('tracking_id', $id)->first();
                        $list[$i]['tracking_id'] = $id;
                        $list[$i]['system_create'] = $custome_route ? 'No' : 'Yes';
                        $list[$i]['custom_create'] = $custome_route ? 'Yes' : 'No';
                        $normal_route = 'No';
                        $big_box_route = 'No';
                        $custom_route = 'No';
                        $failed_order = 'No';
                        $review= '';
                        $route_number = '';
                        $sprint_status = '';
                        $date = date('Y-m-d');
                        $taskId = Task::where('id',$trackind_check->task_id)->first();
                        if ($taskId) {
                            $sprint = Sprint::where('id', $taskId->sprint_id)->first();
                            if ($sprint) {
                                $sprint_date = date('Y-m-d', strtotime($sprint->created_at));
                                $date = date('Y-m-d', strtotime($date . ' -1 days'));
                                if (in_array($sprint->creator_id, [477260, 477282])) {
                                    if ($sprint_date == $date and $sprint->status == 61 and $sprint->in_hub_route == 0) {
                                        $review = 'Enable for routing';
                                    }
                                    if (in_array($sprint->status, [101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 131, 135, 136, 143]) and $sprint->in_hub_route != 0) {
                                        $review = 'Order is not return scan';
                                    }
                                    $sprint_status = strval(self::$status[$sprint->status_id]);
                                }
                                if (in_array($sprint->creator_id, $ctcVendorIds)) {
                                    if ($sprint->status == 124 and $sprint->in_hub_route == 0) {
                                        $review = 'Enable for routing';
                                    }
                                    if (in_array($sprint->status, [101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 131, 135, 136, 143]) and $sprint->in_hub_route != 0) {
                                        $review = 'Order is not return scan';
                                    }
                                    $current_status = $sprint->status_id;
                                    if ($sprint->status_id == 17) {
                                        $preStatus = TaskHistory
                                            ::where('sprint_id', '=', $sprint->id)
                                            ->where('status_id', '!=', '17')
                                            ->orderBy('id', 'desc')->first();
                                        if (!empty($preStatus)) {
                                            $current_status = $preStatus->status_id;
                                        }
                                    }
                                    if ($current_status == 13) {
                                        $sprint_status = "At hub - processing";
                                    } else {
                                        $sprint_status = strval(self::$status[$current_status]);
                                    }
                                }
                            }
                        }

                        $route_location = MerchantIds::join('sprint__tasks', 'sprint__tasks.id', '=', 'merchantids.task_id')
                            ->join('joey_route_locations', 'joey_route_locations.task_id', '=', 'sprint__tasks.id')
                            ->whereNull('joey_route_locations.deleted_at')
                            ->where('tracking_id', $id)->first(['joey_route_locations.route_id', 'sprint__tasks.id','sprint__tasks.sprint_id']);
                        if ($route_location) {

                            $route = JoeyRoute::where('id', $route_location->route_id)->whereNull('deleted_at')->first();
                            if ($route) {
                                $route_number = $route->id;
                                if ($route->zone != null) {
                                    $is_custom_check = DB::table("zones_routing")->where('id', $route->zone)->whereNull('is_custom_routing')->whereNull('deleted_at')->first();
                                    if ($is_custom_check) {
                                        $normal_route = 'Yes';
                                    } else {
                                        $custom_route_data = DB::table('custom_routing_tracking_id')->where('tracking_id', $id)->orderBy('created_at', 'DESC')->first();
                                        if ($custom_route_data) {
                                            if ($custom_route_data->is_big_box == 1) {
                                                $big_box_route = 'Yes';
                                            } else {
                                                $custom_route = 'Yes';
                                            }
                                        } else {
                                            $custom_route = 'Yes';
                                        }
                                    }
                                } else {
                                    $custom_route_data = DB::table('custom_routing_tracking_id')->where('tracking_id', $id)->orderBy('created_at', 'DESC')->first();
                                    if ($custom_route_data) {
                                        if ($custom_route_data->is_big_box == 1) {
                                            $big_box_route = 'Yes';
                                        } else {
                                            $custom_route = 'Yes';
                                        }
                                    } else {
                                        $custom_route = 'Yes';
                                    }


                                }
                            }
                        }
                            $list[$i]['system_route'] = $normal_route;
                            $list[$i]['custom_route'] = $custom_route;
                            $list[$i]['big_box_route'] = $big_box_route;
                            $list[$i]['review'] = $review;
                            $list[$i]['route'] = $route_number;
                            $list[$i]['sprint_status'] =$sprint_status;

                            $note_data = '';
                            $note = TrackingNote::where('tracking_id',$id)->first();
                            if ($note)
                            {
                                $note_data= $note->note;
                            }
                        $list[$i]['note'] =$note_data;
                        $amazon_tracking_Ids = DB::table('xml_failed_orders')->where('tracking_id', $id)->first();
                        if ($amazon_tracking_Ids) {
                            $failed_order = 'Yes';
                        } else {
                            $ctc_tracking_Ids = DB::table('ctc_failed_orders')->where('tracking_num', $id)->first();
                            if ($ctc_tracking_Ids) {
                                $failed_order = 'Yes';
                            }
                        }

                        $list[$i]['failed_order'] = $failed_order;
                        $i++;
                    }
                    $trackingList[] = $id;
                }
            }
        }
        //dd($list);
        return backend_view('tracking-report.multipletrackingreport', ['data' => $list]);
    }

    public function saveTrackingReport(Request $request){

        $tracking_id=$request->get('tracking_id');
        $note=$request->get('note_data');
        $check_tracking = TrackingNote::where('tracking_id',$tracking_id)->first();
        if ($check_tracking){
            $check_tracking->note = $note;
            $check_tracking->save();
        }
        else {
            $createData = [
                'tracking_id' => $tracking_id,
                'note' => $note,
            ];

            TrackingNote::create($createData);
        }
        return back()->with('success','Note Save Successfully!');
    }


    public function getMontrealManifestReport(Request $request)
    {
        return backend_view('tracking-report.montrealmanifestreport');
    }

    public function getMontrealManifestData(Request $request)
    {
        $metaData = $request->all();
        $list = [];
        $manifest = (isset($metaData['manifest_ids'])) ? $metaData['manifest_ids'] : [];
        $date = $metaData['date'] ? $metaData['date'] : null;
        $metaData['current_page'] = ($metaData['current_page'] > 1) ? $metaData['current_page'] : 1;
        $curretn_manifestId = '';
        if ($date) {

            $trackingIds = [];
            $failedOrder = [];
            $failedOrderCreate = 0;
            $sortedOrder = [];

            $date = date('Y-m-d', strtotime($date . ' -1 days'));
            //dd($date);
            $startdate = $date . ' 00:00:00';
            $endDate = $date . ' 23:59:59';
            $startDateConversion = convertTimeZone($startdate, 'America/Toronto', 'UTC', 'Y-m-d H:i:s');
            $endDateConversion = convertTimeZone($endDate, 'America/Toronto', 'UTC', 'Y-m-d H:i:s');

            if ($metaData['current_page'] == 1) {
                $manifestIds_list = MainfestFields::where('vendor_id', 477260)->whereBetween('created_at', [$startDateConversion, $endDateConversion])->pluck('id')->toArray();
                $manifest = MainfestFields::whereIn('id', $manifestIds_list)->pluck('manifestNumber')->toArray();
                $manifest = array_unique($manifest);
                $manifest = array_values($manifest);
                $metaData['total_pages'] = count($manifest);

                if ($manifest) {
                    $curretn_manifestId = $manifest[0];
                    $trackingIds = DB::table('mainfest_fields')->where('manifestNumber', $curretn_manifestId)->pluck('trackingID');
                    $failedOrder = DB::table('xml_failed_orders')->whereIn('tracking_id', $trackingIds)->pluck('tracking_id');
                    $failedOrderCreate = DB::table('merchantids')->whereIn('tracking_id', $failedOrder)->count();
                    $sortedOrder = DB::table('amazon_enteries')->whereIn('tracking_id', $trackingIds)->whereNotNull('sorted_at')->pluck('tracking_id');
                }
            } elseif ($metaData['current_page'] <= $metaData['total_pages']) {
                $current_manifest_id = $manifest[$metaData['current_page'] - 1];
                if ($current_manifest_id) {
                    $curretn_manifestId = $current_manifest_id;
                    $trackingIds = DB::table('mainfest_fields')->where('manifestNumber', $current_manifest_id)->pluck('trackingID');
                    $failedOrder = DB::table('xml_failed_orders')->whereIn('tracking_id', $trackingIds)->pluck('tracking_id');
                    $failedOrderCreate = DB::table('merchantids')->whereIn('tracking_id', $failedOrder)->count();
                    $sortedOrder = DB::table('amazon_enteries')->whereIn('tracking_id', $trackingIds)->whereNotNull('sorted_at')->pluck('tracking_id');
                }
            }


            $metaData['manifest_ids'] = $manifest;
            $list['manifest'] = $curretn_manifestId;
            $list['total_order'] = count($trackingIds);
            $list['failed_order'] = count($failedOrder);
            $list['created_failed_order'] = $failedOrderCreate;
            $list['not_created_failed_order'] = ($failedOrderCreate <= count($failedOrder)) ?count($failedOrder) - $failedOrderCreate :0;
            $list['sorted_order'] =  count(array_unique($sortedOrder));

        }

        return RestAPI::response($list, 200, '', $metaData);
    }

    public function getOttawaManifestReport(Request $request)
    {
        return backend_view('tracking-report.ottawamanifestreport');
    }

    public function getOttawaManifestData(Request $request)
    {
        $metaData = $request->all();
        $list = [];
        $manifest = (isset($metaData['manifest_ids'])) ? $metaData['manifest_ids'] : [];
        $date = $metaData['date'] ? $metaData['date'] : null;
        $metaData['current_page'] = ($metaData['current_page'] > 1) ? $metaData['current_page'] : 1;
        $curretn_manifestId = '';
        if ($date) {

            $trackingIds = [];
            $failedOrder = [];
            $failedOrderCreate = 0;
            $sortedOrder = [];

            $date = date('Y-m-d', strtotime($date . ' -1 days'));
            //dd($date);
            $startdate = $date . ' 00:00:00';
            $endDate = $date . ' 23:59:59';
            $startDateConversion = convertTimeZone($startdate, 'America/Toronto', 'UTC', 'Y-m-d H:i:s');
            $endDateConversion = convertTimeZone($endDate, 'America/Toronto', 'UTC', 'Y-m-d H:i:s');

            if ($metaData['current_page'] == 1) {
                $manifestIds_list = MainfestFields::where('vendor_id', 477282)->whereBetween('created_at', [$startDateConversion, $endDateConversion])->pluck('id')->toArray();
                $manifest = MainfestFields::whereIn('id', $manifestIds_list)->pluck('manifestNumber')->toArray();
                $manifest = array_unique($manifest);
                $manifest = array_values($manifest);
                $metaData['total_pages'] = count($manifest);
                if ($manifest) {
                    $curretn_manifestId = $manifest[0];
                    $trackingIds = DB::table('mainfest_fields')->where('manifestNumber', $manifest[0])->pluck('trackingID');
                    $failedOrder = DB::table('xml_failed_orders')->whereIn('tracking_id', $trackingIds)->pluck('tracking_id');
                    $failedOrderCreate = DB::table('merchantids')->whereIn('tracking_id', $failedOrder)->count();
                    $sortedOrder = DB::table('amazon_enteries')->whereIn('tracking_id', $trackingIds)->whereNotNull('sorted_at')->pluck('tracking_id');
                }
            } elseif ($metaData['current_page'] <= $metaData['total_pages']) {
                $current_manifest_id = $manifest[$metaData['current_page'] - 1];
                if ($current_manifest_id) {
                    $curretn_manifestId = $current_manifest_id;
                    $trackingIds = DB::table('mainfest_fields')->where('manifestNumber', $current_manifest_id)->pluck('trackingID');
                    $failedOrder = DB::table('xml_failed_orders')->whereIn('tracking_id', $trackingIds)->pluck('tracking_id');
                    $failedOrderCreate = DB::table('merchantids')->whereIn('tracking_id', $failedOrder)->count();
                    $sortedOrder = DB::table('amazon_enteries')->whereIn('tracking_id', $trackingIds)->whereNotNull('sorted_at')->pluck('tracking_id');
                }
            }


            $metaData['manifest_ids'] = $manifest;
            $list['manifest'] = $curretn_manifestId;
            $list['total_order'] = count($trackingIds);
            $list['failed_order'] = count($failedOrder);
            $list['created_failed_order'] = $failedOrderCreate;
            $list['not_created_failed_order'] = ($failedOrderCreate <= count($failedOrder)) ?count($failedOrder) - $failedOrderCreate :0;
            $list['sorted_order'] = count(array_unique($sortedOrder));

        }

        return RestAPI::response($list, 200, '', $metaData);
    }


}
