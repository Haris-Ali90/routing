@section('CSSLibraries')
        <!-- DataTables CSS -->
<link href="{{ backend_asset('libraries/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
@endsection

<div class="row">
    
<div class="col-lg-6">
<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
        {{ Form::label('title', 'Title *', ['class'=>' ']) }}
        <div class="col-md-6 col-sm-6 col-xs-12">
                {{ Form::text('title', null, ['class' => 'form-control col-md-7 col-xs-12']) }}
        </div>
        @if ( $errors->has('title') )
                <p class="help-block">{{ $errors->first('title') }}</p>
        @endif
</div>
</div>
<div class="col-lg-6">
<div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
    {{ Form::label('amount', 'Amount *', ['class'=>' ']) }}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {{ Form::text('amount', null, ['class' => 'form-control col-md-7 col-xs-12']) }}
    </div>
    @if ( $errors->has('amount') )
        <p class="help-block">{{ $errors->first('amount') }}</p>
    @endif
</div>

</div>
</div>

{{--
<div class="form-group{{ $errors->has('rights') ? ' has-error' : '' }}">
        {{ Form::label('rights', 'Rights *', ['class'=>' ']) }}
        <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="js-example-basic-multiple form-control col-md-7 col-xs-12" name="rights[]" required="" multiple="multiple">
                    <option value="subadmins" {{(in_array('subadmins', $rights)) ? 'Selected' : ''}}> Sub Admin</option>
                <option value="montreal_routes" {{(in_array('montreal_routes', $rights)) ? 'Selected' : ''}}> Montreal Routes</option>
                    <option value="ottawa_routes" {{(in_array('ottawa_routes', $rights)) ? 'Selected' : ''}}> Ottawa Routes</option>
                    <option value="ctc_routes" {{(in_array('ctc_routes', $rights)) ? 'Selected' : ''}}> CTC Routes</option>
                    <option value="wm_routes" {{(in_array('wm_routes', $rights)) ? 'Selected' : ''}}> WM Routes</option>
                    <option value="montreal_zones" {{(in_array('montreal_zones', $rights)) ? 'Selected' : ''}}> Montreal Zones</option>
                    <option value="ottawa_zones" {{(in_array('ottawa_zones', $rights)) ? 'Selected' : ''}}> Ottawa Zones</option>
                    <option value="ctc_zones" {{(in_array('ctc_zones', $rights)) ? 'Selected' : ''}}> CTC Zones</option>
                </select>
        </div>
        @if ( $errors->has('rights') )
                <p class="help-block">{{ $errors->first('rights') }}</p>
        @endif
</div>
<div class="form-group{{ $errors->has('permissions') ? ' has-error' : '' }}">
        {{ Form::label('permissions', 'Permissions *', ['class'=>' ']) }}
        <div class="col-md-6 col-sm-6 col-xs-12">
                <!-- {{ Form::select('institute_id',  array('1' => 'Anees Hussain', '2' => 'Ahmedabad', '3' => 'Aligarh Institute'),null,['class' => 'form-control col-md-7 col-xs-12']) }} -->
                <select class="js-example-basic-multiple form-control col-md-7 col-xs-12" name="permissions[]" required="" multiple="multiple">
                    
                    <option value="read" {{(in_array('read', $permissions)) ? 'Selected' : ''}}> View</option>
                    <option value="add" {{(in_array('add', $permissions)) ? 'Selected' : ''}}> Add</option>
                    <option value="edit" {{(in_array('edit', $permissions)) ? 'Selected' : ''}}> Edit</option>
                    <option value="delete" {{(in_array('delete', $permissions)) ? 'Selected' : ''}}> Delete </option>
                </select>
        </div>
        @if ( $errors->has('permissions') )
                <p class="help-block">{{ $errors->first('permissions') }}</p>
        @endif
</div>
--}}



<div class="ln_solid"></div>
<div class="d-flex justify-content-end">
    
        {{ Form::submit('Save', ['class' => 'btn sub-ad btn-primary']) }}
        {{ Html::link( backend_url('zonestypes'), 'Cancel', ['class' => 'btn sub-ad btn-default']) }}
 
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
                singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                },
                calender_style: "picker_4"
            }, function(start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
        });
    </script>
@endsection
