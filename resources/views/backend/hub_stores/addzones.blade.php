@extends( 'backend.layouts.app' )

@section('title', 'Add Hub Stores')
@section('CSSLibraries')
    <!-- DataTables CSS -->
    <link href="{{ backend_asset('libraries/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
@endsection

@section('JSLibraries')
    <!-- DataTables JavaScript -->
    <script src="{{ backend_asset('libraries/moment/min/moment.min.js') }}"></script>
    <script src="{{ backend_asset('libraries//bootstrap-daterangepicker/daterangepicker.js') }}"></script>
@endsection

@section('inlineJS')
    <script>
        $(document).ready(function () {
            $('#birthday').daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                },

                calender_style: "picker_4"
            }, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
        });
    </script>
@endsection

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <!-- <h3>Zones</h3> -->
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">

                    <div class="x_panel">
                        @if ( $errors->count() )
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                There was an error while saving your form, please review below.
                            </div>
                        @endif

                        @include( 'backend.layouts.notification_message' )

                        <div class="x_title">
                            <h2>Attach Zones</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br/>
                        </div>
                        <form action="{{ route('attach.zones.update') }}" method="post">
                            {{ csrf_field() }}
                            <div class="row d-flex align-items-center">
                            <div class="col-lg-3">
                            <div class="form-group">
                                <label>Stores </label>
                                <input type="hidden" name="hub_id" id="hub_id" class="form-control" value="{{ $id }}">
                                <select class="js-example-basic-multiple form-control" name="zone_id[]"
                                        id="zone_id" style="width: 65%;min-height: 33px !important;"
                                        multiple="multiple" required>
                                    <option value="">Selected</option>
                                    @foreach($zones as $zone)
                                        <option value="{{ $zone->id }}" {{ ($hubs->zone->pluck('id')->contains($zone->id)) ? 'selected' : null }}>{{$zone->title}}</option>
                                    @endforeach
                                </select>
                               
                            </div>
                            </div>
                            <div class="col-lg-6">
                            <button type="submit" class="btn btn-primary sub-ad" style="margin:15px 0px 0px 0px !important">Add</button>
                            </div>
                            </div>
                          
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- /page content -->
    {{--  loader image  2022-04-01--}}
    <div id="wait" style="display:none;position:fixed;top:50%;left:50%;padding:2px;">
        <img src="{{app_asset('images/loading.gif')}} " width="104" height="64"/>
    </div>
    {{--Searching Model 2022-04-01--}}
    <div id="ex10" class="modal" style="display: none">
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class="modal-header">
                    <h4 class="modal-title">Getting stores near by hub</h4>
                </div>
                <div class="modal-body form-group">
                    <p><b>Searching .......</b></p>
                </div>
            </div>
        </div>
    </div>

    <!-- /#page-wrapper -->
    <script>
        {{--  loader script  --}}
        $(document).ready(function () {
            $(document).ajaxStart(function () {
                $("#wait").css("display", "block");
            });
            $(document).ajaxComplete(function () {
                $("#wait").css("display", "none");
            });
            $("button").click(function () {
                $("#txt").load("demo_ajax_load.asp");
            });
        });

        // get vendor by hub id for one kilometer
        // $(document).ready(function () {
        //     $('#ex10').modal();
        //     var hubId = document.getElementById("hub_id").value;
        //     $.ajax({
        //         type: "GET",
        //         url: '../hub/zone/vendor/' + hubId,
        //         beforeSend: function () {
        //             // Show image container
        //             $("#wait").show();
        //         },
        //         success: function (data) {
        //             console.log(data)
        //             data.forEach(function (val, index) {
        //                 // console.log(index, val.vendor_id);
        //                 var select = document.getElementById("vendor_id");
        //                 var option = document.createElement("option");
        //                 option.text = val.vendor_name + ' | ' + val.distance + ' | ' + '(' + val.vendor_id + ')';
        //                 option.value = val.vendor_id;
        //                 select.appendChild(option);
        //             });
        //             $('#ex10').modal('hide');
        //             // console.log(data)
        //         },
        //         complete: function (data) {
        //             // Hide image container
        //             $("#wait").hide();
        //         }
        //     });
        // })

    </script>




@endsection
