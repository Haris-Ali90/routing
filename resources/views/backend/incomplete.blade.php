<?php
use App\Joey;
use App\Vehicle;
use App\SlotsPostalCode;
use App\Sprint;
use App\MerchantIds;

?>
@extends( 'backend.layouts.app' )

@section('title', 'Remove Unattempt Orders')

@section('CSSLibraries')
    <!-- DataTables CSS -->
    <link href="{{ backend_asset('libraries/datatables-plugins/dataTables.bootstrap.css') }}" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="{{ backend_asset('libraries/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">
    <!-- Image Viewer CSS -->
    <link href="{{ backend_asset('libraries/galleria/colorbox.css') }}" rel="stylesheet">
    <style>
        .green-gradient, .green-gradient:hover {
            color: #fff;
            background: #bad709;
            background: -moz-linear-gradient(top, #bad709 0%, #afca09 100%);
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #bad709), color-stop(100%, #afca09));
            background: -webkit-linear-gradient(top, #bad709 0%, #afca09 100%);
            background: linear-gradient(to bottom, #bad709 0%, #afca09 100%);
        }

        .black-gradient,
        .black-gradient:hover {
            color: #fff;
            background: #535353;
            background: -moz-linear-gradient(top, #535353 0%, #353535 100%);
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #535353), color-stop(100%, #353535));
            background: -webkit-linear-gradient(top, #535353 0%, #353535 100%);
            background: linear-gradient(to bottom, #535353 0%, #353535 100%);
        }

        .red-gradient,
        .red-gradient:hover {
            color: #fff;
            background: #da4927;
            background: -moz-linear-gradient(top, #da4927 0%, #c94323 100%);
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #da4927), color-stop(100%, #c94323));
            background: -webkit-linear-gradient(top, #da4927 0%, #c94323 100%);
            background: linear-gradient(to bottom, #da4927 0%, #c94323 100%);
        }

        .orange-gradient,
        .orange-gradient:hover {
            color: #fff;
            background: #f6762c;
            background: -moz-linear-gradient(top, #f6762c 0%, #d66626 100%);
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #f6762c), color-stop(100%, #d66626));
            background: -webkit-linear-gradient(top, #f6762c 0%, #d66626 100%);
            background: linear-gradient(to bottom, #f6762c 0%, #d66626 100%);
        }

        .btn {
            font-size: 12px;
        }

        span.select2-selection.select2-selection--multiple {
            height: 39px;
        }

        .form-control {
            height: 39px !important;
        }

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

        /*button.button.orange-gradient {
            border: none;
            line-height: 12px;
            display: inline-block;
            margin: 0;
            border-radius: 4px;
            padding: 8px 20px;
            color: #fff;
            background: #e46d24;
        }*/
        .form-group {
            width: 100%;
            margin: 10px 0;
            padding: 0 15px;
        }

        .form-group input, .form-group select {
            width: 65% !important;
            height: 30px;
        }

        .form-group label {
            width: 25%;
            float: left;
            clear: both;
        }

        input#date {
            height: 30px;
            width: 194px;
        }

        #tracking_id_chosen {
            width: 280px !important;
            margin-right: 5px !important;
            float: left;

        }

        /* #sprint_id_chosen {
            width: 280px !important;
            margin-right: 5px !important;
            float: left;
        } */
        select {
            margin: 0px 5px 0 0 !important;
        }

        /* .tracking_id input {
            padding: 18px !important;
        }
        .sprint_id input {
            padding: 18px !important;
        } */
        span.select2.select2-container.select2-container--default {
            width: 100% !important;
        }

        /* span.select2-selection.select2-selection--multiple {
            height: 35px !important;
        } */
        .tracking_id {
            width: 25%;
            margin-right: 5px;
            float: left;
        }

        .sprint_id {
            width: 25%;
            margin-right: 5px;
            float: left;
        }

    </style>
@endsection

@section('JSLibraries')
    <!-- DataTables JavaScript -->
    <script src="{{ backend_asset('libraries/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ backend_asset('libraries/datatables-plugins/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ backend_asset('libraries/datatables-responsive/dataTables.responsive.js') }}"></script>
    <script src="{{ backend_asset('libraries/galleria/jquery.colorbox.js') }}"></script>
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="{{ backend_asset('js/jquery-ui.js') }}"></script>
    <link href="{{ backend_asset('js/jquery-ui.css') }}" rel="stylesheet"> -->

@endsection

@section('inlineJS')

@endsection

@section('content')

    <div class="right_col" role="main">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        <div class="">
            <div class="page-title">
                <div class="title_left amazon-text">
                    <h3>Remove Unattempt Orders
                        <small></small>
                    </h3>
                </div>
            </div>

            <div class="clearfix"></div>

            {{--@include('backend.layouts.modal')
            @include( 'backend.layouts.popups')--}}
            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <!-- <button style="margin-left:10px" class="btn green-gradient" data-toggle="modal" data-target="#ex1"> <i class="fa fa-plus"></i> Create Slot</button> -->
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_title">
                            <form method="post" action="{{route('mark-incomplete.update')}}">
                                {{csrf_field()}}
                                <input type="hidden" name="is_incomplete" id="is_incomplete" value='1'
                                       class="form-control"/>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Date </label>
                                        <input type="date" name="date" class="form-control" required=""
                                               value="{{ isset($_GET['date'])?$_GET['date']: date('Y-m-d') }}"
                                               placeholder="date">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Hub </label>
                                        <select class="js-example-basic-multiple col-md-4 col-sm-4 col-xs-4 form-control" required="" name="hub">
                                            <option value=""> Select Status </option>
                                            <option value="16"> Montreal</option>
                                            <option value="19"> Ottawa</option>
                                            <option value="17"> Ctc</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-lg green-gradient" type="submit" style="margin-top: 24px;">
                                        Remove Unattempt Orders
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>
    <!-- /#page-wrapper -->


    <!-- CreateSLotsModal -->

    <!-- UpdateSLotModal -->










    <script type="text/javascript">
        $(document).ready(function () {
            $('#sprint_id').select2();
        });
        $(document).ready(function () {
            $('#tracking_id').select2();
        });

    </script>

    <script type="text/javascript">

        $(document).ready(function () {


            $(".tracking_id").show();
//    $(".sprint_id").hide();
//    $('#tracking_id').prop('required',false);
//     $('#tracking_id').prop('required',false);


        });

        // function myFunction() {

        // if (document.typeCV.type.value == "2")  {
        // $(".tracking_id").show();
        // //$('.sprint_id').removeAttr('required');​​​​​
        // $('#tracking_id').prop('required',true);
        // $(".sprint_id").hide();
        // $('#sprint_id').prop('required',false);
        // }
        // else if(document.typeCV.type.value == "1"){
        // $(".sprint_id").show();
        // $('#tracking_id').prop('required',false);
        // $(".tracking_id").hide();
        // $('#sprint_id').prop('required',true);
        // }
        // else{
        // $(".tracking_id").hide();
        //    $(".sprint_id").hide();
        // }
        // }
        $(".chosen-select").chosen({
            no_results_text: "Oops, nothing found!"
        })

    </script>
@endsection