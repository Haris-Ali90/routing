<?php 
use App\Joey;
use App\Vehicle;
use App\SlotsPostalCode;
use App\SprintConfirmation;
use App\RouteTransferLocation;

$status_show = array("136" => "Client requested to cancel the order",
    "137" => "Delay in delivery due to weather or natural disaster",
    "118" => "left at back door",
    "117" => "left with concierge",
    "135" => "Customer refused delivery",
    "108" => "Customer unavailable-Incorrect address",
    "106" => "Customer unavailable - delivery returned",
    "107" => "Customer unavailable - Left voice mail - order returned",
    "109" => "Customer unavailable - Incorrect phone number",
    "103" => "Delay at pickup",
    "114" => "Successful delivery at door",
    "113" => "Successfully hand delivered",
    "120" => "Delivery at Hub",
    "110" => "Delivery to hub for re-delivery",
    "111" => "Delivery to hub for return to merchant",
    "121" => "Out for delivery",
    "102" => "Joey Incident",
    "140" => "Delivery missorted, may cause delay",
    // "104" => "Damaged on road - delivery will be attempted",
    "143" => "Damaged on road - undeliverable",
    "105" => "Item damaged - returned to merchant",
    "129" => "Joey at hub",
    "128" => "Package on the way to hub",
    "116" => "Successful delivery to neighbour",
    "132" => "Office closed - safe dropped",
    "101" => "Joey on the way to pickup",
    "124" => "At hub - processing",
    "112" => "To be re-attempted",
    "131" => "Office closed - returned to hub",
    "125" => "Pickup at store - confirmed",
    "133" => "Packages sorted",
    "141" => "Lost package",
    '153' => 'Miss sorted to be reattempt',
    '154' => 'Joey unable to complete the route', '155' => 'To be re-attempted tomorrow');
?>

@extends( 'backend.layouts.app' )

@section('title', 'Order Details')

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
.half-sec{
      width:50%;
      float:left;
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
    padding: 5px 15px;
    border-bottom: 1px solid #e5e5e5;
    background: #c6dd38;
}

.form-group {
    width: 100%;
    margin: 10px 0;
    padding: 0 15px;
}
/*.form-group input, .form-group select {
    width: 65% !important;
    height: 30px;
}*/
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
}
.addMoresec {
    text-align: right;
    padding: 0 50px;
}
.panel {
  padding: 0 18px;
  display: none;
  background-color: white;
  overflow: hidden;
}
span.lbl {
    color: #000;
}
#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content, #caption {  
  animation-name: zoom;
  animation-duration: 0.6s;
}

