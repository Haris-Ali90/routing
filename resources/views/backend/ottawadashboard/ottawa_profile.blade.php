@extends( 'backend.layouts.app' )



@section('title', 'Ottawa Profile')

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
        $(document).ready(function () {
            $(".group1").colorbox({height: "75%"});
        });
    </script>

@endsection



@section('content')

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>{{$amazon_ottawa->joey}} Profile</h3>
                </div>


            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Ottawa Profile <small></small></h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                                <div class="profile_img">
                                    <div id="crop-avatar">

                                        <ul class="main-image" style="list-style: none;">
                                            <li class="col-md-12">
                                                <a class="group1">
                                                    <img class="img-responsive avatar-view" src="{{ URL::to('/') }}/public/images/profile_images/default.png" style="    margin-left: -46px;" class="avatar" alt="Avatar"/>
                                                </a>
                                            </li>
                                        </ul>

                                    </div>
                                </div>
                                <h3></h3>

                                {{--<ul class="list-unstyled user_data">
                                     <li><label>Full Name :</label> {{$amazon_ottawa['order_id'] or "N/A"}}</li>
                                     <li><label>Email Address : </label> {{$amazon_ottawa['route'] or "N/A"}}</li>
                                     <li><label>Phone / Mobile no :</label>{{$amazon_ottawa['joey'] or "N/A"}}</li>

                                </ul>--}}

                            </div>
                            <div class="col-md-9 col-sm-9 col-xs-12">

                                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Amazon Ottawa Detail</a>
                                        </li>
                                        <!-- <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Student Document</a>
                                        </li> -->
                                    </ul>
                                    <div id="myTabContent" class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                                            <!-- start user projects -->
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th colspan="2" >Ottawa Profile Detail</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td style="width: 30%;"><label>JoeyCo Order #</label></td>
                                                    <td>{{$amazon_ottawa->order_id or "N/A"}}</td>
                                                </tr>
                                                <tr>
                                                    <td><label>Amazon tracking #</label></td>
                                                    <td>{{$amazon_ottawa->tracking_id or "N/A"}}</td>
                                                </tr>
                                                <tr>
                                                    <td><lable>Route Number</lable></td>
                                                    <td>{{$amazon_ottawa->route  or "N/A"}}</td>
                                                </tr>
                                                <tr>
                                                    <td><label>Joey</label></td>
                                                    <td>{{$amazon_ottawa->joey or "N/A"}}</td>
                                                </tr>
                                                <tr>
                                                    <td><label>Customer Address</label></td>
                                                    <td>{{$amazon_ottawa->address or "N/A"}}</td>
                                                </tr>

                                                <tr>
                                                    <td><label>Scheduled Time</label></td>
                                                    <td>{{$amazon_ottawa->scheduled_duetime or "N/A"}}</td>
                                                </tr>                                        
                                                <tr>
                                                    <td><label>Actual Arrival @ CX</label></td>
                                                    <td>{{$amazon_ottawa->arrival_time or "N/A"}}</td>
                                                </tr>
                                                 <tr>
                                                    <td><label>Estimated Delivery ETA</label></td>
                                                    <td>{{$amazon_ottawa->departure_time or "N/A"}}</td>
                                                </tr>
                                                <tr>
                                                    <td><label>Pickup From Hub</label></td>
                                                    <td>{{$amazon_ottawa->picked_hub_time or "N/A"}}</td>
                                                </tr>
                                                <tr>
                                                    <td><label>Sorter Time</label></td>
                                                    <td>{{$amazon_ottawa->sorter_time or "N/A"}}</td>
                                                </tr>

                                                <tr>
                                                    <td><label>Time Open</label></td>
                                                    <td>{{$amazon_ottawa->start_time or "N/A"}}</td>
                                                </tr>
                                                <tr>
                                                    <td><label>Time close</label></td>
                                                    <td>{{$amazon_ottawa->end_time or "N/A"}}</td>
                                                </tr>
                                                <tr>
                                                    <td><label>Drop Off</label></td>
                                                    <td>{{$amazon_ottawa->dropoff_eta or "N/A"}}</td>
                                                </tr>
                                                <tr>
                                                    <td><label>Delivery Time</label></td>
                                                    <td>{{$amazon_ottawa->delivery_time or "N/A"}}</td>
                                                </tr>
                                                <tr>
                                                    <td><label>Signature</label></td>
                                                    <td>{{$amazon_ottawa->signature or "N/A"}}</td>
                                                </tr>
                                                <tr>
                                                    <td><label>Sprint #</label></td>
                                                    <td>{{$amazon_ottawa->sprint_id or "N/A"}}</td>
                                                </tr>
                                                <tr>
                                                    <td><label>Task Status</label></td>
                                                    <td>{{$amazon_ottawa->sprint_status or "N/A"}}</td>
                                                </tr>
                                                <tr>
                                                    <td><label>Merchant #</label></td>
                                                    <td>{{$amazon_ottawa->merchant_order_num or "N/A"}}</td>
                                                </tr>
                                                <tr>
                                                    <td><label>Image</label></td>
                                                    <td>{{$amazon_ottawa->image or "N/A"}}</td>
                                                </tr>
                                                <tr>
                                                    <td><label>Vender #</label></td>
                                                    <td>{{$amazon_ottawa->vendor_id or "N/A"}}</td>
                                                </tr>

                                                </tbody>
                                            </table>
                                            <!-- end user projects -->

                                        </div>

                                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

                                            <!-- start user projects -->
                                            <!--  -->
                                            <!-- end user projects -->

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-wrapper -->

@endsection