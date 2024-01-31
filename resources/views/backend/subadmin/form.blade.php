@section('CSSLibraries')
        <!-- DataTables CSS -->
<link href="{{ backend_asset('libraries/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
@endsection
<div class="col-lg-6 responsive-width">
<div class="form-group{{ $errors->has('full_name') ? ' has-error' : '' }}">
        {{ Form::label('full_name', 'Full Name *', ['class'=>'  ']) }}
        <div class=" ">
                {{ Form::text('full_name', null, ['class' => 'form-control col-md-7 col-xs-12','required' => 'required']) }}
        </div>
        @if ( $errors->has('full_name') )
                <p class="help-block">{{ $errors->first('full_name') }}</p>
        @endif
</div>
</div>

<div class="col-lg-6 responsive-width">
<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        {{ Form::label('email', 'Email *', ['class'=>'  ']) }}
        <div class=" ">
                {{ Form::text('email', null, ['class' => 'form-control col-md-7 col-xs-12','required' => 'required']) }}
        </div>
        @if ( $errors->has('email') )
                <p class="help-block">{{ $errors->first('email') }}</p>
        @endif
</div>
</div>
<div class="col-lg-6 responsive-width">
<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
        {{ Form::label('phone', 'Mobile *', ['class'=>'  ']) }}
        <div class=" ">
                {{ Form::text('phone', null, ['class' => 'class="date-picker form-control col-md-7 col-xs-12" ','required' => 'required']) }}
        </div>
        @if ( $errors->has('phone') )
                <p class="help-block">{{ $errors->first('phone') }}</p>
        @endif
</div>
</div>
<div class="col-lg-6 responsive-width">
<div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
        {{ Form::label('address', 'Address (Optional)', ['class'=>'  ']) }}
        <div class=" ">
                {{ Form::text('address', null, ['class' => 'form-control col-md-7 col-xs-12']) }}
        </div>
        @if ( $errors->has('address') )
                <p class="help-block">{{ $errors->first('address') }}</p>
        @endif
</div>
</div>

<div class="col-lg-6 responsive-width">
<div class="form-group{{ $errors->has('rights') ? ' has-error' : '' }}">
        {{ Form::label('rights', 'Rights *', ['class'=>'  ']) }}
        <div class=" ">
                <!-- {{ Form::select('institute_id',  array('1' => 'Anees Hussain', '2' => 'Ahmedabad', '3' => 'Aligarh Institute'),null,['class' => 'form-control col-md-7 col-xs-12']) }} -->
                <select class="js-example-basic-multiple form-control col-md-7 col-xs-12" name="rights[]" required="" multiple="multiple">
                    <option value="subadmins"> Sub Admin</option>
                    <option value="hailify">Hailify</option>
                    <option value="sorted_section">Sorted Section</option>
                    <option value="manifest_file_creation">Manifest Creation File</option>
                    <option value="csv_file_uploader">Csv File Uploader</option>
                    <option value="assigning_postal_code">Assigning Postal Code</option>
                    <option value="montreal_routes"> Montreal Routes</option>
                    <option value="ottawa_routes"> Ottawa Routes</option>
                    <option value="ctc_routes"> Toronto Routes</option>
                    <option value="scarborough_routes"> Scarborough Routes</option>
                    <option value="flower_routes"> Flower Routes</option>
                    <option value="wm_routes"> WM Routes</option>
                    <option value="montreal_zones"> Montreal Zones</option>
                    <option value="ottawa_zones"> Ottawa Zones</option>
                    <option value="ctc_zones"> Toronto Zones</option>
                   <option value="zone_types">Zone Types</option>
                   <option value="amazon_failed_order">Montreal Amazon Failed Order</option>
                   <option value="amazon_failed_order_ottawa">Ottawa Amazon Failed Order</option>
                   <option value="ctc_failed_order">CTC Failed Order Toronto</option>
                   <option value="ctc_failed_order_ottawa">CTC Failed Order Ottawa</option>
                   <option value="borderless_failed_orders">Borderless Failed Order</option>
                   <option value="vancouver_failed_orders">Vancouver Failed Order</option>
                   <option value="reattempt_order">Reattempt Order</option>
                   <option value="montreal_big_box_routes">Montreal Big Box Routes</option>
                   <option value="ottawa_big_box_routes">Ottawa Big Box Routes</option>
                   <option value="ctc_big_box_routes">Toronto Big Box Routes</option>
                   <option value="manifest_routes_montreal">Montreal Manifest Routing</option>
                   <option value="manifest_routes_ottawa">Ottawa Manifest Routing</option>
                    <option value="route_volume_state">Route Volume State</option>
                    <option value="tracking_report">Tracking Report</option>
                    <option value="montreal_manifest_report">Montreal Manifest Report</option>
                    <option value="ottawa_manifest_report">Ottawa Manifest Report</option>
                    <option value="routing-engine.get">Route Engine</option>
                    <option value="hubs_stores">Hubs and Stores</option>
                    <option value="vancouver">Vancouver Routing</option>
                    <option value="ottawa_failed_orders">Ottawa Failed Order</option>
                    <option value="fulfilment">Fulfilment</option>
                    <option value="addressupdate">Address Update</option>
                    <option value="addressupdateapproval">Address Update Approval</option>
                    <option value="controlpermission">Controls</option>
                    <option value="wildfork">Wildfork Routing</option>
                    <option value="zone_list_actions">Zone List Actions</option>
                </select>
        </div>
        @if ( $errors->has('rights') )
                <p class="help-block">{{ $errors->first('rights') }}</p>
        @endif
