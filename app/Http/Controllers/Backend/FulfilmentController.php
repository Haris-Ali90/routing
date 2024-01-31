<?php

namespace App\Http\Controllers\Backend;

use App\ClientSetting;
use Illuminate\Http\Request;
use App\Sprint;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use DateTime;
use DateTimeZone;


class FulfilmentController extends BackendController
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
        "255" => 'Order Delay',
        "145" => 'Returned To Merchant',
        "146" => "Delivery Missorted, Incorrect Address",
        "147" => "Scanned at hub",
        "148" => "Scanned at Hub and labelled",
        "149" => "Bundle Pick From Hub",
        "150" => "Bundle Drop To Hub",
        '153' => 'Miss sorted to be reattempt',
        '154' => 'Joey unable to complete the route', '155' => 'To be re-attempted tomorrow');

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
            "255" => 'Order Delay',
            "145" => 'Returned To Merchant',
            "146" => "Delivery Missorted, Incorrect Address",
            "147" => "Scanned at hub",
            "148" => "Scanned at Hub and labelled",
            "149" => "Bundle Pick From Hub",
            "150" => "Bundle Drop To Hub",
            '153' => 'Miss sorted to be reattempt',
            '154' => 'Joey unable to complete the route', '155' => 'To be re-attempted tomorrow');
        return $statusid[$id];
    }

    /**
     * Get Fulfilment List
     */
    public function fulfilmentList(Request $request)
    {
        $tracking_id = isset($request->trackingIds) ? $request->trackingIds : '';
        $tracking_ids = explode(',',$tracking_id);

        $today_date = date("Y-m-d");

        $start_dt = new DateTime($today_date." 00:00:00", new DateTimezone('America/Toronto'));
        $start_dt->setTimeZone(new DateTimezone('UTC'));
        $start = $start_dt->format('Y-m-d H:i:s');

        $end_dt = new DateTime($today_date." 23:59:59", new DateTimezone('America/Toronto'));
        $end_dt->setTimeZone(new DateTimezone('UTC'));
        $end = $end_dt->format('Y-m-d H:i:s');

        if (!empty($tracking_ids) && $tracking_id != "")
        {
            //dd([$tracking_ids,!empty($tracking_ids), $tracking_id != ""]);
            $fulfilmentData = Sprint::join('sprint__tasks', 'sprint__tasks.sprint_id', '=', 'sprint__sprints.id')
                ->join('merchantids', 'merchantids.task_id', '=', 'sprint__tasks.id')
                ->whereNull('sprint__sprints.deleted_at')
                ->whereNull('sprint__tasks.deleted_at')
                ->whereNotIn('sprint__sprints.status_id', [36])
                ->whereIn('merchantids.tracking_id', $tracking_ids)
				->whereNotNull('merchantids.tracking_id')
                // ->where('sprint__tasks.type','=', 'dropoff')
                ->groupBy('sprint__sprints.id')
                ->select(['sprint__sprints.*','sprint__tasks.status_id as task_status_id','merchantids.tracking_id','sprint__tasks.id as task_ids'])->get();

        }
        else
        {
            $fulfilmentData = [];
        }
        
        

        return backend_view('label-order.index',compact('fulfilmentData','tracking_id'));
    }

    public function FulfilmentPrint($id, Request $request)
    { if ($id == 0)
    {

        $ids = $request->sprintIds[0];

        $id = explode(",", $ids);

    }
    else
    {
        $id = [$id];
    }

        $printSize = ClientSetting::where('user_id',Auth::user()->id)->whereNull('deleted_at')->pluck('print_size')->toArray();

        $printLabelDatas = Sprint::join('sprint__tasks','sprint__sprints.id', '=', 'sprint__tasks.sprint_id')
            ->join('vendors','vendors.id', '=', 'sprint__sprints.creator_id')
            ->join('locations','sprint__tasks.location_id', '=', 'locations.id')
            ->join('sprint__contacts','sprint__tasks.contact_id', '=', 'sprint__contacts.id')
            ->join('merchantids','merchantids.task_id', '=', 'sprint__tasks.id')
            ->whereIn('sprint__sprints.id',$id)
            ->whereNotNull('merchantids.tracking_id')
            // ->groupBy('sprint__sprints.id')
            ->select(['sprint__sprints.*','sprint__contacts.name as sprint_name','locations.address as sprint_address','locations.postal_code as sprint_postal_code','vendors.name as vendor_name','vendors.business_address as vendor_address','merchantids.tracking_id'])->get();
			
			if ($printLabelDatas->isEmpty())
        {
            $printLabelData = $checkEmptyData;
        }
        else
        {
            $printLabelData = $printLabelDatas;
        }
			
        return backend_view('label-order.print-lable.order_label', compact('printLabelData','printSize'));

    }

}
