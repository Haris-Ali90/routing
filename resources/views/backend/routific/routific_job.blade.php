<?php 
use App\Joey;
use App\Vehicle;
use App\SlotsPostalCode;


if(!isset($_REQUEST['date']) || empty($_REQUEST['date'])){
    $date = "20".date('y-m-d');
}
else {
    $date = $_REQUEST['date'];
}

?>
@extends( 'backend.layouts.app' )

@section('title', 'Routifc Jobs Panel')

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
    background: #3d58bc;
    background: -moz-linear-gradient(top, #3d58bc 0%, #3d58bc 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#3d58bc), color-stop(100%,#3d58bc));
    background: -webkit-linear-gradient(top, #3d58bc 0%,#3d58bc 100%);
    background: linear-gradient(to bottom, #3d58bc 0%,#3d58bc 100%);
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
/* .modal-dialog {
    width: 94%;
} */

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
    padding: 5px 15px;
    border-bottom: 1px solid #e5e5e5;
    background: #c6dd38;
}
/*button.button.orange-gradient {
    border: none;
    line-height: 12px;
    display: inline-block;
    margin: 0;
    border-radius: 4px;
    padding: 8px 20px;
    color: #fff;
    background: #e46d24;
}*/
.form-group {
    width: 100%;
    margin: 10px 0;
    padding: 0 15px;
}
.form-group input, .form-group select {
    width: 80% !important;
    height: 30px;
}
.form-group label {
    width: 25%;
    float: left;
    clear: both;
}
input#date {
    height: 30px;
    width: 194px;
}



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


/* start */
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
.route-details {
    padding: 20px;
}

.route-details h3 {
    background: rgb(86, 102, 108);
    color: white;
    padding: 10px;
    font-size: 18px;
    font-weight: 600;
}
.route-details h4 {
    color: #3d58bc;
    font-size: 14px;
    font-weight: 600;
}
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
                    <!-- <h3>Routific Jobs<small></small></h3> -->
                </div>
            </div>

            <div class="clearfix"></div>
           
            {{--@include('backend.layouts.modal')
            @include( 'backend.layouts.popups')--}}
            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Routific Jobs</h2>
                        <form id="filter"  style="padding: 10px;" action="<?php echo "../../routific/".$id."/job"?>" method="get">  
           <div class="row d-flex baseline">
      <div class="col-lg-3">
      <div class="form-group">
                <label >Search By Date :</label>
            <input id="date" name="date"  type="date" placeholder="date "   value='{{$date}}' class="form-control">
            </div>
      </div>
               <div class="col-lg-6">
               <button  id="search" type="submit" class="btn sub-ad btn-primary" style="margin:16px 0px 0px 0px !important">Filter</button>
               </div>
           </div>
                
            </form>
         
           
                            <div class="clearfix"></div>
                        </div>


                        <div class="x_content">

                         @include( 'backend.layouts.notification_message' )

	                <div class="table-responsive">
	                    <table id="datatable" class="table table-striped table-bordered">
	                      <thead stylesheet="color:black;">
	                      		<tr>
                                    <th>Id</th>
                                    <th>Job Id</th>
                                    <th>Zone</th>
                                    <th>Status</th>
                                    <th>Action</th>
	                      		</tr>
	                      </thead>
                          <tbody>
                          @if(count($datas)==0)
                         
                            <tr class="odd"><td valign="top" colspan="9" class="dataTables_empty">No data available in table</td></tr>
                        
                          @else
                                {{--*/ $i = 1 /*--}}
                                @foreach( $datas as $record )
                                    <tr class="">
                                        <td>{{ $i }}</td>
                                        <td>{{ $record->job_id }}</td>
                                        <td>{{ ucfirst($record->title) }}</td>
                                        <td>{{ ucfirst($record->status) }}</td>
                                        <td>
                                        @if($record->status!='finished' && $record->is_custom_route!='0')
                                        <button type='button'  class='createCustom btn  green-gradient actBtn ' data-id="{{$record->job_id}}" >Create Custom Route <i class='fa fa-eye'></i></button>
                                        @elseif($record->status!='finished'&& $record->is_custom_route!='1')
                                        <button type='button'  class='create btn  green-gradient actBtn ' data-id="{{$record->job_id}}" >Create Route <i class='fa fa-eye'></i></button>
                                        @endif
                                        <!--<button class='details btn  orange-gradient actBtn ' data-id="{{$record->job_id}}">Details</button>-->
                                        <!--<button type='button'  class='dselect btn btn green-gradient actBtn' data-toggle='modal' data-target='#ex50' onclick="fullmap('{{$record->job_id}}')" >Map <i class='fa fa-map'></i></button>-->
                                        <button type='button'  class='delete btn  red-gradient actBtn ' data-id="{{$record->id}}" >Delete <i class='fa fa-trash'></i></button>
                                            
                                        </td>
                                    </tr>
                                    {{--*/ $i++ /*--}}
                                @endforeach
                            @endif
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
                                <!-- <div class="sc-dnqmqq bdDqgn" style="border-bottom: 1px solid rgb(236, 239, 241); border-radius: 0px; padding-top: 12px; padding-bottom: 12px;">
                                        <div class="sc-eNQAEJ cBZXtz">
                                            <div class="radio-button sc-gqjmRU fjplhj">
                                                <input class='check' type='checkbox' name='check' id="checkAll" type="radio" >
                                                <label class="sc-VigVT hFIOIT" for="unselect_all">Select All</label>
                                            </div>
                                            <button type='button'  class='rselect btn  red-gradient actBtn '  >Submit <i class='fa fa-search'></i></button>
                                        </div>
                                </div> -->
                                <div class="sc-dnqmqq bdDqgn">
                                <div id='mdd'></div>
                                </div>
                            </div>
                            <div id='map50' style="width: 100%; height: 800px;" ></div>   
                    </div>
            </div>
        </div>
    </div>


  
    <!-- CreateSLotsModal -->
    

    <!-- UpdateSLotModal -->
                 <!-- DeleteSlotsModal -->

    <div id='map50' style="width: 100%; height: 800px;" ></div>

   <div id="ex4" class="modal" style="display: none">
        <div class='modal-dialog'>
            <div id="delteform">
            </div>
            <div id="detailpopup">
            </div>
        </div>
    </div>

    <div id="ex6" class="modal" style="display: none">
        <div class='modal-dialog'>
          <div id='main_form'>
        </div>
        </div>
    </div>





<script type="text/javascript">

$(function() {
$(".create").click(function(){
var element = $(this);
var del_id = element.attr("data-id");
document.getElementById('main_form').innerHTML ="<div class='modal-content'><div class='modal-header'><button type='button' class='close' data-dismiss='modal'>&times;</button><h4 class='modal-title'>Create Route</h4></div><form action='../../create/"+del_id+"/route' method='get'><div class='form-group'><p><b>Are you sure you want to pull these routes?</b></p></div><div class='form-group'><button type='submit' class='btn green-gradient btn-xs' >Yes</button><button type='button' class='btn red-gradient btn-xs' data-dismiss='modal' >No</button></div>  </form></div>";

$('#ex6').modal();
});
});



$(function() {
    $(".createCustom").click(function(){
        var element = $(this);
        var del_id = element.attr("data-id");
        document.getElementById('main_form').innerHTML ="<div class='modal-content'><div class='modal-header'>" +
            "<button type='button' class='close' data-dismiss='modal'>&times;</button><h4 class='modal-title'>Create Route</h4></div>" +
            "<form action='../../createCustom/"+del_id+"/route' method='get'><div class='form-group'><p><b>Are you sure you want to pull these routes?</b></p></div>" +
            "<div class='form-group'><button type='submit' class='btn green-gradient btn-xs' >Yes</button>" +
            "<button type='button' class='btn red-gradient btn-xs' data-dismiss='modal' >No</button>" +
            "</div>  " +
            "</form></div>";

        $('#ex6').modal();
    });
});


$(function() {
    $(".delete").click(function(){
        var element = $(this);
        var del_id = element.attr("data-id");
        document.getElementById('delteform').innerHTML ="<div class='modal-content'><div class='modal-header'><button type='button' class='close' data-dismiss='modal'>&times;</button><h4 class='modal-title'>Delete Route</h4></div><form action='../../routific/job/delete' method='post'><input type='hidden' name='_token' value='{{ csrf_token() }}'><input type='hidden' name='delete_id' value="+del_id+"><div class='form-group'><p><b>Are you sure you want to delete this?</b></p></div><div class='form-group'> <button type='submit' class='btn green-gradient btn-xs' >Yes</button><button type='button' class='btn red-gradient btn-xs' data-dismiss='modal' >No</button></div></form></div>";

        $('#ex4').modal();
    });

    $(".details").click(function(){
        var element = $(this);
        var id = element.attr("data-id");

        $.ajax({
            type: "GET",
            url: '../job/details/'+id,
            success: function(response){   
                //$.alert(message);
                var routes="";
                response.routes.forEach((value, index) => {
                    routes += "<h3>Route - "+parseInt(index+1)+"</h3><p>Total Distance: "+Math.round(value.summary.distance,2)+"</p><p>Route Start Time: "+convertMinutesToHours(value.summary.begin_time)+"</p><p>Route End Time: "+convertMinutesToHours(value.summary.end_time)+"</p><p>Total Dropoffs: "+value.summary.dropoff_quantity+"</p>"; 
                    value.stops.forEach((routelist, index) => {
                        if(index > 0){
                            routes+= "<hr><h4>STOP #"+index+"</h4><p>Arrival Time: "+convertMinutesToHours(routelist.arrival_time)+"</p><p>Finish Time: "+convertMinutesToHours(routelist.depart_time)+"<p>Postal Code: "+routelist.geometry.zipcode+"</p></p>";
                        }
                        
                    });

                });
                console.log(routes);
                document.getElementById('detailpopup').innerHTML ="<div class='modal-content'><div class='modal-header'><button type='button' class='close' data-dismiss='modal'>&times;</button><h4 class='modal-title'>Job Details</h4></div><div class='modal-body'>Status: "+response.status+"<br>Total Routes: "+response.plan_summary.num_routes+"<br>Total Assigned Orders: "+response.plan_summary.assigned+"<br>Total Unserved: "+response.plan_summary.unassigned+"</div><div class='route-details'>"+routes+"</div></div>";
            }
        });
        $('#ex4').modal();
    });

});

        function convertMinutesToHours(minutes) {
            var hours = Math.floor(minutes / 60);
            var remainingMinutes = Math.round(minutes % 60);

            if (remainingMinutes.toString().length == 1) {
                remainingMinutes = "0" + remainingMinutes;
            }

            return hours + ":" + remainingMinutes;
        }

        function fullmap(jobId) {

            arr=['blu-blank','purple-square','blu-diamond','blu-square','blu-stars',
      'red-blank','red-circle','red-diamond','red-square','red-stars',
      'grn-blank','grn-circle','grn-diamond','grn-square','grn-stars',
      'pink-blank','pink-circle','pink-diamond','pink-square','pink-stars',
      'purple-blank','purple-circle','purple-diamond','purple-square','purple-stars',
      'wht-blank','wht-circle','wht-diamond','wht-square','wht-stars'];

            var directionsService = new google.maps.DirectionsService();
            document.getElementById('map50').innerHTML = "";
            directionsDisplay = new google.maps.DirectionsRenderer();
            var bounds = new google.maps.LatLngBounds();
            
                <?php    
                    if(empty($_REQUEST['date'])){
                        $date= date('Y-m-d');
                    }
                    else{
                        $date= $_REQUEST['date'];
                    }  ?>

                $.ajax({

                    url : '../../routific/job/details/'+jobId,
                    type : 'GET',
                    dataType:'json',
                    success : function(data) {
                        console.log(data);
                        var mapmarker=0;
                        
                        for(var i=0;i<data['routes'].length;i++)
                        {
                            
                            document.getElementById('mdd').innerHTML =document.getElementById('mdd').innerHTML+"<div id='ooo'><input type='checkbox' data-id='Route-"+i+"'  class='delete_check cb-element'  name='del[]'  >  <label class='sc-VigVT hFIOIT' id='Route-"+i+"' for='unselect_all'>Route-"+i+"</label></div>";
                        }

                        var latlng = new google.maps.LatLng({
                            lat:parseFloat(data['routes'][0]['stops'][0]['geometry']['lat']),
                            lng:parseFloat(data['routes'][0]['stops'][0]['geometry']['lon'])
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
                                                
                        for(var i=0;i< data['routes'].length; i++){
        
                            for(var j=0;j<data['routes'][i]['stops'].length;j++){

                                    var latlng = new google.maps.LatLng({lat:parseFloat(data['routes'][i]['stops'][j]['geometry']['lat']),
                                    lng:parseFloat(data['routes'][i]['stops'][j]['geometry']['lon'])});
                                    console.log(latlng);
                                    bounds.extend(latlng);

                                    // var a="R-"+data['data'][i][j]['route_id']+"\nCR-"+data['data'][i][j]['sprint_id']+"\n("+data['data'][i][j]['address']+")";
                                    if(mapmarker==1)
                                    {
                                        var icon_marker="https://assets.joeyco.com/images/marker/marker_red"+(j+1)+".png";
                                    }
                                    else
                                    {
                                        var icon_marker="http://maps.google.com/mapfiles/kml/paddle/"+arr[i%30]+".png";
                                    }

                                    var marker = new google.maps.Marker({
                                        position: latlng,
                                        map: map,
                                        icon:icon_marker,
                                        title: "Route-"+i+"-"+j+" ("+data['routes'][i]['stops'][j]['id']+") "
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

    </script>
  
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTK4viphUKcrJBSuoidDqRhVA4AWnHOo0"></script>

@endsection