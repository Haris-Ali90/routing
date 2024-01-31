<?php
use App\Joey;
use App\MicroHubOrder;
use App\Slots;
use App\RoutingZones;
use App\JoeyRouteLocations;use App\Sprint;


?>
@extends( 'backend.layouts.app' )

@section('title', 'Hailify Booking')

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
        div#transfer select#joey_id {
            width: 100% !important;
        }
        #transfer .custom_dropdown {
            width: 100%;
            margin-bottom: 10px;
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
        .modal-dialog.map-model {
            width: 94%;
        }
        .btn{
            font-size : 12px;
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

        #ex1 form{
            padding: 10px;
        }
        div#transfer .modal-content, div#details .modal-content {
            padding: 20px;
        }

        #details .modal-content {
            overflow-y: scroll;
            height: 500px;
        }
        div#map5 {
            width: 100% !important;
        }

        .jconfirm .jconfirm-box{
            border : 5px solid #bad709
        }
        .btn-info {
            color: #fff;
            background-color: #cd692e;
        }
        .jconfirm .jconfirm-box .jconfirm-buttons button.btn-default {
            background-color: #b8452b;
            color: #fff !important;
        }

        .jconfirm-content {
            color: #535353;
            font-size: 16px;
        }

        .jconfirm button.btn:hover {
            background: #e46d29 !important;
        }

        .select2 {
            width: 70% !important;
            margin: 0 0 5px 10px;
        }

        /* start */
        .form-group label {
            width: 50px;
        }
        div#route .form-group {
            width: 25%;
            float: left;
        }

        div#route {
            position: absolute;
            z-index: 9999;
            top: 83px;
            width: 97%;
        }

        .
        div {
            display: block;
        }
        .iycaQH {
            position: absolute;
            background-color: white;
            border-radius: 0.286em;
            box-shadow: rgba(86, 102, 108, 0.24) 0px 1px 5px 0px;
            overflow: hidden;
            margin: 1.429em 0px 0px;
            z-index: 9999;
            width: 30%;
            top: 70px;
            left: 26px;
        }
        .cBZXtz {
            display: flex;
            -webkit-box-pack: justify;
            justify-content: space-between;
            -webkit-box-align: center;
            align-items: center;
        }
        .bdDqgn {
            padding: 0.6em 1em;
            background-color: white;
            border-bottom-left-radius: 0.286em;
            border-bottom-right-radius: 0.286em;
            max-height: 28.571em;
            overflow: scroll;
        }
        .cBZXtz {
            display: flex;
            -webkit-box-pack: justify;
            justify-content: space-between;
            -webkit-box-align: center;
            align-items: center;
        }
        .kikQSm {
            display: inline-block;
            max-width: 100%;
            font-size: 0.857em;
            font-family: Lato;
            font-weight: 700;
            color: rgb(86, 102, 108);
            margin-bottom: 0.429em;
        }
        .gdoBAT {
            font-size: 12px;
            margin: 0px 0px 5px 10px;
            color: rgb(86, 102, 108);
        }
        .control-size {
            width: 70px;
        }



        /*boxes css*/
        .montreal-dashbord-tiles h3 {
            color: #fff;
        }
        .montreal-dashbord-tiles .count {
            color: #fff;
        }
        .montreal-dashbord-tiles .tile-stats
        {
            border: 1px solid #c6dd38;
            background: #c6dd38;
        }

        .montreal-dashbord-tiles .tile-stats {
            border: 1px solid #c6dd38;
            background: #c6dd38;
        }
        .montreal-dashbord-tiles .icon {
            color: #e36d28;
        }
        .tile-stats .icon i {
            margin: 0;
            font-size: 60px;
            line-height: 0;
            vertical-align: bottom;
            padding: 0;
        }
        .select2-container {
            width: 100% !important;
            margin-bottom: 10px !important;
        }

        @media only screen and (max-width: 1680px){
            .top_tiles .tile-stats {
                padding-right: 70px;
            }
            .tile-stats .count {
                font-size: 30px;
                font-weight: bold;
                line-height: 1.65857;
                overflow: hidden;
                box-sizing: border-box;
                text-overflow: ellipsis;
            }
            .tile-stats h3 {
                font-size: 12px;
            }
            .top_tiles .icon {
                font-size: 40px;
                position: absolute;
                right: 10px;
                top: 0px;
                width: auto;
                height: auto;
                font-size: 40px;
            }
            .top_tiles .icon .fa {
                vertical-align: middle;
                font-size: inherit;
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="{{ backend_asset('js/jquery-ui.js') }}"></script>
    <link href="{{ backend_asset('js/jquery-ui.css') }}" rel="stylesheet"> -->

@endsection

@section('inlineJS')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#datatable').DataTable({
                "lengthMenu": [25,50,100, 250, 500, 750, 1000 ],
                "ordering": false,
            });
            $(".group1").colorbox({height:"50%",width:"50%"});
        });
    </script>
