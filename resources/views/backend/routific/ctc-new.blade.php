<?php 
use App\Joey;
use App\Slots;
use App\RoutingZones;
use App\JoeyRoute;
use App\JoeyRouteLocations;


?>
@extends( 'backend.layouts.app' )

@section('title', 'Toronto Routes')

@section('CSSLibraries')
    <!-- DataTables CSS -->
    <link href="{{ backend_asset('libraries/datatables-plugins/dataTables.bootstrap.css') }}" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="{{ backend_asset('libraries/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">
    <!-- Image Viewer CSS -->
    <link href="{{ backend_asset('libraries/galleria/colorbox.css') }}" rel="stylesheet">

    <style>
        .green-gradient, .green-gradient:hover {
    color: #fff;
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
.modal-dialog.map-model {
    width: 94%;
}
.btn{
    font-size : 12px;
}

    .modal.fade {
        opacity: 1
    }

    .modal-header {
        font-size: 16px;
    }

    .modal-body h4 {
        background: #f6762c;
        padding: 8px 10px;
        margin-bottom: 10px;
        font-weight: bold;
        color: #fff;
    }

    .form-control {
        display: block;
        width: 100%;
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    }

    .form-control:focus {
        border-color: #66afe9;
        outline: 0;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(102, 175, 233, .6);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(102, 175, 233, .6);
    }

    .form-group {
        margin-bottom: 15px;
    }

    #ex1 form{
    padding: 10px;
}
div#transfer .modal-content, div#details .modal-content {
    padding: 20px;
    }

   #details .modal-content {
     overflow-y: auto;
     height: 500px;
}
div#map5 {
    width: 100% !important;
}

.jconfirm .jconfirm-box{
    border : 5px solid #bad709
}
.btn-info {
    color: #fff;
    background-color: #cd692e;
}
.jconfirm .jconfirm-box .jconfirm-buttons button.btn-default {
    background-color: #b8452b;
    color: #fff !important;
}

.jconfirm-content {
    color: #535353;
    font-size: 16px;
}

.jconfirm button.btn:hover {
    background: #99af14 !important;
}

.select2 {
    width: 70% !important;
    margin: 0 0 5px 10px;
}

/* start */
.form-group label {
    width: 50px;
}
div#route .form-group {
    width: 25%;
    float: left;
}

div#route {
    position: absolute;
    z-index: 9999;
    top: 83px;
    width: 97%;
}

.
div {
    display: block;
}
.iycaQH {
    position: absolute;
    background-color: white;
    border-radius: 0.286em;
    box-shadow: rgba(86, 102, 108, 0.24) 0px 1px 5px 0px;
    overflow: hidden;
    margin: 1.429em 0px 0px;
    z-index: 9999;
    width: 30%;
    top: 70px;
    left: 26px;
}
.cBZXtz {
    display: flex;
    -webkit-box-pack: justify;
    justify-content: space-between;
    -webkit-box-align: center;
    align-items: center;
}
.bdDqgn {
    padding: 0.6em 1em;
    background-color: white;
    border-bottom-left-radius: 0.286em;
    border-bottom-right-radius: 0.286em;
    max-height: 28.571em;
    overflow: scroll;
}
.cBZXtz {
    display: flex;
    -webkit-box-pack: justify;
    justify-content: space-between;
    -webkit-box-align: center;
    align-items: center;
}
.kikQSm {
    display: inline-block;
    max-width: 100%;
    font-size: 0.857em;
    font-family: Lato;
    font-weight: 700;
    color: rgb(86, 102, 108);
    margin-bottom: 0.429em;
}
.gdoBAT {
    font-size: 12px;
    margin: 0px 0px 5px 10px;
    color: rgb(86, 102, 108);
}




/*boxes css*/
.montreal-dashbord-tiles h3 {
    color: #fff;
}
.montreal-dashbord-tiles .count {
    color: #fff;
}
.montreal-dashbord-tiles .tile-stats 
{
    border: 1px solid #c6dd38;
    background: #c6dd38;
}

.montreal-dashbord-tiles .tile-stats {
    border: 1px solid #c6dd38;
    background: #c6dd38;
}
.montreal-dashbord-tiles .icon {
    color: #e36d28;
}
.tile-stats .icon i {
    margin: 0;
    font-size: 60px;
    line-height: 0;
    vertical-align: bottom;
    padding: 0;
}
.mydiv {
    position: absolute;
    z-index: 9;
    background-color: #f1f1f1;
    text-align: center;
    border: 1px solid #d3d3d3;
}

.mydivheader {
    padding: 10px;
    cursor: move;
    z-index: 10;
    background-color: #c7dd1f;
    color: black;
}

.route-detail-h4{
    background: #f6762c;
    padding: 10px;
    color: white;
    font-weight: 700;
    text-align: left;
}
.route-detail-p{
    text-align: left;
    margin-left: 10px;
}

@media only screen and (max-width: 1680px){
.top_tiles .tile-stats {
    padding-right: 70px;
}
.tile-stats .count {
    font-size: 30px;
    font-weight: bold;
    line-height: 1.65857;
    overflow: hidden;
    box-sizing: border-box;
    text-overflow: ellipsis;
}
.tile-stats h3 {
    font-size: 12px;
}
.top_tiles .icon {
    font-size: 40px;
    position: absolute;
    right: 10px;
    top: 0px;
    width: auto;
    height: auto;
    font-size: 40px;
}
.top_tiles .icon .fa {
    vertical-align: middle;
    font-size: inherit;
}
}
        /*added by Muhammad Raqib @date 7/10/2022*/


        @media only screen and (min-width: 200px) and (max-width: 480px)  {
            [class*="order-data-"] {width: 100%;}
        }
        @media only screen and (min-width: 460px) and (max-width: 768px)  {
            [class*="order-data-"] {width: 50%;}
        }
        @media only screen and (min-width: 760px) and (max-width: 991px)  {
            [class*="order-data-"] {width: 30%;}
        }
        @media only screen and (min-width: 991px) and (max-width: 1280px)  {
            [class*="order-data-"] {width: 34%;}
        }
        @media only screen and (min-width: 1280px) and (max-width: 1600px)  {
            [class*="order-data-"] {width: 28%;}
        }
        .order-data-2{padding-left: 12px;}


        /*end*/
    </style>

