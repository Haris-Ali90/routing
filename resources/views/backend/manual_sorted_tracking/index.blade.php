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
    "147" => "Scanned at hub",
    "148" => "Scanned at Hub and labelled",
    "149" => "Bundle Pick From Hub",
    "150" => "Bundle Drop To Hub",
    '153' => 'Miss sorted to be reattempt',
    '154' => 'Joey unable to complete the route', '155' => 'To be re-attempted tomorrow'

);
$statuses = array(
    "136" => "Client requested to cancel the order",
    "135" => "Customer refused delivery",
    "108" => "Customer unavailable-Incorrect address",
    "106" => "Customer unavailable - delivery returned",
    "107" => "Customer unavailable - Left voice mail - order returned",
    "109" => "Customer unavailable - Incorrect phone number",
    "142" => "Damaged at hub (before going OFD)",
    "143" => "Damaged on road - undeliverable",
    "110" => "Delivery to hub for re-delivery",
    "111" => "Delivery to hub for return to merchant",
    "102" => "Joey Incident",
    "104" => "Damaged on road - delivery will be attempted",
    "105" => "Item damaged - returned to merchant",
    "101" => "Joey on the way to pickup",
    "112" => "To be re-attempted",
    "131" => "Office closed - returned to hub",
    "145" => "Returned To Merchant",
    "146" => "Delivery Missorted, Incorrect Address",
    "147" => "Scanned at hub",
    "148" => "Scanned at Hub and labelled",
    "149" => "Bundle Pick From Hub",
    "150" => "Bundle Drop To Hub",
    '153' => 'Miss sorted to be reattempt',
    '154' => 'Joey unable to complete the route', '155' => 'To be re-attempted tomorrow'
);
?>

@extends( 'backend.layouts.app' )

@section('title', 'Sorted Tracking List')

@section('CSSLibraries')
    <!-- DataTables CSS -->
    <link href="{{ backend_asset('libraries/datatables-plugins/dataTables.bootstrap.css') }}" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="{{ backend_asset('libraries/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">
    <!-- Image Viewer CSS -->
    <link href="{{ backend_asset('libraries/galleria/colorbox.css') }}" rel="stylesheet">
    <!--joey-custom-css-->
    <link href="{{ backend_asset('css/joeyco-custom.css') }}" rel="stylesheet">
    <style>


        .search-order {
            background-color: #c6dd38;
            margin-top: 26px;
        }

        .tracking_id
        {
            margin-top: 26px;
        }
        .input-error {
            color: red;
            padding: 10px 0px;
        }
        .form-submit-btn {
            margin-top: 26px;
            width: 100%;
            background-color: #c6dd38;
        }
        .filter-out-button .filter-out
        {
            margin-top: 26px;
            text-align: center;
            background-color: #c6dd38;
        }
        .show-notes{
            background-color: #C6DD38;
            border-style:none;
            padding: 6px 9px 6px 9px;
        }
        /* dragable div for route count */

        #mydiv {
            position: absolute;
            z-index: 9;
            background-color: #f1f1f1;
            text-align: center;
            border: 1px solid #d3d3d3;
        }

        #mydivheader {
            padding: 10px;
            cursor: move;
            z-index: 10;
            background-color: #c7dd1f;
            color: black;
        }
    </style>


@endsection

@section('JSLibraries')
    <!-- DataTables JavaScript -->
    <script src="{{ backend_asset('libraries/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ backend_asset('libraries/datatables-plugins/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ backend_asset('libraries/datatables-responsive/dataTables.responsive.js') }}"></script>
    <script src="{{ backend_asset('libraries/galleria/jquery.colorbox.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTK4viphUKcrJBSuoidDqRhVA4AWnHOo0&libraries=places" type="text/javascript"></script>
    <!-- Custom JavaScript -->
    <script src="{{ backend_asset('js/joeyco-custom-script.js')}}"></script>
@endsection

