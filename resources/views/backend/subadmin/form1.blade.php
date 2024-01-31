@section('CSSLibraries')
<!-- DataTables CSS -->
<link href="{{ backend_asset('libraries/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
@endsection
<div class="col-lg-6 responsive-width">
        <div class="form-group{{ $errors->has('full_name') ? ' has-error' : '' }}">
                {{ Form::label('full_name', 'Full Name *', ['class'=>' ']) }}

                {{ Form::text('full_name', null, ['class' => 'form-control col-md-7 col-xs-12','required' =>
                'required']) }}

                @if ( $errors->has('full_name') )
                <p class="help-block">{{ $errors->first('full_name') }}</p>
                @endif
        </div>
</div>

<div class="col-lg-6 responsive-width">
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                {{ Form::label('email', 'Email *', ['class'=>' ']) }}

                {{ Form::text('email', null, ['class' => 'form-control col-md-7 col-xs-12','readonly']) }}

                @if ( $errors->has('email') )
                <p class="help-block">{{ $errors->first('email') }}</p>
                @endif
        </div>
</div>
<div class="col-lg-6 responsive-width">
        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                {{ Form::label('phone', 'Mobile *', ['class'=>' ']) }}

                {{ Form::text('phone', null, ['class' => 'class="date-picker form-control col-md-7 col-xs-12"
                ','required' => 'required']) }}

                @if ( $errors->has('phone') )
                <p class="help-block">{{ $errors->first('phone') }}</p>
                @endif
        </div>
</div>
<div class="col-lg-6 responsive-width">
        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                {{ Form::label('address', 'Address ', ['class'=>' ']) }}

                {{ Form::text('address', null, ['class' => 'form-control col-md-7 col-xs-12']) }}

                @if ( $errors->has('address') )
                <p class="help-block">{{ $errors->first('address') }}</p>
                @endif
        </div>
</div>
<div class="col-lg-6 responsive-width">
        <div class="form-group{{ $errors->has('rights') ? ' has-error' : '' }}">
                {{ Form::label('rights', 'Rights *', ['class'=>' ']) }}

                <select class="js-example-basic-multiple form-control col-md-7 col-xs-12" name="rights[]" required=""
                        multiple="multiple">
                        <option value="subadmins" {{(in_array('subadmins', $rights)) ? 'Selected' : '' }}> Sub Admin
                        </option>
                        <option value="hailify" {{(in_array('hailify', $rights)) ? 'Selected' : '' }}> Hailify</option>
                        <option value="sorted_section" {{(in_array('sorted_section', $rights)) ? 'Selected' : '' }}>
                                Sorted Section</option>
                        <option value="manifest_file_creation" {{(in_array('manifest_file_creation', $rights))
                                ? 'Selected' : '' }}>Manifest Creation File</option>
                        <option value="csv_file_uploader" {{(in_array('csv_file_uploader', $rights)) ? 'Selected' : ''
                                }}>Csv File Uploader</option>
                        <option value="assigning_postal_code" {{(in_array('assigning_postal_code', $rights))
                                ? 'Selected' : '' }}>Assigning Postal Code</option>
                        <option value="montreal_routes" {{(in_array('montreal_routes', $rights)) ? 'Selected' : '' }}>
                                Montreal Routes</option>
                        <option value="ottawa_routes" {{(in_array('ottawa_routes', $rights)) ? 'Selected' : '' }}>
                                Ottawa Routes</option>
                        <option value="ctc_routes" {{(in_array('ctc_routes', $rights)) ? 'Selected' : '' }}> Toronto
                                Routes</option>
                        <option value="scarborough_routes" {{(in_array('scarborough_routes', $rights)) ? 'Selected' : ''
                                }}> Scarborough Routes</option>
                        <option value="flower_routes" {{(in_array('flower_routes', $rights)) ? 'Selected' : '' }}>
                                Flower Routes</option>
                        <option value="wm_routes" {{(in_array('wm_routes', $rights)) ? 'Selected' : '' }}> WM Routes
                        </option>
                        <option value="montreal_zones" {{(in_array('montreal_zones', $rights)) ? 'Selected' : '' }}>
                                Montreal Zones</option>
                        <option value="ottawa_zones" {{(in_array('ottawa_zones', $rights)) ? 'Selected' : '' }}> Ottawa
                                Zones</option>
                        <option value="ctc_zones" {{(in_array('ctc_zones', $rights)) ? 'Selected' : '' }}> Toronto Zones
                        </option>
                        <option value="zone_types" {{(in_array('zone_types', $rights)) ? 'Selected' : '' }}>Zone Types
                        </option>
                        <option value="amazon_failed_order" {{(in_array('amazon_failed_order', $rights)) ? 'Selected'
                                : '' }}> Montreal Amazon Failed Order</option>
                        <option value="amazon_failed_order_ottawa" {{(in_array('amazon_failed_order_ottawa', $rights))
                                ? 'Selected' : '' }}> Ottawa Amazon Failed Order</option>
                        <option value="ctc_failed_order" {{(in_array('ctc_failed_order', $rights)) ? 'Selected' : '' }}>
                                CTC Failed Order Toronto</option>
                        <option value="ctc_failed_order_ottawa" {{(in_array('ctc_failed_order_ottawa', $rights))
                                ? 'Selected' : '' }}>CTC Failed Order Ottawa</option>
                        <option value="borderless_failed_orders" {{(in_array('borderless_failed_orders', $rights))
                                ? 'Selected' : '' }}>Toronto Failed Order</option>
                        <option value="vancouver_failed_orders" {{(in_array('vancouver_failed_orders', $rights))
                                ? 'Selected' : '' }}>Vancouver Failed Order</option>
                        <option value="reattempt_order" {{(in_array('reattempt_order', $rights)) ? 'Selected' : '' }}>
                                Reattempt Order</option>
                        <option value="montreal_big_box_routes" {{(in_array('montreal_big_box_routes', $rights))
                                ? 'Selected' : '' }}>Montreal Big Box Routes</option>
                        <option value="ottawa_big_box_routes" {{(in_array('ottawa_big_box_routes', $rights))
                                ? 'Selected' : '' }}>Ottawa Big Box Routes</option>
                        <option value="ctc_big_box_routes" {{(in_array('ctc_big_box_routes', $rights)) ? 'Selected' : ''
                                }}>Toronto Big Box Routes</option>
                        <option value="manifest_routes_montreal" {{(in_array('manifest_routes_montreal', $rights))
                                ? 'Selected' : '' }}>Montreal Manifest Routing</option>
                        <option value="manifest_routes_ottawa" {{(in_array('manifest_routes_ottawa', $rights))
                                ? 'Selected' : '' }}>Ottawa Manifest Routing</option>
                        <option value="route_volume_state" {{(in_array('route_volume_state', $rights)) ? 'Selected' : ''
                                }}>Route Volume State</option>
                        <option value="tracking_report" {{(in_array('tracking_report', $rights)) ? 'Selected' : '' }}>
                                Tracking Report</option>
                        <option value="montreal_manifest_report" {{(in_array('montreal_manifest_report', $rights))
                                ? 'Selected' : '' }}>Montreal Manifest Report</option>
                        <option value="ottawa_manifest_report" {{(in_array('ottawa_manifest_report', $rights))
                                ? 'Selected' : '' }}>Ottawa Manifest Report</option>
                        <option value="hub_management" {{(in_array('hub_management', $rights)) ? 'Selected' : '' }}>Hub
                                Management</option>
                        <option value="beta_custom_routing_ctc" {{(in_array('beta_custom_routing_ctc', $rights))
                                ? 'Selected' : '' }}>Beta Routific Custom Routing CTC</option>
                        <option value="beta_custom_routing_ottawa" {{(in_array('beta_custom_routing_ottawa', $rights))
                                ? 'Selected' : '' }}>Beta Routific Custom Routing Ottawa</option>
                        <option value="beta_custom_routing_montreal" {{(in_array('beta_custom_routing_montreal',
                                $rights)) ? 'Selected' : '' }}>Beta Routific Custom Routing Montreal</option>
                        <option value="beta_routific_job_ctc" {{(in_array('beta_routific_job_ctc', $rights))
                                ? 'Selected' : '' }}>Beta Routific Job CTC</option>
                        <option value="beta_routific_job_ottawa" {{(in_array('beta_routific_job_ottawa', $rights))
                                ? 'Selected' : '' }}>Beta Routific Job Ottawa</option>
                        <option value="beta_routific_job_montreal" {{(in_array('beta_routific_job_montreal', $rights))
                                ? 'Selected' : '' }}>Beta Routific Job Montreal</option>
                        <option value="routing-engine.get" {{(in_array('routing-engine.get', $rights)) ? 'Selected' : ''
                                }}>Route Engine</option>
                        <option value="hubs_stores" {{(in_array('hubs_stores', $rights)) ? 'Selected' : '' }}>Hubs and
                                Stores</option>
                        <option value="vancouver" {{(in_array('vancouver', $rights)) ? 'Selected' : '' }}>Vancouver
                                Routing</option>
                        <option value="ottawa_failed_orders" {{(in_array('ottawa_failed_orders', $rights)) ? 'Selected'
                                : '' }}>Ottawa Failed Order</option>
                        <option value="fulfilment" {{(in_array('fulfilment', $rights)) ? 'Selected' : '' }}>Fulfilment
                        </option>
                        <option value="addressupdate" {{(in_array('addressupdate', $rights)) ? 'Selected' : '' }}>
                                Address Update</option>
                        <option value="addressupdateapproval" {{(in_array('addressupdateapproval', $rights))
                                ? 'Selected' : '' }}>Address Update Approval</option>
                        <option value="controlpermission" {{(in_array('controlpermission', $rights)) ? 'Selected' : ''
                                }}>Controls</option>
                        <option value="wildfork" {{(in_array('wildfork', $rights)) ? 'Selected' : '' }}>Wildork Routing
                        </option>
                        <option value="zone_list_actions" {{(in_array('zone_list_actions', $rights)) ? 'Selected' : ''
                                }}>Zone List Actions</option>
                </select>

                @if ( $errors->has('rights') )
                <p class="help-block">{{ $errors->first('rights') }}</p>
                @endif
        </div>
</div>
<div class="col-lg-6 responsive-width">
        <div class="form-group{{ $errors->has('permissions') ? ' has-error' : '' }}">
                {{ Form::label('permissions', 'Permissions *', ['class'=>' ']) }}

                <!-- {{ Form::select('institute_id',  array('1' => 'Anees Hussain', '2' => 'Ahmedabad', '3' => 'Aligarh Institute'),null,['class' => 'form-control col-md-7 col-xs-12']) }} -->
                <select class="js-example-basic-multiple form-control col-md-7 col-xs-12" name="permissions[]"
                        required="" multiple="multiple">

                        <option value="read" {{(in_array('read', $permissions)) ? 'Selected' : '' }}> View</option>
                        <option value="add" {{(in_array('add', $permissions)) ? 'Selected' : '' }}> Add</option>
                        <option value="edit" {{(in_array('edit', $permissions)) ? 'Selected' : '' }}> Edit</option>
                        <option value="delete" {{(in_array('delete', $permissions)) ? 'Selected' : '' }}> Delete
                        </option>
                </select>

                @if ( $errors->has('permissions') )
                <p class="help-block">{{ $errors->first('permissions') }}</p>
                @endif
        </div>
</div>

<div class="col-lg-6 responsive-width">
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                {{ Form::label('password', 'Password', ['class'=>' ']) }}

                {{ Form::password('password', ['class' => 'form-control col-md-7 col-xs-12']) }}

                @if ( $errors->has('password') )
                <p class="help-block">{{ $errors->first('password') }}</p>
                @endif
        </div>
</div>
<div class="col-lg-6 responsive-width">
        <div class="form-group{{ $errors->has('profile_picture') ? ' has-error' : '' }}">
                {{ Form::label('profile_picture', 'Profile picture', ['class'=>' ']) }}

                {{ Form::file('profile_picture', null, ['class' => 'form-control col-md-7 col-xs-12','required' =>
                'required']) }}

                @if ( $errors->has('profile_picture') )
                <p class="help-block">{{ $errors->first('profile_picture') }}</p>
                @endif
        </div>
</div>
<div class="col-lg-6 responsive-width d-flex align-items-start">
        <div class="form-group{{ $errors->has('avatar_view') ? ' has-error' : '' }}">

                <img class="img-responsive avatar-view" src="{{$user->profile_picture}}"
                        style="width:50px;height:50px; margin-left: 51.5%;" class="avatar" alt="Avatar" />


        </div>
</div>

<div class="row d-flex justify-content-end">
        <div class=" d-flex">
                {{ Form::submit('Save', ['class' => 'btn sub-ad btn-primary']) }}
                {{ Html::link( backend_url('subadmins'), 'Cancel', ['class' => 'btn sub-ad btn-default']) }}
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