@endsection

@section('JSLibraries')
    <!-- DataTables JavaScript -->
    <script src="{{ backend_asset('libraries/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ backend_asset('libraries/datatables-plugins/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ backend_asset('libraries/datatables-responsive/dataTables.responsive.js') }}"></script>
    <script src="{{ backend_asset('libraries/galleria/jquery.colorbox.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="{{ backend_asset('js/jquery-ui.js') }}"></script>
    <link href="{{ backend_asset('js/jquery-ui.css') }}" rel="stylesheet"> -->

@endsection

@section('inlineJS')

    <script type="text/javascript">
        
        $(document).ready(function () {

            $('#datatable').DataTable({
              "lengthMenu": [25,50,100, 250, 500, 750, 1000 ]
            });

            $(".group1").colorbox({height:"50%",width:"50%"});

            $(document).on('click', '.reroute', function(e){

                var $form = $(this);
                $.confirm({
                    title: 'A secure action',
                    content: 'Are you sure you want to Reroute this route ?',
                    icon: 'fa fa-question-circle',
                    animation: 'scale',
                    closeAnimation: 'scale',
                    opacity: 0.5,
                    buttons: {
                        'confirm': {
                            text: 'Proceed',
                            btnClass: 'btn-info',
                            action: function () {
                                console.log($form.attr("data-re"));
                
                                 var id = $form.attr("data-re");
                                
                                $.ajax({
                                    type: "GET",
                                    url: '../hub/16/re-route/'+id,
                                    success: function(message){   
                                        $.alert(message);
                                       // location.reload();
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

            $(document).on('click', '.delete', function(e){

                var $form = $(this);
                $.confirm({
                    title: 'A secure action',
                    content: 'Are you sure you want to delete this route ?',
                    icon: 'fa fa-question-circle',
                    animation: 'scale',
                    closeAnimation: 'scale',
                    opacity: 0.5,
                    buttons: {
                        'confirm': {
                            text: 'Proceed',
                            btnClass: 'btn-info',
                            action: function () {
                            var id = $form.attr("data-id");
                                
                            $.ajax({
                                type: "GET",
                                url: '../route/' + id + '/delete/hub',
                                success: function(message){   
                                    $.alert(message);
                                    //location.reload();
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

        });

    </script>

@endsection

@section('content')
<meta type="hidden" name="csrf-token" content="{{ csrf_token() }}" />
<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
   
<div class="right_col" role="main">
        <div class="">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>    
                <strong>{{ $message }}</strong>
            </div>
            @endif
            
            @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>    
                <strong>{{ $message }}</strong>
            </div>
            @endif
            <div class="page-title">
                <div class="title_left amazon-text">
                    <!-- <h3>Toronto Routes<small></small></h3> -->
                </div>
            </div>

            <div class="clearfix"></div>
            <?php
                if(empty($_REQUEST['date'])){
                    $date = date('Y-m-d');
                }
                else{
                    $date = $_REQUEST['date'];
                }
            ?>
            {{--@include('backend.layouts.modal')
            @include( 'backend.layouts.popups')--}}
            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                     <div class="x_title">
                        <h2>Toronto Routes</h2>
                     </div>
                    <form id="filter" style="padding: 10px;margin-left: 6px;" action="" method="get">  
             <div class="row d-flex align-items-center">
             <div class="col-md-3">
             <div class="form-group">
                <label>Search By Date :</label>
              <input id="date" name="date" style="width:35%px" type="date" placeholder="date" value="<?php echo $date ?>"  class="form-control">
              
              </div>
             </div>
        <div class="col-lg-6">
        <button  id="search" type="submit" class="btn sub-ad btn-primary  " style="margin:8px 0px 0px 0px !important">Submit</button>
        </div>
             </div>
                
            </form>
                {{--Muhammad Raqib @date 7/10/2022--}}
                        <!--Count Div Row Open-->
                        <div class="row">
                            <!--top_tiles Div Open-->
                            <div class="top_tiles montreal-dashbord-tiles">
                                <!--Animated-a Div Open-->
                                <div class="animated flipInY order-data-2 col-lg-3">
                                    <div class="tile-stats">
                                        <div class="icon">
                                            <i class="fa fa-cubes"></i>
                                        </div>
                                        <div class="count" id="order_counts" >

                                        </div>
                                        <h3>Total Orders in Route</h3>
                                    </div>
                                </div>
                                <!--Animated-a Div Close-->
                            </div>
                            <!--top_tiles Div Close-->
{{--New add--}}
                            <div class="top_tiles montreal-dashbord-tiles">
                                <!--Animated-a Div Open-->
                                <div class="animated flipInY order-data-2 col-lg-3">
                                    <div class="tile-stats">
                                        <div class="icon">
                                            <i class="fa fa-cubes"></i>
                                        </div>
                                        <div class="count"  id="joey_count">

                                        </div>
                                        <h3>Total Drivers on Route</h3>
                                    </div>
                                </div>
                                <!--Animated-a Div Close-->
                            </div>
                            <!--top_tiles Div Close-->
                            <div class="top_tiles montreal-dashbord-tiles">
                                <!--Animated-a Div Open-->
                                <div class="animated flipInY order-data-2 col-lg-3">
                                    <div class="tile-stats">
                                        <div class="icon">
                                            <i class="fa fa-cubes"></i>
                                        </div>
                                        <div class="count"  id="not-delivered">

                                        </div>
                                        <h3>Not Deliver / Not Return </h3>
                                    </div>
                                </div>
                                <!--Animated-a Div Close-->
                            </div>
                            <!--top_tiles Div Close-->
                        </div>
                        <!--Count Div Row Close-->
                    {{--end--}}
                        <div class="x_title">
                             <button type='button'  class='dselect sub-ad btn-primary  btn btn  actBtn' data-toggle='modal' data-target='#ex50' onclick='fullmap()' >Map <i class='fa fa-map'></i></button>

                            <div class="clearfix"></div>
                        </div>


                        <div class="x_content">

                         @include( 'backend.layouts.notification_message' )

	                <div class="table-responsive">
	                  <table id="datatable" class="table table-striped table-bordered">
                                <thead stylesheet="color:black;">
                                <div id="mydivpopup"></div>
                                <tr>
                                    <th>Id</th>
                                    <th>Route No</th>
                                    <th>Zone</th>
                                    <th>Cart Number</th>
                                    <!-- <th>Joey Id</th> -->
                                    <th>Driver</th>
                                    <th>Duration</th>
                                    <th>Distance </th>
                                    <th>Orders Left</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

$i=1;
$counter= [];
$counts_total=0;
$total_joeys=0;
$not_delivered=0;
for($j=0;$j<count($counts);$j++) {

    echo "<tr>";
    echo "<td>" . $i . "</td>";
    echo "<td>R-" .$counts[$j]->route_id . "</td>";
    echo "<td></td>";


//    if($counts[$j]->zone!=null)
//    {
//        $cart_id=JoeyRoute::getCartnoOfRoute($counts[$j]->route_id);
//
//        echo "<td>" .chr($cart_id['zone_cart_no']).chr($cart_id['route_cart_no']).chr($cart_id['order_range'])."</td>";
//    }
//    else
//    {
//        echo "<td></td>";
//    }

        $counter[] = $counts[$j]->joey_id;
    $joeys_un = array_unique($counter);
    $joeys =array_filter($joeys_un);
    $total_joeys = count($joeys);
	 if( !empty($counts[$j]->joey_id) || $counts[$j]->joey_id!=NULL ){
		  echo "<td>" . Joey::joeyName($counts[$j]->joey_id) ." (".$counts[$j]->joey_id.") </td>";
	 }
	 else {
		 echo "<td></td>";
	 }
 $duration=0;
    if (!empty($counts[$j]->route_id) ) {
        $duration = JoeyRouteLocations::getDurationOfRoute($counts[$j]->route_id);
    } else {
        $duration = 0;
    }

    echo "<td>" . $duration . "</td>";

    if (!empty($counts[$j]->distance) || $counts[$j]->distance != NULL) {
        $distance = round($counts[$j]->distance / 1000, 2);
    } else {
        $distance = 0;
    }

    if(!empty($counts[$j]->d_distance) || $counts[$j]->d_distance!=NULL ){
        $d_distance = round($counts[$j]->d_distance/1000,2);
     }
     else{
         $d_distance = 0;
     }
//    <button class='details green-gradient btn col-lg-2 col-md-3 col-sm-2 px-auto' data-route-id=" . $counts[$j]->route_id . " data-joey-id=" . $counts[$j]->joey_id . " title='Details'>D</button>
/*for Count Total Orders*/
   $counts_total = $counts_total + $counts[$j]->counts;

//Not Delivered Counts
   $not_delivered = $not_delivered + $counts[$j]->d_counts;
    echo "<td>".$d_distance."km/".$distance."km</td>";
    echo "<td>".$counts[$j]->d_counts."/".$counts[$j]->counts."</td>";
    echo "<td>" . date('Y-m-d', strtotime($counts[$j]->date)) . "</td>";
    echo "<td>
    <button class='green-gradient btn col-lg-2 col-md-3 col-sm-2 px-auto multiple-details' data-routeid=" . $counts[$j]->route_id . " data-joeyid=" . $counts[$j]->joey_id . ">D</button>

     <a class=' orange-gradient btn col-lg-2 col-md-3 col-sm-2 px-auto' target='_blank' href='../route/" . $counts[$j]->route_id . "/edit/hub/17' title='Edit Route'>E</a>
     <button class='transfer  black-gradient btn col-lg-2 col-md-3 col-sm-2 px-auto' data-route-id=" . $counts[$j]->route_id . " title='Transfer'>T</button>
     <button type='button' class=' red-gradient btn col-lg-2 col-md-3 col-sm-2 px-auto' data-toggle='modal' data-target='#ex5' onclick='initialize(" . $counts[$j]->route_id . ")' title='Map of Whole Route'>M</button>
     <button type='button' class=' orange-gradient btn col-lg-2 col-md-3 col-sm-2 px-auto' data-toggle='modal' data-target='#ex5' onclick='currentMap(" . $counts[$j]->route_id . ")' title='Map of Current Route'>CM</button>
     <button type='button'  class='delete  red-gradient btn col-lg-2 col-md-3 col-sm-2 px-auto'  data-id='" . $counts[$j]->route_id . "' title='Delete Route'>R</button>
     <button class='reroute  orange-gradient btn col-lg-2 col-md-3 col-sm-2 px-auto' data-re=".$counts[$j]->route_id."  title='Re Route'>RR</button>
     <a class=' orange-gradient btn col-lg-2 col-md-3 col-sm-2 px-auto' target='_blank' href='../routific/route/".$counts[$j]->route_id."/history' title='Route History'>RH</a>
     </td>";
    echo "</tr>";
    $i++;
} ?>

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




    <div id="ex50" class='modal fade' role='dialog'> 
  <div class='modal-dialog map-model'>          
      <div class='modal-content'>
          <div class='modal-header'>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Map</h4>
          </div>
            <div class='modal-body'>
                    <div class="sc-iwsKbI iycaQH">
                          <div class="sc-dnqmqq bdDqgn" style="border-bottom: 1px solid rgb(236, 239, 241); border-radius: 0px; padding-top: 12px; padding-bottom: 12px;">
                                  <div class="sc-eNQAEJ cBZXtz">
                                      <div class="radio-button sc-gqjmRU fjplhj">
                                        <input class='check' type='checkbox' name='check' id="checkAll" type="radio" >
                                        <label class="sc-VigVT hFIOIT" for="unselect_all">Select All</label>
                                      </div>
                                      <button type='button'  class='rselect btn  red-gradient actBtn '  >Submit <i class='fa fa-search'></i></button>
                                  </div>
                          </div>
                          <div class="sc-dnqmqq bdDqgn">
                           <div id='mdd'> <p class="iii">No Data</p></div>
                          </div>
                    </div>
                    <div id='map50' style="width: 100%; height: 800px;" ></div>   
            </div>
      </div>
    </div>
  </div>
    <!-- /#page-wrapper -->

    <div id="ex5" class='modal fade' role='dialog'>
        <div class='modal-dialog'>

            <div class='modal-content'>
                <div class='modal-header'>
                    <h4 class='modal-title'>Map </h4>
					<p class='route-id'></p>
                </div>
                <div class='modal-body'>

                    <div id='map5' style="width: 430px; height: 380px;"></div>
                    <a class="btn black-gradient" data-dismiss="modal" aria-hidden="true">Close</a>

                </div>
            </div>
        </div>
    </div>

    <div id="ex1" class="modal" style="display: none">
        <div class='modal-dialog'>
            <div class='modal-content'>
                <form action="routes/add" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label>Date</label>
                        <input required type="date" id="date2" name="create_date" class="form-control" placeholder="Select Date">
                    </div>

                    <div class="form-group">
                    <label>Select Zone</label>
                    <select id="zone" multiple class="form-control chosen-select" name="zone[]" requried style="width: 100%;">
                        <?php 
                        $zones =  RoutingZones::where('hub_id','=',16)->whereNull('deleted_at')->get();
                        foreach ($zones as $zone) {
                            echo "<option value='" . $zone->id . "'>ZN-" . $zone->id ."</option>";
                        }
                    
                        ?>
                    </select>
            </div>

                    <!-- <div class="form-group">
                <label>Select Slots</label>
                <select id="slots" multiple class="form-control chosen-select" name="slots[]"  requried style="width: 100%;"></select>
            </div> -->

                    <div class="form-actions">
                        <button type="submit" class="btn orange-gradient">
                            Create Routes <i class="fa fa-plus"></i>
                        </button>
                        <a class="btn black-gradient" data-dismiss="modal" aria-hidden="true">Close</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="details" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-body">
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <p><strong class="order-id green"></strong></p>
                    <p><strong class="count orange"></strong></p>

                    <div id="rows"></div>
                    <div class="modal-footer">
                        <a class="btn black-gradient close-btn" data-dismiss="modal" aria-hidden="true">Close</a>
                    </div>
                </div>
            </div> 
        </div>
    </div>

<div id="transfer" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-body">
        <div class='modal-dialog'>
        <div class='modal-content'>
            <p><strong class="order-id green"></strong></p>
            <form action='../route/transfer/hub' method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <label>Please Select a driver</label>
                <select  id="joey_id"  name="joey_id" class="form-control chosen-select s">
                    <?php

                    $joeys = Joey::whereNull('deleted_at')
                    ->where('is_enabled', '=', 1)
                    ->whereNull('email_verify_token')
                    ->whereNOtNull('plan_id')
                    ->orderBy('first_name')
                    ->get();

                    foreach ($joeys as $joey) {
                        echo "<option value=" . $joey->id . ">" . $joey->first_name . " " . $joey->last_name . "(" . $joey->id . ")</option>";
                    }
                    ?>
                </select>
                <input type="hidden" name="route_id" id="route-id">
                <br>
              <div class="row d-flex">
              <a type="submit" data-selected-row="false"  onclick="transfer()" class="btn  c-c sub-ad green-gradient transfer-model-btn">Transfer</a>

<a class="btn black-gradient c-c sub-ad" data-dismiss="modal" aria-hidden="true">Close</a>
              </div>
            </form>
            </div>
        </div>
    </div>
</div>
<!-- map model -->
<div id="ex5" class='modal fade' role='dialog'> 
        <div class='modal-dialog'>
                 
                 <div class='modal-content'>
                    <div class='modal-header'>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Map</h4>
                    <p class="route-id"></p>
                    </div>
                   <div class='modal-body'>
                    
                    <div id='map5' style="width: 570px; height: 380px;" ></div>
                    <a class="btn black-gradient" data-dismiss="modal" aria-hidden="true">Close</a>
                    </div>
                   </div>    </div>
  </div>
<script type="text/javascript">
    /* Get Total Joeys Count */
    var totalJoeys ='<?php echo $total_joeys; ?>'
    console.log(totalJoeys , `totalJoeys`);
   $("#joey_count").append([totalJoeys]);
    /* Get Total Order Counts */
    var totalcounts = "<?php echo $counts_total ; ?>";
    console.log(totalcounts , `totalcounts`);
    $("#order_counts").append([totalcounts]);
    /* Get Not Delivered Counts */
    var not_delivered = "<?php echo $not_delivered ; ?>";
    console.log(not_delivered , `not_delivered`);
    $("#not-delivered").append([not_delivered]);
</script>
<script>

    // multiple popup on click with draggable
    $(document).on('click', '.multiple-details', function(e) {

        //get route id
        var routeId = this.getAttribute('data-routeid');

        // store multiple div ids in variable
        var modalId = 'mydiv-'+routeId;
        var divHeader = 'mydiv-'+routeId+'header';
        var routeDetailDivId = 'mydivroutedetail-'+routeId;
        // check modal is already open
        var existsModal = checkModalIsAlreadyOpen(modalId);
        if(existsModal == modalId){
            $.confirm({
                title: '',
                content: 'Route (R-' + routeId + ') is already open!',
                animation: 'scale',
                closeAnimation: 'scale',
                opacity: 0.5,
                buttons: {
                    ok: function () {}
                }
            });
            return false;
        }

        var div = $("#mydivpopup").find("div.mydiv");
        var marginDiv = 50;
        for (let i = 0; i < div.length; i++) {
            marginDiv += 50;
        }

        // create div modal in variable
        var modal = "<div style='margin-left: "+marginDiv+"px' onclick='divUpperOnPage("+routeId+")'>" +
            "<div id='"+modalId+"' style='position: fixed;' class='mydiv'>" +
            "<div id='"+divHeader+"' class='mydivheader' style='margin-bottom: 15px; background:#558AFC; color:white'>" +
            "Route Details (R-" + routeId + ")" +
            "<button type='button' class='close close-route-modal' data-route-id-close='"+routeId+"' data-dismiss='alert'>×</button>"+
            "</div>" +
            "<strong class='count-multi-route-"+routeId+"'></strong>"+
            "<div id='"+routeDetailDivId+"' style='overflow:scroll; height:400px; width:400px;padding: 10px;'>" +
            "</div>" +
            "</div>" +
            "</div>";

        //ajax request to get route detail
        $.ajax({
            url: '../route/' +  routeId + '/details',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var i = 0;
                var html = "";
                $("#mydivpopup").append(modal);

                $('.count-multi-route-'+routeId).text("Count : " + data.routes.length);
                data.routes.forEach(function(route) {

                    var heading = "<h4 class='route-detail-h4' style='background:#558AFC'>R-" + route.route_id +'-'+route.ordinal+ "</h4>";
                    if (route.type == 'dropoff') {
                        var sprint = "<p class='route-detail-p'>Sprint : CR-" + route.sprint_id;
                        var merchantorder = "<p class='route-detail-p'>Merchant Order Number : " + route.merchant_order_num;
                    } else {
                        var sprint = "",
                            merchantorder = "";
                    }

                    var type = "<p class='route-detail-p'>Type : " + route.type + "</p>";
                    var name = "<p class='route-detail-p'>Name : " + route.name + "</p>";
                    var phone = "<p class='route-detail-p'>Phone : " + route.phone + "</p>";
                    var email = "<p class='route-detail-p'>Email : " + route.email + "</p>";
                    var address = "<p class='route-detail-p'>Address : " + route.address + "</p>";
                    //  var arrival = "<p>Arrival Time : "+route.arrival_time+"</p>";
                    //  var finish = "<p>Finish Time : "+route.finish_time+"</p>";
                    var distance = "<p class='route-detail-p'>Distance : " + Math.round(route.distance / 1000).toFixed(2); +"KM</p>";
                    //  var duration = "<p>Duration : "+route.duration+"</p>";
                    html += heading + sprint + merchantorder + type + name + phone + email + address + distance;
                    //+duration;
                    i++;

                });

                data.exchange.forEach(function(exge) {
                    var heading = "<h4 class='route-detail-h4'>R-" + exge.route_id + "</h4>";
                    var trackingId = "<p class='route-detail-p'>Tracking Id : " + exge.tracking_id_exchange + "</p>";
                    var type = "<p class='route-detail-p'>Type : Pickup</p>";
                    var address = "<p class='route-detail-p'>Address : " + exge.dropoff_address + "</p>";
                    //  var finish = "<p>Finish Time : "+route.finish_time+"</p>";
                    // var distance = "<p>Distance : " + Math.round(route.distance / 1000).toFixed(2); +"KM</p>";
                    //  var duration = "<p>Duration : "+route.duration+"</p>";
                    html += heading + trackingId + type + address;
                });
                $('#'+routeDetailDivId).html(html);
                dragElement(document.getElementById(modalId));
            },
            error: function(request, error) {
                alert("Request: " + JSON.stringify(request));
            }
        });

        //Make the DIV element draggagle:
        function dragElement(elmnt) {
            // alert(elmnt)
            var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
            if (document.getElementById(elmnt.id + "header")) {
                /* if present, the header is where you move the DIV from:*/
                document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
            } else {
                /* otherwise, move the DIV from anywhere inside the DIV:*/
                elmnt.onmousedown = dragMouseDown;
            }

            function dragMouseDown(e) {
                e = e || window.event;
                e.preventDefault();
                // get the mouse cursor position at startup:
                pos3 = e.clientX;
                pos4 = e.clientY;
                document.onmouseup = closeDragElement;
                // call a function whenever the cursor moves:
                document.onmousemove = elementDrag;
            }

            function elementDrag(e) {
                e = e || window.event;
                e.preventDefault();
                // calculate the new cursor position:
                pos1 = pos3 - e.clientX;
                pos2 = pos4 - e.clientY;
                pos3 = e.clientX;
                pos4 = e.clientY;
                // set the element's new position:
                elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
                elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
            }

            function closeDragElement() {
                /* stop moving when mouse button is released:*/
                document.onmouseup = null;
                document.onmousemove = null;
            }
        }

    });

    $(document).on('click', '.close-route-modal', function(e) {
        var routeModalClose = this.getAttribute('data-route-id-close');
        document.getElementById("mydiv-"+routeModalClose).remove();
    });
    function checkModalIsAlreadyOpen(modalId){
        var div = $("#mydivpopup").find("div#"+modalId).attr("id");
        return div;
    }

    function divUpperOnPage(RouteId){
        var div = $("#mydivpopup").find("div.mydiv");
        var divId = "mydiv-"+RouteId;
        console.log(div.length);

        for (let i = 0; i < div.length; i++) {
            console.log(divId, div[i].id);
            // var upperDiv = $("#mydivpopup").find("div#"+divId).attr("id");
            if(divId == div[i].id){
                document.getElementById("mydiv-"+RouteId).style.zIndex = 999;
            }
            if(divId != div[i].id){
                document.getElementById(div[i].id).style.zIndex = null;
            }
        }

    }
</script>
  <script>

$(document).ready(function() {

  $('#joey_id').select2({
            dropdownParent: $("#transfer")
             });

$('#zone').select2({
    maximumSelectionLength: 1
 });
});

  	arr=['blu-blank','blu-circle','blu-diamond','blu-square','blu-stars',
      'red-blank','red-circle','red-diamond','red-square','red-stars',
      'grn-blank','grn-circle','grn-diamond','grn-square','grn-stars',
      'pink-blank','pink-circle','pink-diamond','pink-square','pink-stars',
      'purple-blank','purple-circle','purple-diamond','purple-square','purple-stars',
      'wht-blank','wht-circle','wht-diamond','wht-square','wht-stars'];
      $(document).ready(function(){
          $("map5").empty();
      });
      function Routemap(data)
{
    if(data['data'].length==1)
                        {
                            var mapmarker=1;
                        }
                        else
                        {
                            var mapmarker=0;
                        }
    var latlng;
        var geocoder;
        var directionsDisplay;
        var directionsService = new google.maps.DirectionsService();
        var map = null;
        var bounds = null;


        document.getElementById('map50').innerHTML = "";
        directionsDisplay = new google.maps.DirectionsRenderer();

        var bounds = new google.maps.LatLngBounds();

        var latlng = new google.maps.LatLng({
            lat: parseFloat(data['data'][0][0]['latitude']),
            lng: parseFloat(data['data'][0][0]['longitude'])
        });
       
        var myOptions = {
            zoom: 12,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById("map50"), myOptions);
        directionsDisplay.setMap(map);
        var infowindow = new google.maps.InfoWindow();

        var marker, i, j = 1;
        var request = {
            travelMode: google.maps.TravelMode.DRIVING
        };
        for (var i = 0; i < data['data'].length; i++) {
            for (var k = 0; k < data['data'][i].length; k++) {
          //  if (data[i]['type'] == "dropoff") {

                var latlng = new google.maps.LatLng({
                    lat: parseFloat(data['data'][i][k]['latitude']),
                    lng: parseFloat(data['data'][i][k]['longitude'])
                });
                    var a="R-"+data['data'][i][k]['route_id']+"\nCR-"+data['data'][i][k]['sprint_id']+"\n("+data['data'][i][k]['address']+")";
                bounds.extend(latlng);
                if(mapmarker==1)
                          {
                              var icon_marker="../../../../assets/images/marker/marker_red"+(k+1)+".png";
                          }
                          else
                          {
                            var icon_marker="http://maps.google.com/mapfiles/kml/paddle/"+arr[i%30]+".png";
                          }
                    var marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    icon: icon_marker,
                    //"http://maps.google.com/mapfiles/kml/paddle/"+arr[i%30]+".png",
                    //"https://assets.joeyco.com/images/marker/marker_red"+(k+1)+".png",
                    title:   "R-"+data['data'][i][k]['route_id']+"\nCR-"+data['data'][i][k]['sprint_id']+"\n("+data['data'][i][k]['address']+")"
                });
            
                
                google.maps.event.addListener(marker, 'click', (function(marker, j) {
                    return function() {
                        infowindow.setContent(marker.title);
                        infowindow.open(map, marker);
                    }
                })(marker, j));

                if (k == 0) request.origin = marker.getPosition();
                // else if (i == data['store'].length - 1) request.destination = marker.getPosition();
                else {
                    if (!request.waypoints) request.waypoints = [];
                    request.waypoints.push({
                        location: marker.getPosition(),
                        stopover: true
                    });
                }
                j++;
        //    }
            }
        }

        // zoom and center the map to show all the markers
        directionsService.route(request, function(result, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(result);
            }
        });

        map.fitBounds(bounds);
      //  google.maps.event.addDomListener(window, "load", initialize);
}


function fullmap() {
    var directionsService = new google.maps.DirectionsService();
    document.getElementById('map50').innerHTML = "";
    directionsDisplay = new google.maps.DirectionsRenderer();
    var bounds = new google.maps.LatLngBounds();
    <?php    if(empty($_REQUEST['date'])){
                                    $date= date('Y-m-d');
                                }
                                else{
                                    $date= $_REQUEST['date'];
                                }  ?>
                $.ajax({

                    url : '../../backend/allroute/0/location/joey?date=<?php echo $date; ?>',
                    type : 'GET',
                    dataType:'json',
                    success : function(data) {
                        console.log(data);
                        // initialize map center on first point
                        if(data['key'].length==1)
                        {
                            var mapmarker=1;
                        }
                        else
                        {
                            var mapmarker=0;
                        }
                        
                      
                               for(var i=0;i<data['key'].length;i++)
                            {
                                if(i==0)
                                {
                                    document.getElementById('mdd').innerHTML="";
                                }
                               
                               
                    document.getElementById('mdd').innerHTML =document.getElementById('mdd').innerHTML+"<div id='ooo'><input type='checkbox' data-id='"+data['key'][i]+"'  class='delete_check cb-element'  name='del[]'  >  <label class='sc-VigVT hFIOIT' id='"+data['key'][i]+"' for='unselect_all'>R-"+data['key'][i]+"</label></div>";
                               
                            }
                    var latlng = new google.maps.LatLng({
                        lat:parseFloat(data['data'][0][0]['latitude']),
                        lng:parseFloat(data['data'][0][0]['longitude'])
                    });
                   
            
                var myOptions = {
                    zoom: 20,
                    center: latlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };

                                map = new google.maps.Map(document.getElementById("map50"), myOptions);
                                directionsDisplay.setMap(map);
                                var infowindow = new google.maps.InfoWindow();
                                
                                var marker,k=0;
                            
                                var request = {
                                    travelMode: google.maps.TravelMode.DRIVING
                                };
                                                
                                                for(var i=0;i< data['data'].length; i++){
                                                // if(data['hub'][i]['type']=="dropoff"){
                                                    for(var j=0;j<data['data'][i].length;j++){
                                                    

                                                    var latlng = new google.maps.LatLng({lat:parseFloat(data['data'][i][j]['latitude']),
                                                    lng:parseFloat(data['data'][i][j]['longitude'])});
                                bounds.extend(latlng);
                          var a="R-"+data['data'][i][j]['route_id']+"\nCR-"+data['data'][i][j]['sprint_id']+"\n("+data['data'][i][j]['address']+")";
                          if(mapmarker==1)
                          {
                              var icon_marker="../../../../assets/images/marker/marker_red"+(j+1)+".png";
                          }
                          else
                          {
                            var icon_marker="http://maps.google.com/mapfiles/kml/paddle/"+arr[i%30]+".png";
                          }
                                var marker = new google.maps.Marker({
                                    position: latlng,
                                    map: map,
                                    icon:icon_marker,
                                    title: "R-"+data['data'][i][j]['route_id']+"\nCR-"+data['data'][i][j]['sprint_id']+"\n("+data['data'][i][j]['address']+")"
                                });
                                google.maps.event.addListener(marker, 'click', (function(marker, j) {
                                    return function() {
                                        infowindow.setContent(marker.title);
                                        infowindow.open(map, marker);
                                    }
                                    })(marker, j));

                                    if (j == 0) request.origin = marker.getPosition();
                                    // else if (i == data['store'].length - 1) 
                                    // request.destination = marker.getPosition();
                                    else {
                                    if (!request.waypoints) request.waypoints = [];
                                    request.waypoints.push({
                                        location: marker.getPosition(),
                                        stopover: true
                                    });
                                    }
                                    
                                    k++;
                                    // }
                                    }
                                 }

                                                            // zoom and center the map to show all the markers
                                directionsService.route(request, function(result, status) {
                                    if (status == google.maps.DirectionsStatus.OK) {
                                    directionsDisplay.setDirections(result);
                                    }
                                });
                                
                                map.fitBounds(bounds);
                                google.maps.event.addDomListener(window, "load", fullmap);
                                google.maps.event.trigger(map, 'resize');

                    
                        },
                        error : function(request,error)
                        {
                            
                        }
                    });
 
}

    //    $('#checkAll').click(function(){
    //       $('.delete_check').each(function(i,item){
    //           if($(this).prop('checked') == false)
    //               $(item).prop('checked',true);
    //           else
    //               $(item).prop('checked',false);
    //       })
    //   })
      
    $('#checkAll').click(function(){
    $('.cb-element').prop('checked',this.checked);
    });

    $('.cb-element').click(function(){
    if ($('.cb-element:checked').length == $('.cb-element').length){
    $('#checkall').prop('checked',true);
    }
    else {
    $('#checkall').prop('checked',false);
    }
    });

        $(".rselect").click(function(){
           
           var del_id=[];
          $('.delete_check').each(function(){
             if($(this).is(':checked')){
               var element = $(this);
               del_id.push(element.attr("data-id")); 
             }
          });
         
           if(del_id.length==0)
          {
              alert('Please Select Route Id:');
          }
          else{
           $.ajax({
               type: "POST",
               url: '../route/map/location',
               headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
               data:{ids : del_id},
               success: function(data){
              data=JSON.parse(data);
             
                Routemap(data);
           }
       });
          }
         
        
       
         });
        </script>
<script>
    
    function selectSlots(){

        $('#slots').empty().trigger("change");
       zoneId = $('#zone').val();
       $.ajax({

        url: '../zone/' + zoneId + '/slots',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            
            console.log(data);
            slots="";
            data.forEach(function(slot){
               slots+= "<option>SL-"+slot.id+"</option>";
            });
          
            $('#slots').html(slots);
               
        },
        error: function(request, error) {}
       });
    }

    function initialize(id) {
        
        $.ajax({

            url: '../route/' + id + '/map',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                // initialize map center on first point
               
                $('#ex5 .route-id').text("R-" + id);
                mapCreate(data);

            },
            error: function(request, error) {

            }
        });

    }

    function currentMap(id) {
        
        $.ajax({
            url: '../route/' + id + '/remaining',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                // initialize map center on first point
               
                $('#ex5 .route-id').text("R-" + id);
                mapCreate(data);
            },
            error: function(request, error) {}
        });
    }

    function mapCreate(data){
        var latlng;
        var geocoder;
        var directionsDisplay;
        var directionsService = new google.maps.DirectionsService();
        var map = null;
        var bounds = null;


        document.getElementById('map5').innerHTML = "";
        directionsDisplay = new google.maps.DirectionsRenderer();

        var bounds = new google.maps.LatLngBounds();

        var latlng = new google.maps.LatLng({
            lat: parseFloat(data[0]['latitude']),
            lng: parseFloat(data[0]['longitude'])
        });
        
        var myOptions = {
            zoom: 12,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById("map5"), myOptions);
        directionsDisplay.setMap(map);
        var infowindow = new google.maps.InfoWindow();

        var marker, i, j = 1;
        var request = {
            travelMode: google.maps.TravelMode.DRIVING
        };
        for (var i = 0; i < data.length; i++) {
            if (data[i]['type'] == "dropoff") {

                var latlng = new google.maps.LatLng({
                    lat: parseFloat(data[i]['latitude']),
                    lng: parseFloat(data[i]['longitude'])
                });

                bounds.extend(latlng);
                
                    var marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    icon: "../../../../assets/images/marker/marker_red"+data[i]['ordinal']+".png",
                    title:   "DRIVER"
                });
            
                
                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infowindow.setContent("CR-" + data[i]['sprint_id'] + "\n(" + data[i]['address'] + ")");
                        infowindow.open(map, marker);
                    }
                })(marker, i));

                if (i == 0) request.origin = marker.getPosition();
                // else if (i == data['store'].length - 1) request.destination = marker.getPosition();
                else {
                    if (!request.waypoints) request.waypoints = [];
                    request.waypoints.push({
                        location: marker.getPosition(),
                        stopover: true
                    });
                }
                j++;
            }
            else{
                var latlng = new google.maps.LatLng({
                    lat: parseFloat(data[i]['latitude']),
                    lng: parseFloat(data[i]['longitude'])
                });

                bounds.extend(latlng);
                
                    var marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    icon: "../../../../assets/images/map/pins/big/default.png",
                    title:   "DRIVER"
                });
            
                
                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infowindow.setContent(data[i]['address']);
                        infowindow.open(map, marker);
                    }
                })(marker, i));

                if (i == 0) request.origin = marker.getPosition();
                // else if (i == data['store'].length - 1) request.destination = marker.getPosition();
                else {
                    if (!request.waypoints) request.waypoints = [];
                    request.waypoints.push({
                        location: marker.getPosition(),
                        stopover: true
                    });
                }
                j++;
            }
        }

        // zoom and center the map to show all the markers
        directionsService.route(request, function(result, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(result);
            }
        });

        map.fitBounds(bounds);
        google.maps.event.addDomListener(window, "load", initialize);
    }

   


    $(document).on('click', '.details', function(e) {

        e.preventDefault();

        var routeId = this.getAttribute('data-route-id');
        var joeyId = this.getAttribute('data-joey-id');


        $.ajax({

            url: '../route/' +  routeId + '/details',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var i = 0;
                var html = "";

                $('#details .count').text("Count : " + data.routes.length);

                data.routes.forEach(function(route) {

                    var heading = "<h4>R-" + route.route_id +'-'+route.ordinal+ "</h4>";
                    if (route.type == 'dropoff') {
                        var sprint = "<p>Sprint : CR-" + route.sprint_id;
                        var merchantorder = "<p>Merchant Order Number : " + route.merchant_order_num;
                    } else {
                        var sprint = "",
                            merchantorder = "";
                    }

                    var type = "<p>Type : " + route.type + "</p>";
                    var name = "<p>Name : " + route.name + "</p>";
                    var phone = "<p>Phone : " + route.phone + "</p>";
                    var email = "<p>Email : " + route.email + "</p>";
                    var address = "<p>Address : " + route.address + "</p>";
                    //  var arrival = "<p>Arrival Time : "+route.arrival_time+"</p>";
                    //  var finish = "<p>Finish Time : "+route.finish_time+"</p>";
                    var distance = "<p>Distance : " + Math.round(route.distance / 1000).toFixed(2); +"KM</p>";
                    //  var duration = "<p>Duration : "+route.duration+"</p>";
                    html += heading + sprint + merchantorder + type + name + phone + email + address + distance;




                    //+duration;
                    i++;
                });

                data.exchange.forEach(function(exge) {
                    var heading = "<h4>R-" + exge.route_id + "</h4>";
                    var trackingId = "<p>Tracking Id : " + exge.tracking_id_exchange + "</p>";
                    var type = "<p>Type : Pickup</p>";
                    var address = "<p>Address : " + exge.dropoff_address + "</p>";
                    //  var finish = "<p>Finish Time : "+route.finish_time+"</p>";
                    // var distance = "<p>Distance : " + Math.round(route.distance / 1000).toFixed(2); +"KM</p>";
                    //  var duration = "<p>Duration : "+route.duration+"</p>";
                    html += heading + trackingId + type + address;
                });

                $('#rows').html(html);
            },
            error: function(request, error) {
                alert("Request: " + JSON.stringify(request));
            }
        });

        $('#details').show();
        $('#details .order-id').text("R-" + routeId);

        return false;
    });
    $('.close-btn').on('click',function(){
        $('#details').hide();
    });
    $(document).on('click', '.transfer', function(e) {

        e.preventDefault();

        var routeId = this.getAttribute('data-route-id');
        $('#route-id').val(routeId);

        $('#transfer').modal();
        $('#transfer .order-id').text("R-" + routeId);

        return false;
    });


    function transfer() {
            let joey_id = $('#joey_id').val();
            let route_id = $('#route-id').val()
            //alert(joey_id+'---'+route_id);


            if(joey_id  == 'undefined'){
                alert('please select the joey');
            }
            else{

                $.ajax({
                    type: "POST",
                    url: '../route/transfer/hub',
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    data:{joey_id : joey_id,route_id:route_id},
                    success: function (data) {
                      // alert('data='+data)
                        if(data.status)
                        {
                            $('.route-tbl-tr-'+data.body.route_id).find('.routes-td-joye-name').val('update');
                            alert('Your route has been updated '+data.body.route_id+' please refresh your page to see changes')
                        }
                        else
                        {
                            alert('error');
                        }

                    },
                    error: function (error) {
                    }
                });
            }



        }


    function pageReload() {
        location.reload();
    }

    $( document ).ready(function() {
    window.onclick = function(event) {       
               $('#details').modal('hide');
    }
});

$( document ).ready(function() {
    setTimeout(() => {   i=$('#datatable').DataTable().rows()
    .data().length;
    console.log(i);
 
if(i!=0)
{
    $(".right_col").css({"min-height": "auto"});
} }, 1000);   
});
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBX0Z04xF9br04EGbVWR3xWkMOXVeKvns8"></script>

@endsection
