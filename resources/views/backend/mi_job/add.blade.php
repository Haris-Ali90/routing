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
<style>
    .addspace {
        margin-bottom: 8px;
        float: left;
    }

    #set_start_end_time {
        margin: 0;
        height: 32px;
        margin-top: 24px !important;
        background: #c6dd38;
        border: none;
        color: #3e3e3e;
        border-radius: 3px;
    }

    button.btn.btn-primary {
        background: #c6dd38;
        border: none;
        color: #3e3e3e;
    }

    .addspace label {
        float: left;
        width: 100%;
    }
    span.select2.select2-container.select2-container--default {
        width: 100% !important;
    }
    #set_start_end_time i.fa {
        font-size: 16px;
        color: #000;
        margin-right: 2px;
    }
</style>
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
{{--            @if ($message = Session::get('error'))--}}
{{--                <div class="alert alert-danger alert-red">--}}
{{--                    <button type="button" class="close" data-dismiss="alert">×</button>--}}
{{--                    <strong>{{ $message }}</strong>--}}
{{--                </div>--}}
{{--            @endif--}}
            <div class="page-title">
                <div class="title_left">
                    <!-- <h3>Mi Jobs</h3> -->
                </div>
            </div>
            <div class="clearfix"></div>
            @if (\Session::has('error'))
                <div class="alert alert-danger">
                    {!! \Session::get('error') !!}
                </div>
            @endif

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
                            <h2>Create Mi Job</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br/>
                        </div>
                        <form action="{{ route('mi.job.store') }}" method="post"
                              onkeydown="return event.key != 'Enter';">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-4 col-nd-4 addspace">
                                        <label>Title</label>
                                        <input type="text" name="title" id="title"
                                               class="form-control" required value="{{ old('title') }}">
                                    </div>
                                    <div class="col-lg-4 col-nd-4 addspace">
                                        <label>Type</label>
                                        <select class="form-control" style="width:100% !important" name="type" onchange="selectType()"
                                                id="type">
                                            <option value="joeyco_mid_mile" {{ (old('type') == 'joeyco_mid_mile') ? 'selected' : null }}>
                                                Alrafeeq Mid Mile
                                            </option>
                                            <option value="micro_hub_mid_mile" {{ (old('type') == 'micro_hub_mid_mile') ? 'selected' : null }}>
                                                Micro Hub Mid Mile
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-nd-4 addspace">
                                        <label>Execution Time</label>
                                        <input type="time" name="execution_time" id="execution_time"
                                               class="form-control" required value="{{ old('execution_time') }}">
                                    </div>
                                </div>



                                <div class="row">
                                    @if($errors->has('execution_time'))
                                        <div class="error">{{ $errors->first('execution_time') }}</div>
                                    @endif
                                    <div class="col-lg-4 col-nd-4 addspace">
                                        <label>Start Address </label>
                                        <input name="start_address" id="start_address" required
                                               value="{{ old('start_address') }}"
                                               class="form-control form-control-lg update-address-on-change google-address">
                                    </div>
                                    <div class="col-lg-4 col-nd-4 addspace" id="stores">
                                        <label>Stores </label>
                                        <select class="js-example-basic-multiple form-control datas" name="vendor_id[]"
                                                id="vendor_id" multiple="multiple">
                                            @foreach($stores as $store)
                                                <option value="{{ $store->id }}">
                                                    {{ $store->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-lg-4 col-nd-4 addspace">
                                        <label>Hubs </label>
                                        <select class="js-example-basic-multiple form-control datas" name="hub_id[]"
                                                id="hub_id" multiple="multiple">
                                            @foreach($hubs as $hub)
                                                <option value="{{ $hub->id }}">{{ $hub->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                          
                                <div class="row">
                                    <div id="multi-vendor-time"></div>
                                    <div id="multi-hub-time"></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-nd-4 addspace">
                                        <label>End DropOff</label>
                                        <select class="form-control" style="width:100% !important" name="end_hub_id" id="end_hub_id" required>
                                            @foreach($hubs as $hub)
                                                <option value="{{$hub->id}}">{{ $hub->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-nd-4 addspace">
                                        <label>Job Start Time</label>
                                        <input type="time" name="drop_start_time" id="drop_start_time"
                                               class="form-control">
                                    </div>
                                    <div class="col-lg-4 col-nd-4 addspace">
                                        <label>Job End Time</label>
                                        <input type="time" name="drop_end_time" id="drop_end_time"
                                               class="form-control">
                                    </div>
                                </div>
                                <input type="hidden" id="address2" name="street"/>
                                <input type="hidden" id="locality" name="city"/>
                                <input type="hidden" id="state" name="city_id"/>
                                <input type="hidden" id="postcode" name="postal_code"/>
                                <input type="hidden" id="country" name="country"/>
                                <input type="hidden" id="latitude" name="start_latitude"/>
                                <input type="hidden" id="longitude" name="start_longitude"/>

                              <div class="col-lg-6 d-flex     align-items-center;">
                              <button type="submit" class="btn btn-primary sub-ad" style="margin-top: 10px;margin-bottom: 0px !important;">Submit</button>
                              <button type="button" id="set_start_end_time" style="margin-top: 10px !important;" class="sub-ad btn-primary"><i
                                                    class="fa fa-clock-o"></i> Set
                                            Start End Time
                                        </button>
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

        function selectType() {
            var x = document.getElementById("type").value;
            if (x == 'micro_hub_mid_mile') {
                $("#multi-vendor-time").empty();
                document.getElementById('stores').style.display = "none";
            } else {
                document.getElementById('stores').style.display = "block";
            }
        }

        $('#set_start_end_time').click(function () {

            var x = document.getElementById("type").value;

            if (x == 'micro_hub_mid_mile') {
                var hub = $('#hub_id').val();
                $("#multi-hub-time").empty();
                for (var i = 0; i < hub.length; i++) {
                    $.ajax({
                        url: '../../backend/mi_job/get_hub_name',
                        type: 'POST',
                        data: { id: hub[i]},
                        beforeSend: function (request) {
                            return request.setRequestHeader('X-CSRF-Token', "{{ csrf_token() }}");
                        },
                        //show success response
                        success: function (data) {
                            var data = JSON.parse(data);
                            $("#multi-hub-time").append('<input type="hidden" id="start_type" name="start_type[]" readonly value="hub" class="form-control"><input type="hidden" id="ids" name="ids[]" readonly value="' + data.id + '" class="form-control"><div class="col-lg-4 col-md-4 addspace"><label>Hub Name </label><input id="hubname" readonly value="' + data.title + '" class="form-control"></div><div class="col-lg-4 col-md-4 addspace"><label>Hub Start Time </label><input type="time" name="start_time[]" id="start_time" class="form-control" required></div><div class="col-lg-4 col-md-4 addspace"><label>Hub End Time </label><input type="time" name="end_time[]" id="end_time" class="form-control"></div>')
                        },
                        failure: function (result) {
                            bootprompt.alert(result);
                        }
                    });
                }
            } else {
                var vendor = $('#vendor_id').val();
                var hub = $('#hub_id').val();

                $("#multi-vendor-time").empty();
                $("#multi-hub-time").empty();

                if(vendor != null){
                    for (var i = 0; i < vendor.length; i++) {
                        $.ajax({
                            url: '../../backend/mi_job/get_vendor_name',
                            type: 'POST',
                            data: { id: vendor[i]},
                            beforeSend: function (request) {
                                return request.setRequestHeader('X-CSRF-Token', "{{ csrf_token() }}");
                            },
                            //show success response
                            success: function (data) {
                                var data = JSON.parse(data);
                                $("#multi-vendor-time").append('<input type="hidden" id="start_type" name="start_type[]" readonly value="store" class="form-control"><input type="hidden" id="ids" name="ids[]" readonly value="' + data.id + '" class="form-control"><div class="col-lg-4 col-md-4 addspace addspace"><label>Vendor Name </label><input id="vendorname" readonly value="' + data.title + '" class="form-control"></div><div class="col-lg-4 col-md-4 addspace"><label>Vendor Start Time </label><input type="time" name="start_time[]" id="start_time" class="form-control"></div><div class="col-lg-4 col-md-4 addspace"><label>Vendor End Time </label><input type="time" name="end_time[]" id="end_time" class="form-control"></div>')
                            },
                            failure: function (result) {
                                bootprompt.alert(result);
                            }
                        });

                    }
                }
                if(hub != null){
                    for (var i = 0; i < hub.length; i++) {
                        $.ajax({
                            url: '../../backend/mi_job/get_hub_name',
                            type: 'POST',
                            data: { id: hub[i]},
                            beforeSend: function (request) {
                                return request.setRequestHeader('X-CSRF-Token', "{{ csrf_token() }}");
                            },
                            //show success response
                            success: function (data) {
                                var data = JSON.parse(data);
                                $("#multi-hub-time").append('<input type="hidden" id="start_type" name="start_type[]" readonly value="hub" class="form-control"><input type="hidden" id="ids" name="ids[]" readonly value="' + data.id + '" class="form-control"><div class="col-lg-4 col-md-4 addspace"><label>Hub Name </label><input id="hubname" readonly value="' + data.title + '" class="form-control"></div><div class="col-lg-4 col-md-4 addspace"><label>Hub Start Time </label><input type="time" name="start_time[]" id="start_time" class="form-control"></div><div class="col-lg-4 col-md-4 addspace"><label>Hub End Time </label><input type="time" name="end_time[]" id="end_time" class="form-control"></div>')
                            },
                            failure: function (result) {
                                bootprompt.alert(result);
                            }
                        });
                    }
                }
            }
        });

        // $('#hub_time_add').click(function() {
        //
        //     $("#multi-hub-time").empty();
        //     for (var i=0; i < hub.length; i++) {
        //         $("#multi-hub-time").append('<div class="col-lg-4 col-md-4 addspace"><label>Hub Id </label><input id="vendorname" readonly value="'+hub[i]+'" class="form-control"></div><div class="col-lg-4 col-md-4"><label>Hub Start Time </label><input type="time" name="start_time[]" id="start_time" class="form-control"></div><div class="col-lg-4 col-md-4"><label>Hub End Time </label><input type="time" name="end_time[]" id="end_time" class="form-control"></div>')
        //     }
        // });


        // get vendor by hub id for one kilometer
        // $(document).ready(function () {
        //     $('#ex10').modal();
        //     var hubId = document.getElementById("hub_id").value;
        //     $.ajax({
        //         type: "GET",
        //         url: '../hub/zone/vendor/'+hubId,
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
        //                 option.text = val.vendor_name + ' | ' + '('+val.vendor_id+')';
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
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?libraries=places&sensor=false&key=AIzaSyDTK4viphUKcrJBSuoidDqRhVA4AWnHOo0"></script>
    <script type="text/javascript">
        google.maps.event.addDomListener(window, 'load', function () {
            var places = new google.maps.places.Autocomplete(document.getElementById('start_address'));
            google.maps.event.addListener(places, 'place_changed', function () {
                var place = places.getPlace();
                var address = place.formatted_address;
                var latitude = place.geometry.location.lat();
                var longitude = place.geometry.location.lng();
                var latlng = new google.maps.LatLng(latitude, longitude);
                var geocoder = geocoder = new google.maps.Geocoder();
                geocoder.geocode({'latLng': latlng}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            var address = results[0].formatted_address;
                            var pin = results[0].address_components[results[0].address_components.length - 1].long_name;
                            var country = results[0].address_components[results[0].address_components.length - 2].long_name;
                            var state = results[0].address_components[results[0].address_components.length - 3].long_name;
                            var city = results[0].address_components[results[0].address_components.length - 4].long_name;

                            console.log(latitude)
                            console.log(longitude)
                            console.log(address)
                            console.log(pin)
                            console.log(country)
                            console.log(state)
                            console.log(city)

                            document.getElementById('address2').value = address;
                            document.getElementById('country').value = country;
                            document.getElementById('locality').value = city;
                            document.getElementById('state').value = state;
                            document.getElementById('postcode').value = pin;
                            document.getElementById('latitude').value = latitude;
                            document.getElementById('longitude').value = longitude;

                        }
                    }
                });
            });


        });
    </script>




@endsection
