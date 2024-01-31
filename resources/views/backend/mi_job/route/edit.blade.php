<?php
use App\JoeyRoute;
use App\RouteTransferLocation;
use App\Task;

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
    "147" => "Scanned at Hub",
    "148" => "Scanned at Hub and labelled",
    "149" => "pickup from hub",
    "150" => "drop at other hub",
'153' => 'Miss sorted to be reattempt',
'154' => 'Joey unable to complete the route', '155' => 'To be re-attempted tomorrow',
    "151" => "",
    "152" => "",
);

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
        .bug span.select2.select2-container.select2-container--default.select2-container--below {
            box-shadow: 0 0 6px #cd4424;
            border: 0px solid #ca4424;
            border-radius: 10px;
        }
        .bug span.select2.select2-container.select2-container--default.select2-container--below:focus {
            box-shadow: 0 0 6px #cd4424;
            border: 0px solid #ca4424;
            outline-color: #ca4424;
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
                    <h3>Mi Mid Mile Route Details<small></small></h3>
                </div>
            </div>

            <div class="clearfix"></div>

            {{--@include('backend.layouts.modal')
            @include( 'backend.layouts.popups')--}}
            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">

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
    background-color: #000000ba; display: none "
                                >
                                    <div class="loader-iner-warp">
                                        <div class="loader" style="display: none" ></div>
                                    </div>
                                </div>
                                <table id="datatable" class="table table-striped table-bordered">
                                    <thead stylesheet="color:black;">
                                    <tr>
                                        <th>Id</th>
                                        <th>Ref No</th>
                                        <th>Bundle Id</th>
                                        <th>Hub Name</th>
                                        <th>Address</th>
                                        <th>No Of Orders</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    date_default_timezone_set('America/Toronto');

                                    $i=1;
                                    foreach($route as $key => $routeLoc) {

//                                    $tracking = Task::getDropOffTrackingId($routeLoc->sprint_id);

                                        echo "<tr>";
                                        echo "<td>".$i."</td>";
                                        echo "<td>".$routeLoc['reference_no']." </td>";
                                        echo "<td>".$routeLoc['bundle_id']."</td>";
                                        echo "<td>".$routeLoc['hub_name']."</td>";
                                        echo "<td>".$routeLoc['address']."</td>";
                                        echo "<td>".$routeLoc['no_of_order']."</td>";
                                        echo "<td><button type='button' class='details green-gradient btn' data-hub-id='".$routeLoc['hub_id']."' data-bundle-id='".$routeLoc['bundle_id']."'>Order Detail</button></td>";
                                        echo "</tr>";
                                        $i++;
                                    }  ?>

                                    </tbody>


                                </table>
                            </div>


                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <table id="datatable2" class="table table-striped table-bordered" style="display: none">

                        <h1 id="order-detail-heading" style="display: none">Order Details</h1>
                        <thead style="color:black; display: block !important; visibility: visible">
                        <tr>
                            <th>Id</th>
                            <th>Bundle Id</th>
                            <th>Sprint Id</th>
                            <th>Tracking Id</th>
                            <th>Merchant Order Num</th>
                            <th>Hub Name</th>
                            <th>Hub Address</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <div id="wait" style="display:none;position:fixed;top:50%;left:50%;padding:2px;"><img
                src="{{app_asset('images/loading.gif')}} " width="104" height="64"/><br></div>
    <!-- /#page-wrapper -->

    <div id="transfer" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-body">
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <p><strong class="order-id green">Transfer <span id="locs"></span> locations to</strong></p>
                    <p><strong class="order-id red"> <span id="locs_error"></span></strong></p>
                    <input type="hidden" name="route_id" id="route-id" value="{{$route_id}}">
{{--                    <input type="hidden" name="hub_id" id="hub-id" value="{{$hub_id}}">--}}
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
        $(document).ready(function() {
            $(document).ajaxStart(function () {
                $("#wait").css("display", "block");
            });
            $(document).ajaxComplete(function () {
                $("#wait").css("display", "none");
            });
            $("button").click(function () {
                $("#txt").load("demo_ajax_load.asp");
            });
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
                    url: '<?php echo URL::to('/'); ?>/backend/ctc/route/joey/data',
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


        $(document).on('click', '.details', function(e) {
            e.preventDefault();
            var hubId = this.getAttribute('data-hub-id');
            var bundleId = this.getAttribute('data-bundle-id');
            // var date = $('#date').val();

            document.getElementById('datatable2').style.display="block";
            document.getElementById('order-detail-heading').style.display="block"

            $.ajax({
                url: '../../../mi_job/hub/'+hubId+'/order/'+bundleId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data)
                    var i = 1;
                    var comp = "";

                    $('#details .count').text("Count : " + data.details.length);
                    $("#wait").show();
                    $('#datatable2').empty();

                    var thead = '<thead><tr><th>Id</th><th>Bundle Id</th><th>Sprint Id</th><th>Tracking Id</th><th>Merchant Order Num</th><th>Hub</th><th>Address</th><th style="min-width: 280px">Status</th></tr></thead>';

                    data.details.forEach(function(detail) {
                        var sno = i++;
                        var html = '<tr><td>'+sno+'</td><td>'+detail.bundle_id+'</td><td>'+detail.sprint_id+'</td><td>'+detail.tracking_id+'</td><td>'+detail.merchant_order_no+'</td><td>'+detail.hub_name+'</td><td>'+detail.hub_address+'</td><td>'+data.statuses[detail.status_id]+'</td></tr>';
                        comp += html;
                    });
                    $("#wait").hide();

                    $('#datatable2').append(thead+comp);
                },
                error: function(request, error) {
                    alert("Request: " + JSON.stringify(request));
                }
            });
            return false;
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
            $(".loader").show();
            $(".loader-background").show();
            if($('#route').val()==null)
            {
                $(".loader").hide();
                $(".loader-background").hide();
                $("#locs_error").html('Alert : Please Select a Route ID');
            }
            else
            {

                $('#transfer').modal('toggle');
                $.ajax({
                    type: "POST",
                    data : {
                        'locations' : locs,
                        'route_id' : $('#route').val(),

                        '_token' : '{{ csrf_token() }}'
                    },
                    url: '<?php echo URL::to('/'); ?>/backend/ctc/route/locations/transfer',
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

        }

    </script>

@endsection