@keyframes zoom {
  from {transform: scale(0.1)} 
  to {transform: scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}

tr.reattemptrow {
    background: #c6dd38 !important;
    color: #555;
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
            <div class="page-title">
                <div class="title_left amazon-text">
                    <h3>Order Details <small></small></h3>
                </div>
            </div>

            <div class="clearfix"></div>
            @include( 'backend.layouts.notification_message' )
            <div class="clearfix"></div>
            {{--@include('backend.layouts.modal')
            @include( 'backend.layouts.popups')--}}
            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">

                        <div class="x_content">

    <?php foreach($data as $response){

      // dd($response);

         ?>
     
        <h2 style="background: #e36d24;padding: 10px 5px;color: #fff;"><?php echo "CR-".$response->sprint_id;?></h2>
        
        <?php
        echo "<div class='half-sec'>";
        echo "<h5><span class='lbl'>Tracking Id</span> : ".$response['tracking_id']."</h5>";
        echo "<h5><span class='lbl'>Merchant Order Num</span> : ".$response['merchant_order_num']."</h5>";
        if(!empty($response['route_id']))
        {
          $route_transfer=RouteTransferLocation::where('new_route_location_id','=',$response['route_location_id'])->first();
                           
          if($route_transfer!=null)
          {
             
               echo "<td>R-".$route_transfer->old_route_id."-".$route_transfer->old_ordinal."</td>";

          }
          else
          {
               echo "<h5><span class='lbl'>Route No</span> :".$response['route_id']."-".$response['stop_number']."</h5>";   
           
          }
        
        }
        else
        {
          echo "<h5><span class='lbl'>Route No</span> :</h5>";
        }
        echo "<h5><span class='lbl'>Customer Name</span> : ".$response->name."</h5>";
        echo "<h5><span class='lbl'>Customer Phone</span> : ".$response->phone."</h5>";
        echo "<h5><span class='lbl'>Customer Email</span> : ".$response->email."</h5>";
        if(!empty($response->address_line2))
             $show_address = $response->address_line2;
        else
            $show_address = $response->address;
                                        
        echo "<h5><span class='lbl'>Customer Address</span> : ".$show_address."</h5>";


        $order_image = \App\OrderImage::where('tracking_id', $response['tracking_id'])->whereNull('deleted_at')->orderBy('id','asc')->get();
        if(!empty($order_image))
        {

            echo "<h5><span class='lbl'>Additional Image </span> </h5>";
            foreach($order_image as $img){
            echo "<img id='myImg' src='".$img->image."' onclick='ShowLightBox(this)'alt='CR-".$response->sprint_id."' width='300' height='200' style='box-sizing: border-box;
                max-width: 100%;
                max-height: 100%;margin: 4px;'
                >";
        }
        }

        echo "</div>";
        echo "<div class='half-sec'>";
        $statuses = array_merge($response['status'],$response['status1'],$response['status2']
    );
        $sort_key = array_column($statuses, 'created_at');
        $sort_id_key = array_column($statuses, 'id');
        array_multisort($sort_key, SORT_ASC, $statuses);
            if(!empty($response->joey_id))
            {
              echo "<h5><span class='lbl'>Joey</span> : ".$response->joey_firstname." ".$response->joey_lastname." (".$response->joey_id.")</h5>";
            }
            else
            {
              echo "<h5><span class='lbl'>Joey</span> : </h5>";
            } 
            echo "<h5><span class='lbl'>Joey Contact</span> : ".$response['joey_contact']."</h5>";
            echo "<h5><span class='lbl'>Merchant</span> : ".$response->vendor_name."</h5>";
            if (array_intersect([ 17, 113, 114, 116, 117, 118, 132, 138, 139, 144, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 131, 135, 136], $sort_id_key))
           {
            $image=SprintConfirmation::where('task_id','=',$response['id'])->whereNotNull('attachment_path')->orderBy('id','desc')->first();
            if(!empty($image))
            {
            //     echo "<a target='_blank' href=src='../".$image->attachment_path."' >
            //     <img src='".$image->attachment_path."' alt='".$response['sprint_id']."' style='width:150px'>
            //   </a>";
           echo "<h5><span class='lbl'>Image </span> </h5> <img id='myImg' onclick='ShowLightBox(this);' src='".$image->attachment_path."' alt='CR-".$response['sprint_id']."' width='300' height='200' style='box-sizing: border-box;
    max-width: 100%;
    max-height: 100%;' >";
             
            }
            }
          echo "</div>";
        ?>
        <h5 style="clear:both;text-align:left" class="accordion"><button  style="margin-top: 6px;" class="btn btn-xs orange-gradient color:#000 !important;">Status History
        <i class="fa fa-angle-down"></i></button></h5>
      <table id="main"  class="table table-striped table-bordered panel">
        
        <thead>
        <tr>
            <th id="main" >Code</th>
            <th id="main">Description</th>
            <th id="main" >Date</th>
        </tr>
        </thead>

        <tbody>
        <?php
       // dd($response);
           
            
            //  foreach ($statuses as $status){
            //    echo "<tr>";
            //    echo "<td>".$status['id']."</td>";
            //    echo "<td>".$status['description']."</td>";
            //    echo "<td>".$status['created_at']."</td>"; 
            //    //echo "<td>20".date("y-m-d h:i:s",strtotime($status['created_at']."- 4 hours"))."</td>"; 
            //    echo "</tr>";
            //  }

            $firstattempt=[];
            $secondattempt=[];
            $thirdattempt=[];
            
            if(!empty($response['status2'])){
              
              $firstattempt = $response['status2'];
              $secondattempt = $response['status'];
              $thirdattempt = $response['status1'];
          
            }
            else if(!empty($response['status'])){
              $firstattempt = $response['status'];
              $secondattempt = $response['status1'];
            }
            else{
              $firstattempt = $response['status1'];
            }


              echo "<tr class='reattemptrow'>";
              echo "<td colspan='3'><strong>First Attempt</strong></td>";
              echo "</tr>";
              foreach ($firstattempt as $status){
               echo "<tr>";
               echo "<td>".$status['id']."</td>";
               echo "<td>".$status['description']."</td>";
            //   echo "<td>".$status['created_at']."</td>"; 
               echo "<td>20".date("y-m-d h:i:s",strtotime($status['created_at']."+5 hours"))."</td>"; 
               echo "</tr>";
             }
             if( $secondattempt)
             {
              echo "<tr class='reattemptrow'>";
              echo "<td colspan='3'><strong>Second Attempt</strong></td>";
              echo "</tr>";
             }
           
             foreach ( $secondattempt as $status){
               if($status['id']==125 || $status['id']==61){
                 continue;
               }
              echo "<tr>";
              echo "<td>".$status['id']."</td>";
              echo "<td>".$status['description']."</td>";
              echo "<td>".date("y-m-d h:i:s",strtotime($status['created_at']."+5 hours"))."</td>"; 
              echo "</tr>";
            }
            if($thirdattempt)
            {
             echo "<tr class='reattemptrow'>";
            
             echo "<td colspan='3'><strong>Third Attempt</strong></td>";
           
             echo "</tr>";
            }
            foreach ( $thirdattempt  as $status){
              if($status['id']==125 || $status['id']==61){
                continue;
              }
              echo "<tr>";
              echo "<td>".$status['id']."</td>";
              echo "<td>".$status['description']."</td>";
              echo "<td>".date("y-m-d h:i:s",strtotime($status['created_at']."+5 hours"))."</td>"; 
              echo "</tr>";
            }




//  if(isset($response['status2'])){
//                       foreach ($response['status2'] as $key => $status){
//                       echo "<tr>";
//                       echo "<td>".$status['id']."</td>";
//                       echo "<td>".$status['description']."</td>";
//                       echo "<td>".date("Y-m-d H:i:s", strtotime($status['created_at']) )."</td>";
//                       //echo "<td>20".date("y-m-d h:i:s",strtotime($status['created_at']."- 4 hours"))."</td>";
//                       echo "</tr>";
//                       }
//                       }
//                       if(isset($response['status'])){
//                       foreach ($response['status'] as $key => $status){
//                       echo "<tr>";
//                       echo "<td>".$status['id']."</td>";
//                       echo "<td>".$status['description']."</td>";
//                       echo "<td>".date("Y-m-d H:i:s", strtotime($status['created_at']) )."</td>";
//                       //echo "<td>20".date("y-m-d h:i:s",strtotime($status['created_at']."- 4 hours"))."</td>";
//                       echo "</tr>";
//                       }
//                       }
//                       if(isset($response['status1'])){
//                       foreach ($response['status1'] as $key => $status){
//                       echo "<tr>";
//                       echo "<td>".$status["id"]."</td>";
//                       echo "<td>".$status['description']."</td>";
//                       echo "<td>".$status['created_at']."</td>";
//                       //echo "<td>20".date("y-m-d h:i:s",strtotime($status['created_at']."- 4 hours"))."</td>";
//                       echo "</tr>";

//                       }
//                       }
         ?>
        </tbody> 
      </table>

      <h5 style="clear:both;text-align:left" class="accordionnew">
        <button class="btn btn-xs orange-gradient color:#000 !important;">Manual Status
            History
            <i class="fa fa-angle-down"></i></button>
    </h5>
    <div class="table-responsive" style="display: none">
      <table id="main" class="table table-striped table-bordered panel" style="display: inline-table;    overflow-x: visible;">

          <thead>
          <tr>
              <th id="main"  style="width: 10%">Tracking #</th>
              <th id="main" style="width: 20%">Status</th>
              <th id="main" style="width: 10%">Image</th>
              <th id="main" style="width: 20%">Reason</th>
              <th id="main" style="width: 15%">User</th>
              <th id="main" style="width: 10%">Domain</th>
              <th id="main" style="width: 10%">Created At</th>

        


          </tr>
          </thead>
          @if (count($manualHistory) > 0)
              @foreach ($manualHistory as $manualValue)
                  <tr>
                      <td>{{$manualValue->tracking_id}}</td>
                      <td>{{$manualValue->status_id}}</td>
                      <td>
                          @if($manualValue->attachment_path!='')
                              <img onClick="ShowLightBox(this);" style="width:50px;height:50px" src ="{{$manualValue->attachment_path}}" />
                          @endif
                      </td>
                      <td>{{$manualValue->reason_id}}</td>
                      <td>{{$manualValue->user_id}}</td>
                      <td>{{$manualValue->domain}}</td>
                      <td>{{date("y-m-d h:i:s",strtotime($manualValue->created_at."+5 hours"))}}</td>

                  </tr>
              @endforeach
          @else
          <tr>
              <td class="text-center " colspan="7">No data...</td>
          </tr>    
          @endif
          <tbody>
        
          </tbody>
      </table>
    </div> 


            <h2 style="background: #e36d24;padding: 10px 5px;color: #fff;">Upload Image</h2>
                {!! Form::open( ['url' => ['backend/sprint/image/upload'], 'files'=> true , 'method' => 'POST', 'class' => 'form-horizontal form-label-left', 'role' => 'form']) !!}

                {{ Form::hidden('sprint_id',$response->sprint_id, ['class' => 'form-control col-md-7 col-xs-12']) }}
                {{ Form::hidden('creator_id',$response->creator_id, ['class' => 'form-control col-md-7 col-xs-12']) }}
                {{ Form::hidden('contact_id',$response->contact_id, ['class' => 'form-control col-md-7 col-xs-12']) }}
                <div class="form-group{{ $errors->has('sprint_image') ? ' has-error' : '' }}">
                    {{ Form::label('sprint_image', 'Image', ['class'=>'control-label-sm col-md-3 col-sm-3 col-xs-12']) }}
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="file" name="sprint_image"
                               class="form-control col-md-7 col-xs-12" required>
                    </div>
                    @if ( $errors->has('sprint_image') )
                        <p class="help-block">{{ $errors->first('sprint_image') }}</p>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('status_id') ? ' has-error' : '' }}">
                    {{ Form::label('status_id', 'Status', ['class'=>'control-label-sm col-md-3 col-sm-3 col-xs-12']) }}
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <select id="status_id" name="status_id"
                                class='form-control col-md-7 col-xs-12' required>
                            <option value="">Please Select Status</option>
                            <?php
                            foreach($status_show as $key => $oc){ ?>
                            <option value="<?php echo $key ?>">
                                <?php echo $oc ?></option>
                            <?php }
                            ?>

                        </select>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('reason_id') ? ' has-error' : '' }}">
                    {{ Form::label('reason_id', 'Reason', ['class'=>'control-label-sm col-md-3 col-sm-3 col-xs-12']) }}
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <select id="reason_id" name="reason_id"
                                class='form-control col-md-7 col-xs-12' required>
                            <option value="">Please Select Reason</option>
                            <?php
                            foreach($reasons as $reason){ ?>
                            <option value="<?php echo $reason->id ?>">
                                <?php echo $reason->title ?></option>
                            <?php }
                            ?>

                        </select>
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        {{ Form::submit('Save Image', ['class' => 'btn btn-primary']) }}
                    </div>
                </div>
        {!! Form::close() !!}
     <?php 
     } 
     ?>



                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>
    <!-- /#page-wrapper -->
    <!-- The Modal -->
