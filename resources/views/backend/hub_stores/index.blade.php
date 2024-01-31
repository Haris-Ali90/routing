<?php
use App\Joey;
use App\Vehicle;
use App\SlotsPostalCode;
use App\Slots;
use App\Sprint;
?>
@extends( 'backend.layouts.app' )
@section('title', 'Hubs')
@section('CSSLibraries')
    <link href="{{ backend_asset('libraries/datatables-plugins/dataTables.bootstrap.css') }}" rel="stylesheet">
    <link href="{{ backend_asset('libraries/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">
    <link href="{{ backend_asset('libraries/galleria/colorbox.css') }}" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"
          rel="stylesheet"/>
    <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet"/>
    <link href="{{ backend_asset('libraries/custom/index.css') }}" rel="stylesheet">
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
        <div class="alert-message"></div>
        <div class="">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif

            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-green">
                    <button style="color:#f5f5f5" ; type="button" class="close" data-dismiss="alert"><strong><b><i
                                        class="fa fa-close"></i><b></strong></button>
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


            <div class="clearfix"></div>

            {{--@include('backend.layouts.modal')
            @include( 'backend.layouts.popups')--}}


            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">

                            <?php

                            if (!isset($_REQUEST['date'])) {
                                $date = date('Y-m-d');
                            } else {
                                $date = $_REQUEST['date'];
                            }

                            ?>
                            <form method="get" action="" class="d-flex align-items-center">
                                <div class="col-lg-3">
                                <div class="form-group">
                                <label>Search By Date</label>
                                <input type="date" name="date" id="date" class="form-control" required="" placeholder="Search"
                                       value="<?php echo $date ?>">
                                </div>
                                </div>
                                <button class="btn btn-primary sub-ad " type="submit" style="margin: 20px 0px 0px 0px !important;">
                                    Go</a> </button>
                            </form>

                        {{--                            <a href="{{ route('create.hub.stores') }}">--}}
                        {{--                                <button style="margin-left:10px" class="btn green-gradient"><i class="fa fa-plus"></i>--}}
                        {{--                                    Create Zone--}}
                        {{--                                </button>--}}
                        {{--                            </a>--}}
                        <!-- <button type='button' style="margin-left:10px" class="routeCount btn btn green-gradient actBtn" data-toggle="modal" > <i class="fa fa-eye"></i>Get Total Orders Count</button> -->
                            <div class="clearfix"></div>
                        </div>


                        <div class="x_content">

                            @include( 'backend.layouts.notification_message' )

                            <div class="table-responsive">
                                <table id="datatable-" class="table table-striped table-bordered">
                                    <thead stylesheet="color:black;">
                                    <tr>
                                        <th>ID</th>
                                        <th style="width: 10%;">Hub ID</th>
                                        <th>Hub Title</th>
                                        <th style="width: 11%;">Zones</th>
                                        <th style="width: 11%;">Stores</th>
                                        {{--                                        <th>Action</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $i = 1;
                                        $hub = '';
                                    @endphp
                                    @foreach($hubs as $hub)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $hub->id }}</td>
                                            <td>{{ $hub->title }}</td>
                                            <td style='width: 20%'>
                                                @if(count($hub->zone) > 1)
                                                    <ol>
                                                        <button class='btn green-gradient btn-xs accordion'><i
                                                                    class='fa fa-angle-down'></i></button>
                                                        @endif
                                                        @php $j = 1; @endphp
                                                        @php
                                                            $hubZones = \App\HubZones::with('zone')->where('hub_id',$hub->id)->whereNull('deleted_at')->get();
                                                        @endphp
                                                        @foreach($hubZones as $zone)
                                                            @if(isset($zone->zone))
                                                                @if($j == 1)
                                                                    <li class='pCode'>{{ $j .': '. (isset($zone->zone->title)) ? $zone->zone->title : 'N/A' }}</li>
                                                                @else
                                                                    <li class='panell'>{{ $j .': '. (isset($zone->zone->title)) ? $zone->zone->title : 'N/A' }}</li>
                                                                @endif
                                                            @endif
                                                            @php $j++; @endphp
                                                        @endforeach
                                                    </ol>
                                            </td>
                                            <td style='width: 20%'>
                                                @php
                                                   $getVendorIds = App\HubStore::where('hub_id', $hub->id)->whereNull('deleted_at')->pluck('vendor_id');
                                                @endphp
                                                @if(count($getVendorIds) > 1)
                                                    <ol>
                                                        <button class='btn green-gradient btn-xs accordion'><i
                                                                    class='fa fa-angle-down'></i></button>
                                                        @endif
                                                        @php $j = 1; @endphp
                                                        @foreach($getVendorIds as $vendor)
                                                            @php
                                                                $vendors = App\Vendor::whereNull('deleted_at')->find($vendor);

                                                            @endphp

                                                            @if($j == 1)
                                                                <li class='pCode'>{{ $j .': '. $vendors->first_name .' '. $vendors->last_name .' | '. $vendors->business_address }}</li>
                                                            @else
                                                                <li class='panell'>{{ $j .':' . $vendors->first_name .' '. $vendors->last_name .' | '. $vendors->business_address }}</li>
                                                            @endif
                                                            @php $j++; @endphp
                                                        @endforeach
                                                    </ol>
                                            </td>
                                            <td>
                                                    <a href='{{ url('backend/hub_stores/'. $hub->id) }}' class='btn btn btn-primary actBtn'>Attach Stores</a>
                                                    <a href='{{ url('backend/attach/zones/'. $hub->id) }}' class='btn btn btn-primary actBtn'>Attach Zones</a>
                                            </td>
                                        </tr>
                                        @php $i++; @endphp
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



    <script type="text/javascript">
        // Vendor ids dropdown in hub stores listing
        $(document).ready(function () {
            $(".accordion").click(function () {
                //toggleactiveclass
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                } else {
                    $(this).addClass('active');
                }
                //addcssClass
                if ($(this).hasClass('active')) {
                    $(this).parent().find(".panell").css({
                        "maxHeight": "20px",
                    });
                } else {
                    $(this).parent().find(".panell").css({
                        "maxHeight": "0px",
                    });
                }
            });

            var i = 0;
            $(document).ready(function () {
                i++;
                var scntDiv = $('#add_words');
                $('<div class="line"><label>Postal Code </label><input type="text" value="" name="postal[]" maxlength="3 " style="padding-left: 15px;" placeholder="Postal code" pattern="[A-Za-z]{1}[0-9]{1}[A-Za-z]{1}" required  /> <button class="remScnt btn red-gradient">x</button></div>').appendTo(scntDiv);
            });

            var scntDiv = $('#add_words');
            var wordscount = 1;
            // var i = $('.line').size() + 1;
            $('#add').click(function () {
                // alert()
                var inputFields = parseInt($('#inputs').val());
                for (var n = i; n < inputFields; ++n) {
                    wordscount++;
                    $('<div class="line"><label>Postal Code </label><input type="text" value="" name="postal[]" maxlength="3" placeholder="Postal code" pattern="[A-Za-z]{1}[0-9]{1}[A-Za-z]{1}" required  /> <button class="remScnt btn red-gradient">x</button></div>').appendTo(scntDiv);
                    i++;
                }
                return false;
            });
            //    Remove button
            $('#add_words').on('click', '.remScnt', function () {
                if (i > 1) {
                    $(this).parent().remove();
                    i--;
                }
                return false;
            });
        });
    </script>

    <script type="text/javascript">
        // Datatable
        $(document).ready(function () {

            $('#datatable').DataTable({

                "lengthMenu": [25, 50, 100, 250, 500, 750, 1000]


            });

            $(".group1").colorbox({height: "50%", width: "50%"});

            $(document).on('click', '.status_change', function (e) {
                var Uid = $(this).data('id');

                $.confirm({
                    title: 'A secure action',
                    content: 'Are you sure you want to change user status??',
                    icon: 'fa fa-question-circle',
                    animation: 'scale',
                    closeAnimation: 'scale',
                    opacity: 0.5,
                    buttons: {
                        'confirm': {
                            text: 'Proceed',
                            btnClass: 'btn-info',
                            action: function () {

                                $.ajax({
                                    type: "GET",
                                    url: "<?php echo URL::to('/'); ?>/api/changeUserStatus/" + Uid,
                                    data: {},
                                    success: function (data) {
                                        if (data == '0' || data == 0) {
                                            var DataToset = '<button type="btn" class="btn btn-warning btn-xs status_change" data-toggle="modal" data-id="' + Uid + '" data-target=".bs-example-modal-sm">Blocked</button>';
                                            $('#CurerntStatusDiv' + Uid).html(DataToset);
                                        } else {
                                            var DataToset = '<button type="btn" class="btn btn-success btn-xs status_change" data-toggle="modal" data-id="' + Uid + '" data-target=".bs-example-modal-sm">Active</button>'
                                            $('#CurerntStatusDiv' + Uid).html(DataToset);
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

            $(document).on('click', '.form-delete', function (e) {

                var $form = $(this);
                $.confirm({
                    title: 'A secure action',
                    content: 'Are you sure you want to delete user ??',
                    icon: 'fa fa-question-circle',
                    animation: 'scale',
                    closeAnimation: 'scale',
                    opacity: 0.5,
                    buttons: {
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

        //show Route submit conformation alert
        $(function () {
            $(".route").click(function () {
                var element = $(this);
                var del_id = element.attr("data-id");
                console.log(del_id);
                $('#hub-store').val('' + del_id);
                $('#ex10').modal();
            });
        })

        //Submit Route Request for First mile 2022-03-21
        $('.submitForRoute').submit(function (event) {
            event.preventDefault();
            // get the form data
            var data = new FormData();
            data.append('hub_id', $('input[name=hub-store]').val());
            data.append('create_date', $('input[name=create_date]').val());
            $('#ex10').modal('toggle');
            // process the form
            $(".loader").show();
            $(".loader-background").show();
            //run ajax with data
            $.ajax({
                url: $('.submitForRoute').attr('action'),
                type: 'POST',
                contentType: false,
                processData: false,
                data: data,
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', "{{ csrf_token() }}");
                },
                //show success response
                success: function (data) {
                    // $('#ex20').toggle();
                    $(".loader").hide();
                    $(".loader-background").hide();
                    $('#ex20').modal('hide');
                    if (data.status_code == 200) {

                        $('.alert-message').html('<div class="alert alert-success alert-green"><button style="color:#f5f5f5"; type="button" class="close" data-dismiss="alert"><strong><b><i  class="fa fa-close"></i><b></strong></button><strong>' + data.success + '</strong>');
                    } else {
                        $('.alert-message').html('<div class="alert alert-danger alert-red"><button style="color:#f5f5f5"; type="button" class="close" data-dismiss="alert"><strong><b><i  class="fa fa-close"></i><b></strong></button><strong>' + data.error + '</strong>');
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
    </script>
@endsection