<?php
$statusId = array(
    "136" => "Client requested to cancel the order",
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
    "145" => "Returned To Merchant",
    "146" => "Delivery Missorted, Incorrect Address",
    '153' => 'Miss sorted to be reattempt',
    '154' => 'Joey unable to complete the route', '155' => 'To be re-attempted tomorrow'
);
?>
@extends( 'backend.layouts.app' )
@section('title', 'Orders Label List')
@section('CSSLibraries')
    <link href="{{ backend_asset('libraries/datatables-plugins/dataTables.bootstrap.css') }}" rel="stylesheet">
    <link href="{{ backend_asset('libraries/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">
    <link href="{{ backend_asset('libraries/galleria/colorbox.css') }}" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"
          rel="stylesheet"/>
    <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet"/>
    <link href="{{ backend_asset('libraries/first-mile-hub/index.css') }}" rel="stylesheet">
    <style>
        #print-label-modal {
            transform: translate(-25%, 50%) !important;
        }

        .modal-content {
           margin: 0px 0px 0px 763px !important;
        }
    </style>
@endsection

@section('JSLibraries')
    <!-- DataTables JavaScript -->
    <script src="{{ backend_asset('libraries/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ backend_asset('libraries/datatables-plugins/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ backend_asset('libraries/datatables-responsive/dataTables.responsive.js') }}"></script>
    <script src="{{ backend_asset('libraries/galleria/jquery.colorbox.js') }}"></script>

@endsection


@section('inlineJS')
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
    <script>


        function selectAll(source) {

            checkboxes = document.getElementsByName('foo');
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = source.checked;
            }
        }


        $(".print-label").click(function(){

            var id = [];
            var contect_array = [];
            $(".print-label-id:checked").each(function(){
                id.push($(this).val());
                contect_array.push($(this));
            });
            if (id.length > 0) {
                $('#sprintId').val(id);

                let model_el = $('#print-label-modal').modal();
            }else{
                alert("Please select atleast one checkbox");
            }


        });



    </script>



@endsection
@section('content')

    <div class="right_col" role="main">
        <div class="alert-message"></div>
        <div class="custom_us">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif

            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-green">
                    <button style="color:#f5f5f5" ; type="button" class="close" data-dismiss="alert"><strong><b><i
                                        class="fa fa-close"></i></b></strong></button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-red">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            @if ($message = Session::get('warning'))
                <div class="alert alert-warning alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            @if ($message = Session::get('info'))
                <div class="alert alert-info alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    Please check the form below for errors
                </div>
            @endif
                <div class="page-title">
                    <div class="title_left amazon-text">
                        <!-- <h3>Orders Label List<small></small></h3> -->
                    </div>
                </div>

                <div class="clearfix"></div>
            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                        <h2>Orders Label List<small></small></h2>
                        </div>
                        <div class="x_title">
                            <?php
                                if (!isset($_REQUEST['date'])) {
                                    $date = date('Y-m-d');
                                } else {
                                    $date = $_REQUEST['date'];
                                }
                            ?>
                            <form method="get" action="" >
                                <div class="col-lg-5">
                                   <div class="form-group">
                                   <label>Search By Tracking Ids (<b>Note: </b> Search tracking ids by comma seprated also.) </label>
                                    <input type="text" name="trackingIds" id="trackingIds" required="" placeholder="Tracking Ids"
                                           value="{{$tracking_id}}" class="form-control">
                                   </div>
                                </div>
                                <div class="col-lg-2" style="margin-top:24px;">
                                    <button class="btn sub-ad  btn-primary" type="submit">
                                    Filter
                                    </button>
                                </div>
                            </form>
                                <div class="clearfix"></div>
                        </div>

                        <div class="x_content">

                            @include( 'backend.layouts.notification_message' )

                            <div class="table-responsive">
                                <div class="x_title">   <!---x_title-->
                                    <input type="checkbox" onClick="selectAll(this)" /> Select All
                                    <button type="button" class="btn btn-warning sub-ad btn-primary btn-md print-label"  style="float:right;margin-bottom: 10px;">Print Selected</button><br>
                                    <div class="clearfix">  <!---clearfix-->

                                    </div> <!---clearfix end-->
                                </div>
                                <table class="table table-striped table-bordered return-order-datatable">
                                    <thead stylesheet="color:black;">
                                    <tr>
                                        <th>CheckBox</th>
                                        <th>Order #</th>
                                        <th>Tracking Id</th>
                                        <th>Driver</th>
                                        <th>Customer Address</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($fulfilmentData as $fulfilment)
                                    @php
                                    
                                        $joeyRouteLocation = \App\JoeyRouteLocations::where('task_id', $fulfilment->task_ids)->first();
                                        $joeyRoute = \App\JoeyRoute::find($joeyRouteLocation->route_id);
                                        $joey = \App\Joey::find($joeyRoute->joey_id);
                                    
                                    @endphp
                                    <tr>
                                        <td><input type='checkbox' name='foo'  class='print-label-id' value='{{$fulfilment->id}}'></td>
                                        <td>{{$fulfilment->id}}</td>
                                        <td>{{$fulfilment->tracking_id}}</td>
                                        <td>{{isset($joey) ? $joey->first_name . ' ' . $joey->last_name  . ' (' . $joey->id . ')' : ''}}</td>
                                        <td>{{isset($fulfilment->sprintTasks->task_Location->address) ? $fulfilment->sprintTasks->task_Location->address : ''}}</td>
                                        <td>@if (isset($statusId[$fulfilment->status_id])) {{ $statusId[$fulfilment->status_id]}} @endif</td>
                                        <td>{{$fulfilment->created_at}}</td>
                                        <td><a href="{{backend_url('fulfilment-label/'.$fulfilment->id)}}" target="_blank" title="Detail" class="btn btn-primary btn-xs smBtn">
                                                Print Label
                                        </td>
                                    </tr>
                                    @endforeach
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
    {{--  Loader  --}}
    <div id="wait" style="display:none;position:fixed;top:50%;left:50%;padding:2px;"><img
                src="{{app_asset('images/loading.gif')}} " width="104" height="64"/><br></div>
    <!--model-for-zone-create-open-->
    <div class="modal fade" id="print-label-modal" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content" style="width: 400px; margin: 0 auto;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>
                <div class="modal-body" style=" justify-content: center; display: flex;">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-12 hoverable-dropdown-main-wrap">
                                <!--model-append-html-main-wrap-open-->
                                <div class="col-sm-12 model-zone-append-html-main-wrap">
                                    <p class="confirm-para">Are you sure to print label of selected Id?</p>
                                    <form class="form-horizontal table-top-form-from"  method="get" action="{{route('fulfilment.printLabel', 0)}}">
                                        {{ csrf_field() }}
                                    <input type="hidden" id="sprintId" name="sprintIds[]" value="">
                                        <div class="table-top-form-col-warp inline-form-btn-margin">
                                            <button class="btn orange btn-primary form-submit-btn" style="display: table; margin: 0 auto"> Print </button>
                                        </div>
                                    </form>
                                </div>
                                <!--model-append-html-main-wrap-close-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!--model-for-zone-create-close-->

@endsection