<div id="myModal" class="modal">
  <span onclick="closeimg();" class="close">&times;</span>
  <img class="modal-content" id="img01"  style="height: 600px;" >
  <div id="caption"></div>
</div>

<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.display === "inline-table") {
      panel.style.display = "none";
    } else {
      panel.style.display = "inline-table";
    }
  });
}

        var acc2 = document.getElementsByClassName("accordionnew");
        var j;

        for (j = 0; j < acc2.length; j++) {
            acc2[j].addEventListener("click", function () {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.display === "block") {
                    panel.style.display = "none";
                } else {
                    panel.style.display = "block";
                }
            });
        }

</script>
<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the image and insert it inside the modal - use its "alt" text as a caption
//var img = document.getElementsByClassName('myImg');
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
  modal.style.display = "none";
}


  function ShowLightBox(el) {

    // get current  img src
    let img_src = el.src;
    // create html
    // let html = '<div id="custom-light-box-model" class="modal">';
    // html+=' <span class="custom-light-box-model-close-btn" onClick="CloseLightBox()">X</span>';
    // html+=' <img src="'+img_src+ '" class="custom-light-box-model-img" id=""> ';
    // html+=' </div> ';

    // appending html
    // document.getElementsByTagName("body")[0].insertAdjacentHTML("beforeend",
    //     html );
    modal.style.display = "block";
    modalImg.src = img_src;
    captionText.innerHTML = el.alt;
  }
  function closeimg(){
    modal.style.display = "none";
  }
</script>



@endsection