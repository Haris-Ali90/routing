<?php
use App\Joey;
use App\Vehicle;
use App\SlotsPostalCode;
use App\Slots;
use App\Sprint;
?>
@extends( 'backend.layouts.app' )
@section('title', 'Mi Jobs')
@section('CSSLibraries')
    <link href="{{ backend_asset('libraries/datatables-plugins/dataTables.bootstrap.css') }}" rel="stylesheet">
    <link href="{{ backend_asset('libraries/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">
    <link href="{{ backend_asset('libraries/galleria/colorbox.css') }}" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"
          rel="stylesheet"/>
    <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet"/>
    <link href="{{ backend_asset('libraries/custom/index.css') }}" rel="stylesheet">
    <style>

        .select2-container {
            width: 100% !important;
            margin-bottom: 10px !important;
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
@endsection
@section('content')
    <meta type="hidden" name="csrf-token" content="{{ csrf_token() }}" />
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

                            <a href="{{ route('mi.job.create') }}">
                                <button style="margin-left:10px" class="btn sub-ad btn-primary"><i class="fa fa-plus"></i>
                                    Create Job
                                </button>
                            </a>
                            <div class="clearfix"></div>
                        </div>


                        <div class="x_content">

                            @include( 'backend.layouts.notification_message' )

                            <div class="table-responsive">
                                <table id="datatable-" class="table table-striped table-bordered">
                                    <thead stylesheet="color:black;">
                                    <tr>
                                        <th style="width: 11%;">ID</th>
                                        <th style="width: 11%;">Title</th>
                                        <th style="width: 11%;">Start Address</th>
                                        <th style="width: 11%;">Exeution Time</th>
                                        <th style="width: 11%;">Type</th>
                                        <th style="width: 20%;">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($miJobs) > 0)
                                        @foreach($miJobs as $key => $miJob)
                                            <tr>
                                                <td>{{ $miJob->id }}</td>
                                                <td>{{ $miJob->title }}</td>
                                                <td>{{ $miJob->start_address }}</td>
                                                <td>{{ $miJob->execution_time }}</td>
                                                <td>{{ strtoupper($miJob->type) }}</td>
                                                <td>
                                                    @if($miJob->type == 'micro_hub_mid_mile')
                                                        <button type="button" class="assign btn btn green-gradient btn-primary"
                                                                data-job-id='{{$miJob->id}}'>Assign</button>
                                                    @endif
                                                    <button type='button' class='route btn btn black-gradient actBtn'
                                                            data-job-id='{{$miJob->id}}'>Submit For route
                                                        <i class='fa fa-eye'></i>
                                                    </button>
                                                    <a href="{{ route('mi.job.detail', $miJob->id) }}">
                                                        <button type='button' class='btn btn black-gradient actBtn'>Detail
                                                            <i class='fa fa-eye'></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ route('mi.job.edit', $miJob->id) }}">
                                                        <button type='button' class='btn btn black-gradient actBtn'>Edit
                                                            <i class='fa fa-eye'></i>
                                                        </button>
                                                    </a>
                                                    <a href='{{ url('backend/mi_job/delete/'. $miJob->id) }}'
                                                       class='btn btn red-gradient actBtn' onclick="return confirm('Are you sure you want to delete this item?');">Delete Job</a>
{{--                                                    <a href='{{ url('backend/attach/zones/'. $miJob->id) }}'--}}
{{--                                                       class='btn btn orange-gradient actBtn'>Attach Zones</a>--}}
                                                </td>
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
    <div id="ex10" class="modal" style="display: none">
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> Submit For Job</h4>
                </div>
                <form action='../backend/mi_job/create/job' method='get' class='submitForRoute'>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="job_id" name="job_id" value="">
                    <input type="hidden" id="create_date" name="create_date" value=<?php echo date("Y-m-d") ?> >
                    <div class="form-group">
                        <p><b>Are you sure you want to Submit For Route ?</b></p>
                    </div>
                    <div class="form-group">
                       <div class="row">
                        <div class="col-lg-6 d-flex">
                        <button type="submit" class="btn sub-ad btn-primary  btn-xs">Yes</button>
                        <button type="button" class="btn sub-ad red-gradient btn-xs" data-dismiss="modal">No</button>
                        </div>
                       </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="ex-05" class="modal" role="dialog" aria-hidden="true">
        <div class="modal-body">
            <div class='modal-dialog'>
                <div class='modal-content' style="padding: 20px;">
                    <p><strong class="order-id green"></strong></p>
                    <form action='../' method="POST">
                        <div class="form-group">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <label style="float:left;width: 100% !important;">Please Select a Hub</label>
                        <select name="hub_id" id="hub_id" class="form-control chosen-select">
                            <?php
                                foreach ($hubs as $hub) {
                                    echo "<option value=" . $hub->id . ">".$hub->title."</option>";
                                }
                            ?>
                        </select>
                        </div>
                        <br>
                      <div class="row">
                        <div class="col-lg-3 d-flex">
                        <a type="submit" data-selected-row="false"  onclick="assign()" class=" btn sub-ad btn-primary transfer-model-btn">Assign</a>
                        <a class="btn sub-ad  c-close " data-dismiss="modal" aria-hidden="true">Close</a>
                        </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        // Datatable
        $(document).ready(function () {
            $('#hub_id').select2({
                dropdownParent: $("#ex-05"),
            });
            $('#datatable').DataTable({
                "lengthMenu": [25, 50, 100, 250, 500, 750, 1000]
            });
            $(".group1").colorbox({height: "50%", width: "50%"});
        });

        $(function () {
            $(".route").click(function () {
                var element = $(this);
                var job_id = element.attr("data-job-id");
                $('#job_id').val(job_id);
                $('#ex10').modal();
            });
        })

        //show Route submit conformation alert


        //Submit Route Request for First mile 2022-03-21
        $('.submitForRoute').submit(function (event) {
            event.preventDefault();
            // get the form data
            var data = new FormData();
            data.append('job_id', $('input[name=job_id]').val());
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
                        var parseData = JSON.parse(data);
                        $('.alert-message').html('<div class="alert alert-danger alert-red"><button style="color:#f5f5f5"; type="button" class="close" data-dismiss="alert"><strong><b><i  class="fa fa-close"></i><b></strong></button><strong>' + parseData.output + '</strong>');
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

        $(function () {
            $(".assign").click(function () {
                var element = $(this);
                var job_id = element.attr("data-job-id");
                $('#job_id').val(job_id);
                $('#ex-05').modal();
            });
        })

        // transfer route to joey ajax
        function assign() {
            let job_id = $('#job_id').val();
            let hub_id = $('#hub_id').val()

            if(hub_id  == 'undefined'){
                alert('please select the hub');
            }
            else{

                $.ajax({
                    type: "POST",
                    url: 'mi_job/assign',
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    data:{hub_id:hub_id, job_id:job_id},
                    success: function (data) {
                        alert(data);
                        location.reload();
                    },
                    error: function (error) {
                    }
                });
            }
        }

    </script>
@endsection