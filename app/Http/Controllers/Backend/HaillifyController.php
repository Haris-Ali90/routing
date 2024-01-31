<?php

namespace App\Http\Controllers\Backend;

use App\BoradlessDashboard;
use App\Classes\Fcm;
use App\Classes\HaillifyClient;
use App\CTCEntry;
use App\HaillifyBooking;
use App\HaillifyDeliveryDetail;
use App\Joey;
use App\JoeyLocations;
use App\JoeyRoute;
use App\JoeyRouteLocations;
use App\MerchantIds;
use App\Sprint;
use App\Task;
use App\TaskHistory;
use App\UserDevice;
use App\UserNotification;
use App\Vehicle;
use Illuminate\Http\Request;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class HaillifyController extends BackendController
{
    private $test = array("136" => "Client requested to cancel the order",
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
        "255" =>"Order delay",
        "145"=>"Returned To Merchant",
        "146" => "Delivery Missorted, Incorrect Address",
        "147" => "Scanned at hub",
        "148" => "Scanned at Hub and labelled",
        "149" => "pick from hub",
        "150" => "drop to other hub",
        "151" => "",
        "152" => "",
        "153" => ""
    );

    private $hailifyStatus = array(
        "61" => "booked",
        "101" => "to_pickup",
        "67" => "at_pickup",
        "125" => "to_delivery",
        "68" => "at_delivery",
        "17" => "delivered",
        "113" => "delivered",
        "114" => "delivered",
        "116" => "delivered",
        "117" => "delivered",
        "118" => "delivered",
        "132" => "delivered",
        "138" => "delivered",
        "139" => "delivered",
        "144" => "delivered",

        "104" => "to_return",
        "105" => "to_return",
        "106" => "to_return",
        "107" => "to_return",
        "108" => "to_return",
        "109" => "to_return",
        "135" => "to_return",

        "145" => "returned",
        "36" => "cancelled",
    );

    /**
     * Create a new controller instance.
     *
     * @param HaillifyClient $client
     */
    public function __construct(HaillifyClient $client)
    {
        $this->client = $client;
    }

    // get haillify booking list
    public function index()
    {
        $haillifyBookings = HaillifyBooking::join('sprint__sprints', 'sprint__sprints.id', '=', 'haillify_bookings.sprint_id')
            ->whereNull('haillify_bookings.deleted_at')
            ->whereNull('sprint__sprints.deleted_at')
            ->whereIn('sprint__sprints.status_id', [61,101,67,68,125,104,105,106,107,108,109,110,111,112,131,135,136,143,146])
            ->orderBy('haillify_bookings.id', 'DESC')
            ->groupBy('haillify_bookings.booking_id')
            ->get();

//        $haillifyBookings = HaillifyBooking::whereHas('sprint', function ($query){
//            $query->whereIn('status_id', [61,101,67,68,125,104,105,106,107,108,109,110,111,112,131,135,136,143,146])->whereNull('deleted_at');
//        })->whereNull('deleted_at')->orderBy('id', 'DESC')->groupBy('booking_id')->get();
        return backend_view('haillify.list', compact('haillifyBookings'));
    }

    public function completeBooking(Request $request)
    {
        if(empty($request->get('date'))){
            $date = date('Y-m-d');
        }
        else{
            $date = $request->get('date');
        }

        $haillifyBookings = HaillifyBooking::join('sprint__sprints', 'sprint__sprints.id', '=', 'haillify_bookings.sprint_id')
            ->whereNull('haillify_bookings.deleted_at')
            ->whereNull('sprint__sprints.deleted_at')
            ->whereIn('sprint__sprints.status_id', [17, 113, 114, 116, 117, 118, 132, 138, 139, 144, 145])
            ->where('haillify_bookings.created_at', 'LIKE', $date.'%')
            ->orderBy('haillify_bookings.id', 'DESC')
            ->groupBy('haillify_bookings.booking_id')
            ->get();

//        $haillifyBookings = HaillifyBooking::whereHas('sprint', function ($query){
//            $query->whereIn('status_id', [17, 113, 114, 116, 117, 118, 132, 138, 139, 144, 145])->whereNull('deleted_at');
//        })->whereNull('deleted_at')->where('pickup_time', 'LIKE', $date.'%')->orderBy('id', 'DESC')->groupBy('booking_id')->get();
//
        return backend_view('haillify.complete_booking_list', compact('haillifyBookings'));
    }

    // assign booking of haillify to joey
    public function haillifyBookingTransfer(Request $request)
    {
        $joey_id=$request->input('joey_id');
        $bookingId = $request->get('booking_id');

        $joey = Joey::join('joey_vehicles_detail', 'joey_vehicles_detail.joey_id', '=', 'joeys.id')
            ->join('joey_locations','joey_locations.joey_id','=','joeys.id')->orderBy('joey_locations.id', 'DESC')->find($joey_id);

        if($joey ==  null){
            return json_encode(['status' => 400, 'output' => 'Joey locations not available']);
        }

        $assignBookingUrl = 'https://api.drivehailify.com/carrier/assignbooking';

        $vehicleId = $this->hailifyVehicleType($joey->vehicle_id);

        $joeyData = [
            'driver' => [
                'driverId' => $joey_id,
                'firstName' => $joey->first_name,
                'lastName' => $joey->last_name,
                'email' => $joey->email,
                'phoneNumber' => $joey->phone,
                'latitude' => $joey->latitude/1000000,
                'longitude' => $joey->longitude/1000000,
                'picture' => $joey->image,
                'licenseNumber' => '',
                'issuingState' => '',
                'vehicle' => [
                    'type' => $vehicleId,
                    'plateNumber' => $joey->license_plate,
                    'maker' => $joey->make,
                    'model' => $joey->model,
                    'color' => $joey->color,
                ],
            ],
            'bookingId' => $bookingId,
        ];

        $result = json_encode($joeyData);
        $response = $this->client->bookingRequestWithParam($result, $assignBookingUrl);

        $data = [
            'url' => $assignBookingUrl,
            'request' => $joeyData,
            'code'=>$response['http_code'],
        ];

        $logger = new Logger('hailify');
        $logger->pushHandler(new StreamHandler('../storage/logs/hailify.log', Logger::DEBUG));
        $logger->info('log', $data);

        $bookingSprints = HaillifyBooking::where('booking_id', $bookingId)->whereNull('deleted_at')->get();

        $routeId='';
        $joeyName =  $joey->first_name.' '. $joey->last_name;
        foreach($bookingSprints as $sprint){
            $taskId = Task::where('sprint_id',$sprint->sprint_id)->whereNull('deleted_at')->pluck('id');
            $route = JoeyRouteLocations::whereIn('task_id', $taskId)->whereNull('deleted_at')->first();
            JoeyRoute::where('id',$route->route_id)->whereNull('deleted_at')->update(['joey_id' => $joey_id]);
            Sprint::where('id', $sprint->sprint_id)->whereNull('deleted_at')->update(['joey_id' => $joey_id]);
            BoradlessDashboard::where('sprint_id', $sprint->sprint_id)->whereNull('deleted_at')->update(['joey_id' => $joey_id, 'joey_name' => $joeyName]);
            $routeId = $route->route_id;
        }

        $deviceIds = UserDevice::where('user_id',$request->input('joey_id'))->where('is_deleted_at', 0)->pluck('device_token');
        $subject = 'New Route '.$routeId;
        $message = 'You have assigned new route';
        Fcm::sendPush($subject, $message,'haillify',null, $deviceIds);
        $payload =['notification'=> ['title'=> $subject,'body'=> $message,'click_action'=> 'haillify'],
            'data'=> ['data_title'=> $subject,'data_body'=> $message,'data_click_action'=> 'haillify']];
        $createNotification= [
            'user_id' => $request->input('joey_id'),
            'user_type'  => 'Joey',
            'notification'  => $subject,
            'notification_type'  => 'haillify',
            'notification_data'  => json_encode(["body"=> $message]),
            'payload'            => json_encode($payload),
            'is_silent'          => 0,
            'is_read'            => 0,
            'created_at'         => date('Y-m-d H:i:s')
        ];
        UserNotification::create($createNotification);

        return json_encode(['status' => 200, 'output' => 'Joey assign successfully']);

    }

    // un assign booking of haillify
    public function haillifyBookingUnAssign(Request $request)
    {

        $bookingId = $request->get('booking_id');

        $unAssignBookingUrl = 'https://api.drivehailify.com/carrier/'.$bookingId.'/unassignbooking';

        $response = $this->client->bookingRequestWithoutParam($unAssignBookingUrl);

        $data = [
            'url' => $unAssignBookingUrl,
            'request' => '',
            'code'=>$response['http_code'],
        ];

        $logger = new Logger('hailify');
        $logger->pushHandler(new StreamHandler('../storage/logs/hailify.log', Logger::DEBUG));
        $logger->info('log', $data);

        if($request->input('joey_id') == ""){
            return json_encode(['status' => 400, 'output' => 'already un assign this sprint']);
        }

        $bookingSprints = HaillifyBooking::where('booking_id', $bookingId)->whereNull('deleted_at')->get();

        $routeId='';
        foreach($bookingSprints as $sprint){
            $taskId = Task::where('sprint_id',$sprint->sprint_id)->whereNull('deleted_at')->pluck('id');
            $route = JoeyRouteLocations::whereIn('task_id', $taskId)->whereNull('deleted_at')->first();
            JoeyRoute::where('id',$route->route_id)->whereNull('deleted_at')->update(['joey_id' => null]);
            Sprint::where('id', $sprint->sprint_id)->whereNull('deleted_at')->update(['joey_id' => null]);
            BoradlessDashboard::where('sprint_id', $sprint->sprint_id)->whereNull('deleted_at')->update(['joey_id' => null, 'joey_name' => null]);
            $routeId = $route->route_id;
        }

        $deviceIds = UserDevice::where('user_id',$request->input('joey_id'))->where('is_deleted_at', 0)->pluck('device_token');
        $subject = 'Your Route '.$routeId;
        $message = 'You have unassigned route';
        Fcm::sendPush($subject, $message,'haillify',null, $deviceIds);
        $payload =['notification'=> ['title'=> $subject,'body'=> $message,'click_action'=> 'haillify'],
            'data'=> ['data_title'=> $subject,'data_body'=> $message,'data_click_action'=> 'haillify']];
        $createNotification= [
            'user_id' => $request->input('joey_id'),
            'user_type'  => 'Joey',
            'notification'  => $subject,
            'notification_type'  => 'haillify',
            'notification_data'  => json_encode(["body"=> $message]),
            'payload'            => json_encode($payload),
            'is_silent'          => 0,
            'is_read'            => 0,
            'created_at'         => date('Y-m-d H:i:s')
        ];
        UserNotification::create($createNotification);

        return json_encode(['status' => 200, 'output' => 'un assign this sprint booking']);
    }

    // cancel booking of haillify
    public function haillifyBookingCancel(Request $request)
    {
        $deliveryId = $request->get('delivery_id');
        $sprintId = $request->get('sprint_id');
        $cancelOrderRequestUrl = 'https://api.drivehailify.com/carrier/'.$deliveryId.'/canceldelivery';

        $sprint = Sprint::find($sprintId);
        $sprint->update(['status_id' => 36, 'deleted_at' => date('Y-m-d H:i:s')]);
        BoradlessDashboard::where('sprint_id', $sprintId)->update(['task_status_id' => 36, 'deleted_at' => date('Y-m-d H:i:s')]);
        $sprintTask = Task::where('sprint_id', $sprintId)->get();
        $dropOff=[];

        foreach($sprintTask as $task){
            Task::where('id', $task->id)->update(['status_id' => 36, 'deleted_at' => date('Y-m-d H:i:s')]);
            $sprintTaskHistory = [
                'sprint__tasks_id' => $task->id,
                'sprint_id' => $task->sprint_id,
                'status_id' => 36,
            ];
            TaskHistory::create($sprintTaskHistory);
        }

        $booking = HaillifyBooking::where('delivery_id', $deliveryId)->whereNull('deleted_at')->first();
        $haillifyDeliveryDetails = HaillifyDeliveryDetail::where('haillify_booking_id', $booking->id)->whereNull('deleted_at')->get();

        HaillifyBooking::where('delivery_id',$deliveryId)->update(['deleted_at' => date('Y-m-d H:i:s')]);
        HaillifyDeliveryDetail::where('haillify_booking_id', $booking->id)->update(['deleted_at' => date('Y-m-d H:i:s')]);

        $joey = JoeyLocations::where('joey_id', $sprint->joey_id)->orderBy('id', 'DESC')->first();

        foreach($haillifyDeliveryDetails as $details){
            if($details->dropoff_id != null){
                $dropOff[]=[
                    "dropoffId" => $details->dropoff_id,
                    'status' => 'cancelled',
                    'statusReason' => $this->test[36],
                    'signature' => '',
                    'photo' => '',
                    'customerId' => '',
                ];
            }
        }
        $updateStatusArray = [
            'statusReason' => $this->test[36],
            'status' => 'cancelled',
            'driverId' => $sprint->joey_id,
            'latitude' => (isset($joey->latitude)) ? $joey->latitude/1000000 : 0,
            'longitude' => (isset($joey->longitude)) ? $joey->longitude/100000 : 0,
            'hailifyId' => $booking->haillify_id,
            'dropoffs' => $dropOff,
        ];

        $result = json_encode($updateStatusArray);

        $response = $this->client->bookingRequestWithParam($result, $cancelOrderRequestUrl);

        $data = [
            'url' => $cancelOrderRequestUrl,
            'request' => $updateStatusArray,
            'code'=>$response['http_code'],
        ];

        $logger = new Logger('hailify');
        $logger->pushHandler(new StreamHandler('../storage/logs/hailify.log', Logger::DEBUG));
        $logger->info('log', $data);


        $deviceIds = UserDevice::where('user_id',$sprint->joey_id)->where('is_deleted_at', 0)->pluck('device_token');
        $subject = 'Tracking Id '.$booking->tracking_id; // trackingid
        $message = 'Tracking id has been cancelled';
        if($sprint->joey_id != null){
            Fcm::sendPush($subject, $message,'haillify',null, $deviceIds);
            $payload =['notification'=> ['title'=> $subject,'body'=> $message,'click_action'=> 'haillify'],
                'data'=> ['data_title'=> $subject,'data_body'=> $message,'data_click_action'=> 'haillify']];
            $createNotification= [
                'user_id' => $sprint->joey_id,
                'user_type'  => 'Joey',
                'notification'  => $subject,
                'notification_type'  => 'haillify',
                'notification_data'  => json_encode(["body"=> $message]),
                'payload'            => json_encode($payload),
                'is_silent'          => 0,
                'is_read'            => 0,
                'created_at'         => date('Y-m-d H:i:s')
            ];
            UserNotification::create($createNotification);
        }


        return json_encode(['status' => 200, 'output' => 'cancel order successfully']);

    }

    // reject booking of haillify
    public function haillifyBookingReject(Request $request)
    {
        $bookingId = $request->get('booking_id');
        $joeyId = $request->get('joey_id');

        $bookingExists = HaillifyBooking::where('booking_id',$bookingId)->exists();

        if($bookingExists == false){
            return json_encode(['status' => 400, 'output' => 'Booking id is invalid']);
        }

        $sprintIds = HaillifyBooking::where('booking_id',$bookingId)->pluck('sprint_id', 'tracking_id');
        $Ids = HaillifyBooking::where('booking_id',$bookingId)->pluck('id');
        HaillifyDeliveryDetail::whereIn('haillify_booking_id', $Ids)->update(['deleted_at' => date('Y-m-d H:i:s')]);

        $haillifyBooking = HaillifyBooking::where('booking_id',$bookingId)->update(['deleted_at' => date('Y-m-d H:i:s')]);

//        $orders = Sprint::whereIn('id', $sprintIds)->get();
        $routeId='';
        //update status 36 by booking
        foreach($sprintIds as $trackingId => $sprintId){
//            $sprint = Sprint::where('id',$sprintId)->update(['joey_id' => NULL, 'status_id' => 36, 'deleted_at' => date('Y-m-d H:i:s')]);
//            $sprintTask = Task::whereNull('deleted_at')->where('sprint_id',$sprintId)->update(['status_id'=>36, 'deleted_at' => date('Y-m-d H:i:s')]);
            $spTask = Task::whereNull('deleted_at')->where('sprint_id',$sprintId)->get();

            foreach($spTask as $task) {
                $sprintTaskHistory = [
                    'sprint__tasks_id' => $task->id,
                    'sprint_id' => $task->sprint_id,
                    'status_id' => 36,
                ];
                TaskHistory::create($sprintTaskHistory);
                $route = JoeyRouteLocations::where('task_id', $task->id)->whereNull('deleted_at')->first();
                $routeId = $route->route_id;
            }

            $taskIds = MerchantIds::where('tracking_id', $trackingId)->pluck('task_id');
            $sprint_id = Task::whereNull('deleted_at')->whereIn('id', $taskIds)->pluck('sprint_id');
            $sprint = Sprint::whereIn('id',$sprint_id)->update(['joey_id' => NULL, 'status_id' => 36, 'deleted_at' => date('Y-m-d H:i:s')]);
            $tasks = Task::whereIn('id', $taskIds)->update(['status_id' => 36, 'deleted_at' => date('Y-m-d H:i:s')]);
            BoradlessDashboard::where('sprint_id', $sprintId)->update(['task_status_id' => 36, 'deleted_at' => date('Y-m-d H:i:s')]);
        }

        //**  send data of reject booking to hailify  */

        //reject booking url
        $rejectBookingUrl = 'https://api.drivehailify.com/carrier/'.$bookingId.'/rejectbooking';
        // booking reject curl
        $response = $this->client->bookingRequestWithoutParam($rejectBookingUrl);
        // response of reject booking
        $data = [
            'url' => $rejectBookingUrl,
            'request' => '',
            'code'=>$response['http_code'],
        ];
        // create log of hailify
        $logger = new Logger('hailify');
        $logger->pushHandler(new StreamHandler('../storage/logs/hailify.log', Logger::DEBUG));
        $logger->info('log', $data);

        // send notification to joey and create data
        $deviceIds = UserDevice::where('user_id',$joeyId)->where('is_deleted_at', 0)->pluck('device_token');
        $subject = 'Delete Route '.$routeId; // route id
        $message = 'Your route has been deleted';
        Fcm::sendPush($subject, $message,'haillify',null, $deviceIds);
        $payload =['notification'=> ['title'=> $subject,'body'=> $message,'click_action'=> 'haillify'],
            'data'=> ['data_title'=> $subject,'data_body'=> $message,'data_click_action'=> 'haillify']];
        $createNotification= [
            'user_id' => $joeyId,
            'user_type'  => 'Joey',
            'notification'  => $subject,
            'notification_type'  => 'haillify',
            'notification_data'  => json_encode(["body"=> $message]),
            'payload'            => json_encode($payload),
            'is_silent'          => 0,
            'is_read'            => 0,
            'created_at'         => date('Y-m-d H:i:s')
        ];
        UserNotification::create($createNotification);

        return json_encode(['status' => 200, 'output' => 'Booking reject successfully']);

    }

    //detail of haillify booking
    public function haillifyBookingDetail($bookingId)
    {
        $haillifyBookingDetails = HaillifyBooking::where('booking_id', $bookingId)->whereNull('deleted_at')->get();
        return backend_view('haillify.detail', compact('haillifyBookingDetails'));

    }

    // detail of sprint 
    public function haillifyBookingSprintDetail($sprintId)
    {
        $sprintDetails = HaillifyBooking::join('haillify_delivery_details', 'haillify_delivery_details.haillify_booking_id', '=', 'haillify_bookings.id')
            ->join('sprint__sprints', 'sprint__sprints.id', '=', 'haillify_bookings.sprint_id')
            ->leftjoin('joeys', 'joeys.id', '=', 'sprint__sprints.joey_id')
            ->where('haillify_bookings.sprint_id', $sprintId)
            ->whereNull('haillify_delivery_details.deleted_at')
            ->whereNull('haillify_bookings.deleted_at')
            ->whereNull('sprint__sprints.deleted_at')
            ->get(['haillify_bookings.pickup_time', 'haillify_delivery_details.apart_no','haillify_bookings.sprint_id', 'joeys.first_name', 'joeys.last_name', 'haillify_bookings.tracking_id', 'haillify_bookings.merchant_order_num', 'sprint__sprints.status_id', 'haillify_delivery_details.street']);

//        $sprintDetails = Task::with('merchantIds')->where('sprint_id', $sprintId)->get();
        return backend_view('haillify.sprint_detail', compact('sprintDetails'));
    }

    //update haillify booking status
    public function haillifyBookingUpdateStatus(Request $request)
    {
        $sprintId = $request->get('sprint_id');
        $deliveryId = $request->get('delivery_id');
        $statusId = $request->get('status_id');

        $updateStatusBookingUrl = 'https://api.drivehailify.com/carrier/'.$deliveryId.'/status';

        $sprint = Sprint::find($sprintId);
        $sprint->update(['status_id' => $statusId]);
        $sprintTask = Task::where('sprint_id', $sprintId)->get();

        $dropOff=[];
        foreach($sprintTask as $task){
            Task::where('id', $task->id)->update(['status_id' => $statusId]);
            $sprintTaskHistory = [
                'sprint__tasks_id' => $task->id,
                'sprint_id' => $task->sprint_id,
                'status_id' => $statusId,
            ];
            TaskHistory::create($sprintTaskHistory);
        }

        $joey = JoeyLocations::where('joey_id', $sprint->joey_id)->orderBy('id', 'DESC')->first();

        $haillifyBooking = HaillifyBooking::where('delivery_id', $deliveryId)->first();
        $haillifyDeliveryDetails = HaillifyDeliveryDetail::where('haillify_booking_id', $haillifyBooking->id)->whereNotNull('dropoff_id')->first();

        $pickUpStatus = [121];
        $returnStatus = [101, 104, 105, 106, 107, 108, 109, 110, 111, 112, 131, 135, 136,143,146];
        $deliveredStatus = [17, 113, 114, 116, 117, 118, 132, 138, 139, 144];
        $return = [145];
        $toPickup = [101];

        $allStatus = [121,101, 104, 105, 106, 107, 108, 109, 110, 111, 112, 131, 135, 136,143,146,17, 113, 114, 116, 117, 118, 132, 138, 139, 144,145];

        $hailifyStatus='';
        $statusMsg = '';
        $updateStatusArray=[];
        if(in_array($statusId, $pickUpStatus)){
            $hailifyStatus = 'to_delivery';
            $dropOff[] = [
                "dropoffId" => $haillifyDeliveryDetails->dropoff_id,
                "status" => 'to_delivery',
            ];
        }
        if(in_array($statusId, $returnStatus)){
            $hailifyStatus = 'to_return';

            $damagedStatus = [104, 105];
            $unAvailableStatus = [106, 107, 108, 109, 135];


            if(in_array($statusId, $damagedStatus)){
                $statusMsg = 'PackageDamage';
            }else if(in_array($statusId, $unAvailableStatus)){
                $statusMsg = 'CustomerWontAccept';
            }

            $updateStatusArray['statusReason'] = $statusMsg;

            $dropOff[] = [
                "statusReason" => $statusMsg,
                "dropoffId" => $haillifyDeliveryDetails->dropoff_id,
                "status" => $hailifyStatus,
                "additionalPhotos"=> [],
                "deliveryNotes"=>$this->test[$statusId],
            ];
        }
        if(in_array($statusId, $return)){
            $hailifyStatus = 'returned';
            $dropOff[] =[
                "dropoffId" => $haillifyDeliveryDetails->dropoff_id,
                "status" => $hailifyStatus,
                "photo" => '',
            ];
        }
        if(in_array($statusId, $deliveredStatus)){
            $hailifyStatus = 'delivered';
            $dropOff[]=[
                "dropoffId" => $haillifyDeliveryDetails->dropoff_id,
                "status" => $hailifyStatus,
                "photo" => '',
                "deliveryNotes"=>$this->test[$statusId]
            ];
        }


        if(in_array($statusId,$allStatus)){
            $updateStatusArray['status'] = $hailifyStatus;
            $updateStatusArray['driverId'] = $sprint->joey_id;
            $updateStatusArray['latitude'] = (isset($joey->latitude)) ? $joey->latitude/1000000 : 0;
            $updateStatusArray['longitude'] = (isset($joey->longitude)) ? $joey->longitude/1000000 : 0;
            $updateStatusArray['hailifyId'] = $haillifyBooking->haillify_id;
            $updateStatusArray['dropoffs'] = $dropOff;

            $result = json_encode($updateStatusArray);

            $response = $this->client->bookingRequestWithParam($result, $updateStatusBookingUrl);

            $data = [
                'url' => $updateStatusBookingUrl,
                'request' => $updateStatusArray,
                'code'=>$response['http_code'],
            ];

            $logger = new Logger('hailify');
            $logger->pushHandler(new StreamHandler('../storage/logs/hailify.log', Logger::DEBUG));
            $logger->info('log', $data);
        }

        return json_encode(['status' => 200, 'output' => 'update status successfully']);

    }

    // un assign Driver Of sprint
    public function haillifyUnAssignDriver(Request $request)
    {
        $deliveryId = $request->get('delivery_id');
        $sprintId = $request->get('sprint_id');

        $unAssignDriverUrl = 'https://api.drivehailify.com/carrier/'.$deliveryId.'/unassigndriver';

        $response = $this->client->bookingRequestWithoutParam($unAssignDriverUrl);


        $data = [
            'url' => $unAssignDriverUrl,
            'request' => '',
            'code'=>$response['http_code'],
        ];

        $logger = new Logger('hailify');
        $logger->pushHandler(new StreamHandler('../storage/logs/hailify.log', Logger::DEBUG));
        $logger->info('log', $data);


        $booking = HaillifyBooking::where('sprint_id', $sprintId)->update(['updated_at' => date('Y-m-d H:i:s')]);

        $sprint = Sprint::find($sprintId);


        $deviceIds = UserDevice::where('user_id',$sprint->joey_id)->pluck('device_token');
        $subject = 'Un Assign '.$sprintId;
        $message = 'You have un assigned your booking';
        Fcm::sendPush($subject, $message,'haillify',null, $deviceIds);
        $payload =['notification'=> ['title'=> $subject,'body'=> $message,'click_action'=> 'haillify'],
            'data'=> ['data_title'=> $subject,'data_body'=> $message,'data_click_action'=> 'haillify']];
        $createNotification= [
            'user_id' => $sprint->joey_id,
            'user_type'  => 'Joey',
            'notification'  => $subject,
            'notification_type'  => 'haillify',
            'notification_data'  => json_encode(["body"=> $message]),
            'payload'            => json_encode($payload),
            'is_silent'          => 0,
            'is_read'            => 0,
            'created_at'         => date('Y-m-d H:i:s')
        ];
        UserNotification::create($createNotification);
        $sprint->update(['joey_id' => null]);
        return json_encode(['status' => 200, 'output' => 'un assign this sprint booking']);
    }

    public function hailifyVehicleType($vehicleId)
    {
        $vehicleTypeId = 0;
        //Sedan = 0
        if($vehicleId == 3){
            $vehicleTypeId = 0;
        }
        //SUV = 1
        if($vehicleId == 5){
            $vehicleTypeId = 1;
        }
        //Truck = 2
        if($vehicleId == 4){
            $vehicleTypeId = 2;
        }
        //Bicycle = 3
        if($vehicleId == 1){
            $vehicleTypeId = 3;
        }
        return $vehicleTypeId;
    }

}