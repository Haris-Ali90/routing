@section('CSSLibraries')
    <!-- DataTables CSS -->
    <link href="{{ backend_asset('libraries/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
@endsection
<div class="col-lg-6">
<div class="form-group{{ $errors->has('full_name') ? ' has-error' : '' }}">
    {{ Form::label('full_name', 'Full Name *', ['class'=>'']) }}
   
        {{ Form::text('full_name', null, ['class' => 'form-control  ','required' => 'required']) }}

    @if ( $errors->has('full_name') )
        <p class="help-block">{{ $errors->first('full_name') }}</p>
    @endif
</div>
</div>

<div class="col-lg-6">
<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    {{ Form::label('email', 'Email', ['class'=>'']) }}

        {{ Form::text('email', null, ['class' => 'form-control  ','required' => 'required']) }}
    
    @if ( $errors->has('email') )
        <p class="help-block">{{ $errors->first('email') }}</p>
    @endif
</div>
</div>
<div class="col-lg-6">
<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
    {{ Form::label('phone', 'Mobile', ['class'=>'']) }}
  
        {{ Form::text('phone', null, ['class' => 'class="date-picker form-control  " ','required' => 'required']) }}
 
    @if ( $errors->has('phone') )
        <p class="help-block">{{ $errors->first('phone') }}</p>
    @endif
</div>
</div>
<div class="col-lg-6">
<div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
    {{ Form::label('address', 'Address *', ['class'=>'']) }}

        {{ Form::text('address', null, ['class' => 'form-control  ']) }}

    @if ( $errors->has('address') )
        <p class="help-block">{{ $errors->first('address') }}</p>
    @endif
</div>
</div>
<div class="col-lg-6">
<div class="form-group{{ $errors->has('rights') ? ' has-error' : '' }}">
    {{ Form::label('rights', 'Rights ', ['class'=>'']) }}
  
        <select class="js-example-basic-multiple form-control  " name="rights[]" required="" multiple="multiple" style="line-height:28px !important">
            <option value="subadmins" {{(in_array('subadmins', $rights)) ? 'Selected' : ''}}> Sub Admin</option>
            <option value="montreal_routes" {{(in_array('montreal_routes', $rights)) ? 'Selected' : ''}}> Montreal Routes</option>
            <option value="ottawa_routes" {{(in_array('ottawa_routes', $rights)) ? 'Selected' : ''}}> Ottawa Routes</option>
            <option value="ctc_routes" {{(in_array('ctc_routes', $rights)) ? 'Selected' : ''}}> CTC Routes</option>
            <option value="wm_routes" {{(in_array('wm_routes', $rights)) ? 'Selected' : ''}}> WM Routes</option>
             <option value="reattempt_order" {{(in_array('reattempt_order', $rights)) ? 'Selected' : ''}}>Reattempt Order</option>
        </select>

    @if ( $errors->has('rights') )
        <p class="help-block">{{ $errors->first('rights') }}</p>
    @endif
</div>
</div>
<div class="col-lg-6">
<div class="form-group{{ $errors->has('permissions') ? ' has-error' : '' }}">
    {{ Form::label('permissions', 'Permissions ', ['class'=>'']) }}
  
    <!-- {{ Form::select('institute_id',  array('1' => 'Anees Hussain', '2' => 'Ahmedabad', '3' => 'Aligarh Institute'),null,['class' => 'form-control  ']) }} -->
        <select class="js-example-basic-multiple form-control  " name="permissions[]" required="" multiple="multiple" style="line-height:28px !important">

            <option value="read" {{(in_array('read', $permissions)) ? 'Selected' : ''}}> View</option>
            <option value="add" {{(in_array('add', $permissions)) ? 'Selected' : ''}}> Add</option>
            <option value="edit" {{(in_array('edit', $permissions)) ? 'Selected' : ''}}> Edit</option>
            <option value="delete" {{(in_array('delete', $permissions)) ? 'Selected' : ''}}> Delete </option>
        </select>

    @if ( $errors->has('permissions') )
        <p class="help-block">{{ $errors->first('permissions') }}</p>
    @endif
</div>
</div>
<!-- <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        {{ Form::label('password', 'Password', ['class'=>'']) }}
        <div class="col-md-6 col-sm-6 col-xs-12">
                {{ Form::password('password', ['class' => 'form-control  ']) }}
        </div>
        @if ( $errors->has('password') )
    <p class="help-block">{{ $errors->first('password') }}</p>
        @endif
        </div>
        <div class="form-group{{ $errors->has('confirmpwd') ? ' has-error' : '' }}">
        {{ Form::label('confirmpwd', 'Confirm Password', ['class'=>'']) }}
        <div class="col-md-6 col-sm-6 col-xs-12">
                {{ Form::password('confirmpwd', ['class' => 'form-control  ']) }}
        </div>
        @if ( $errors->has('confirmpwd') )
    <p class="help-block">{{ $errors->first('confirmpwd') }}</p>
        @endif
        </div> -->
<div class="col-lg-6">
<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
    {{ Form::label('password', 'Password', ['class'=>'']) }}

        {{ Form::password('password', ['class' => 'form-control  ']) }}

    @if ( $errors->has('password') )
        <p class="help-block">{{ $errors->first('password') }}</p>
    @endif
</div>
</div>
<div class="col-lg-6">
<div class="form-group{{ $errors->has('profile_picture') ? ' has-error' : '' }}">
    {{ Form::label('profile_picture', 'Profile picture', ['class'=>'']) }}

        {{ Form::file('profile_picture', null, ['class' => 'form-control  ','required' => 'required']) }}

    @if ( $errors->has('profile_picture') )
        <p class="help-block">{{ $errors->first('profile_picture') }}</p>
    @endif
</div>
</div>
<div class="col-lg-6">
<div class="form-group{{ $errors->has('avatar_view') ? ' has-error' : '' }}">

        <img class="img-responsive avatar-view" src="{{$user->profile_picture}}" style = "width:50px;height:50px;" class="avatar" alt="Avatar"/>


</div>
</div>

<div class="ln_solid"></div>
<div class="row d-flex justify-content-end">
<div class="d-flex">

{{ Form::submit('Save', ['class' => 'btn sub-ad btn-primary']) }}
{{ Html::link( backend_url('dashboard'), 'Cancel', ['class' => 'btn sub-ad c-close btn-default']) }}

</div>
</div>
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