@endsection

@section('content')
    <meta type="hidden" name="csrf-token" content="{{ csrf_token() }}" />

    <div class="right_col" role="main">
        <div class="alert-message"></div>
        <div class="">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">�</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">�</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            <div class="page-title">
                <div class="title_left amazon-text">
                    <!-- <h3>Hailify Booking List<small></small></h3> -->
                </div>
            </div>

            <div class="clearfix"></div>
            <?php
            if(empty($_REQUEST['date'])){
                $date = date('Y-m-d');
            }
            else{
                $date = $_REQUEST['date'];
            }
            ?>
            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <!--<form id="filter" style="padding: 10px;margin-left: 6px;" action="" method="get">
                            <input id="date" name="date" style="width:35%px" type="date" placeholder="date" value="<?php echo $date ?>"  class="form-control1">
                            <button  id="search" type="submit" class="btn green-gradient">Submit</button>

                        </form>-->

                        <div class="x_content">
                            <div class="x_title">
                                <h2>Hailify Booking List</h2>
                            </div>

                            @include( 'backend.layouts.notification_message' )

                            <div class="table-responsive">
                                <table id="datatable" class="table table-striped table-bordered">
                                    <thead stylesheet="color:black;">
                                    <tr>
                                        <th>Id</th>
                                        <th>Date</th>
                                        <th>Booking Id</th>
                                        <th>Joey Name</th>
                                        <th>Distance</th>
                                        <th>Duration</th>
                                        <th>Order Count</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($haillifyBookings as $key => $haillifyBooking)
                                        @php
                                            $joeyId = (isset($haillifyBooking->sprint->joey)) ? $haillifyBooking->sprint->joey->id : null;
                                            $sprintCount = $haillifyBooking->SprintCount($haillifyBooking->booking_id);
                                            $joeyName = $haillifyBooking->joeyExists($haillifyBooking->booking_id);
                                            $joey = \App\Joey::find($joeyName);
                                        @endphp
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $haillifyBooking->pickup_time }}</td>
                                            <td>{{ $haillifyBooking->booking_id }}</td>
                                            <td>
                                                @if(isset($joey))
                                                    {{ $joey->first_name.' '.$joey->last_name .' ('. $joey->id .')' }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $haillifyBooking->distance }}</td>
                                            <td>{{ $haillifyBooking->duration }}</td>
                                            <td>{{ $sprintCount }}</td>
                                            <td>
                                                <a class=' orange-gradient btn control-size' target='_blank' href='../../haillify/booking/{{$haillifyBooking->booking_id}}' title='Detail'>Detail</a>
                                                    @if(isset($joey))
                                                        <button class='un-assign  black-gradient btn control-size' style="padding: 6px 6px;" data-sprint-id="{{$haillifyBooking->sprint_id}}" data-joey-id="{{ $joeyName }}" data-booking-id="{{$haillifyBooking->booking_id}}" title='Assign'>Un Assign</button>
                                                    @else
                                                        <button class='assign  btn control-size btn-primary' data-booking-id="{{$haillifyBooking->booking_id}}"  title='Assign'>Assign</button>
                                                    @endif
                                                <button class='reject  red-gradient btn control-size' data-booking-id="{{$haillifyBooking->booking_id}}" data-reject-joey-id="{{ $joeyName }}" title='reject'>Reject</button>
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
    <div id="wait" style="display:none;position:fixed;top:50%;left:50%;padding:2px;"><img
                src="{{app_asset('images/loading.gif')}} " width="104" height="64"/><br></div>
    <!-- /#page-wrapper -->

    {{--  Un Assign Booking Confirmation Model --}}
    <div id="un-assign" class="modal" style="display: none">
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Un Assign Booking</h4>
                </div>
                <form action='../../haillify/booking/unassign' method='get' class='UnAssignBooking' style="padding: 15px;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="sprint_id" name="sprint_id" value="">
                    <input type="hidden" id="un_assign_booking_id" name="un_assign_booking_id" value="">
                    <input type="hidden" id="un_assign_joey_id" name="un_assign_joey_id" value="">
                    <div class="form-group">
                        <p><b>Are you sure you want to Un Assign Booking ?</b></p>
                    </div>
                    <div class="d-flex justify-content-end ">
                        <button type="submit" class="btn green-gradient sub-ad btn-xs">Yes</button>
                        <button type="button" class="btn red-gradient sub-ad btn-xs" data-dismiss="modal">No</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--  Reject Booking Confirmation Model --}}
    <div id="reject" class="modal" style="display: none">
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Reject Booking</h4>
                </div>
                <form action='../../haillify/booking/reject' method='get' class='RejectBooking' style="padding: 15px;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="booking_id" name="booking_id" value="">
                    <input type="hidden" id="reject_joey_id" name="reject_joey_id" value="">
                    <div class="form-group">
                        <p><b>Are you sure you want to Reject Booking ?</b></p>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn sub-ad green-gradient btn-xs">Yes</button>
                        <button type="button" class="btn sub-ad red-gradient btn-xs" data-dismiss="modal">No</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--  Assign Booking To Joey Model  --}}
    <div id="assign" class="modal" role="dialog" aria-hidden="true">
        <div class="modal-body">
            <div class='modal-dialog'>
                <div style="padding: 20px;" class='modal-content'>
                    <p><strong class="order-id green"></strong></p>
                    <form action='../route/transfer' method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <label style="width: 100% !important;">Please Select a Joey</label>
                        <select name="joey_id" id="joey_id" class="form-control chosen-select s">
                            <?php $joeys = Joey::whereNull('deleted_at')
                                ->where('is_enabled', '=', 1)
                                ->whereNull('email_verify_token')
                                ->whereNOtNull('plan_id')
                                ->orderBy('first_name')
                                ->get();
