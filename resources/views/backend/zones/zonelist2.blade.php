<?php
use App\Joey;
use App\Vehicle;
use App\SlotsPostalCode;
use App\Slots;
use App\Sprint;
use Illuminate\Support\Facades\Auth;

?>
@extends( 'backend.layouts.app' )

@section('title', 'Zones')

@section('CSSLibraries')
    <!-- DataTables CSS -->
    <link href="{{ backend_asset('libraries/datatables-plugins/dataTables.bootstrap.css') }}" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="{{ backend_asset('libraries/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">
    <!-- Image Viewer CSS -->
    <link href="{{ backend_asset('libraries/galleria/colorbox.css') }}" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css" rel="stylesheet"/>
    <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet"/>
    <style>
        .alert.alert-success.alert-block {
            display: inline-block;
            width: 100%;
            background: #3e3e3e;
            opacity: 0.4;
            border-color: #3e3e3e;
            padding: 25px 15px;
        }
        .green-gradient, .green-gradient:hover {
            /*color: #fff;*/
            color: #3e3e3e;
            background: #bad709;
            background: -moz-linear-gradient(top, #bad709 0%, #afca09 100%);
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#bad709), color-stop(100%,#afca09));
            background: -webkit-linear-gradient(top, #bad709 0%,#afca09 100%);
            background: linear-gradient(to bottom, #bad709 0%,#afca09 100%);
        }
        .black-gradient,
        .black-gradient:hover {
            color: #fff;
            background: #535353;
            background: -moz-linear-gradient(top,  #535353 0%, #353535 100%);
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#535353), color-stop(100%,#353535));
            background: -webkit-linear-gradient(top,  #535353 0%,#353535 100%);
            background: linear-gradient(to bottom,  #535353 0%,#353535 100%);
        }

        .red-gradient,
        .red-gradient:hover {
            color: #fff;
            background: #da4927;
            background: -moz-linear-gradient(top,  #da4927 0%, #c94323 100%);
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#da4927), color-stop(100%,#c94323));
            background: -webkit-linear-gradient(top,  #da4927 0%,#c94323 100%);
            background: linear-gradient(to bottom,  #da4927 0%,#c94323 100%);
        }

        .orange-gradient,
        .orange-gradient:hover {
            color: #fff;
            background: #f6762c;
            background: -moz-linear-gradient(top,  #f6762c 0%, #d66626 100%);
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f6762c), color-stop(100%,#d66626));
            background: -webkit-linear-gradient(top,  #f6762c 0%,#d66626 100%);
            background: linear-gradient(to bottom,  #f6762c     0%,#d66626 100%);
        }

        .btn{
            font-size : 12px;
        }


        .modal-header .close
        {
            opacity: 1;
            margin: 5px 0;
            padding: 0;
        }
        .modal-footer .close
        {
            opacity: 1;
            margin: 5px 0;
            padding: 0;
        }
        .modal-header h4 {
            color: #000;
        }
        .modal-footer {
            padding: 0 10px;
            text-align: right;
            border-top: 1px solid #e5e5e5;
        }
        .modal-header {
            border-radius: 6px;
            padding: 5px 15px;
            border-bottom: 1px solid #e5e5e5;
            background: #c6dd38;
        }

        .form-group {
            width: 100%;
            margin: 10px 0;
            padding: 0 15px;
        }
        .form-group input, .form-group select {
            width: 65% !important;
            height: 30px;
        }
        .form-group label {
            width: 25%;
            float: left;
            clear: both;
        }

        .lineEdit {
            width: 100%;
            float: left;
            margin: 5px 0;
        }
        .addInputs {
            width: 75%;
            float: left;
        }
        .lineEdit input {
            width: 80% !important;
            float: left;
        }
        button.remScntedit {
            height: 30px;
            margin: 0 5px;
        }
        button.remScnt {
            height: 30px;
            margin-top: 2px;
        }
        .addMoresec {
            text-align: right;
            padding: 0 50px;
        }


        /*.active, .accordion:hover {
          background-color: #ccc;
        }*/
        #ex3 .form-group p {
            width: 75%;
            background: #f5f5f5;
            float: right;
            padding-left: 7px;
        }
        #ex3 .form-group label {
            float: none;
        }



        /*.accordion:after {
          content: '\002B';
          color: #777;
          font-weight: bold;
          float: right;*/
        /*margin-left: 5px;
      }

      .active:after {
        content: "\2212";
      }*/

        .panell {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.2s ease-out;
        }
        button.btn.green-gradient.btn-xs.accordion {
            height: 17px;
            line-height: 0;
            margin: 0;
        }
        td li {
            width: 80%;
            float: left;
            list-style: none;
        }

        td ol
        {
            padding: 0;
        }

        .alert.alert {
            margin-top: 50px;
        }
        .form-control {

            font-size: 13px;

            color: #555;

        }

        .error-div{
            padding: 8px;
        }
        .error-div-inner-start-time{
            margin: -13px;
        }
        .error-div-inner-end-time{
            margin: -9px;
        }
        .error-div-inner-joey-count{
            margin: -19px;
        }
        .loader {
            position: relative;
            right: 0%;
            top: 0%;
            justify-content: center;
            text-align: center;
            /* text-align: center; */
            border: 18px solid #e36d28;
            border-radius: 50%;
            border-top: 16px solid #34495e;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 4s linear infinite;
            animation: spin 2s linear infinite;
            margin: 0 auto;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .loader-iner-warp {
            position: relative;
            width: 100%;
            text-align: center;
            top: 40%;
        }

        /*added by Muhammad Raqib @date 5/10/2022*/
        @media (max-width: 990px) { {
            width: 100% !important;
        }
        }

        @media (min-width: 760px) {
            #ex20 #aaa {
                margin: 2px 36% !important;
            }
        }

        @media (max-width: 768px) {
            #ex20 #aaa {
                margin: 2px 36% !important;
            }

            .table-responsive {
                width: 100%;
                margin-bottom: 15px;
                overflow-y: auto;
                -ms-overflow-style: -ms-autohiding-scrollbar;
                border: 1px;
                border-top-color: initial;
                border-top-style: initial;
                border-top-width: 1px;
                border-right-color: initial;
                border-right-style: initial;
                border-right-width: 1px;
                border-bottom-color: initial;
                border-bottom-style: initial;
                border-bottom-width: 1px;
                border-left-color: initial;
                border-left-style: initial;
                border-left-width: 1px;
                border-image-source: initial;
                border-image-slice: initial;
                border-image-width: initial;
                border-image-outset: initial;
                border-image-repeat: initial;}

            .width-btn {
                width: 100% !important;
            }

            .table-width {
                width: 32% !important;
            }
            #ex2089 .modal-dialog {
                position: relative;
                width: auto;
                margin: 20px auto!important;

            }
        }

        @media (max-width: 400px) {
            #ex20 #aaa {
                margin: 2px 28% !important;
            }

            .width-btn {
                width: 100% !important;
            }

            .table-width {
                width: 36% !important;
            }
            #ex2089 .modal-dialog {
                position: relative;
                width: auto;
                margin: 20px auto!important;

            }

        }
        /*end*/

    </style>
@endsection

@section('JSLibraries')
    <!-- DataTables JavaScript -->
    <script src="{{ backend_asset('libraries/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ backend_asset('libraries/datatables-plugins/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ backend_asset('libraries/datatables-responsive/dataTables.responsive.js') }}"></script>
    <script src="{{ backend_asset('libraries/galleria/jquery.colorbox.js') }}"></script>


    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="{{ backend_asset('js/jquery-ui.js') }}"></script>
    <link href="{{ backend_asset('js/jquery-ui.css') }}" rel="stylesheet"> -->

@endsection

@section('inlineJS')

@endsection

@section('content')

    <?php
        $user = Auth::user();
        if($user->email!="admin@routing.joeyco.com")
        {
            $rights = explode(',', $user['rights']);
            $dataPermission = explode(',', $user['permissions']);
            $fullname = $user->full_name;
        }
        else{
            $rights = [];
            $dataPermission=[];
            $fullname = $user->full_name;
        }
    ?>
    <div class="right_col" role="main">
        <div class="alert-message"></div>
        <div class="">


            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif

            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-green">
                    <button style="color:#f5f5f5"; type="button" class="close" data-dismiss="alert"><strong><b><i  class="fa fa-close"></i><b></strong></button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-red">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            @if ($message = Session::get('warning'))
                <div class="alert alert-warning alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            @if ($message = Session::get('info'))
                <div class="alert alert-info alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    Please check the form below for errors
                </div>
            @endif
            <div class="page-title">
                <div class="title_left amazon-text">

                    <?php
                    if ($id ==16)
                    {
                        $zonetitle = "Montreal";
                    }
                    elseif ($id ==17) {
                        $zonetitle = "Toronto";
                    }
                    elseif ($id ==19) {
                        $zonetitle = "Ottawa";
                    }
                    else{
                        $zonetitle = "";
                    }
                    ?>

                  
                </div>
            </div>

            <div class="clearfix"></div>

            {{--@include('backend.layouts.modal')
            @include( 'backend.layouts.popups')--}}



            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title reder"> 
                             <div class="col-lg-6">
                        <h2> <?php echo $zonetitle?> Zones<small></small></h2>
                        </div>
                        <button  data-id='{{$id}}'class='btn sub-ad btn-primary otalOrderCount' >Orders Count</button></div>
                        <div class="x_title">

                            <?php

                            if(!isset($_REQUEST['date'])){
                                $date = date('Y-m-d');
                            }
                            else{
                                $date = $_REQUEST['date'];
                            }

                            ?>
                            <form method="get" action="">
                               <div class="row d-flex baseline">
                               <div class="col-lg-3">
                               <div class="form-group">
                               <label>Search By Date</label>
                                <input type="date" name="date" id="date" required="" class="form-control" placeholder="Search" value="<?php echo $date ?>">
                               </div>
                               </div>
                               <div class="col-lg-6">
                               <button class="btn sub-ad btn-primary" type="submit" style="margin-top: -3%,4%">Go</a> </button>
                               </div>
                               </div>
                            </form>
                                <?php
                                    if(count($rights) == 0 || (count($rights) > 0 && in_array("zone_list_actions", $rights))) { ?>
                                        <button " class="btn green-gradient sub-ad" data-toggle="modal" data-target="#ex1"> <i class="fa fa-plus"></i> Create Zone</button>
                                <?php
                                    }
                                ?>

                            <div class="clearfix"></div>
                        </div>


                        <div class="x_content">

                            @include( 'backend.layouts.notification_message' )

                            <div class="table-responsive">
                                <table id="datatable-" class="table table-striped table-bordered">
                                    <thead stylesheet="color:black;">
                                    <tr>
                                        <th>ID</th>
                                        <th style="width: 10%;">Zone ID </th>
                                        <th>Zone Title</th>
                                        <th style="width: 11%;">Zone Type</th>
                                        <th>Microhub</th>
                                        <!--  <th>Hub ID</th>
                                         <th>Address</th> -->
                                        <th style="width: 11%;">Postal Codes</th>
                                        {{--      <th>Order Count</th>
                                              <th>Not In Route</th>
                                              <th>Total Joeys Count</th>
                                              <th>Slots Detail</th>   --}}
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i=1;
                                    $hub='';
                                    foreach($data as $zones)
                                    {

                                        echo "<tr>";
                                        echo "<td>".$i."</td>";
                                        echo "<td>".$zones->id."</td>";
                                        echo "<td style='width: 400px;'>".$zones->title."</td>";


                                        if(!empty($zones->zoneType)){
                                            echo "<td style='width: 400px'>".$zones->zoneType->title."</td>";
                                        }
                                        else {
                                            echo "<td></td>";
                                        }
                                        if(!empty($zones->hub)){
                                            echo "<td style='width: 400px'>".$zones->hub->pluck('title')->implode(',')."</td>";
                                        }
                                        else {
                                            echo "<td></td>";
                                        }
                                        // echo "<td>".$zones->hub_id."</td>";
                                        //echo "<td>".$zones->address."</td>";
                                        echo "<td style='width: 20%'>";

                                        $SlotsPostalCode = SlotsPostalCode::where('slots_postal_code.zone_id' ,'=', $zones->id)->WhereNull('slots_postal_code.deleted_at')->get();
                                        if(count($SlotsPostalCode)>1)
                                        {
                                            echo "<ol><button class='btn green-gradient  btn-xs accordion'><i class='fa fa-angle-down'></i></button>";
                                        }
                                        $j = 1;



                                        foreach ($SlotsPostalCode as $postalCode)
                                        {

                                            if($j==1)
                                            {
                                                echo "<li class='pCode'>$j :".$postalCode->postal_code."</li>
                                          ";
                                            }
                                            else
                                            {
                                                echo "<li class='panell' >$j :".$postalCode->postal_code."</li>";
                                            }


                                            $j++;

                                        }
                                        echo "</ol>";
                                        echo"</td>";

                                        /*   $SlotsPostalCode = SlotsPostalCode::where('zone_id' ,'=', $zones->id)->WhereNull('slots_postal_code.deleted_at')->first([\DB::raw('group_concat(postal_code) as postals')]);
                                           $postals = "'".str_replace(',',"','",$SlotsPostalCode->postals)."'";

                                           // $date=date('Y-m-d');
                                           $created_at = date("Y-m-d",strtotime('-1 day',strtotime($date)));

                                           if ($zones->hub_id == 16)
                                           {
                                               $vendor= "477260";
                                               $condition = " AND CONVERT_TZ(sprint__sprints.created_at,'UTC','America/Toronto') LIKE '".$created_at."%'";
                                               $statusCond = "sprint__sprints.status_id IN(13,61)";

                                               $ordercountQury = "SELECT
                                               COUNT(*) AS counts,
                                               SUM(CASE WHEN (in_hub_route IS NULL) AND (".$statusCond.")  THEN 1 ELSE 0 END) AS d_counts
                                               FROM sprint__sprints
                                               join sprint__tasks ON(sprint_id=sprint__sprints.id  AND type='dropoff')
                                               join merchantids on(task_id=sprint__tasks.id and tracking_id IS NOT NULL and tracking_id!='')
                                               join locations on(location_id=locations.id)
                                               WHERE creator_id IN(".$vendor.")
                                               AND SUBSTRING(locations.postal_code,1,3) IN (".$postals.")
                                               AND sprint__sprints.`deleted_at` IS NULL".$condition;

                                                      // dd($ordercountQury);

                                               $ordercount = DB::select($ordercountQury);
                                               $orders = $ordercount[0]->counts;
                                               $d_orders = $ordercount[0]->d_counts;
                                           }

                                           if ($zones->hub_id == 19)
                                           {


                                               $ordercountQury1 = "SELECT
                                               COUNT(*) AS counts,
                                               SUM(CASE WHEN (in_hub_route IS NULL) AND (sprint__sprints.status_id IN(13,61))  THEN 1 ELSE 0 END) AS d_counts
                                               FROM sprint__sprints
                                               join sprint__tasks ON(sprint_id=sprint__sprints.id  AND type='dropoff')
                                               join merchantids on(task_id=sprint__tasks.id and tracking_id IS NOT NULL and tracking_id!='')
                                               join locations on(location_id=locations.id)
                                               WHERE creator_id IN(477282)
                                               AND SUBSTRING(locations.postal_code,1,3) IN (".$postals.")
                                               AND sprint__sprints.`deleted_at` IS NULL
                                               AND CONVERT_TZ(sprint__sprints.created_at,'UTC','America/Toronto') LIKE '".$created_at."%'";



                                               $amazonordercount = DB::select($ordercountQury1);


                                               $ordercountQury2 = "SELECT
                                               COUNT(*) AS counts,
                                               SUM(CASE WHEN in_hub_route IS NULL  THEN 1 ELSE 0 END) AS d_counts
                                               FROM sprint__sprints
                                               join sprint__tasks ON(sprint_id=sprint__sprints.id  AND type='dropoff')
                                               join merchantids on(task_id=sprint__tasks.id and tracking_id IS NOT NULL and tracking_id!='')
                                               join locations on(location_id=locations.id)
                                               WHERE creator_id IN(477340,477341,477342,477343,477344,477345,477346)
                                               AND SUBSTRING(locations.postal_code,1,3) IN (".$postals.")
                                               AND sprint__sprints.`deleted_at` IS NULL
                                               AND sprint__sprints.status_id IN(13,124)";


                                               $ctcordercount = DB::select($ordercountQury2);
                                               $orders = $amazonordercount[0]->counts + $ctcordercount[0]->counts;
                                               $d_orders  = $amazonordercount[0]->d_counts + $ctcordercount[0]->d_counts;

                                           }

                                           if ($zones->hub_id == 17)
                                           {
                                               $vendor = "477255,477254,477283,477284,477286,477287,477288,477289,477307,477308,477309,477310,477311,477312,477313,477314,477292,477294,477315,477317,477316,477295,477302,477303,477304,477305,477306,477296,477290,477297,477298,477299,477300,477320,477301,477318,477328,476294,477334,477335,477336,477337,477338,477339";

                                               $ordercountQury = "SELECT
                                               COUNT(*) AS counts,
                                               SUM(CASE WHEN in_hub_route IS NULL THEN 1 ELSE 0 END) AS d_counts
                                               FROM sprint__sprints
                                               join sprint__tasks ON(sprint_id=sprint__sprints.id  AND type='dropoff')
                                               join merchantids on(task_id=sprint__tasks.id and tracking_id IS NOT NULL and tracking_id!='')
                                               join locations on(location_id=locations.id)
                                               WHERE creator_id IN(".$vendor.")
                                               AND SUBSTRING(locations.postal_code,1,3) IN (".$postals.")
                                               AND sprint__sprints.`deleted_at` IS NULL
                                               AND sprint__sprints.status_id IN(13,124)";

                                               $ordercount = DB::select($ordercountQury);
                                               $orders = $ordercount[0]->counts;
                                               $d_orders = $ordercount[0]->d_counts;
                                           }




                                                   //     $ordercountQury = "SELECT
                                                   //     COUNT(*) AS counts,
                                                   //     SUM(CASE WHEN (in_hub_route IS NULL) AND (".$statusCond.")  THEN 1 ELSE 0 END) AS d_counts
                                                   //     FROM sprint__sprints
                                                   //     join sprint__tasks ON(sprint_id=sprint__sprints.id  AND type='dropoff')
                                                   //     join merchantids on(task_id=sprint__tasks.id and tracking_id IS NOT NULL and tracking_id!='')
                                                   //     join locations on(location_id=locations.id)
                                                   //     WHERE creator_id IN(".$vendor.")
                                                   //     AND SUBSTRING(locations.postal_code,1,3) IN (".$postals.")
                                                   //     AND sprint__sprints.`deleted_at` IS NULL".$condition;

                                                   //    // dd($ordercountQury);

                                                   //     $ordercount = DB::select($ordercountQury);

                                           echo "<td>".$orders."</td>";
                                           echo "<td>".$d_orders."</td>";

                                           $joeyCount = Slots::where('zone_id','=',$zones->id)
                                           ->WhereNull('slots.deleted_at')
                                           ->sum('joey_count');

                                           echo "<td>".$joeyCount."</td>";

                                           $vehicleTyp = Slots::where('zone_id','=',$zones->id)->join('vehicles','vehicles.id','=','slots.vehicle')->WhereNull('slots.deleted_at')->get(['vehicles.name','slots.joey_count']);
                                           // dd($vehicleTyp);
                                           echo "<td>";

                                           foreach ($vehicleTyp as $key) {
                                               // dd($key);
                                              // echo $key->joey_count;
                                              echo $key->name ." : ".$key->joey_count."</br>" ;
                                           }*/

                                        echo "</td>";
                                        echo "<td style='width: 600px'>";

                                        // if(count($rights) == 0 || (count($rights) > 0 && in_array("zone_list_actions", $rights))) {
                                            echo "<button type='button'  class='update btn btn green-gradient actBtn col-sm-6 col-md-3 width-btn btn-primary'  data-id='" . $zones->id . "'>Edit <i class='fa fa-pencil'></i></button>";
                                        // }

                                        // if(count($rights) == 0 || (count($rights) > 0 && in_array("zone_list_actions", $rights))) {
                                            echo "<button type='button'  class='delete btn btn red-gradient actBtn col-sm-6 col-md-4 width-btn' data-id='" . $zones->id . "'>Delete <i class='fa fa-trash'></i></button>";
                                        // }


                                        /* echo "<button type='button'  class='details btn btn orange-gradient actBtn '  data-id='".$zones->id."'>Details <i class='fa fa-eye'></i></button>";*/

                                        echo "<button type='button'  class='counts btn btn orange-gradient actBtn col-sm-6 col-md-4 width-btn'  data-id='" . $zones->id . "'>Count <i class='fa fa-eye'></i></button>";
                                        /*Added By Muhammad Raqib @date 30/09/2022*/
                                        echo "<button type='button'  class='viewlist btn btn orange-gradient actBtn col-sm-6 col-md-6  width-btn'  data-id='" . $zones->id . "'>View Orders List <i class='fa fa-eye'></i></button>";
                                        /*end*/
                                        echo "<a href='../../slots/list/hubid/" . $zones->hub_id . "/zoneid/" . $zones->id . "' class='btn btn orange-gradient actBtn col-sm-6 col-md-5 width-btn '>View Slots <i class='fa fa-eye'></i></button></a>";
                                        if(auth()->user()->id == 2077){
                                            echo "<button type='button'  class='countstest btn btn orange-gradient actBtn col-sm-6 col-md-4 width-btn'  data-id='" . $zones->id . "'>CTest <i class='fa fa-eye'></i></button>";
                                        }
                                        echo "<button type='button'  class='route btn btn black-gradient actBtn col-sm-6 col-md-6 width-btn'  data-id='" . $zones->id . "'>Submit For Route <i class='fa fa-eye'></i></button>";
                                        if(auth()->user()->id == 2077){
                                            echo "<button type='button'  class='routetest btn btn black-gradient actBtn col-sm-6 col-md-4 width-btn'  data-id='" . $zones->id . "'>SRTest <i class='fa fa-eye'></i></button>";
                                        }
                                        echo "<button type='button'  class='attach-micro-hub btn btn green-gradient actBtn col-sm-6 col-md-6  width-btn btn-primary'  data-id='" . $zones->id . "'>Attach Micro Hub <i class='fa fa-plus'></i></button>";
                                        echo "</td>";
                                        echo "</tr>";
                                        $i++;
                                    }
                                    if( isset($zones) && !empty($zones)){
                                        $hub=$zones->hub_id;
                                    }

                                    ?>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>
    <!-- /#page-wrapper -->

    <!-- CreateZonesModal -->
    <div id="ex1" class="modal" style="display: none">
        <div class='modal-dialog'>

            <div class='modal-content'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Zones</h4>
                </div>
                <form action='../../zones/create' method="post">

                 <div class="row d-flex justify-content-center">
                    <div class="col-lg-11">
                 <input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="form-group">
    <label class="hide">Hub Id</label>
    <select class="form-control hide" name="hub_id" id="hub_id" style="width: 100% !important;">
        <?php
        if(empty($id))
        {
            $id=23;
        }
        echo '<option value="' . $id . '">' . $id. '</option>';
        ?>
    </select>
</div>

<div class="form-group">
    <label>Zone Title</label>
    <input type="text" name="title" id="title" style="min-width:100% !important" pattern="[A-Za-z0-9]{1}[A-Za-z 0-9()]{0,40}" class="form-control"  required/>
</div>
<div class="form-group">
    <label>Zone Type</label>
    <select class="form-control " name="zone_type" id="zone_type" style="width: 100% !important;"  required>
        <option value="">Please select zone type</option>
        <?php
        foreach($zoneType as $zones){
            echo '<option value="'.$zones->id.'">'.$zones->title.'</option>';
        }
        ?>
    </select>
</div>


<!-- <div class="form-group">
   <label>Address</label>
   <input type="text" name="address" id="address" class="form-control"  required/>
</div> -->


<div class="form-group">
    <label>No. Of Postal Code</label>
    <input id="inputs" type="number" name="" class="form-control" style="width:100% !important  " placeholder="No of postal code">
    <button class="btn green-gradient sub-ad" id="add" href="#" type="button" style="margin-top: 2px;line-height: 13px;padding: 8px;">Add <i class="fa fa-plus"></i></button>
    <div id="add_words"></div>
</div>


<div class="form-group">
    <button type="submit" class="btn sub-ad orange-gradient " >
        Create Zone <i class="fa fa-plus"></i>
    </button>
</div>
    </div>
                 </div>
                </form>
            </div>
        </div>
    </div>
    <!-- UpdateZoneModal -->
    <div id="ex2" class="modal" style="display: none">
        <div class='modal-dialog'>

            <div class='modal-content'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Zone</h4>
                </div>
                <form action='../../zones/update' method="post">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <input type="hidden" name="id_time" id="id_time" class="form-control"  required/>
                        <label class="hide">Hub Id</label>
                        <select class="form-control hide" name="hub_id" id="hub_id" style="width: 50%;">
                            <?php
                            if(empty($id))
                            {
                                $id=23;
                            }
                            echo '<option value="' . $id . '">' . $id. '</option>';
                            ?>
                        </select>


                    </div>



                    <div class="form-group">
                        <label>Zone Title</label>
                        <input type="text" name="title_edit" id="title_edit" pattern="[A-Za-z0-9]{1}[A-Za-z 0-9()]{0,40}" class="form-control"  required/>
                    </div>
                    <div class="form-group">
                        <label>Zone Type</label>
                        <select class="form-control testing" name="zone_type" id="zone_type" style="width: 50%;" required>
                            <option value="" style="=    font-size: 12px;">Please select zone type</option>
                            <?php
                            foreach($zoneType as $zones){
                                echo '<option style="    font-size: 12px;" value="'.$zones->id.'">'.$zones->title.'</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <!-- <div class="form-group">
                           <label>Address</label>
                           <input type="text" name="address_edit" id="address_edit" class="form-control"  required/>
                    </div> -->

                    <div class="form-group">
                        <label >Postal Codes :</label>
                        <div class="addInputs">
                        </div>
                        <div class="addMoresec">
                            <button class="addmore btn green-gradient" id="addmore" type="button" style=" margin-right: 0;">Add more <i class="fa fa-plus"></i></button>
                        </div>
                    </div>


                    <div class="form-group">
                        <button type="submit" class="btn orange-gradient" >
                            Update Zone</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--  Attach Micro Hub Model  --}}

    <div id="ex2mi" class="modal" style="display: none">
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Attach Micro Hub</h4>
                </div>

                <form action="{{ URL::to('backend/ctc/zones/microhub/add')}}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label>Micro Hub</label>
                        <input type="hidden" name="attach_zone_id" id="attach_zone_id">
                        <select class="form-control testing" name="microhub" id="microhub" style="width: 50%;" required>
                            <option value="" style="=    font-size: 12px;">Please select Micro Hub</option>
                            <?php
                            foreach($hubs as $hub){
                                echo '<option style="    font-size: 12px;" value="'.$hub->id.'">'.$hub->title.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn sub-ad btn-primary " >
                            Attach Micro Hub</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- DetailZonesModal -->
    <div id="ex3" class="modal" style="display: none">
        <div class='modal-dialog'>

            <div class='modal-content'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Details Zones</h4>
                </div>
                <div class="form-group">
                    <label>Zone ID :</label>
                    <p id="zone_id"></p>
                </div>
                <div class="form-group">
                    <label>Hub ID :</label>
                    <p id="hub_id_d"></p>
                </div>
                <div class="form-group">
                    <label>Title :</label>
                    <p id="title_d">ss</p>
                </div>
                <!-- <div class="form-group">
                    <label>Address:</label>
                    <p id="address_d">ss</p>
                </div> -->

                <div class="form-group">
                    <label>Postal codes :</label>
                    <p id="postal_code_d">ss</p>
                </div>
            </div>
            </form>
        </div>
    </div>
    </div>


    {{--Update By Muhammad Raqib @date 6/10/2022--}}
    <div id="ex20" class="modal" style="display: none;margin-top: 245px;">
        <div class='modal-dialog'>

            <div class='modal-content'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 style="text-align: -webkit-center;
                font-size: x-large;" id="count_detail" class="modal-title">Count Details</h4>
                </div>
                <div class="col-md-12 text-center add-slot-error"></div>
                <div class="form-group text-right" style="margin-bottom: -40px;">
                    <button style="margin-left:10px" class="slot-create btn green-gradient" data-toggle="modal" data-target="#exslot" data-slot-zone=''> <i class="fa fa-plus"></i> Create Slot</button>
                </div>
                <div {{--style="padding-left: 208px;"--}} class="form-group">
                    <label style=" font-size: 14px; width: 40%; color: black">Title :</label>
                    <p style="    font-size: 14px;     margin-left: 113px;color: black" id="name"></p>
                </div>


                <div {{--style="padding-left: 208px;"--}} class="form-group">
                    <label style=" font-size: 14px; width: 40%; color: black">Zone Id</label>
                    <p style="    font-size: 14px;     margin-left: 113px;color: black" id="d"></p>
                </div>


                <div {{--style="padding-left: 208px;"--}} class="form-group">
                    <label style=" font-size: 14px; width: 40%; color: black">Order Count:</label>
                    <p style="font-size: 14px;margin-left: 113px;color: black" id="check"></p>
                </div>
                <div {{--style="padding-left: 208px;"--}} class="form-group">
                    <label style="    font-size: 14px;width: 40%;color: black">Not In route</label>
                    <p style="    font-size: 14px;    margin-left: 113px;color: black" id="d_orders"></p>
                </div>

                <div {{--style="padding-left: 208px;"--}} class="form-group">
                    <label style="    font-size: 14px;width: 40%;color: black">Total joeys count</label>
                    <p style="    font-size: 14px;    margin-left: 113px;color: black" id="joeys_count"></p>
                </div>
                <div {{--style="padding-left: 208px;"--}} class="form-group">
                    <label style="    font-size: 14px;width: 40%;color: black">Slot details</label>
                    <p style="    font-size: 14px;color: black" id="slots_detail"></p>
                </div>
                <div {{--style="padding-left: 208px;"--}} class="form-group">
                    <a type='button' id="aaa" style="margin-top:10px;width: 168px;"
                       class='route btn btn btn-primary sub-ad actBtn sbroute' data-id=''>Submit For Route <i class='fa fa-eye'></i></a>
                </div>

            </div>
            </form>
        </div>
    </div>
    {{--end--}}

    <!-- CreateSLotsModal -->
    <div id="exslot" class="modal" style="display: none">
        <div class='modal-dialog'>

            <div class='modal-content'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Slots</h4>
                </div>
                <form action="{{URL::to('/backend')}}/slots/create/data" method="post" class="slotCreateRecord">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="zone_id" id="slot_zone_id" value="">
                    <input type="hidden" name="hub_id" id="slot_hub_id" value="{{ $id }}">


                    <div class="form-group">
                        <label>Vehicle</label>
                        <select class="form-control" name="vehicle" id="vehicle" style="width: 50%;">
                            <?php

                            $vehicles = Vehicle::get();
                            foreach ($vehicles as $vehicle) {
                                echo '<option value="' . $vehicle->id . '">' . $vehicle->name . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Start Time</label>
                        <input type="time" name="start_time" id="start_time" class="form-control">
                        <div class="col-md-6 text-right start-time-error error-div"></div>
                    </div>

                    <div class="form-group">
                        <label>End Time</label>
                        <input type="time" name="end_time" id="end_time" class="form-control">
                        <div class="col-md-6 text-right end-time-error error-div"></div>
                    </div>

                    <!--  <div class="form-group">
                         <label>No. of postal Code</label>
                         <input id="inputs" type="number" min="1" max="50" name="" style="width:40%!important;" placeholder="No of Postal Code" value="1">
                         <button class="btn green-gradient" id="add" href="#" type="button" style="margin-top: 2px;line-height: 13px;padding: 8px;">Add <i class="fa fa-plus"></i></button>
                         <div id="add_words"></div>
                     </div> -->

                    <div class="form-group">
                        <label>Joeys Count</label>
                        <input type="number" name="joey_count" id="joey_count" class="form-control"/>
                        <div class="col-md-6 text-right joey-count-error error-div"></div>
                    </div>
                    <div class="form-group">
                        <label>Custom Capacity</label>
                        <input type="number" name="custom_capacity" id="custom_capacity" class="form-control"/>
                    </div>

                    <!-- <div class="form-group">
                        <label>Orders Count</label>
                        <input type="number" name="orders_count" id="orders_count" class="form-control"  required/>
                    </div> -->

                    <div class="form-group">
                        <button type="button" onclick="createSlot()" class="btn orange-gradient" >
                            Create Slot <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div id="ex201" class="modal" style="display: none    ;margin-top: 245px;">
        <div class='modal-dialog'>

            <div  class='modal-content'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 style="    text-align: -webkit-center;
                font-size: x-large;" id="count_detailt"  class="modal-title">Count Details</h4>
                </div>


                <div style="padding-left: 208px;" class="form-group">
                    <label style=" font-size: 14px; width: 40%; color: black">Title :</label>
                    <p style="    font-size: 14px;     margin-left: 113px;color: black"  id="name"></p>
                </div>


                <div style="padding-left: 208px;" class="form-group">
                    <label style=" font-size: 14px; width: 40%; color: black">Zone Id</label>
                    <p style="    font-size: 14px;     margin-left: 113px;color: black"  id="d"></p>
                </div>



                <div style="padding-left: 208px;" class="form-group">
                    <label style=" font-size: 14px; width: 40%; color: black">Order Count:</label>
                    <p style="    font-size: 14px;     margin-left: 113px;color: black"  id="order-count"></p>
                </div>
                <div style="padding-left: 208px;" class="form-group">
                    <label style="    font-size: 14px;width: 40%;color: black">Not In route</label>
                    <p  style="    font-size: 14px;    margin-left: 113px;color: black" id="d_orders"></p>
                </div>

                <div style="padding-left: 208px;" class="form-group">
                    <label style="    font-size: 14px;width: 40%;color: black">Total joeys count</label>
                    <p  style="    font-size: 14px;    margin-left: 113px;color: black"id="joeys_count"></p>
                </div>
                <div style="padding-left: 208px;" class="form-group">
                    <label style="    font-size: 14px;width: 40%;color: black">Slot details</label>
                    <p style="    font-size: 14px;color: black"id="slots_detail"></p>
                </div>
                <div style="padding-left: 208px;" class="form-group">
                    <a type='button'  id="aaat"  style="margin-top:10px;width: 168px;"class='route btn btn black-gradient actBtn'  data-id=''>Submit For Route <i class='fa fa-eye'></i></a>
                </div>

            </div>
            </form>
        </div>
    </div>



    <!-- for counts in route or not in route -->

    <div id="ex21" class="modal" style="display: none">
        <div class='modal-dialog'>

            <div class='modal-content'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Get Total Orders Count</h4>
                </div>
                {{--<form action='../../zones/update' method="get">--}}

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                {{--<div class="form-group">--}}
                {{--<input type="hidden" name="id_time" id="id_time" class="form-control"  required/>--}}
                {{--<label class="hide">Hub Id</label>--}}



                {{--</div>--}}



                <div class="form-group">
                    <label>Total Orders</label>
                    <p id="total_orders"></p>

                </div>


                <div class="form-group">
                    <label>Not In Route</label>
                    <p id="not_in_route"></p>

                </div>

                {{--</form>--}}
            </div>
        </div>
    </div>


    <div id="totalordercount" class="modal" style="display: none">
        <div class='modal-dialog'>

            <div class='modal-content'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> Total Orders Count</h4>
                </div>

                <div class="form-group">
                    <label>Total Orders</label>
                    <p id="total_orders_counts"></p>

                </div>

                <div class="form-group">
                    <label>Order Not In Route</label>
                    <p id="not_in_routes_counts"></p>

                </div>

            </div>
        </div>
    </div>


    <!-- DeleteZonesModal -->
    <div id="ex4" class="modal" style="display: none">
        <div class='modal-dialog'>

            <div class='modal-content'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Zone</h4>
                </div>
                <form action='../../zonestesting/deletezone' method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="delete_id" name="delete_id" value="">


                    <div class="form-group">
                        <p><b>Are you sure you want to delete this?</b></p>
                    </div>
                    <div class="form-group d-flex">
                        <button type="submit" class="btn green-gradient sub-ad btn-xs" >Yes</button>
                        <button type="button" class="btn red-gradient sub-ad btn-xs" data-dismiss="modal" >No</button>

                    </div>

                </form>


            </div>
        </div>
    </div>
    <div id="ex10" class="modal" style="display: none">
        <div class='modal-dialog'>

            <div class='modal-content'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> Submit For Route</h4>
                </div>
                <?php if($id==19)
                {
                    echo "<form action='../../ottawa/routes/add' method='post' class='submitForRoute' >";
                }
                elseif($id==16)
                {
                    echo "<form action='../../montreal/routes/add' method='post' class='submitForRoute' >";
                }
                elseif($id==17)
                {
                    echo "<form action='../../ctc/routes/add' method='post' class='submitForRoute' >";
                }
                elseif($id==129)
                {
                    echo "<form action='../../vancouver/routes/add' method='post' class='submitForRoute' >";
                }
                elseif($id==157)
                {
                    echo "<form action='../../scarborough/routes/add' method='post' class='submitForRoute' >";
                }
                elseif($id==160)
                {
                    echo "<form action='../../wildfork/routes/add' method='post' class='submitForRoute' >";
                }
                ?>

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="hub_id_for_slot" id="hub_id_for_slot" value="{{ $id }}">
                <input type="hidden" id="zone" name="zone" value="">
                <input type="hidden" id="create_date" name="create_date" value=<?php echo date("Y-m-d") ?> >


                <div class="form-group ">
                    <p><b>Are you sure you want to Submit For Route ?</b></p>
                </div>
                <div class="form-group d-flex">
                    <button type="submit" class="btn green-gradient sub-ad btn-xs" >Yes</button>
                    <button type="button" class="btn red-gradient btn-xs sub-ad" data-dismiss="modal" >No</button>

                </div>

                </form>


            </div>
        </div>
    </div>

    <div id="ex101" class="modal" style="display: none">
        <div class='modal-dialog'>

            <div class='modal-content'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> Submit For Route</h4>
                </div>
                <?php if($id==19)
                {
                    echo "<form action='../../ottawa/routes/add' method='post'>";
                }
                elseif($id==16)
                {
                    echo "<form action='../../test/montreal/routes/add' method='post'>";
                }
                elseif($id==17)
                {
                    echo "<form action='../../ctc/routes/add' method='post'>";
                }?>

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="zone" name="zone" value="">
                <input type="hidden" id="create_date" name="create_date" value=<?php echo date("Y-m-d") ?> >


                <div class="form-group">
                    <p><b>Are you sure you want to Submit For Route ?</b></p>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn green-gradient btn-xs" >Yes</button>
                    <button type="button" class="btn red-gradient btn-xs" data-dismiss="modal" >No</button>

                </div>

                </form>


            </div>
        </div>
    </div>

    <!-- loader -->
    <div id="wait" style="display: none;align-items: center;justify-content: center;width: 100%;height: 100%;position: fixed;top:0;left: 0;">
        <img src="{{app_asset('images/loading.gif')}} " width="104" height="64" /><br>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $(document).ajaxStart(function(){
                $("#wait").css("display", "flex");
            });
            $(document).ajaxComplete(function(){
                console.log('ajaxComplete');
                $("#wait").css("display", "none");
            });
            $("button").click(function(){
                $("#txt").load("demo_ajax_load.asp");
            });
        });

        $(document).ready(function()
        {
            $( ".accordion" ).click(function()
            {
                //toggleactiveclass
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                } else {
                    $(this).addClass('active');
                }

                //addcssClass
                if ($(this).hasClass('active')) {
                    $(this).parent().find(".panell").css({
                        "maxHeight": "20px",
                    });
                } else {
                    $(this).parent().find(".panell").css({
                        "maxHeight": "0px",
                    });
                }
            });
            var i = 0;
            $(document).ready(function(){
                i++;
                var scntDiv = $('#add_words');
                $('<div class="line"><label>Postal Code </label><input type="text" value="" name="postal[]" maxlength="3 " class="form-control" style="padding-left: 15px; width:100% !important" placeholder="Postal code" pattern="[A-Za-z]{1}[0-9]{1}[A-Za-z]{1}" required  /> <button class="remScnt sub-ad btn red-gradient">x</button></div>').appendTo(scntDiv);
            });

            var scntDiv = $('#add_words');
            var wordscount = 1;
            // var i = $('.line').size() + 1;

            $('#add').click(function() {
                // alert()
                var inputFields = parseInt($('#inputs').val());
                for (var n = i; n < inputFields; ++ n){
                    wordscount++;
                    $('<div class="line"><label>Postal Code </label><input type="text" value="" name="postal[]" maxlength="3" placeholder="Postal code" pattern="[A-Za-z]{1}[0-9]{1}[A-Za-z]{1}" required  /> <button class="remScnt btn sub-ad red-gradient">x</button></div>').appendTo(scntDiv);
                    i++;
                }
                return false;
            });

            //    Remove button
            $('#add_words').on('click', '.remScnt', function() {
                if (i > 1) {
                    $(this).parent().remove();
                    i--;
                }
                return false;
            });
        });

        // detailsFunc
        $(document).ready(function(){
            $(".details").click(function(){
                var a;
//    var element = $(this);
                var del_id = element.attr("data-id");

                // console.log(del_id);
                $.ajax({
                    type: "GET",
                    url: '../../zonestesting/'+del_id+'/detail',

                    success: function(data){
                        a = JSON.parse(data);
                        console.log(a);

                        console.log(a['data']['hub_id']);


                        $('#zone_id').html(''+a['data']['id']);
                        $('#hub_id_d').html(''+a['data']['hub_id']);
                        // console.log($("#hub_id"))
                        $('#title_d').html(''+a['data']['title']);
                        $('#address_d').html(''+a['data']['address']);



                        arrNew_d = [];
                        var post='';
                        $.each(a['postalcodedata'],function (i , val) {
                            //  arrNew_d.push(val['postal_code'])
                            if (post=="") {
                                post=val['postal_code'];
                            } else {
                                post=post+','+val['postal_code'];
                            }
                            $('#postal_code_d').html(''+post);
                        })


                        $('#ex3').modal();


                    }

                });
            });
        });
        setInterval(function(){
            $('.start-time-error').html('');
            $('.end-time-error').html('');
            $('.joey-count-error').html('');
            $('.add-slot-error').html('');
        },7000);
        //create slot ajax
        function createSlot(){

            if($('#start_time').val() == ''){
                $('.start-time-error').html('<span class="alert text-danger alert-red error-div-inner-start-time">Please insert start time</span>');
                return false;
            }
            if($('#end_time').val() == ''){
                $('.end-time-error').html('<span class="alert text-danger alert-red error-div-inner-end-time">Please insert end time</span>');
                return false;
            }
            if($('#joey_count').val() == ''){
                $('.joey-count-error').html('<span class="alert text-danger alert-red error-div-inner-joey-count">Please insert joey count</span>');
                return false;
            }

            var url = $('.slotCreateRecord').attr('action');
            var data = new FormData();
            data.append('hub_id', $('#slot_hub_id').val());
            data.append('zone_id', $('#slot_zone_id').val());
            data.append('vehicle', $('#vehicle').val());
            data.append('start_time', $('#start_time').val());
            data.append('end_time', $('#end_time').val());
            data.append('joey_count', $('#joey_count').val());
            data.append('custom_capacity', $('#custom_capacity').val());

            $(".loader").show();
            $(".loader-background").show();
            var a;
            $.ajax({
                url: url,
                type: 'POST',
                contentType: false,
                processData: false,
                data:data,
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token',"{{ csrf_token() }}");
                },

                success: function(data){
                    a = JSON.parse(data);

                    $(".loader").hide();
                    $(".loader-background").hide();
                    $('#exslot').hide();
                    var frm = document.getElementsByClassName('slotCreateRecord')[0];
                    frm.reset();

                    $('#joeys_count').html(''+a.joeys_count);
                    // $('#slots_detail').html(''+a['slots_detail'][0]['name']+":"+""+a['slots_detail'][0]['joey_count']);.
                    var x='';
                    for (var i=0; i < a.slots_detail.length;i++)
                    {
                        x = x + a['slots_detail'][i].name+":"+""+a['slots_detail'][i].joey_count + ' ';
                    }
                    $('#slots_detail').html(x);

                    $('#exslot').modal('hide');
                    //
                    // if(data.status_code==200)
                    // {
                    //     $('#ex20').modal('hide');
                    //     $('.alert-message').html('<div class="alert alert-success alert-green"><button style="color:#f5f5f5"; type="button" class="close" data-dismiss="alert"><strong><b><i  class="fa fa-close"></i><b></strong></button><strong>'+data.success+'</strong>');
                    // }
                    // else
                    // {
                    //     $('.alert-message').html('<div class="alert alert-danger alert-red"><button style="color:#f5f5f5"; type="button" class="close" data-dismiss="alert"><strong><b><i  class="fa fa-close"></i><b></strong></button><strong>'+data.error+'</strong>');
                    // }
                    // location.reload();





                },
                failure: function(result){
                    $('#ex20').modal('hide');
                    $(".loader").hide();
                    $(".loader-background").hide();


                    bootprompt.alert(result);
                }
            });

        }

        //routeCount function routeCount
        $(document).ready(function(){
            $(".routeCount").click(function(){
                var a;

                var element = $(this);
                var date =$('#date').val()

                // var del_id = element.attr("data-id");

                var id = $('#hub_id').val();
                $.ajax({
                    type: "GET",
                    url: '../../zonestesting/count/'+id+'/'+date,


                    beforeSend: function(){
                        // Show image container
                        $("#wait").show();
                    },
                    success: function(data)
                    {
                        a = JSON.parse(data);
                        console.log(a);

                        $('#total_orders').html(''+a.orders);
                        $('#not_in_route').html(''+a.d_orders);


                        $('#ex21').modal();


                    },
                    complete:function(data){
                        // Hide image container
                        $("#wait").hide();
                    }
                });
            });
        });

        //count function
        $(document).ready(function(){
            $(".counts").click(function(){

                var a;

                var element = $(this);
                var date =$('#date').val()

                var del_id = element.attr("data-id");

                var id = $('#hub_id').val();



                $.ajax({
                    type: "GET",
                    //url: '../../zonestesting/list/'+id+'/count/'+date+'/'+del_id,
                    url: '../../order/count/'+id+'/zone/'+del_id+'/date/'+date,
                    success: function(data)
                    {
                        a = JSON.parse(data);

                        // if(a.joeys_count == 0){
                        //     // document.getElementsByClassName("").disabled = true;
                        //     var element = document.getElementById("aaa");
                        //     element.classList.add("mystyle");
                        // }

                        console.log(a.id)
                        var slotzoneid = $('#slot_zone_id').val(a.id);
                        $('#count_detail').html(''+a.title);
                        $('#name').html(''+a.title);

                        $('#d').html(''+a.id);
                        $('#check').html(''+a.orders);
                        $('#d_orders').html(''+a.d_orders);
                        $('#joeys_count').html(''+a.joeys_count);
                        // $('#slots_detail').html(''+a['slots_detail'][0]['name']+":"+""+a['slots_detail'][0]['joey_count']);.
                        var x='';
                        for (var i=0; i < a.slots_detail.length;i++)
                        {
                            x = x + a['slots_detail'][i].name+":"+""+a['slots_detail'][i].joey_count + ' ';

                        }
                        $('#slots_detail').html(x);

                        /* var d = document.getElementById("aaa");  //   Javascript

                         //console.log(d);
                         d.setAttribute('data-id' ,id);*/
                        $('#ex20').find('#aaa').attr('data-id',del_id);
                        $('#ex20').modal();


                    }
                });
            });
            $(".countstest").click(function(){

                var a;

                var element = $(this);
                var date =$('#date').val()

                var del_id = element.attr("data-id");

                var id = $('#hub_id').val();
                console.log(id);

                $.ajax({
                    type: "GET",
                    url: '../../test/zonestesting/list/'+id+'/count/'+date+'/'+del_id,
                    success: function(data)
                    {
                        a = JSON.parse(data);
                        console.log(a);

                        $('#count_detailt').html(''+a.title);
                        $('#namet').html(''+a.title);

                        $('#dt').html(''+a.id);
                        $('#ordert').html(''+a.orders);
                        $('#d_orderst').html(''+a.d_orders);
                        $('#joeys_countt').html(''+a.joeys_count);
                        // $('#slots_detail').html(''+a['slots_detail'][0]['name']+":"+""+a['slots_detail'][0]['joey_count']);.
                        console.log(a.slots_detail.length);
                        var x='';
                        for (var i=0; i < a.slots_detail.length;i++)
                        {
                            x = x + a['slots_detail'][i].name+":"+""+a['slots_detail'][i].joey_count + ' ';

                        }
                        $('#slots_detailt').html(x);

                        /* var d = document.getElementById("aaa");  //   Javascript

                         //console.log(d);
                         d.setAttribute('data-id' ,id);*/
                        $('#ex201').find('#aaat').attr('data-id',del_id);
                        $('#ex201').modal();


                    }
                });
            });
        });


        // updateFunc
        $(document).ready(function(){
            $(".update").click(function(){
                var a;
                var element = $(this);
                var del_id = element.attr("data-id");
                // console.log(del_id);
                $.ajax({
                    type: "GET",
                    url: '../../zonestesting/'+del_id+'/update',
                    success: function(data)
                    {
                        a = JSON.parse(data);
                        console.log(a);
                        $('#id_time').val(''+a['data']['id']);
                        $('#title_edit').val(''+a['data']['title']);
                        $('#address_edit').val(''+a['data']['address']);
                        $('.testing').val(''+a['data']['zone_type']);


                        arrNew = [];
                        $.each(a['postalcodedata'], function (i , val)
                        {
                            arrNew.push(val['postal_code'])
                        })

                        var addInputs = $('.addInputs');
                        var inputcount = arrNew.length;

                        var i = 0;
                        $(addInputs).empty();
                        for (var n = i; n < inputcount; ++ n)
                        {
                            $('<div class="lineEdit"><input type="text" value='+arrNew[i]+' name="postal_code_edit[]" maxlength="3" placeholder="Postal code" pattern="[A-Za-z]{1}[0-9]{1}[A-Za-z]{1}" class="form-control" required /><button class="remScntedit btn red-gradient" >x</button></div>').appendTo(addInputs);
                            i++;
                        }



                        $("#addmore").click(function(){

                            $('<div class="lineEdit"><input type="text" value="" name="postal_code_edit[]" maxlength="3"  placeholder="Postal code" pattern="[A-Za-z]{1}[0-9]{1}[A-Za-z]{1}" class="form-control" required><button class="remScntedit btn red-gradient" >x</button></div>').appendTo(addInputs);
                            $('#addInputs').append(lineEdit.clone());
                        });



                        $('.addInputs').on('click', '.remScntedit', function() {
                            var addInputs = $('.remScntedit');

                            if (addInputs.length> 1) {

                                $(this).parent().remove();
                                i--;
                            }
                            return false;
                        });



                        $('#ex2').modal();
                    }
                });
            });
        });


        $(document).ready(function(){
            $(".attach-micro-hub").click(function(){
                var element = $(this);
                var attach_zone_id = element.attr("data-id");
                document.getElementById('attach_zone_id').value = attach_zone_id;
                $('#ex2mi').modal();

            });
        });

        //DeleteFunc
        $(function() {
            $(".delete").click(function(){

                var element = $(this);
                var del_id = element.attr("data-id");
                $('#delete_id').val(''+del_id);
                $('#ex4').modal();
            });
        });

        // clearOrder
        $(document).on('click','.totalOrderCount',function(){
            element = $(this);

            var hub_id = element.attr("data-id");
            let date=document.getElementsByName('date')[0].value;
            $(".loader").show();
            $(".loader-background").show();
            $.ajax({
                type: "post",
                url: "{{ URL::to('backend/total/order/notinroute')}}",
                data:{id:hub_id,date:date},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token',"{{ csrf_token() }}");
                },
                success: function (data) {
                    $(".loader").hide();
                    $(".loader-background").hide();
                    if(data.status_code==200)
                    {


                        $('#totalordercount').modal();
                        $('#totalordercount #total_orders_counts').text(data.total_count);
                        $('#totalordercount #not_in_routes_counts').text(data.not_in_route_counts);
                    }



                },
                error:function (error) {
                    $(".loader").hide();
                    $(".loader-background").hide();

                    bootprompt.alert('some error');
                }
            });



        });


    </script>

    <script type="text/javascript">
        // Datatable
        $(document).ready(function () {

            $('#datatable').DataTable({

                "lengthMenu": [25,50,100, 250, 500, 750, 1000 ]


            });

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
                                            var DataToset = '<button type="btn" class="btn btn-warning btn-xs status_change" data-toggle="modal" data-id="'+Uid+'" data-target=".bs-example-modal-sm">Blocked</button>';
                                            $('#CurerntStatusDiv'+Uid).html(DataToset);
                                        }
                                        else
                                        {
                                            var DataToset = '<button type="btn" class="btn btn-success btn-xs status_change" data-toggle="modal" data-id="'+Uid+'" data-target=".bs-example-modal-sm">Active</button>'
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
        //route
        $(function() {
            $(".route").click(function(){

                var element = $(this);
                var del_id = element.attr("data-id");
                console.log(del_id);
                $('#zone').val(''+del_id);
                $('#ex20').modal('hide');
                $('#ex10').modal();
            });
            $(".routetest").click(function(){

                var element = $(this);
                var del_id = element.attr("data-id");
                console.log(del_id);
                $('#zone').val(''+del_id);
                $('#ex101').modal();
            });
        })

        $('.submitForRoute').submit(function(event) {

            event.preventDefault();

            // get the form data

            var data = new FormData();
            data.append('hub_id', $('input[name=hub_id_for_slot]').val());
            data.append('zone', $('input[name=zone]').val());
            data.append('create_date', $('input[name=create_date]').val());
            $('#ex10').modal('toggle');

            // process the form
            $(".loader").show();
            $(".loader-background").show();

            $.ajax({
                url: $('.submitForRoute').attr('action'),
                type: 'POST',
                contentType: false,
                processData: false,
                data:data,
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token',"{{ csrf_token() }}");
                },

                success: function(data){

                    if(data.status_code == 201){
                        $('#ex20').modal();
                        $('.add-slot-error').html('<span class="alert alert-danger alert-red col-md-12" style="margin-top: 5px;padding: 5px;">Please create slot first then click on submit for route!</span>');
                        // $('#ex10').modal('hide');

                        return false;
                    }

                    // $('#ex20').toggle();
                    $(".loader").hide();
                    $(".loader-background").hide();
                    $('#ex20').modal('hide');

                    if(data.status_code==200)
                    {
                        $('#ex20').modal('hide');
                        $('.alert-message').html('<div class="alert alert-success alert-green"><button style="color:#f5f5f5"; type="button" class="close" data-dismiss="alert"><strong><b><i  class="fa fa-close"></i><b></strong></button><strong>'+data.success+'</strong>');
                    }
                    else
                    {
                        $('.alert-message').html('<div class="alert alert-danger alert-red"><button style="color:#f5f5f5"; type="button" class="close" data-dismiss="alert"><strong><b><i  class="fa fa-close"></i><b></strong></button><strong>'+data.error+'</strong>');
                    }
                       // location.reload();





                },
                failure: function(result){
                    $('#ex20').modal('hide');
                    $(".loader").hide();
                    $(".loader-background").hide();


                    bootprompt.alert(result);
                }
            });


            event.preventDefault();
        });


        /*Added By Muhammad Raqib
         @date 30/09/2022*/
        /*List*/
        $(document).ready(function () {
            $(".viewlist").click(function () {

                var a;
                var element = $(this);
                var date = $('#date').val()

                var del_id = element.attr("data-id");

                var id = $('#hub_id').val();
                // console.log(id);

                $.ajax({
                    type: "GET",
                    // url: '../../zonestesting/viewlist/'+id+'/'+date+'/'+del_id,
                    url: '../../order/' + id + '/zone/' + del_id + '/date/' + date,
                    // url: '../../order/count/'+id+'/zone/'+del_id+'/date/'+date,
                    success: function (data) {
                        a = JSON.parse(data);
                        // console.log(a);

//                         $('#count_detail').html(''+a.title);
                        $('#name').html('' + a.title);
                        $('#title').html('' + a.title);
                        $('#d').html('' + a.id);
                        if (a.orders == 0) {
                            document.getElementById("order").innerHTML = "Data Not Found...";
                        } else {
                            let ids = a.orders.map((item) => item.tracking_id);
                            console.log(ids, 'ids')
                            var x = '';
                            for (var i = 0; i < ids.length; i++) {
                                var tr = ids[i];
                                x = x + '<tr ><td class="text-center col-md-12" style="font-size: 14px; color: black; letter-spacing: 1px;word-wrap: break-all;">' + tr + '</td></tr>';
                                console.log(x, ids.length)
                            }

                            $('#order').html(x);
                            if (ids.length > 10) {
                                $('#scroll-order').addClass('anyClass');
                            } else {
                                $('#scroll-order').removeClass('anyClass');
                            }

                        }
                        $('#ex2089').find('#aaa').attr('data-id', del_id);
                        $('#ex2089').modal();

                    }
                });
            });

        });

    </script>
@endsection

{{--Added by Muhammad Raqib @date 3/10/2022--}}
<div id="ex2089" class="modal" style="display: none;margin-top: 265px;">
    <div class='modal-dialog' style="width: 340px">
        <div class='modal-content'>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 style="text-align: -webkit-center;font-size: x-large;" id="title"
                    class="modal-title text-center"></h4>
            </div>

            <div style="height: 372px!important;" class="form-group text-center px-auto ">
                <div class="table-responsive tab-border" id="scroll-order">
                    <table class="table" id="order">

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .anyClass {
        height: 372px;
        overflow-y: scroll;
    }

    #ex2089 .table {
        margin-bottom: 0px !important;
    }

    .tab-border {
        border: 3px solid #c3c5cb;
    }
</style>
{{--end--}}