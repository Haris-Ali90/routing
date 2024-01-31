@extends( 'backend.layouts.app' )

@section('title', 'Add User')

@section('content')



        <!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Change Password</h3>
            </div>


            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">

                </div>
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
                        <h2>Sub Admin <small>Change Password</small></h2>


                    
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />

                    </div>

                    {!! Form::open( ['url' => ['backend/subadmin/change/password',$id], 'method' => 'POST', 'class' => 'form-horizontal form-label-left', 'role' => 'form']) !!}
                        <div class="form-group{{ $errors->has('old_pwd') ? ' has-error' : '' }}">
                        <input name="id" type="hidden" value={{$id}}>
                            {{ Form::label('old_pwd', 'Old Password', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) }}
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::text('old_pwd', null, ['class' => 'form-control col-md-7 col-xs-12','required' => 'required']) }}
                                
                            </div>
                            @if ( $errors->has('old_pwd') )
                                <p class="help-block">{{ $errors->first('old_pwd') }}</p>
                            @endif
                             </div>
                        <div class="form-group{{ $errors->has('new_pwd') ? ' has-error' : '' }}">
                            {{ Form::label('new_pwd', 'New Password', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) }}
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::text('new_pwd', null, ['class' => 'form-control col-md-7 col-xs-12','required' => 'required']) }}
                            </div>
                            @if ( $errors->has('new_pwd') )
                                <p class="help-block">{{ $errors->first('new_pwd') }}</p>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('confirm_pwd') ? ' has-error' : '' }}">
                            {{ Form::label('confirm_pwd', 'Confirm Password', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) }}
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::text('confirm_pwd', null, ['class' => 'form-control col-md-7 col-xs-12','required' => 'required']) }}
                            </div>
                            @if ( $errors->has('confirm_pwd') )
                                <p class="help-block">{{ $errors->first('confirm_pwd') }}</p>
                            @endif
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                {{ Form::submit('Save', ['class' => 'btn btn-primary']) }}
                                {{ Html::link( backend_url('dashboard'), 'Cancel', ['class' => 'btn btn-default']) }}
                            </div>
                        </div>

                        {!! Form::close() !!}
                </div>
            </div>
        </div>

    </div>
</div>
<!-- /page content -->



        <!-- /#page-wrapper -->


@endsection