@section('inlineJS')
    <script type="text/javascript">
        <!-- Datatable -->
        $(document).ready(function () {
            //Set Columns In Table After Scan
             let tracking_datatable = $('.return-order-datatable').DataTable({
                 // scrollX: true,   // enables horizontal scrolling,
             });

            //Multiple Reattempt Order
            $(document).on('click', '.multiple-reattempt-order', function (e) {
                let el = $(this);
                var data_object = JSON.parse(el.attr('data-object'));

                $.confirm({
                    title: 'A secure action',
                    content: 'Are you sure you want to multiple package sort orders?',
                    icon: 'fa fa-question-circle',
                    animation: 'scale',
                    closeAnimation: 'scale',
                    opacity: 0.5,
                    buttons: {
                        'confirm': {
                            text: 'Proceed',
                            btnClass: 'btn-info',
                            action: function () {
                                showLoader();
                                $.ajax({
                                    type: "GET",
                                    url: "{{URL::to('/')}}/backend/manual/sorting/multiple_tracking",
                                    data: {
                                        data: data_object
                                    },
                                    success: function (res) {
                                        hideLoader();
                                        var data = JSON.parse(res)
                                        ShowSessionAlert('success', data.message);
                                        setTimeout(function(){
                                            location.reload();
                                        }, 1000);
                                    },
                                    error: function (error) {
                                        hideLoader();
                                        ShowSessionAlert('danger', 'Something critical went wrong');
                                        console.log(error);
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


            //marked status
            $(document).on('click', '.marked', function(e){

                var element = document.getElementById('tracking-id-marked');
                var dataID = element.getAttribute('data-tracking-id');

                $.confirm({
                    title: 'A secure action',
                    content: 'Are you sure you want to marked sorted this order?',
                    icon: 'fa fa-question-circle',
                    animation: 'scale',
                    closeAnimation: 'scale',
                    opacity: 0.5,
                    buttons: {
                        'confirm': {
                            text: 'Proceed',
                            btnClass: 'btn-info',
                            action: function () {
                                showLoader();
                                $.ajax({
                                    type: "GET",
                                    url: "{{URL::to('/')}}/backend/manual/sorting/single_tracking",
                                    data: {
                                        tracking_id: dataID
                                    },
                                    success: function (res) {
                                        var data = JSON.parse(res)
                                        ShowSessionAlert('success', data.message);
                                        setTimeout(function(){
                                            location.href = "{{URL::to('/')}}/backend/manual/sorting/tracking";
                                        }, 1000);
                                    },
                                    error: function (error) {
                                        hideLoader();
                                        ShowSessionAlert('danger', 'Something critical went wrong');
                                        console.log(error);
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
        });

        //ajax function for select all and condition for check all and uncheck
        $('.select-all').click(function() {

            let is_checked = $(this).prop('checked');
            if (is_checked)
            {
                $('.reattemptCheckbox').prop('checked', true); // Checks it
            }
            else
            {
                $('.reattemptCheckbox').prop('checked', false); // Un-checks it
            }

            loadCheck(is_checked);

        });

        //loadCheck(); // initial call this function to load data

        $(document).on('click', '.reattemptCheckbox', function (e)
        {

            single_checkbox_fn($(this),'single');
        });

        // single checkbox fucntion
        function single_checkbox_fn(el,type = 'load') {
            let element = el;
            let tracking_id = element.val();
            let data_reattempt_id = element.attr('data-reattempt');
            let btn_data = JSON.parse($('.scan-for-multiple-reattempt-order').attr('data-object'));
            if(element.prop("checked") == true)
            {
                btn_data[data_reattempt_id] = {"tracking_id":tracking_id,"reattempt_id":data_reattempt_id};
            }
            else
            {
                // remove uncheck all checked btn
                if(type == 'single')
                {
                    $('.select-all').prop('checked', false);
                }

                delete btn_data[data_reattempt_id];
            }

            // checking the object is empty
            if(type == 'single' && Object.keys(btn_data).length === 0)
            {
                $('.scan-for-multiple-reattempt-order').hide();
            }
            else if(type == 'single' && Object.keys(btn_data).length > 0)
            {
                $('.scan-for-multiple-reattempt-order').show();
            }
            // updated
            btn_data = JSON.stringify(btn_data);
            $('.scan-for-multiple-reattempt-order').attr('data-object',btn_data);
        }

        //Function for get and set value for reattempt
        function loadCheck(type) {

            // getting all check box
            var all_checkbox_count = $('.reattemptCheckbox');
            // getting checked boxes
            var reattemptCheckbox_checked = $('input[name="scan-reattempt"]:checked');
            // get button
            let button = $('.multiple-reattempt-order');

            //checking the total box checked then checek all show
            if(reattemptCheckbox_checked.length < all_checkbox_count.length)
            {
                $('.select-all').prop('checked', false);
            }
            else
            {
                $('.select-all').prop('checked', true);
            }

            // checking all checked type
            if(type)
            {
                // looping up the checked boxes for set values
                reattemptCheckbox_checked.each(function(index){
                    single_checkbox_fn($(this));

                });
                // show button
                button.show();
            }
            else
            {
                // make checked box to unchecked
                all_checkbox_count.prop('checked', false);

                // remove data from button
                button.attr('data-object',"{}");
                // hide button
                button.hide();

            }

        }

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
{{--    @include( 'backend.layouts.loader' )--}}
    <div id="map"></div>
    <div class="right_col" role="main">
        <div class="page-title">
            <div class="title_left">
                <!-- <h3>Sorted Section
                    <small></small>
                </h3> -->
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                    <h2>Sorted Tracking List</h2>
                    </div>
                    <div class="x_title">
                        <div class="clearfix"></div>
                        <form class="search-tracking-id" action="{{ route('manual.sorting.index') }}" method="get">
                            <div class="row d-flex align-items-center ">
                                <div class="col-lg-3 ">
                                    <div class="form-group">
                                    <input class="form-control tracking_id" name="tracking_id" type="text" placeholder="Tracking Id" required="required" />
                                    </div>
                                </div>
                                
                                
                                  <button class=" sub-ad btn-primary" type="submit"  >Search</button>
                             
                               
                            </div>
                        </form>
                        
                        <div class="clearfix"></div>
                    </div>
                    @include( 'backend.layouts.notification_message' )
                    <div class="x_content">
                        @if($data == false)
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                                Tracking id already scanned!
                            </div>
                        @endif
                        @include( 'backend.layouts.errors' )
                        <div class="empty">
                            @if(count($routeData) > 0)
                                @if($exists == 1)
                                    <input type="hidden" id="hiddenValue" />
                                    <button type="submit"
                                            class="col-md-1 btn btn-success btn-sm multiple-reattempt-order scan-for-multiple-reattempt-order"
                                            id="showValue"
                                            data-object="{}"
                                            data-id=""
                                            data-tracking_id="" style="display: none"> Marked All
                                    </button>
                                @endif
                            @endif
                            <div class="clearfix"></div>
                        </div>
                        <table class="table table-striped table-bordered return-order-datatable" data-form="deleteForm">
                            <thead>
                            <tr>
                                <th style="width: 8%" data-orderable="false">Select All
                                    @if(count($routeData) > 0)
                                        @if($exists == 1)
                                            <input type="checkbox" name="tracking-ids[]" class="select-all"/>
                                        @endif
                                    @endif
                                </th>
                                <th style="width: 8%">Order Id</th>
                                <th style="width: 10%">Tracking Id</th>
                                <th style="width: 10%">Route Id</th>
                                <th style="width: 7%">Status</th>
                                <th style="width: 10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @if($routeData != null)
                                @foreach($routeData as $data)
                                    @if($data->status_id != 133)
                                    <tr class="tr-no">
                                            <td>
                                                @if($data->status_id == 61 || $data->status_id == 124)
                                                    <Input class="reattemptCheckbox" type="checkbox" value="{{$data->tracking_id }}" data-reattempt="{{$data->id }}" name="scan-reattempt">
                                                @else
                                                    <input type="checkbox">
                                                @endif
                                            </td>
                                            <td>{{$data->sprint_id}}</td>
                                            <td>{{$data->tracking_id}}</td>
                                            <td>{{$data->route_id}}</td>
                                            <td>{{$statusId[$data->status_id]}}</td>
                                            <td>
                                                @if($data->status_id == 61 || $data->status_id == 124)
                                                    <button class="btn btn-primary marked" id="tracking-id-marked" data-tracking-id="{{ $data->tracking_id }}">Mark</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @else
                                <tr>
                                    <td>No Record Found</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        <div id="mydiv" style="display: none;height: 300px;width: 300px;">
                            <div id="mydivheader">Route Details</div>
                            <div class="col-md-12 mt-4" style="margin-top: 12px">
                                <div class="col-md-6 text-left">Route Id:</div>
                                <div class="col-md-6 text-right" id="route-id"></div>
                            </div>
                            <div class="col-md-12" style="margin-top: 12px">
                                <div class="col-md-6 text-left">Order Count:</div>
                                <div class="col-md-6 text-right" id="order-count"></div>
                            </div>
                            <div class="col-md-12" style="margin-top: 12px">
                                <div class="col-md-6 text-left">Pickup Count:</div>
                                <div class="col-md-6 text-right" id="pickup-count"></div>
                            </div>
                            <div class="col-md-12" style="margin-top: 12px">
                                <div class="col-md-6 text-left">Delivered Count:</div>
                                <div class="col-md-6 text-right" id="delivered-count"></div>
                            </div>
                            <div class="col-md-12" style="margin-top: 12px">
                                <div class="col-md-6 text-left">Return Count:</div>
                                <div class="col-md-6 text-right" id="return-count"></div>
                            </div>
                            <div class="col-md-12" style="margin-top: 12px">
                                <div class="col-md-6 text-left">Reattempt Count:</div>
                                <div class="col-md-6 text-right" id="reattempt-count"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
