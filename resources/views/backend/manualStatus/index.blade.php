<?php

$status = array("136" => "Client requested to cancel the order",
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
    '153' => 'Miss sorted to be reattempt',
    '154' => 'Joey unable to complete the route', '155' => 'To be re-attempted tomorrow');
?>

@extends( 'backend.layouts.app' )

@section('title', 'Manual status History')

@section('CSSLibraries')
    <!-- DataTables CSS -->
    <link href="{{ backend_asset('libraries/datatables-plugins/dataTables.bootstrap.css') }}" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="{{ backend_asset('libraries/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">
    <!-- Image Viewer CSS -->
    <link href="{{ backend_asset('libraries/galleria/colorbox.css') }}" rel="stylesheet">
    <style>


        .modal-header .close {
            opacity: 1;
            margin: 5px 0;
            padding: 0;
        }

        .modal-footer .close {
            opacity: 1;
            margin: 5px 0;
            padding: 0;
        }

        .modal-header h4 {
            color: #000;
        }

        .modal-footer {
            padding: 0 10px;
            text-align: right;
            border-top: 1px solid #e5e5e5;
        }

        .modal-header {
            padding: 5px 15px;
            border-bottom: 1px solid #e5e5e5;
            background: #c6dd38;
        }

        span.lbl {
            color: #000;
        }

        .myImg {
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .myImg:hover {
            opacity: 0.7;
        }

        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 99999; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0, 0, 0); /* Fallback color */
            background-color: rgba(0, 0, 0, 0.9); /* Black w/ opacity */
        }

        /* Modal Content (image) */
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        /* Caption of Modal Image */
        #caption {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            color: #ccc;
            padding: 10px 0;
            height: 150px;
        }

        /* Add Animation */
        .modal-content, #caption {
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        @keyframes zoom {
            from {
                transform: scale(0.1)
            }
            to {
                transform: scale(1)
            }
        }

        /* The Close Button */
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 700px) {
            .modal-content {
                width: 100%;
            }
        }


    </style>
@endsection

@section('JSLibraries')
    <!-- DataTables JavaScript -->
    <script src="{{ backend_asset('libraries/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ backend_asset('libraries/datatables-plugins/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ backend_asset('libraries/datatables-responsive/dataTables.responsive.js') }}"></script>
    <script src="{{ backend_asset('libraries/galleria/jquery.colorbox.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="{{ backend_asset('js/jquery-ui.js') }}"></script>
    <link href="{{ backend_asset('js/jquery-ui.css') }}" rel="stylesheet"> -->

@endsection

@section('inlineJS')

    <script>
        $(document).ready(function () {
            $('#datatable').DataTable();
        });
    </script>
@endsection

@section('content')


    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                

                </div>
            </div>

            <div class="clearfix"></div>

            {{--@include('backend.layouts.modal')
            @include( 'backend.layouts.popups')--}}
            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                        <h2>Manual Status History
                        <small></small>
                    </h2>
                        </div>
                        <div class="x_title">
                            <form method="get" action="">
                                <div class="row">
                                    <div class="col-xs-12  col-md-3 col-lg-3">
                                       <div class="form-group">
                                       <label>Search By Tracking Id</label>
                                        <input type="text" name="tracking_id" class="form-control"
                                               value="{{ isset($_GET['tracking_id'])?$_GET['tracking_id']: "" }}"
                                               required="" placeholder="Search By Tracking Id">
                                       </div>
                                    </div>

                                    <div class="col-md-2 col-xs-12">
                                        <button class="btn sub-ad btn-primary" type="submit" style="margin-top: 26px;
    padding-bottom: 9px;">Go</a> </button>
                                    </div>
                                </div>
                            </form>


                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            @include( 'backend.layouts.notification_message' )


                            <div class="table-responsive">
                                {{-- <table id="datatable" class="table table-striped table-bordered">--}}
                                <table id="datatable" class="table table-striped table-bordered">
                                    <thead stylesheet="color:black;">

                                    <tr>
                                        <th class="text-center " style="width: 10%">Tracking #</th>
                                        <th class="text-center " style="width: 20%">Status</th>
                                        <th class="text-center " style="width: 10%">Image</th>
                                        <th class="text-center " style="width: 20%">Reason</th>
                                        <th class="text-center " style="width: 15%">User</th>
                                        <th class="text-center " style="width: 10%">Domain</th>
                                        <th class="text-center " style="width: 10%">Created At</th>
                                    </tr>
                                    </thead>


                                    <tbody>

                                    {{--*/ $i = 1 /*--}}
                                    @foreach( $record as $rec )
                                        <tr>

                                            <td class="text-center ">{{$rec->tracking_id}}</td>
                                            <td class="text-center ">
                                                @if(isset($rec->status_id))
                                                @if ($rec->status_id == 13)
                                                    {{"At hub Processing"}}
                                                @else

                                                    {{$status[$rec->status_id]}}
                                                @endif
                                                    @else

                                                @endif
                                            </td>
                                            <td class="text-center ">
                                                @if($rec->attachment_path)
                                                    <img class='myImg' style="width:50px;height:50px"
                                                         src="{{ $rec->attachment_path }}"/>
                                                @endif
                                            </td>
                                            <td class="text-center ">
                                                @if($rec->reason)
                                                    {{$rec->reason->title}}
                                                @endif
                                            </td>
                                            <td class="text-center ">@if($rec->user)
                                                    {{$rec->user->full_name}}
                                                @endif</td>
                                            <td class="text-center ">{{$rec->domain}}</td>
                                            <?php
                                            if ($rec->created_at) {
                                                $created_at = new \DateTime($rec->created_at, new \DateTimeZone('UTC'));
                                                $created_at->setTimeZone(new \DateTimeZone('America/Toronto'));
                                                $crate_time_zone =  $created_at->format('Y-m-d H:i:s');
                                            }
                                            ?>
                                            <td class="text-center ">{{$crate_time_zone}}</td>
                                        </tr>
                                        {{--*/ $i++ /*--}}
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
    <div id="myModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="img01" style="height: 600px;">
        <div id="caption"></div>
    </div>
    <!-- /#page-wrapper -->
    <script>

        $('.myImg').click(function () {
            let el = $(this);
            let source_src = el.attr('src');
            let source_title = el.attr('alt');

            // geting model
            let model = $('#myModal');
            model.show();
            model.find('#img01').attr('src', source_src);
            model.find('#caption').html(source_title);


        });

        $('#myModal .close').click(function () {

            $('#myModal').hide();
        });

        //    // Get the modal
        //    var modal = document.getElementById('myModal');
        //
        //    // Get the image and insert it inside the modal - use its "alt" text as a caption
        //    var img = document.getElementsByClassName('myImg');
        //    var modalImg = document.getElementById("img01");
        //    var captionText = document.getElementById("caption");
        //    img.onclick = function(){
        //        modal.style.display = "block";
        //        modalImg.src = this.src;
        //        captionText.innerHTML = this.alt;
        //    }
        //    // Get the <span> element that closes the modal
        //    var span = document.getElementsByClassName("close")[0];
        //
        //    // When the user clicks on <span> (x), close the modal
        //    span.onclick = function() {
        //        modal.style.display = "none";
        //    }
    </script>
@endsection