</div>
</div>
<div class="col-lg-6 responsive-width">
<div class="form-group{{ $errors->has('permissions') ? ' has-error' : '' }}">
        {{ Form::label('permissions', 'Permissions *', ['class'=>'  ']) }}
        <div class=" ">
                <!-- {{ Form::select('institute_id',  array('1' => 'Anees Hussain', '2' => 'Ahmedabad', '3' => 'Aligarh Institute'),null,['class' => 'form-control col-md-7 col-xs-12']) }} -->
                <select class="js-example-basic-multiple form-control col-md-7 col-xs-12" name="permissions[]" required="" multiple="multiple">
                    
                    <option value="read"> View</option>
                    <option value="add"> Add</option>
                    <option value="edit"> Edit</option>
                    <option value="delete"> Delete </option>
                </select>
        </div>
        @if ( $errors->has('permissions') )
                <p class="help-block">{{ $errors->first('permissions') }}</p>
        @endif
</div>
</div>

<div class="col-lg-6 responsive-width">
<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        {{ Form::label('password', 'Password *', ['class'=>'  ']) }}
        <div class=" ">
                {{ Form::password('password', ['class' => 'form-control col-md-7 col-xs-12','required' => 'required']) }}
        </div>
        @if ( $errors->has('password') )
                <p class="help-block">{{ $errors->first('password') }}</p>
        @endif
</div>
</div>
<div class="col-lg-6 responsive-width">
<div class="form-group{{ $errors->has('confirmpwd') ? ' has-error' : '' }}">
        {{ Form::label('confirmpwd', 'Confirm Password *', ['class'=>'  ']) }}
        <div class=" ">
                {{ Form::password('confirmpwd', ['class' => 'form-control col-md-7 col-xs-12','required' => 'required']) }}
        </div>
        @if ( $errors->has('confirmpwd') )
                <p class="help-block">{{ $errors->first('confirmpwd') }}</p>
        @endif
</div>
</div>
<!-- <div class="form-group{{ $errors->has('profile_picture') ? ' has-error' : '' }}">
        {{ Form::label('profile_picture', 'Profile picture ', ['class'=>'  ']) }}
        <div class=" ">
                {{ Form::file('profile_picture', null, ['class' => 'form-control col-md-7 col-xs-12','required' => 'required']) }}
        </div>
        @if ( $errors->has('profile_picture') )
                <p class="help-block">{{ $errors->first('profile_picture') }}</p>
        @endif
</div> -->

<!-- <div class="ln_solid"></div> -->
<div class="row d-flex justify-content-end">
<div class="form-group">
        <div class="d-flex">
                {{ Form::submit('Save', ['class' => 'btn btn-primary sub-ad every-add-button']) }}
                {{ Html::link( backend_url('subadmins'), 'Cancel', ['class' => 'btn sub-ad btn-default every-cancel-button']) }}
        </div>
</div>
</div>


@section('JSLibraries')
        <!-- DataTables JavaScript -->
<script src="{{ backend_asset('libraries/moment/min/moment.min.js') }}"></script>
<script src="{{ backend_asset('libraries//bootstrap-daterangepicker/daterangepicker.js') }}"></script>
@endsection

@section('inlineJS')
        <script>
                $(document).ready(function() {
                        $('#birthday').daterangepicker({
                                locale: {
                                format: 'YYYY-MM-DD',
                                },
                                singleDatePicker: true,

                                calender_style: "picker_4"

                        }, function(start, end, label) {
                                console.log(start.toISOString(), end.toISOString(), label);
                        });
                });
        </script>
@endsection
