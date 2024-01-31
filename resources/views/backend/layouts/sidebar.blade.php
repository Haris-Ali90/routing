<?php
$user = Auth::user();

if($user->email!="admin@routing.joeyco.com")
{

$data = explode(',', $user['rights']);
$dataPermission = explode(',', $user['permissions']);
$fullname = $user->full_name;
}

else{
    $data = [];
    $dataPermission=[];
    $fullname = $user->full_name;
}


$approved_order_list = App\ReturnAndReattemptProcessHistory::where('verified_by', '!=' , null)
    ->whereNull('deleted_at')
    ->where('is_processed', 0)
    //->where('created_by', auth()->user()->id)
    ->count();

 ?>
<style>
    .badge {
        position: absolute;
        top: 5px;
        right: 40px;
        border-radius: 50%;
        background-color: red;
        color: white;
    }
</style>
<div class="col-md-3 left_col">
    <div class="left_col scroll-view">

        <div class="navbar nav_title" style="border: 0;">
            <div class="title-img-col">
                <a class="site_title" href="{{ backend_url('dashboard') }}">
                    <img class="dashboard-logo-icon" src="{{app_asset('images/logo-no-background.png')}} ">
                    <img class="dashboard-logo-text" src="{{app_asset('images/logo-no-background.png')}} ">
                </a>
            </div>

        </div>

        <!-- <div class="clear"</div> -->

        <!-- menu profile quick info -->
        <div class="profile">
            <!-- <div class="profile_pic">
                <img src="{{app_asset('/images/logo-no-background.png')}} " alt="..." class="img-circle profile_img">
            </div> -->
            <div class="profile_info">
                <!-- <span>Welcome,</span>
                <h2>{{$fullname}}</h2> -->
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <!-- <h3>General</h3> -->
                <ul class="nav side-menu">
                    <li> <a href="{{ backend_url('dashboard') }}"><i class="fa fa-tachometer"></i> Dashboard</a></li>

                    <?php
                    if(count($data)== 0 || (count($data)>0 &&in_array("subadmins", $data)))
                    {
                    ?>
                    <li>
                        <a><i class="fa fa-users"></i>Sub Admin<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li> <a href="{{ backend_url('subadmins') }}"> Sub Admins </a></li>
                            <?php } ?>
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("add", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('subadmin/add') }}"> Add Sub Admin</a></li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php }
                    if(count($data)== 0 || (count($data)>0 &&in_array("hailify", $data))){
                    ?>

                    <li>
                        <a><i class="fa fa-home"></i>Haillify<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{backend_url('haillify/booking/list')}}">Active Booking List</a></li>
                            <li><a href="{{backend_url('haillify/complete/booking/list')}}">Complete Booking List</a></li>
                        </ul>
                    </li>

                    <?php }
                    if(count($data)== 0 || (count($data)>0 &&in_array("manifest_file_creation", $data))){
                    ?>

                    <li>
                        <a><i class="fa fa-home"></i>Manifest Creation Files<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{backend_url('manifest/file/creation')}}">Manifest Creation Files </a></li>
                        </ul>
                    </li>

                    <?php }

                    if(count($data)== 0 || (count($data)>0 &&in_array("csv_file_uploader", $data))){
                    ?>

                    <li>
                        <a><i class="fa fa-home"></i>Csv File Upload<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{backend_url('csv/file/uploader')}}">Csv File Upload </a></li>
                        </ul>
                    </li>

                    <?php }

                    if(count($data)== 0 || (count($data)>0 &&in_array("sorted_section", $data))){
                    ?>

                    <li>
                        <a><i class="fa fa-home"></i>Sorted Orders<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{backend_url('manual/sorting/tracking')}}">Manual Sorted Orders</a></li>
                        </ul>
                    </li>

                    <?php }
                    if(count($data)== 0 || (count($data)>0 &&in_array("assigning_postal_code", $data))){
                    ?>

                    <li>
                        <a><i class="fa fa-home"></i>Assigning Postal Code<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{backend_url('fsa/assigning')}}">Assigning Postal Code</a></li>
                        </ul>
                    </li>

                    <?php }
                    if(count($data)== 0 || (count($data)>0 && in_array("montreal_routes", $data))){
                    ?>
                    <li>
                        <a><i class="fa fa-cubes"></i>Montreal Routing <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li> <a href="{{ backend_url('montreal/routes') }}"> Montreal Routes</a></li>
                            <?php } ?>
                        <!-- <?php
                            //  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                                <li><a data-toggle="modal" data-target="#ex1"> Create Montreal Routes</a></li>
