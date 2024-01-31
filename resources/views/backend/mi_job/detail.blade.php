<?php
use App\Joey;
use App\Vehicle;
use App\SlotsPostalCode;
use App\Slots;
use App\Sprint;
?>
@extends( 'backend.layouts.app' )
@section('title', 'Mi Jobs Details')
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


{{--            <div class="clearfix"></div>--}}
{{--                @if (\Session::has('success'))--}}
{{--                    <div class="alert alert-danger">--}}
{{--                        <ul>--}}
{{--                            <li>{!! \Session::get('success') !!}</li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                @endif--}}
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
                            <form method="get" action="">
                             <div class="row d-flex baseline">
                             <div class="col-lg-3">
                             <div class="form-group">
                             <label>Search By Date</label>
                                <input type="date" name="date" id="date" required="" placeholder="Search" class="form-control"
                                       value="<?php echo $date ?>">
                             </div>
                              </div>
                                <button class="btn btn-primary sub-ad" type="submit" style="margin-top: -3%,4%">
                                    Go</a> </button>
                             </div>
                            </form>

                            <div class="clearfix"></div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-4 text-center mt-4 mb-4"><span>{{ $mi_job->title }}</span></div>
                            <div class="col-md-4 text-center">{{ $mi_job->start_address }}</div>
                            <div class="col-md-4 text-center">{{ $mi_job->execution_time }}</div>
                        </div>

                        <div class="x_content">

                            @include( 'backend.layouts.notification_message' )

                            <div class="table-responsive">
                                <table id="datatable-" class="table table-striped table-bordered">
                                    <thead stylesheet="color:black;">
                                    <tr>
                                        <th style="width: 11%;">ID</th>
                                        <th style="width: 11%;">Title</th>
                                        <th style="width: 11%;">Location</th>
                                        <th style="width: 11%;">Start Address</th>
                                        <th style="width: 11%;">Exeution Time</th>
                                        <th style="width: 11%;">Location Type</th>
                                        <th style="width: 11%;">Type</th>
                                        <th style="width: 11%;">Start Time</th>
                                        <th style="width: 11%;">End Time</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($miJobDetail) > 0)
                                        @foreach($miJobDetail as $key => $detail)
                                            @php
                                               $vendor = \App\Vendor::find($detail->locationid);
                                                $hub = \App\Hub::find($detail->locationid);
                                            @endphp
                                            <tr>
                                                <td>{{ $detail->id }}</td>
                                                <td>{{ $mi_job->title }}</td>
                                                <td>{{ ($vendor) ? $vendor->first_name.' '. $vendor->last_name : $hub->title }}</td>
                                                <td>{{ $mi_job->start_address }}</td>
                                                <td>{{ $mi_job->execution_time }}</td>
                                                <td>{{ $detail->location_type }}</td>
                                                <td>{{ $detail->type }}</td>
                                                <td>{{ $detail->start_time }}</td>
                                                <td>{{ $detail->end_time }}</td>

                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>No Record Found</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--  Submit For Route For Routific VRP  --}}


    <script type="text/javascript">
        // Datatable
        $(document).ready(function () {
            $('#datatable').DataTable({
                "lengthMenu": [25, 50, 100, 250, 500, 750, 1000]
            });
            $(".group1").colorbox({height: "50%", width: "50%"});



        {{--    $(document).on('click', '.form-delete', function (e) {--}}

        {{--        var $form = $(this);--}}
        {{--        $.confirm({--}}
        {{--            title: 'A secure action',--}}
        {{--            content: 'Are you sure you want to delete user ??',--}}
        {{--            icon: 'fa fa-question-circle',--}}
        {{--            animation: 'scale',--}}
        {{--            closeAnimation: 'scale',--}}
        {{--            opacity: 0.5,--}}
        {{--            buttons: {--}}
        {{--                'confirm': {--}}
        {{--                    text: 'Proceed',--}}
        {{--                    btnClass: 'btn-info',--}}
        {{--                    action: function () {--}}
        {{--                        $form.submit();--}}
        {{--                    }--}}
        {{--                },--}}
        {{--                cancel: function () {--}}
        {{--                    //$.alert('you clicked on <strong>cancel</strong>');--}}
        {{--                }--}}
        {{--            }--}}
        {{--        });--}}
        {{--    });--}}

        });


    </script>
@endsection