//                                echo "<option value='' required='required'>Please Select Joey</option>";
                                foreach ($joeys as $joey) {
                                    echo "<option value=" . $joey->id . ">" . $joey->first_name . " " . $joey->last_name . "(" . $joey->id . ")</option>";
                                }
                            ?>
                        </select>
                        <input type="hidden" name="assign_booking_id" id="assign_booking_id">
                        <br>
                        <a type="submit" data-selected-row="false"  onclick="transfer()" class="btn green-gradient transfer-model-btn">Assign</a>
                        <a class="btn black-gradient" data-dismiss="modal" aria-hidden="true">Close</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>

        $(document).ready(function() {
            $('#joey_id').select2({
                dropdownParent: $("#assign"),
            });

            $(document).ajaxStart(function () {
                $("#wait").css("display", "block");
            });
            $(document).ajaxComplete(function () {
                $("#wait").css("display", "none");
            });
        });

        arr=['blu-blank','blu-circle','blu-diamond','blu-square','blu-stars',
            'red-blank','red-circle','red-diamond','red-square','red-stars',
            'grn-blank','grn-circle','grn-diamond','grn-square','grn-stars',
            'pink-blank','pink-circle','pink-diamond','pink-square','pink-stars',
            'purple-blank','purple-circle','purple-diamond','purple-square','purple-stars',
            'wht-blank','wht-circle','wht-diamond','wht-square','wht-stars'];

        $(document).ready(function(){
            $("map5").empty();
        });



        //un assign model
        $(document).on('click', '.reject', function(e) {
            e.preventDefault();
            var bookingId = this.getAttribute('data-booking-id');
            var rejectJoeyId = this.getAttribute('data-reject-joey-id');
            $('#booking_id').val(bookingId);
            $('#reject_joey_id').val(rejectJoeyId);
            $('#reject').modal();
        });

        // un assign booking
        $('.RejectBooking').submit(function (event) {
            event.preventDefault();
            // get the form data
            var data = new FormData();
            data.append('booking_id', $('input[name=booking_id]').val());
            data.append('joey_id', $('input[name=reject_joey_id]').val());
            // $('#ex10').modal('toggle');
            // process the form
            $(".loader").show();
            $(".loader-background").show();
            //run ajax with data
            $.ajax({
                url: $('.RejectBooking').attr('action'),
                type: 'POST',
                contentType: false,
                processData: false,
                data: data,
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', "{{ csrf_token() }}");
                },
                //show success response
                success: function (data) {
                    $('#reject').modal('hide');
                    var res = JSON.parse(data);
                    if(res.status == 200){
                        $('.alert-message').html('<div class="alert alert-success alert-green"><button style="color:#f5f5f5"; type="button" class="close" data-dismiss="alert"><strong><b><i  class="fa fa-close"></i><b></strong></button><strong>' + res.output + '</strong>');
                        setTimeout(function(){
                            location.reload();
                        }, 1000);
                    }else{
                        $('.alert-message').html('<div class="alert alert-success alert-red"><button style="color:#f5f5f5"; type="button" class="close" data-dismiss="alert"><strong><b><i  class="fa fa-close"></i><b></strong></button><strong>' + res.output + '</strong>');
                    }

                },
                failure: function (result) {
                    $('#ex20').modal('hide');
                    $(".loader").hide();
                    $(".loader-background").hide();
                    bootprompt.alert(result);
                }
            });
            event.preventDefault();
        });

        //un assign model
        $(document).on('click', '.un-assign', function(e) {
            e.preventDefault();
            var sprintId = this.getAttribute('data-sprint-id');
            var joeyId = this.getAttribute('data-joey-id');
            var bookingId = this.getAttribute('data-booking-id');
            $('#sprint_id').val(sprintId);
            $('#un_assign_joey_id').val(joeyId);
            $('#un_assign_booking_id').val(bookingId);
            $('#un-assign').modal();
        });

        // un assign booking
        $('.UnAssignBooking').submit(function (event) {
            event.preventDefault();
            // get the form data
            var data = new FormData();
            data.append('sprint_id', $('input[name=sprint_id]').val());
            data.append('joey_id', $('input[name=un_assign_joey_id]').val());
            data.append('booking_id', $('input[name=un_assign_booking_id]').val());
            // $('#ex10').modal('toggle');
            // process the form
            $(".loader").show();
            $(".loader-background").show();
            //run ajax with data
            $.ajax({
                url: $('.UnAssignBooking').attr('action'),
                type: 'POST',
                contentType: false,
                processData: false,
                data: data,
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', "{{ csrf_token() }}");
                },
                //show success response
                success: function (data) {
                    $('#un-assign').modal('hide');
                    var res = JSON.parse(data);
                    if(res.status == 200){
                        $('.alert-message').html('<div class="alert alert-success alert-green"><button style="color:#f5f5f5"; type="button" class="close" data-dismiss="alert"><strong><b><i  class="fa fa-close"></i><b></strong></button><strong>' + res.output + '</strong>');
                        setTimeout(function(){
                            location.reload();
                        }, 1000);
                    }else{
                        $('.alert-message').html('<div class="alert alert-success alert-red"><button style="color:#f5f5f5"; type="button" class="close" data-dismiss="alert"><strong><b><i  class="fa fa-close"></i><b></strong></button><strong>' + res.output + '</strong>');
                    }
                },
                failure: function (result) {
                    $('#ex20').modal('hide');
                    $(".loader").hide();
                    $(".loader-background").hide();
                    bootprompt.alert(result);
                }
            });
            event.preventDefault();
        });

        //transfer joey model
        $(document).on('click', '.assign', function(e) {
            e.preventDefault();
            var bookingId = this.getAttribute('data-booking-id');
            $('#assign_booking_id').val(bookingId);
            $('#assign').modal();
            return false;
        });

        // transfer route to joey ajax
        function transfer() {
            let joey_id = $('#joey_id').val();
            let booking_id = $('#assign_booking_id').val()

            if(joey_id  == 'undefined'){
                alert('please select the joey');
            }
            else{

                $.ajax({
                    type: "POST",
                    url: '../../haillify/booking/transfer',
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    data:{joey_id : joey_id, booking_id:booking_id},
                    success: function (data) {
                        $('#assign').modal('hide');
                        var res = JSON.parse(data);
                        if(res.status == 200){
                            $('.alert-message').html('<div class="alert alert-success alert-green"><button style="color:#f5f5f5"; type="button" class="close" data-dismiss="alert"><strong><b><i  class="fa fa-close"></i><b></strong></button><strong>' + res.output + '</strong>');
                            setTimeout(function(){
                                location.reload();
                            }, 1000);
                        }else{
                            $('.alert-message').html('<div class="alert alert-success alert-red"><button style="color:#f5f5f5"; type="button" class="close" data-dismiss="alert"><strong><b><i  class="fa fa-close"></i><b></strong></button><strong>' + res.output + '</strong>');
                        }
                    },
                    error: function (error) {
                    }
                });
            }
        }

        $( document ).ready(function() {
            setTimeout(() => {   i=$('#datatable').DataTable().rows()
                .data().length;
                console.log(i);

                if(i!=0)
                {
                    $(".right_col").css({"min-height": "auto"});
                } }, 1000);
        });

        //delete route
        $(document).on('click', '.delete', function(e){

            var $form = $(this);
            $.confirm({
                title: 'A secure action',
                content: 'Are you sure you want to delete this route ?',
                icon: 'fa fa-question-circle',
                animation: 'scale',
                closeAnimation: 'scale',
                opacity: 0.5,
                buttons: {
                    'confirm': {
                        text: 'Proceed',
                        btnClass: 'btn-info',
                        action: function () {
                            var id = $form.attr("data-id");

                            $.ajax({
                                type: "GET",
                                url: '../../mi_job/route/'+id+'/delete',
                                success: function(message){
                                    $.alert(message);
                                    location.reload();
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

    </script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTK4viphUKcrJBSuoidDqRhVA4AWnHOo0"></script>

@endsection