<?php// } ?> -->
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('routific/16/job/') }}"> Montreal Jobs</a></li>
                            <?php } ?>
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('hub/16/route/assign') }}"> Assign To Sorter</a></li>
                            <?php } ?>
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('route/montreal/deleted') }}"> Montreal Deleted Routes</a></li>
                            <?php } ?>
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('custom/routing/16/hub') }}"> Montreal Custom Routing</a></li>
                            <?php }
                            if(count($data)== 0 || (count($data)>0 && in_array("montreal_big_box_routes", $data))){
                            ?>
                            <li> <a href="{{ backend_url('bigbox/custom/routing/16/hub') }}"> Montreal Big Box Custom Routing</a></li>
                            <li> <a href="{{ backend_url('bigbox/routific/16/job') }}"> Montreal Big Box Jobs</a></li>
                            <?php } if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('inbound/scanning/16/hub') }}"> Montreal Inbound Scanning</a></li>
                            <?php } ?>
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('incomplete/16/route') }}"> Montreal Unattempt Orders</a></li>
                            <?php } ?>

                        </ul>
                    </li>

                    <?php }

                    if(count($data)== 0 || (count($data)>0 && in_array("ottawa_routes", $data)))
                    {
                    ?>
                    <li>
                        <a><i class="fa fa-cubes"></i>Ottawa Routing <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li> <a href="{{ backend_url('ottawa/routes') }}"> Ottawa Routes</a></li>
                            <?php } ?>
                        <!-- <?php  //if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                                <li><a data-toggle="modal" data-target="#ex1"> Create Ottawa Routes</a></li>
<?php //} ?> -->
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('routific/19/job') }}"> Ottawa Jobs</a></li>
                            <?php } ?>
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('hub/19/route/assign') }}"> Assign To Sorter</a></li>
                            <?php } ?>
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('route/ottawa/deleted') }}"> Ottawa Deleted Routes</a></li>
                            <?php } ?>
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('custom/routing/19/hub') }}"> Ottawa Custom Routing</a></li>
                            <?php } ?>
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('inbound/scanning/19/hub') }}"> Ottawa Inbound Scanning</a></li>
                            <?php } ?>
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('incomplete/19/route') }}"> Ottawa Unattempt Orders</a></li>
                            <?php } ?>

                        </ul>
                    </li>

                    <?php }


                    if(count($data)== 0 || (count($data)>0 && in_array("ctc_routes", $data)))
                    {
                    ?>
                    <li>
                        <a><i class="fa fa-cubes"></i>Toronto Routing <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li> <a href="{{ backend_url('ctc/routes') }}"> Toronto Routes</a></li>
                            <?php } ?>
                        <!-- <?php  //if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                                <li><a data-toggle="modal" data-target="#ex1"> Create CTC Routes</a></li>
