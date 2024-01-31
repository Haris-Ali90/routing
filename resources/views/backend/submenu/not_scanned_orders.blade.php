<?php  
$user = Auth::user();
if($user->email!="admin@gmail.com")
{

$data = explode(',', $user['rights']);
$dataPermission = explode(',', $user['permissions']);
}

else{
    $data = [];
    $dataPermission=[];
}
 ?>
@extends( 'backend.layouts.app' )

@section('title', 'Not Scanned Orders')

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
    <script src="{{ backend_asset('js/jquery-1.12.4.js') }}"></script>
    <script src="{{ backend_asset('js/jquery-ui.js') }}"></script>
    <script src="{{ backend_asset('js/jquery-ui.css')}}"></script>
@endsection

@section('inlineJS')
<script type="text/javascript">
   $( function() {
    $( "#datepicker" ).datepicker().attr('autocomplete','off');
  } );
  </script>
    <script type="text/javascript">
        <!-- Datatable -->
        $(document).ready(function () {

            $('#datatable').dataTable();
            $(".group1").colorbox({height:"50%",width:"50%"});

            $(document).on('click', '.status_change', function(e){
                var Uid = $(this).data('id');

                $.confirm({
                    title: 'A secure action',
                    content: 'Are you sure you want to change user status??',
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
                                    type: "GET",
                                    url: "<?php echo URL::to('/'); ?>/api/changeUserStatus/"+Uid,
                                    data: {},
                                    success: function(data)
                                    {
                                        if(data== '0' || data== 0 )
                                        {
                                            var DataToset = '<button type="button" class="btn btn-warning btn-xs status_change" data-toggle="modal" data-id="'+Uid+'" data-target=".bs-example-modal-sm">Blocked</button>';
                                            $('#CurerntStatusDiv'+Uid).html(DataToset);
                                        }
                                        else
                                        {
                                            var DataToset = '<button type="button" class="btn btn-success btn-xs status_change" data-toggle="modal" data-id="'+Uid+'" data-target=".bs-example-modal-sm">Active</button>'
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
                    content: 'Are you sure you want to delete user ??',
                    icon: 'fa fa-question-circle',
                    animation: 'scale',
                    closeAnimation: 'scale',
                    opacity: 0.5,
                    buttons: {
                        'confirm': {
                            text: 'Proceed',
                            btnClass: 'btn-info',
                            action: function () {
                                $form.submit();
                            }
                        },
                        cancel: function () {
                            //$.alert('you clicked on <strong>cancel</strong>');
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
                    <h3 style="margin-left: 43%;">Not Scanned Orders<small></small></h3>
                </div>
            </div>

            <div class="clearfix"></div>
            

            {{--@include('backend.layouts.modal')
            @include( 'backend.layouts.popups')--}}
            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Not Scanned Orders</small></h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_title">
                          <form method="get" action="order">
                                <label>Search By Date</label>
                                 <input type="text" id="datepicker" name="datepicker" required="">
                                 <button class="btn btn-primary" type="submit" style="margin-top: -3%,4%">Go</a> </button>
                           </form>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            @include( 'backend.layouts.notification_message' )


                            <table id="datatable" class="table table-striped table-bordered">
                    <thead stylesheet="color:black;">
                      <tr>
                          <th>JoeyCo Order #</th>
                          <th>Image</th>
                          <th>Joey</th>
                          <th>Customer Address</th>
                          <th>Time Open</th>
                          <th>Time close</th>
                          <th>Task Status</th>
                          <th>Merchant Order #</th>
                          <!-- <th>Action</th> -->
                      </tr>
                      </thead>
                      <tbody>
                    @foreach( $notscan_order as $record )
                      <tr>
                        <td>{{ $record->order_id }}</td>
                        <td><a class="group1" href="{{ URL::to('/') }}/public/images/profile_images/{{$record->image}}" ><img style="width:50px;height:50px" src="{{ URL::to('/') }}/public/images/profile_images/{{$record->image}}" /></a>
                        </td>
                        <td>{{ $record->joey }}</td>
                        <td>{{ $record->address }}</td>
                        <td>{{ $record->start_time }}</td>
                        <td>{{ $record->end_time }}</td>
                        <td>{{ $record->task_status }}</td>
                        <td>{{ $record->merchant_order_num }}</td>

                        <!-- <td><a href="{{backend_url('profile/montreal/'.$record->id)}}" class="btn btn-primary btn-xs" style="float: left;"><i class="fa fa-folder"></i></a> -->
                        </td>
                       
                      </tr>
                      </tbody>
                     @endforeach
  </table>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>
    <!-- /#page-wrapper -->

@endsection