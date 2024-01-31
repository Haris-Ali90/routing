@extends( 'backend.layouts.app' )

@section('title', 'Sub Admin')

@section('CSSLibraries')
    <!-- DataTables CSS -->
    <link href="{{ backend_asset('libraries/datatables-plugins/dataTables.bootstrap.css') }}" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="{{ backend_asset('libraries/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">
    <!-- Image Viewer CSS -->
    <link href="{{ backend_asset('libraries/galleria/colorbox.css') }}" rel="stylesheet">
@endsection

@section('JSLibraries')
    <!-- DataTables JavaScript -->
    <script src="{{ backend_asset('libraries/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ backend_asset('libraries/datatables-plugins/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ backend_asset('libraries/datatables-responsive/dataTables.responsive.js') }}"></script>
    <script src="{{ backend_asset('libraries/galleria/jquery.colorbox.js') }}"></script>
@endsection

@section('inlineJS')
    <script type="text/javascript">
        <!-- Datatable -->
        $(document).ready(function () {

            $('#datatable').dataTable();
            $(".group1").colorbox({height:"50%",width:"50%"});

            $(document).on('click', '.status_change', function(e){
                var Uid = $(this).data('id');
console.log(Uid);
                $.confirm({
                    title: 'A secure action',
                    content: 'Are you sure you want to change sub admin statusd??',
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
                                    type: "get",
                                    url: "<?php echo URL::to('/'); ?>/backend/subadmin/changeUserStatus/"+Uid,
                                    data: {},
                                    success: function(data)
                                    {

                                        if(data == '0' || data== 0 )
                                        {
                                            var DataToset	=	'<button type="button" class="btn btn-warning btn-xs status_change" data-toggle="modal" data-id="'+Uid+'" data-target=".bs-example-modal-sm">Blocked</button>';
                                            $('#CurerntStatusDiv'+Uid).html(DataToset);
                                        }
                                        else
                                        {
                                            var DataToset	=	'<button type="button" class="btn btn-success btn-xs status_change" data-toggle="modal" data-id="'+Uid+'" data-target=".bs-example-modal-sm">Active</button>'
                                            $('#CurerntStatusDiv'+Uid).html(DataToset);
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

            $(document).on('click', '.form-delete', function(e){

                var $form = $(this);
                $.confirm({
                    title: 'A secure action',
                    content: 'Are you sure you want to delete sub admin ??',
                    icon: 'fa fa-question-circle',
                    animation: 'scale',
                    closeAnimation: 'scale',
                    opacity: 0.5,
                    buttons: {
                        'confirm': {
                            text: 'Proceed',
                            btnClass: 'btn-info btn-primary sub-ad',
                            action: function () {
                                $form.submit();
                            }
                        },
                        cancel: function () {
                            // btnClass: 'btn-info btn-primary sub-ad',
                        }
                    }
                });
            });

        });

    </script>
    <script>
        $(document).ready(function() {
            $('#birthday').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker_4"
            }, function(start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
        });
    </script>
@endsection

@section('content')


    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <!-- <h3>Sub Admin <small></small></h3> -->
                </div>
            </div>

            <div class="clearfix"></div>

            {{--@include('backend.layouts.modal')
            @include( 'backend.layouts.popups')--}}
            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Sub Admin list</h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            @include( 'backend.layouts.notification_message' )


                            <table id="datatable" class="table table-striped table-bordered" data-form="deleteForm">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <!-- <th>Image</th> -->
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Status</th>
                                    <th style="width: 20%">Action</th>
                                </tr>
                                </thead>


                                <tbody>
                                    
                                {{--*/ $i = 1 /*--}}
                                @foreach( $users as $record )
                                    <tr class="">

                                        <td>{{ $i }}</td>
                                        <!-- <td><a class="group1" href="{{ URL::to('/') }}/public/images/profile_images/{{$record->profile_picture}}" >
                                                <img style="width:50px;height:50px" src="{{ URL::to('/') }}/public/images/profile_images/{{$record->profile_picture}}" /></a>
                                        </td> -->
                                        <td>{{ rtrim($record->full_name)}}</td>
                                        <td>{{ $record->email }}</td>
                                        <td>{{ $record->phone }}</td>
                                        <td id="CurerntStatusDiv{{ $record->id }}">

                                            @if($record->status === 1)
                                                <a  class="btn btn-xs" type="button" data-toggle="modal"
                                                    data-target="#statusModal{{ $record->id }}">
                                                    <span class="label label-success">Active</span>
                                                </a>

                                                <div id="statusModal{{ $record->id }}" class="modal fade" role="dialog">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                                            aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title">Confirm Status?</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to change the status?</p>
                                                            </div>
                                                            <div class="modal-footer d-flex justify-content-end">
                                                                <button type="button" class="btn btn-default btn-flat pull-left sub-ad c-close" data-dismiss="modal">Close</button>
                                                                {!! Form::model($record, ['method' => 'get',  'url' => 'backend/sub-admin/inactive/'.$record->id, 'class' =>'form-inline form-edit']) !!}
                                                                {!! Form::hidden('id', $record->id) !!}
                                                                {!! Form::submit('Yes', ['class' => 'btn btn-primary btn-flat sub-ad']) !!}
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            @else
                                                <a  class="btn btn-xs" type="button" data-toggle="modal"
                                                    data-target="#statusModal{{ $record->id }}">
                                                    <span class="label label-danger">In Active</span>
                                                </a>
                                                <div id="statusModal{{ $record->id }}" class="modal fade" role="dialog">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                                            aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title">Confirm Status?</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to change the status?</p>
                                                            </div>
                                                            <div class="modal-footer d-flex justify-content-end">
                                                                <button type="button" class="btn btn-default btn-flat pull-left c-close sub-ad" data-dismiss="modal">Close</button>
                                                                {!! Form::model($record, ['method' => 'get',  'url' => 'backend/sub-admin/active/'.$record->id, 'class' =>'form-inline form-edit']) !!}
                                                                {!! Form::hidden('id', $record->id) !!}
                                                                {!! Form::submit('Yes', ['class' => 'btn btn-primary btn-flat sub-ad']) !!}
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            @endif
                                        </td>
                                        <td>

                                             <a href="{{ backend_url('sub/admin/profile/'.base64_encode($record->id)) }}" class="btn btn-primary sub-ad btn-xs" style="float: left;"><i class="fa fa-folder"></i> </a>
                                            <a href="{{ backend_url('subadmin/edit/'.base64_encode($record->id)) }}" class="btn btn-info btn-primary sub-ad btn-xs edit" style="float: left;"><i class="fa fa-pencil"></i>  </a>
                                          {{--  <a href="{{ backend_url('subadmin/change/password/'.base64_encode($record->id)) }}" class="btn btn-info btn-xs edit" style="float: left;"><i class="fa fa-key"></i>  </a>--}}
                                            {!! Form::model($record, ['method' => 'delete', 'url' => 'backend/subadmins/'.$record->id, 'class' =>'form-inline form-delete']) !!}
{!! Form::hidden('id', $record->id) !!}
{!! Form::button('<i class="fa fa-trash-o"></i> ', ['class' => 'btn sub-ad btn-danger btn-xs', 'name' => 'delete_modal','data-toggle' => 'modal']) !!}
{!! Form::close() !!}

                                        </td>
                                    </tr>
                                    {{--*/ $i++ /*--}}
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- /#page-wrapper -->

@endsection