<?php// } ?> -->
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('routific/17/job') }}"> Toronto Jobs</a></li>
                            <?php } ?>
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('hub/17/route/assign') }}"> Assign To Sorter</a></li>
                            <?php } ?>
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('route/ctc/deleted') }}"> Toronto Deleted Routes</a></li>
                            <?php } ?>
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('custom/routing/17/hub') }}"> Toronto Custom Routing</a></li>
                            <?php } ?>
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('inbound/scanning/17/hub') }}"> Toronto Inbound Scanning</a></li>
                            <?php } ?>
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('incomplete/17/route') }}"> Toronto Unattempt Orders</a></li>
                            <?php } ?>

                        </ul>
                    </li>

                    <?php }

                    if(count($data)== 0 || (count($data)>0 && in_array("scarborough_routes", $data)))
                    {
                    ?>
                    <li>
                        <a><i class="fa fa-cubes"></i>Scarborough Routing <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li> <a href="{{ backend_url('scarborough/routes') }}"> Scarborough Routes List</a></li>
                            <?php } ?>
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('routific/157/job') }}"> Scarborough Jobs</a></li>
                            <?php } ?>
                            <li> <a href="{{ backend_url('zonestesting/list/157') }}"> Scarborough Zones List</a></li>
                            <li><a href="{{ backend_url('custom/routing/zones/list/157') }}"> Scarborough Custom Routes Zones</a></li>
                            <?php  //if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            {{--                            <li><a href="{{ backend_url('hub/157/route/assign') }}"> Assign To Sorter</a></li>--}}
                            <?php //} ?>
                            <?php  //if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            {{--                            <li><a href="{{ backend_url('route/scarborough/deleted') }}"> Scarborough Deleted Routes</a></li>--}}
                            <?php //} ?>
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('custom/routing/157/hub') }}"> Scarborough Custom Routing</a></li>
                            <?php } ?>
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('inbound/scanning/157/hub') }}"> Scarborough Inbound Scanning</a></li>
                            <?php } ?>
                            <li> <a href="{{ backend_url('bigbox/custom/routing/157/hub') }}"> Scarborough Big Box Custom Routing</a></li>
                            <li> <a href="{{ backend_url('bigbox/routific/157/job') }}"> Scarborough Big Box Jobs</a></li>
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('incomplete/157/route') }}"> Scarborough Unattempt Orders</a></li>
                            <?php }
                            if(count($data) == 0 || (count($dataPermission) > 0 && in_array("read", $dataPermission)) && in_array("scarborough_failed_orders", $data)){  ?>
                            <li> <a href="{{ backend_url('scarborough/failed/orders') }}"> Scarborough Failed Order</a></li>
                            <?php
                            }
                            ?>

                        </ul>
                    </li>
                    <?php
                    }


                    if(count($data)== 0 || (count($data)>0 && in_array("hubs_stores", $data)))
                    {
                    ?>
                    <li>
                        <a><i class="fa fa-home"></i>Hubs and Stores<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{backend_url('hub/list/zones')}}">Hub List</a></li>
                        </ul>
                    </li>
                    <?php
                    }
                    ?>

                    <li>
                        <a><i class="fa fa-home"></i>Mi Jobs<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{backend_url('mi_jobs')}}">Mi Jobs</a></li>
                            <li><a href="{{backend_url('mi_job/route/list')}}">Mi Jobs Routes List</a></li>
                        </ul>
                    </li>
                    <?php
                    // if(count($data) == 0 || (count($data) > 0 && (in_array("manifest_routes_montreal", $data) || in_array("montreal_manifest_report", $data) )))
                    // {
                    ?>

                <!-- <li>
                    <a><i class="fa fa-cubes"></i>Montreal Manifest <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu"> -->

                    <?php  //if(count($data) == 0 || (count($dataPermission) > 0 && in_array("read", $dataPermission)) && in_array("manifest_routes_montreal", $data) ){  ?>
                <!-- <li> <a href="{{ backend_url('manifest/16/routes') }}"> Montreal Manifest Routing</a></li> -->

                    <?php //} ?>
                    <?php  //if(count($data) == 0 || (count($dataPermission) > 0 && in_array("read", $dataPermission)) && in_array("montreal_manifest_report", $data)){  ?>
                <!-- <li> <a href="{{ backend_url('montreal-manifest-report') }}"> Montreal Manifest Report</a></li> -->

                    <?php // } ?>
                <!-- </ul> -->
                    <!-- </li> -->
                    <?php //}

                    // if(count($data) == 0 || (count($data) > 0 && (in_array("ottawa_manifest_report", $data) || in_array("manifest_routes_ottawa", $data) )))
                    // {
                    ?>

                <!-- <li>
                        <a><i class="fa fa-cubes"></i>Ottawa Manifest <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu"> -->

                    <?php // if(count($data) == 0 || (count($dataPermission) > 0 && in_array("read", $dataPermission)) && in_array("manifest_routes_ottawa", $data)){  ?>
                <!-- <li> <a href="{{ backend_url('manifest/19/routes') }}"> Ottawa Manifest Routing</a></li> -->
                    <?php //} ?>
                    <?php // if(count($data) == 0 || (count($dataPermission) > 0 && in_array("read", $dataPermission)) && in_array("ottawa_manifest_report", $data) ){  ?>
                <!-- <li> <a href="{{ backend_url('ottawa-manifest-report') }}"> Ottawa Manifest Report</a></li> -->
                    <?php// } ?>
                <!-- </ul>
                    </li> -->
                    <?php //}


                    if(count($data)== 0 || (count($data)>0 && in_array("montreal_big_box_routes", $data)))
                    {
                    ?>
                    <li>
                        <a><i class="fa fa-cubes"></i>Montreal Big Box Routing <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission)))
                            {  ?>
                            <li> <a href="{{ backend_url('bigbox/custom/routing/16/hub') }}"> Montreal Big Box Custom Routing</a></li>
                            <li> <a href="{{ backend_url('bigbox/routific/16/job') }}"> Montreal Big Box Jobs</a></li>
                            <?php } ?>
                        </ul>
                    </li>

                    <?php
                    }
                    // if(count($data)== 0 || (count($data)>0 && in_array("mid_mile", $data)))
                    // {
                    ?>
                <!-- <li>
                    <a><i class="fa fa-home"></i>Mid Mile<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                            <li><a href="{{backend_url('mid/mile/hub/list')}}">Mid Mile Hub List</a></li>
                            <li><a href="{{backend_url('mid/mile/jobs')}}">Mid Mile Jobs</a></li>
                            <li><a href="{{backend_url('mid/mile/routes/list')}}">Mid Mile Routes</a></li>
                    </ul>
                    </li> -->
                    <?php
                    // }
                    if(count($data)== 0 || (count($data)>0 && in_array("ottawa_big_box_routes", $data)))
                    {
                    ?>
                    <li>
                        <a><i class="fa fa-cubes"></i>Ottawa Big Box Routing <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission)))
                            {  ?>
                            <li> <a href="{{ backend_url('bigbox/custom/routing/19/hub') }}"> Ottawa Big Box Custom Routing</a></li>
                            <li> <a href="{{ backend_url('bigbox/routific/19/job') }}"> Ottawa Big Box Jobs</a></li>
                            <?php } ?>
                        </ul>
                    </li>

                    <?php
                    }
                    if(count($data)== 0 || (count($data)>0 && in_array("ctc_big_box_routes", $data)))
                    {
                    ?>
                    <li>
                        <a><i class="fa fa-cubes"></i>Toronto Big Box Routing <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission)))
                            {  ?>
                            <li> <a href="{{ backend_url('bigbox/custom/routing/17/hub') }}"> Toronto Big Box Custom Routing</a></li>
                            <li> <a href="{{ backend_url('bigbox/routific/17/job') }}"> Toronto Big Box Jobs</a></li>
                            <?php } ?>
                        </ul>
                    </li>

                    <?php
                    }




                    if(count($data)== 0 || (count($data)>0 && in_array("montreal_zones", $data)))
                    {
                    ?>
                    <li>
                        <a><i class="fa fa-calendar"></i>Montreal Zones <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li> <a href="{{ backend_url('zonestesting/list/16') }}"> Zones List</a></li>
                            <li><a href="{{ backend_url('custom/routing/zones/list/16') }}"> Montreal Custom Routes Zones</a></li>
                        <!-- <li> <a href="{{ backend_url('postal-codes/hub/16') }}"> Montreal Postal Codes</a></li> -->
                            <?php } ?>
                        </ul>
                    </li>

                    <?php }

                    if(count($data)== 0 || (count($data)>0 && in_array("ottawa_zones", $data)))
                    {
                    ?>
                    <li>
                        <a><i class="fa fa-calendar"></i>Ottawa Zones <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li> <a href="{{ backend_url('zonestesting/list/19') }}"> Zones List</a></li>
                            <li><a href="{{ backend_url('custom/routing/zones/list/19') }}"> Ottawa Custom Routes Zones</a></li>
                        <!-- <li> <a href="{{ backend_url('postal-codes/hub/19') }}"> Ottawa Postal Codes</a></li> -->
                            <?php } ?>
                        </ul>
                    </li>

                    <?php }

                    if(count($data)== 0 || (count($data)>0 && in_array("ctc_zones", $data)))
                    {
                    ?>
                    <li>
                        <a><i class="fa fa-calendar"></i>Toronto Zones <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li> <a href="{{ backend_url('zonestesting/list/17') }}"> Zones List</a></li>
                            <li><a href="{{ backend_url('custom/routing/zones/list/17') }}"> Toronto Custom Routes Zones</a></li>
                        <!-- <li> <a href="{{ backend_url('postal-codes/hub/17') }}"> CTC Postal Codes</a></li> -->
                            <?php } ?>
                        </ul>
                    </li>

                    <?php }



                    if(count($data)== 0 || (count($data)>0 && in_array("vancouver", $data)))
                    {
                    ?>
                    <li>
                        <a><i class="fa fa-calendar"></i>Vancouver Routing <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('vancouver/routes') }}"> Vancouver Routes List</a></li>
                            <li><a href="{{ backend_url('zonestesting/list/129') }}"> Vancouver Zones List</a></li>
                            <li><a href="{{ backend_url('custom/routing/zones/list/129') }}"> Vancouver Custom Routes Zones</a></li>
                            <li><a href="{{ backend_url('custom/routing/129/hub') }}"> Vancouver Custom Routing</a></li>
                            <li><a href="{{ backend_url('routific/129/job') }}"> Vancouver Jobs</a></li>
                            <li><a href="{{ backend_url('bigbox/custom/routing/129/hub') }}"> Vancouver Big Box Custom Routing</a></li>
                            <li><a href="{{ backend_url('bigbox/routific/129/job') }}"> Vancouver Big Box Jobs</a></li>
                            <li><a href="{{ backend_url('inbound/scanning/129/hub') }}"> Vancouver Inbound Scanning</a></li>
                            <?php } ?>
                        </ul>
                    </li>

                    <?php }

                    if(count($data)== 0 || (count($data)>0 && in_array("wildfork", $data)))
                    {
                    ?>
                    <li>
                        <a><i class="fa fa-calendar"></i>Wildfork Routing <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('wildfork/routes') }}"> Wildfork Routes List</a></li>
                            <li><a href="{{ backend_url('zonestesting/list/160') }}"> Wildfork Zones List</a></li>
                            <li><a href="{{ backend_url('routific/160/job') }}"> Wildfork Jobs</a></li>
                            <?php } ?>
                        </ul>
                    </li>

                    <?php }

                    // zone type
                    if(count($data)== 0 || (count($data)>0 && in_array("zone_types", $data) ))
                    {

                    ?>
                    <li>
                        <a><i class="fa fa-calendar"></i>Zone Types<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <?php
                            if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li> <a href="{{ backend_url('zonestypes') }}"> Zone Types List</a></li>
                            <?php } ?>
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("add", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('zonestypes/add') }}"> Add Zones Type</a></li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php }


                    if(count($data) == 0 || (count($data) > 0 && (in_array("amazon_failed_order", $data) || in_array("amazon_failed_order_ottawa", $data) || in_array("ctc_failed_order", $data) || in_array("ctc_failed_order_ottawa", $data) || in_array("borderless_failed_orders", $data) || in_array("vancouver_failed_orders", $data) )))
                    {
                    ?>

                    <li>
                        <a><i class="fa fa-times"></i>Failed Order<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <?php  if(count($data) == 0 || (count($dataPermission) > 0 && in_array("read", $dataPermission)) && in_array("amazon_failed_order", $data) ){  ?>
                            <li> <a href="{{ backend_url('amazon/failed/orders') }}">Montreal Amazon Failed Order</a></li>

                            <?php } ?>
                            <?php  if(count($data) == 0 || (count($dataPermission) > 0 && in_array("read", $dataPermission)) && in_array("amazon_failed_order_ottawa", $data) ){  ?>
                            <li> <a href="{{ backend_url('amazon/failed/orders/ottawa') }}"> Ottawa Amazon Failed Order</a></li>

                            <?php } ?>
                            <?php  if(count($data) == 0 || (count($dataPermission) > 0 && in_array("read", $dataPermission)) && in_array("ctc_failed_order", $data)){  ?>
                            <li> <a href="{{ backend_url('ctc/failed/orders') }}"> CTC Failed Order Toronto</a></li>

                            <?php } ?>
                            <?php  if(count($data) == 0 || (count($dataPermission) > 0 && in_array("read", $dataPermission)) && in_array("ctc_failed_order_ottawa", $data)){  ?>
                            <li> <a href="{{ backend_url('ctc/failed/orders/ottawa') }}"> CTC Failed Order Ottawa</a></li>

                            <?php } ?>
                            <?php  if(count($data) == 0 || (count($dataPermission) > 0 && in_array("read", $dataPermission)) && in_array("borderless_failed_orders", $data)){  ?>
                            <li> <a href="{{ backend_url('borderless/failed/orders') }}"> Toronto Failed Order</a></li>

                            <?php } ?>
                            <?php  if(count($data) == 0 || (count($dataPermission) > 0 && in_array("read", $dataPermission)) && in_array("vancouver_failed_orders", $data)){  ?>
                            <li> <a href="{{ backend_url('vancouver/failed/orders') }}"> Vancouver Failed Order</a></li>

                            <?php } ?>

                            <?php  if(count($data) == 0 || (count($dataPermission) > 0 && in_array("read", $dataPermission)) && in_array("ottawa_failed_orders", $data)){  ?>
                            <li> <a href="{{ backend_url('ottawa/failed/orders') }}"> Ottawa Failed Order</a></li>

                            <?php } ?>
                        </ul>
                    </li>
                    <?php }

                    if(count($data) == 0 || (count($data) > 0 && (in_array("route_volume_state", $data) || in_array("tracking_report", $data) )))
                    {
                    ?>

                    <li>
                        <a><i class="fa fa-file"></i>Reports<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <?php  if(count($data) == 0 || (count($dataPermission) > 0 && in_array("read", $dataPermission)) && in_array("route_volume_state", $data) ){  ?>
                            <li> <a href="{{ backend_url('route-volume-state') }}">Route Volume By Zone</a></li>

                            <?php } ?>
                            <?php  if(count($data) == 0 || (count($dataPermission) > 0 && in_array("read", $dataPermission)) && in_array("tracking_report", $data)
                            ){  ?>
                            <li> <a href="{{ backend_url('tracking-report') }}">Tracking Report</a></li>

                            <?php } ?>
                        </ul>
                    </li>
                    <?php }



                    if(count($data)== 0 || (count($data)>0 && in_array("reattempt_order", $data) ))
                    {
                    ?>
                    <li>
                        <a><i class="fa fa-exchange"></i>Return Portal <span class="badge">{{$approved_order_list}}</span><span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <?php  if(count($data) == 0 || (count($dataPermission) > 0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{backend_url('reattempt/order')}}">Reattempt Order List</a></li>
                            <?php } ?>
                            <?php  if(count($data) == 0 || (count($dataPermission) > 0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{backend_url('customer/support/approved')}}">Customer Approved  <span class="badge">{{$approved_order_list}}</span></a></li>
                            <?php } ?>
                            <?php  if(count($data) == 0 || (count($dataPermission) > 0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{backend_url('reattempt/history')}}">History</a></li>
                            <?php } ?>
                        </ul>
                    </li>

                    <?php }

                    if(count($data)== 0 || (count($data)>0 && in_array("fulfilment", $data) ))
                    {
                    ?>
                    <li>
                        <a><i class="fa fa-exchange"></i>Fulfilment<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <?php  if(count($data) == 0 || (count($dataPermission) > 0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{backend_url('fulfilment/list')}}">Fulfilment List</a></li>
                            <?php } ?>

                        </ul>
                    </li>

                    <?php }

                    if(count($data)== 0 || (count($data)>0 && in_array("addressupdate", $data) ))
                    {
                    ?>
                    <li>
                        <a><i class="fa fa-exchange"></i>Address Update<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <?php  if(count($data) == 0 || (count($dataPermission) > 0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{backend_url('updateaddress/trackingid/multiple')}}">Search Tracking ID</a></li>
                            <?php } ?>

                        </ul>
                    </li>
                    <?php
                    }
                    if(count($data)== 0 || (count($data)>0 && in_array("addressupdateapproval", $data) ))
                    {
                    ?>
                    <li>
                        <a><i class="fa fa-exchange"></i>Address Update Approval<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <?php  if(count($data) == 0 || (count($dataPermission) > 0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{backend_url('updateaddress/trackingid/multiple/approve')}}">Address Approval List</a></li>
                            <?php } ?>

                        </ul>
                    </li>
                    <?php
                    }
                    if(count($data)== 0 || (count($data)>0))
                    {
                    ?>
                    <li>
                        <a><i class="fa fa-cogs"></i>Other Actions <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                        <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                        <!-- <li> <a href="{{ backend_url('hub/routific/status') }}"> Update Status</a></li> -->
                            <?php } ?>
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li> <a href="{{ backend_url('update/multiple/trackingid') }}"> Update Order Status</a></li>
                            <?php } ?>
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                        <!-- <li><a href="{{ backend_url('searchorder/trackingid')}}"> Search Order</a></li> -->
                            <?php } ?>
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('search/trackingid/multiple')}}"> Search Orders</a></li>
                            <?php } ?>
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('manual/status')}}"> Manual Status History</a></li>
                            <?php } ?>
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('complain')}}"> Register Complain</a></li>
                            <?php } ?>
                            <?php
                            if($user->email=="ahmed@joeyco.com")
                            {
                            if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('routific/outfordelivery') }}"> Out For Delivery</a></li>
                        <?php }
                        } ?>
                        <!-- <?php  //if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                                <li><a href="{{ backend_url('route/delete') }}"> Delete Route</a></li>
                    <?php// } ?> -->
                        <!-- <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                                <li><a href="{{ backend_url('mark/incomplete') }}"> Remove Unavailable Orders</a></li>
                            <?php } ?> -->
                        <?php  if(count($data) == 0 || (count($dataPermission) > 0 && in_array("read", $dataPermission))){  ?>
                        <!-- <li><a href="{{ backend_url('enable/route') }}"> Enable For Routes</a></li> -->
                        <?php } ?>
                        <!-- <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission)) && in_array("routing-engine.get", $data) ){  ?>
                                <li><a href="{{ backend_url('routing/engine') }}"> Routing Engine</a></li>
                            <?php } ?> -->

                        </ul>
                    </li>

                    <?php }

                    if(count($data)== 0 || (count($data)>0 && in_array("controlpermission", $data) ))
                    {
                    ?>
                    <li>
                        <a><i class="fa fa-wrench"></i> Controls<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <?php   if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('route/trackingid/enable')}}"> Enable for Route</a></li>
                            <?php } ?>
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('move/route')}}"> Move Route</a></li>
                            <?php } ?>
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission))){  ?>
                            <li><a href="{{ backend_url('mark/incomplete') }}"> Remove Unavailable Orders</a></li>
                            <?php } ?>
                            <?php  if(count($data)== 0 || (count($dataPermission)>0 && in_array("read", $dataPermission)) && in_array("routing-engine.get", $data) ){  ?>
                            <li><a href="{{ backend_url('routing/engine') }}"> Routing Engine</a></li>
                            <?php }?>
                        </ul>
                    </li>
                    <?php

                    }
                    ?>






                </ul>
            </div>

        </div>
        <!-- /sidebar menu -->

    </div>
</div>

<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="{{$user->profile_picture}}" alt="">{{$fullname}}
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">

                        {{-- <li><a href="{{ backend_url('logout') }}"><i class="fa fa-sign-out pull-right"></i> Logout</a></li>--}}

                        <?php if(count($data) == 0) { ?>
                        <li><a href="{{ backend_url('adminedit/'.base64_encode(auth()->user()->id)) }}"><i class="fa fa-edit pull-right"></i>Edit Profile</a>
                        </li>
                        <?php } ?>
                        <li>
                            <a href="{{ backend_url('account/security/edit/'.base64_encode(auth()->user()->id)) }}"><i class="fa fa-lock pull-right"></i>Account Security
                            </a>
                        </li>

                        <li><a href="{{ backend_url('changepwd') }}"><i class="fa fa-key pull-right"></i>Change Password</a></li>
                        <li>
                            <a href="#" onclick="document.getElementById('logout-form').submit();"><i
                                        class="fa fa-sign-out pull-right"></i> Logout</a>
                            <form id="logout-form" action="{{ backend_url('logout') }}" method="POST">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>


            </ul>
        </nav>
    </div>
</div>
            <!-- /top navigation -->