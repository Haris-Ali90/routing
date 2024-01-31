<?php 
use App\JoeyRoute;
use App\RouteTransferLocation;

$test = array("136" => "Client requested to cancel the order",
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
    '147' => 'Scanned at Hub',
    '148' => 'Scanned at Hub and labelled',
    '149' => 'pickup from hub',
    '150' => 'drop to other hub',
    '153' => 'Miss sorted to be reattempt',
    '154' => 'Joey unable to complete the route', '155' => 'To be re-attempted tomorrow',
    '155' => 'To be re-attempted tomorrow');

?>
@extends( 'backend.layouts.app' )

@section('title', 'Route Complete Details')

@section('CSSLibraries')
    <!-- DataTables CSS -->
    <link href="{{ backend_asset('libraries/datatables-plugins/dataTables.bootstrap.css') }}" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="{{ backend_asset('libraries/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">
    <!-- Image Viewer CSS -->
    <link href="{{ backend_asset('libraries/galleria/colorbox.css') }}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <style>
        .green-gradient, .green-gradient:hover {
    color: #fff;
    background: #bad709;
    background: -moz-linear-gradient(top, #bad709 0%, #afca09 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#bad709), color-stop(100%,#afca09));
    background: -webkit-linear-gradient(top, #bad709 0%,#afca09 100%);
    background: linear-gradient(to bottom, #bad709 0%,#afca09 100%);
}
.black-gradient,
.black-gradient:hover {
    color: #fff;
    background: #535353;
    background: -moz-linear-gradient(top,  #535353 0%, #353535 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#535353), color-stop(100%,#353535));
    background: -webkit-linear-gradient(top,  #535353 0%,#353535 100%);
    background: linear-gradient(to bottom,  #535353 0%,#353535 100%);
}

.red-gradient,
.red-gradient:hover {
    color: #fff;
    background: #da4927;
    background: -moz-linear-gradient(top,  #da4927 0%, #c94323 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#da4927), color-stop(100%,#c94323));
    background: -webkit-linear-gradient(top,  #da4927 0%,#c94323 100%);
    background: linear-gradient(to bottom,  #da4927 0%,#c94323 100%);
}

.orange-gradient,
.orange-gradient:hover {
    color: #fff;
    background: #f6762c;
    background: -moz-linear-gradient(top,  #f6762c 0%, #d66626 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f6762c), color-stop(100%,#d66626));
    background: -webkit-linear-gradient(top,  #f6762c 0%,#d66626 100%);
    background: linear-gradient(to bottom,  #f6762c     0%,#d66626 100%);
}

.btn{
    font-size : 12px;
}
#transfer span.select2.select2-container.select2-container--default {
    width: 75%!important;
}
    .modal.fade {
        opacity: 1
    }

    .modal-header {
        font-size: 16px;
    }

    .modal-body h4 {
        background: #f6762c;
        padding: 8px 10px;
        margin-bottom: 10px;
        font-weight: bold;
        color: #fff;
    }
        .bg-color{
            background: #c6dd38;
            margin: 8px !important;
            padding: 8px!important;
            display: inline-block;
            font-size: 14px !important;
            color: #0b0b0b;
        }
    .form-control {
        display: block;
        width: 100%;
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    }

    .form-control:focus {
        border-color: #66afe9;
        outline: 0;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(102, 175, 233, .6);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(102, 175, 233, .6);
    }

    .form-group {
        margin-bottom: 15px;
    }

    div#transfer .modal-content {
    padding: 20px;
}
.loader {
    position: relative;
    right: 0%;
    top: 0%;
    justify-content: center;
    text-align: center;
    /* text-align: center; */
    border: 18px solid #e36d28;
    border-radius: 50%;
    border-top: 16px solid #34495e;
    width: 120px;
    height: 120px;
    -webkit-animation: spin 4s linear infinite;
    animation: spin 2s linear infinite;
    margin: 0 auto;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
td.ab .view {
    display: none !important;
}
.loader-iner-warp {
    position: relative;
    width: 100%;
    text-align: center;
    top: 40%;
}

    </style>

@endsection

@section('JSLibraries')
    <!-- DataTables JavaScript -->
    <script src="{{ backend_asset('libraries/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ backend_asset('libraries/datatables-plugins/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ backend_asset('libraries/datatables-responsive/dataTables.responsive.js') }}"></script>
    <script src="{{ backend_asset('libraries/galleria/jquery.colorbox.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="{{ backend_asset('js/jquery-ui.js') }}"></script>
    <link href="{{ backend_asset('js/jquery-ui.css') }}" rel="stylesheet"> -->

@endsection

@section('inlineJS')
<!-- <script type="text/javascript">
   $( function() {
    $( "#datepicker" ).datepicker({changeMonth: true,
      changeYear: true, showOtherMonths: true,
      selectOtherMonths: true}).attr('autocomplete','off');
  } );
  </script> -->

    <script type="text/javascript">
        <!-- Datatable -->
        $(document).ready(function () {

            $('#datatable').DataTable({
              "lengthMenu": [ 50,100, 250, 500, 750, 1000]
            });

            $(".group1").colorbox({height:"50%",width:"50%"});

            $(document).on('click', '.status_change', function(e){
                var Uid = $(this).data('id');

                $.confirm({
                    title: 'A secure action',
                    content: 'Are you sure you want to change user status??',
                    icon: 'fa fa-question-circle',
                    animation: 'scale',
                    closeAnimation: 'scale',
                    opacity: 0.5,
                    btns: {
                        'confirm': {
                            text: 'Proceed',
                            btnClass: 'btn-info',
                            action: function () {

                                $.ajax({
                                    type: "GET",
                                    url: "<?php echo URL::to('/'); ?>/api/changeUserStatus/"+Uid,
                                    data: {},
                                    success: function(data)
                                    {
                                        if(data== '0' || data== 0 )
                                        {
                                            var DataToset = '<btn type="btn" class="btn btn-warning btn-xs status_change" data-toggle="modal" data-id="'+Uid+'" data-target=".bs-example-modal-sm">Blocked</btn>';
                                            $('#CurerntStatusDiv'+Uid).html(DataToset);
                                        }
                                        else
                                        {
                                            var DataToset = '<btn type="btn" class="btn btn-success btn-xs status_change" data-toggle="modal" data-id="'+Uid+'" data-target=".bs-example-modal-sm">Active</btn>'
                                            $('#CurerntStatusDiv'+Uid).html(DataToset);
                                        }
                                    }
                                });

                            }
                        },
                        cancel: function () {
                            //$.alert('you clicked on <strong>cancel</strong>');
                        }
                    }
                });
            });

            $(document).on('click', '.form-delete', function(e){

                var $form = $(this);
                $.confirm({
                    title: 'A secure action',
                    content: 'Are you sure you want to delete user ??',
                    icon: 'fa fa-question-circle',
                    animation: 'scale',
                    closeAnimation: 'scale',
                    opacity: 0.5,
                    btns: {
                        'confirm': {
                            text: 'Proceed',
                            btnClass: 'btn-info',
                            action: function () {
                                $form.submit();
                            }
                        },
                        cancel: function () {
                            //$.alert('you clicked on <strong>cancel</strong>');
                        }
                    }
                });
            });

        });

    </script>
    <script>
        $(document).ready(function() {
            $('#birthday').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker_4"
            }, function(start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
        });
    </script>
    
@endsection

@section('content')

<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left amazon-text">
                    <!-- <h3>Route Complete Details<small></small></h3> -->
                </div>
            </div>
          
            <div class="clearfix"></div>

            {{--@include('backend.layouts.modal')
            @include( 'backend.layouts.popups')--}}
            <div class="row">

                @if($joey_data != '')
{{--                    <label>Data not found</label>--}}
                <label class="label label-info bg-color ">Joey ID : {{($joey_data->joey_id) ? $joey_data->joey_id : 'N/A'}} </label><br>
                <label class="label label-info bg-color ">Joey Name : {{($joey_data->first_name) ? $joey_data->first_name : 'N/A' }}
                    {{$joey_data->last_name}}  </label><br>
                @php
                    $latitude_value=substr($joey_data['latitude'], 0, 8);
                    $latitude = intval($latitude_value);
                    $longitude_value=substr($joey_data['longitude'], 0, 9);
                    $longitude = intval($longitude_value);
                    if($hub_id==129){
                        $devisor = 100000;
                    }
                    else{
                        $devisor = 1000000;
                    }
                @endphp
                <label class="label label-info bg-color ">Joey Current Location : {{($latitude) ? $latitude/1000000 : 'N/A'}} ,
                    {{($longitude) ? $longitude/$devisor : 'N/A'}}</label><br>
                <div class="x_title">
                    <button type='button' class=' red-gradient btn' data-toggle='modal' data-target='#ex5' onclick='initialize({{$route_id}},{{$latitude/1000000}},{{$longitude/$devisor}})' title='Map of Whole Route'>Map Location of Joey</button>
                    @endif
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
<div class="x_title">
      <div class="row d-flex align-items-center">
      <div class="col-lg-6">
            <h2>

            Route Complete Details

            </h2>
        </div>
        <div class="col-lg-6 d-flex justify-content-end">
            <button class="transfer-but transfer sub-ad btn-primary " disabled>Transfer</button>
        </div>
      </div>
</div>
                        <div class="x_content">

                            @include( 'backend.layouts.notification_message' )

                    <div class="table-responsive">
                    <div class="loader-background" style="
    position: fixed;
    top: 0px;
    left: 0px;
    z-index: 9999;
    width: 100%;
    height: 100%;
    background-color: #000000ba; display: none ">
                    <div class="loader-iner-warp">

                        <div class="loader" style="display: none" ></div>
            </div>
                        </div>
{{--                        "latitude" => 43630173--}}
{{--                        "longitude" => -79627221--}}

                            <div id="ex5" class='modal fade' role='dialog'>
                                <div class='modal-dialog'>

                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h4 class='modal-title'>Map </h4>
                                            <p class='route-id'></p>
                                        </div>
                                        <div class='modal-body'>

                                            <div id='map5' style=" height: 380px;"></div>
                                            <a class="btn black-gradient" data-dismiss="modal" aria-hidden="true">Close</a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    <table id="datatable" class="table table-striped table-bordered">
                    <thead stylesheet="color:black;">
                        <tr>
                            <th><input class='check' type='checkbox' name='check' id="checkAll"></th>
                            <th>Id</th>
                            <th>Cart no</th>
                            <th>Route Label</th>
                            <th>Task Id</th>
                            <th>Sprint Id</th>
                            <th>Tracking Id</th>
                            <th>Merchant Order Number</th>
                            <th>Delivery Window</th>
                            <th>Travel Time</th>
                            <th>Address</th>
                            <th>Distance</th>
                            <th>Status</th>
                            <!-- <th>Action</th> -->
                       </tr>
                      </thead>
                      <tbody>
                      <?php 
             date_default_timezone_set('America/Toronto');

             $i=1;
             foreach($route as $routeLoc) {
                    echo "<tr>";

                    // if($routeLoc->is_transfered)
                    // {
                    //     echo "<td><input class='check' id='check' type='hidden' name='check' value='".$routeLoc->id."'></td>";
                    // }
                    // else
                    // {
                        echo "<td><input class='check' id='check' type='checkbox' name='check' value='".$routeLoc->id."'></td>";
                    // }
                    echo "<td>".$i."</td>";

                    if($zone_seq!=null && $route_seq!=null && $order_range!=null)
                    {
                         echo "<td>".chr($zone_seq).chr($route_seq).chr(ceil($i/$order_range)+64)."-".$i."</td>";
                    }
                    else
                    {
                        echo "<td></td>";
                    }
                    
                    if($routeLoc->is_transfered)
                    {
                            $route_transfer=RouteTransferLocation::where('new_route_location_id','=',$routeLoc->id)->first();
                           
                            if($route_transfer!=null)
                            {
                                echo "<td>R-".$route_transfer->old_route_id."-".$route_transfer->old_ordinal."</td>";
                            }
                            else
                            {
                                echo "<td>R-".$route_id."-".$routeLoc->ordinal."</td>";
                            }
                    }
                    else
                    {
                        echo "<td>R-".$route_id."-".$routeLoc->ordinal."</td>";
                    }
                    echo "<td>".$routeLoc->task_id."</td>";
                    echo "<td>CR-".$routeLoc->sprint_id."</td>";
                    //echo "<td>".$routeLoc->tracking_id."</td>";
                    echo "<td>";
                    echo (preg_match('/old/i', $routeLoc->tracking_id) > 0)?  substr($routeLoc->tracking_id,15) :  $routeLoc->tracking_id;
                    echo "</td>";
                    echo "<td>".$routeLoc->merchant_order_num."</td>";

                    if(strpos($routeLoc->arrival_time,'-'))
                    {
                        $arrival_time= new DateTime($routeLoc->arrival_time);
                        $finish_time= new DateTime($routeLoc->finish_time);
                        echo "<td>".$arrival_time->format('H:i:s')."-".$finish_time->format('H:i:s')."</td>";
                    }
                    else
                    {
                        echo "<td>".$routeLoc->arrival_time."-".$routeLoc->finish_time."</td>";
                    }

                    echo"<td>";
                    if ($i==1  ) {
                        $firstfinish = $routeLoc->finish_time;
                        echo"0";
                     } 
                     else
                     {
                         if($firstfinish!=null && $routeLoc->arrival_time!=null )
                         {
                             if(strpos($routeLoc->arrival_time,'-'))
                             {
                                 $firstfinish=explode("T",$firstfinish);
                                 $arrival_time=explode("T",$routeLoc->arrival_time);
                                 $firstfinish=$firstfinish[0]." ".explode("-",$firstfinish[1])[0];
                                 $arrival_time=$arrival_time[0]." ".explode("-",$arrival_time[1])[0];
 
                                 $date1= new DateTime($firstfinish);
                                 $date2 = new DateTime($arrival_time);
                                 $interval = $date1->diff($date2);
                                 // echo($interval->h.":".$interval->i."".$interval->s);
                                 echo $interval->format("%H:%I:%S");    
                                 $firstfinish = $routeLoc->finish_time;
 
                               
 
                             }
                             else
                             {
                               
                                 $first_finish=explode(":",$firstfinish);
                                 $arrival_time=explode(":",$routeLoc->arrival_time);
                                 if(isset($first_finish[0]) && isset($first_finish[1]))
                                 {
     
                                     if($first_finish[0]>23 && $first_finish[0]< 48)
                                     {
                                         if($first_finish[1]>60 && $first_finish[1]< 120)
                                     {
                                         $date1 = new DateTime("2020-01-02 ".($first_finish[0]-23).":".($first_finish[1]-60).":00");
                                     }
                                     else
                                     {
                                         $date1 = new DateTime("2020-01-02 ".($first_finish[0]-24).":".$first_finish[1].":00");
                                     }
                                         
                                     }
                                     else
                                     {
                                         if($first_finish[1]>60 && $first_finish[1]< 120)
                                         {
                                             $date1 = new DateTime("2020-01-01 ".($first_finish[0]+1).":".($first_finish[1]-60).":00");
                                         }
                                         else
                                         {
                                             if($firstfinish > '60:00'){
                                                 $firstfinish = '00:00';
                                             }
                                             $date1 = new DateTime("2020-01-01 ".$firstfinish.":00");
                                         }
                                       
                                     }
     
                                 }
     
                                 if(isset($arrival_time[0]) && isset($arrival_time[1]))
                                 {
                                     
                                     if($arrival_time[0]>23 && $arrival_time[0]< 48)
                                     {
                                         if($arrival_time[1]>60 && $arrival_time[1]< 120)
                                     {
                                         $date2 = new DateTime("2020-01-02 ".($arrival_time[0]-23).":".($arrival_time[1]-60).":00");
                                     }
                                     else
                                     {
                                         $date2 = new DateTime("2020-01-02 ".($arrival_time[0]-24).":".$arrival_time[1].":00");
                                     }
                                         
                                     }
                                     else
                                     {
                                         if($arrival_time[1]>60 && $arrival_time[1]< 120)
                                         {
                                             $date2 = new DateTime("2020-01-01 ".($arrival_time[0]+1).":".($arrival_time[1]-60).":00");
                                         }
                                         else
                                         {
                                             $arrivalTime = $routeLoc->arrival_time;
                                             if($routeLoc->arrival_time > '60:00'){
                                                 $arrivalTime = '00:00';
                                             }
                                             $date2 = new DateTime("2020-01-01 ".$arrivalTime.":00");
                                         }
                                       
                                     }
     
                                 }
     
                                 
                                
                                 $interval = $date1->diff($date2);
         
                                 echo $interval->format("%H:%I:%S");    
                                 $firstfinish = $routeLoc->finish_time;
         
                             }
                            
                         }
                         else
                         {
                             $firstfinish = "00:00";
                         }
                        
                     } 
                    "</td>";

                    if(!empty($routeLoc->address_line2)){
                        echo "<td>".$routeLoc->address_line2."</td>";
                    }else{
                        echo "<td>".$routeLoc->address."</td>";
                    }


                    echo "<td>".round($routeLoc->distance/1000,2)."km</td>";
                    if($routeLoc->is_transfered)
                    {
                        $route_transfer_location= RouteTransferLocation::where('new_route_location_id','=',$routeLoc->id)->first();
                        if($route_transfer_location!=null)
                        {
                            echo "<td>".$test[$routeLoc->status_id]." ( R-".$route_transfer_location->old_route_id."-".$route_transfer_location->old_ordinal." )</td>";
                        }
                        else
                        {
                            echo "<td>".$test[$routeLoc->status_id]."</td>";
                        }
                   
                    }
                    else
                    {   
                        echo "<td>".$test[$routeLoc->status_id]."</td>";

                    }
  
                    // echo "<td> <a class='btn red-gradient' href='";echo  URL::to('/')."/backend/route/".$routeLoc->id."/delete/hub'>Delete</a></td>";
                    echo "</tr>";
                      $exchangeRequest = \App\ExchangeRequest::where('tracking_id', $routeLoc->tracking_id)->exists();

                      if($exchangeRequest == true){
                      $exchanges = \App\ExchangeRequest::where('tracking_id', $routeLoc->tracking_id)->first();

                      if($routeLoc->tracking_id == $exchanges->tracking_id){
                      ?>
                      <tr>
                          <td><input class='check' id='check' type='checkbox' name='check' value='{{$exchanges->id}}'></td>
                          <td>{{ $exchanges->id }}</td>
                          <td>R-{{ $route_id."-".$routeLoc->ordinal }}</td>
                          <td></td>
                          <td></td>
                          <td>{{ $exchanges->tracking_id_exchange }}</td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td>{{ $exchanges->address }}</td>
                          <td></td>
                          <td>{{ $test[$exchanges->status_id] }}</td>
                      </tr>
                      <?php
                      }
                      }
                    $i++;               
             }  ?>



                      </tbody>


  </table>
                    </div>


                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>
    <!-- /#page-wrapper -->

    <div id="transfer" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-body">
    <div class='modal-dialog'>
            <div class='modal-content'>
        <p><strong class="order-id green">Transfer <span id="locs"></span> locations to</strong></p>
        
        <input type="hidden" name="route_id" id="route-id" value="{{$route_id}}">
        <input type="hidden" name="hub_id" id="hub-id" value="{{$hub_id}}">
            <label>Please Select a Route</label>
            <select  multiple id="route" name="route_id" class="form-control chosen-select s" required>
                
            </select><br>
            <button type="button" onclick="transferLocs()" class="btn green-gradient">Transfer</button>
            <button type="button" data-dismiss="modal" class="btn red-gradient">Close</button>
       </div></div>
    </div>
</div>

<script>
 var locs = [];
$(document).ready(function() 
    {
        $('#route').select2();
    });


         $("#checkAll").click(function () {
             $('input:checkbox').not(this).prop('checked', this.checked);
              // $('.transfer').prop('disabled', true);
         });



$(document).on('click', '.transfer', function(e) {   
       // var locs = [];
       e.preventDefault();
     
       let hub_id=$("#hub-id").val();
       let route_id=$("#route-id").val();
        $.each($("input[name='check']:checked"), function(){
            locs.push($(this).val());
        });
        if($('#route').html().trim()=="")
        {
            $(".loader").show();
                $(".loader-background").show();  
                $.ajax({
                            type: "GET",
                            url: '<?php echo URL::to('/'); ?>/backend/route/joey/data',
                            data:{route_id:route_id,hub_id:hub_id},
                            success: function(data){   
                                $(".loader").hide();
                              $(".loader-background").hide();  
                                $.each(data, function(value)
                                {
                                
                                    if(data[value].joey_id==null)
                                    {
                                        data[value].joey_id="";
                                    }

                                    $('#route').append("<option value='"+data[value].route_id+"' >R-"+data[value].route_id+"  ( "+data[value].first_name+" "+data[value].last_name+" : "+data[value].joey_id+" ) </option>"); 
                                    
                                });
                                $('#locs').html(locs.length);
                                    $('#transfer').modal();
                                    
                                    return false;
                            },
                                error:function (error) {
                                    $(".loader").hide();
                                    $(".loader-background").hide();
                                
                                        alert('some error');
                                }
                            
                       }); 
        }
        else
        {
            $('#locs').html(locs.length);
                                $('#transfer').modal();
                                
                                return false;
        }
       
     
    
    });

    $(document).on('click', '.check', function(e) {
        var checked = $(this).prop('checked');
        // console.log(checked);
        if(checked){
            $('.transfer').prop('disabled', false);
        } else{
            $('.transfer').prop('disabled', true);
        }
   });

   function transferLocs(){
    $('#transfer').modal('toggle');
    $(".loader").show();
                $(".loader-background").show(); 
    $.ajax({
        type: "POST",
        data : {
            'locations' : locs,
            'route_id' : $('#route').val(),
            'hub_id' : <?php echo $hub_id ?>,
            '_token' : '{{ csrf_token() }}'
        },
        url: '<?php echo URL::to('/'); ?>/backend/route/locations/transfer',
        success: function(){   
           
            $(".loader").hide();
                                $(".loader-background").hide();  
                                    $.alert({
                    title: 'A secure action',
                    content: 'Route Location Transfer Successfully',
                    icon: 'fa fa-question-circle',
                    animation: 'scale',
                    closeAnimation: 'scale',
                    opacity: 0.5,
                    btns: {
                        'confirm': {
                            text: 'Proceed',
                            btnClass: 'btn-info',
                            action: function () {
                              
                                         location.reload();  
                            }
                        }
                    }
                });
        }
    });     
   }

</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTK4viphUKcrJBSuoidDqRhVA4AWnHOo0"></script>

<script>


    function initialize(joey_id,latitude,longitude) {
                $('#ex5 .route-id').text("R-" + joey_id);
                mapCreate(latitude,longitude);


        // [START maps_interaction_restricted_mapoptions]
        // new google.maps.Map(document.getElementById("map5"), {
        //     zoom,
        //     center,
        //     minZoom: zoom - 3,
        //     maxZoom: zoom + 3,
        //     restriction: {
        //         latLngBounds: {
        //             north: -10,
        //             south: -40,
        //             east: 160,
        //             west: 100,
        //         },
        //     },
        // });

    }

//    Map Create
    function mapCreate(latitude,longitude){

        var latlng;
        var geocoder;
        var directionsDisplay;
        var directionsService = new google.maps.DirectionsService();
        var map = null;
        var bounds = null;


        document.getElementById('map5').innerHTML = "";
        directionsDisplay = new google.maps.DirectionsRenderer();

        var bounds = new google.maps.LatLngBounds();

        var latlng = new google.maps.LatLng({
            lat: parseFloat(latitude),
            lng: parseFloat(longitude)
        });
        // setTimeout(() => {
        //     this.map.setZoom(zoom);
        // }, 3000);
        var myOptions = {

            // zoom: 13,
            // center: latlng,
            // mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById("map5"), myOptions);
        directionsDisplay.setMap(map);
        var infowindow = new google.maps.InfoWindow();

        // var marker, i, j = 1;
        var request = {
            travelMode: google.maps.TravelMode.DRIVING
        };
        // for (var i = 0; i < data.length; i++) {
        //     if (data[i]['type'] == "dropoff") {

                var latlng = new google.maps.LatLng({
                    lat: parseFloat(latitude),
                    lng: parseFloat(longitude)
                });

                bounds.extend(latlng);

                var marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    // icon: "https://assets.joeyco.com/images/marker/marker_red1.png",
                    icon: "https://assets.joeyco.com/images/map/pins/big/joey.png",

                    title:   "JOEY"
                });


                // google.maps.event.addListener(marker, 'click', (function(marker, i) {
                //     return function() {
                //         infowindow.setContent("CR-" + data[i]['sprint_id'] + "\n(" + data[i]['address'] + ")");
                //         infowindow.open(map, marker);
                //     }
                // })(marker, i));

                // if (i == 0)
                    request.origin = marker.getPosition();
                // else if (i == data['store'].length - 1)
         request.destination = marker.getPosition();
                // else {
                //     if (!request.waypoints) request.waypoints = [];
                //     request.waypoints.push({
                //         location: marker.getPosition(),
                //         stopover: true
                //     });
                // }
                // j++;
            // }
        // }

        // zoom and center the map to show all the markers
        // directionsService.route(request, function(result, status) {
        //     if (status == google.maps.DirectionsStatus.OK) {
        //         directionsDisplay.setDirections(result);
        //     }
        // });

        map.fitBounds(bounds);
        google.maps.event.addDomListener(window, "load", initialize);
    }
</script>

@endsection