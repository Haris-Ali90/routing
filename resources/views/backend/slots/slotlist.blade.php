<?php 
use App\Joey;
use App\Vehicle;
use App\SlotsPostalCode;
use App\Slots;
use App\Sprint;

?>
@extends( 'backend.layouts.app' )

@section('title', 'Slots')

@section('CSSLibraries')
    <!-- DataTables CSS -->
    <link href="{{ backend_asset('libraries/datatables-plugins/dataTables.bootstrap.css') }}" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="{{ backend_asset('libraries/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">
    <!-- Image Viewer CSS -->
    <link href="{{ backend_asset('libraries/galleria/colorbox.css') }}" rel="stylesheet">
<style>
.modal{
    top:30%;
}    

.line input {
    border: 2px solid #ccc;
}

div#add_words .line{
    padding: 10px;
    background: #df6a2745;
    color: #e66e29;
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


/* .active, .accordion:hover {
  background-color: #ccc;
} */
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
    width: 85%;
    float: left;
    list-style: decimal;
}
input#inputs {
    padding: 10px;
    border: 2px solid #ccc;
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
                 
                </div>
            </div>

            <div class="clearfix"></div>
           
            {{--@include('backend.layouts.modal')
            @include( 'backend.layouts.popups')--}}
            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        
                        <div class="x_title">
                  <div class="row">
                  <div class="col-lg-6">
                     <?php 
                    if ($id ==16) 
                     {
                         $zonetitle = "Montreal";
                     }
                     elseif ($id ==17) {
                         $zonetitle = "CTC";
                     }
                     elseif ($id ==19) {
                         $zonetitle = "Ottawa";
                     }
                     else{
                        $zonetitle = "";
                     }
                  ?>
                    <h2><?php echo $zonetitle?> Slots<small></small></h2>
                          
                        </div>
                        <div class="col-lg-6 d-flex justify-content-end">
                        <button  class="btn green-gradient sub-ad " data-toggle="modal" data-target="#ex1"> <i class="fa fa-plus"></i> Create Slot</button>
                            <div class="clearfix"></div>
                        </div>
                  </div>
                     </div>


                        <div class="x_content">

                         @include( 'backend.layouts.notification_message' )

	                <div class="table-responsive">
	                    <table id="datatable" class="table table-striped table-bordered">
	                      <thead stylesheet="color:black;">
	                      		<tr>
	                      			<th>S#</th>
                                    <th>Slot ID </th>
                                    <!-- <th>Postal Codes</th> -->
                                    <th>Vehicle </th> 
                                    <th>Slot Start Time</th> 
                                    <th>Slot End Time</th>          
                                    <th>Drivers</th>
                                    <th>Custom Capacity</th>
                                    <!-- <th>Orders Limit</th> -->
                                    <!-- <th>Orders Count</th>                                        -->
                                    <th>Action</th>
	                      		</tr>
	                      </thead>
	                      <tbody>
	           <?php 
               $i=1;
               foreach($data as $slots) 
               {
                 echo "<tr>";
                 echo "<td>".$i."</td>";
                 echo "<td>Slot-".$slots->id."</td>";
                //  echo "<td>";

                // $SlotsPostalCode = SlotsPostalCode::where('slots_postal_code.slot_id' ,'=', $slots->id)->WhereNull('slots_postal_code.deleted_at')->get();
                //     $j = 1;
                //     $post=[];
                //     foreach ($SlotsPostalCode as $postalCode) 
                //            {
                //          if($j==1)
                //          {
                //               echo "<li class='pCode'>".$postalCode->postal_code."</li>
                //               <button class='btn green-gradient btn-xs accordion'><i class='fa fa-angle-down'></i></button>";
                //          }
                //          else
                //          {
                //             echo "<li class='panell'>".$postalCode->postal_code."</li>";
                //          }
                //           $post[$j]=$postalCode->postal_code;
                //            $j++;

                //           }         
                //   echo"</td>";
                  echo "<td>";
                  		$vehicles = Vehicle::where('id','=',$slots->vehicle)->first();
                  		 echo $vehicles->name ;
                 echo"</td>";
                 echo "<td>".$slots->start_time."</td>";
                 echo "<td>".$slots->end_time."</td>";
                 echo "<td>".$slots->joey_count."</td>";
                 echo "<td>".$slots->custom_capacity."</td>";
                //  echo "<td>".$slots->orders_count."</td>";

       //                      if ($slots->hub_id == 16) 
       //                      {
       //                          $vendor = [477260];
       //                      }

       //                      if ($slots->hub_id == 19) 
       //                      {
       //                          $vendor = [477282];
       //                      }
							
							// if ($slots->hub_id == 17) 
       //                      {
       //                          $vendor = [477255,477254,477283,477284,477286,477287,477288,477289,477307,477308,477309,477310,477311,477312,477313,477314,477292,477294,477315,477317,477316,477295,477302,477303,477304,477305,477306,477296,477290,477297,477298,477299,477300,477320,477301,477318];
       //                      }


       //                      $date=date('Y-m-d');

       //                      $created_at = date("Y-m-d",strtotime('-1 day',strtotime($date)));

       //                      $ordercount = Sprint::join('sprint__tasks','sprint__sprints.id','=','sprint__tasks.sprint_id')
       //                      ->join('locations' , 'sprint__tasks.location_id', '=', 'locations.id')
       //                      ->where('sprint__tasks.type','=','dropoff')
       //                      ->whereNull('in_hub_route')
       //                      ->whereNull('sprint__sprints.deleted_at')
       //                      ->whereIn('sprint__sprints.creator_id',$vendor)
							// ->whereIn(\DB::raw('SUBSTRING(locations.postal_code,1,3)'),$post);
							// if($slots->hub_id == 17){
							// 	$ordercount = $ordercount->whereIn('sprint__sprints.status_id',[124,13]);
							// }
							// else{
       //                          $ordercount = $ordercount->whereIn('sprint__sprints.status_id',[13,61]);
       //                          //->where(\DB::raw("CONVERT_TZ(sprint__sprints.created_at,'UTC','America/Toronto')"), 'like' ,$created_at ."%");
							// }
                            
       //                     $ordercount = $ordercount->count();

       //           echo "<td>".$ordercount."</td>";           
                 echo "<td>";
                 echo "<button type='button'  class='update btn  green-gradient actBtn '  data-id='".$slots->id."'>Edit <i class='fa fa-pencil'></i></button>"; 
                 echo "<button type='button'  class='delete btn  red-gradient actBtn '  data-id='".$slots->id."'>Delete <i class='fa fa-trash'></i></button>";
                 echo "<button type='button'  class='details btn  orange-gradient actBtn '  data-id='".$slots->id."'>Details <i class='fa fa-eye'></i></button>";
                 echo "</td>";
                 echo "</tr>";
                $i++; 
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

    <div id="ex5" class='modal fade' role='dialog'>
        <div class='modal-dialog'>

            <div class='modal-content'>
                <div class='modal-header'>
                    <h4 class='modal-title'>Map </h4>
                </div>
                <div class='modal-body'>

                    <div id='map5' style="width: 430px; height: 380px;"></div>

                </div>
            </div>
        </div>
    </div>
    <!-- CreateSLotsModal -->
    <div id="ex1" class="modal" style="display: none">
        <div class='modal-dialog'>
        	
            <div class='modal-content'>
	            <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title">Add Slots</h4>
			    </div>
                <form action="{{URL::to('/backend')}}/slots/create" method="post">

                	  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="zone_id" value="<?php echo $zoneid; ?>">
			          <div class="form-group">
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
			                     <label>Vehicle</label>
			                      <select class="form-control" name="vehicle" id="vehicle" style="width: 100% !important;">
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
			             <input type="time" name="start_time" id="start_time" class="form-control"  required style="width: 100% !important;"/>
			          </div>

			          <div class="form-group">
			             <label>End Time</label>
			             <input type="time" name="end_time" id="end_time" class="form-control"  required style="width: 100% !important;"/>
			          </div>

			         <!--  <div class="form-group">
			              <label>No. of postal Code</label>
			              <input id="inputs" type="number" min="1" max="50" name="" style="width:40%!important;" placeholder="No of Postal Code" value="1">
			              <button class="btn green-gradient" id="add" href="#" type="button" style="margin-top: 2px;line-height: 13px;padding: 8px;">Add <i class="fa fa-plus"></i></button>
			              <div id="add_words"></div>
			          </div> -->

			          <div class="form-group">
			              <label>Drivers Count</label>
			              <input type="number" name="joey_count" id="joey_count" class="form-control"  required style="width: 100% !important;"/>    
			          </div>
                      <div class="form-group">
                            <label>Custom Capacity</label>
                            <input type="number" name="custom_capacity" id="custom_capacity" class="form-control" style="width: 100% !important;"  />    
                      </div>

			          <!-- <div class="form-group">
			              <label>Orders Count</label>
			              <input type="number" name="orders_count" id="orders_count" class="form-control"  required/>    
			          </div> -->

			          <div class="form-group">
			              <button type="submit" class="btn sub-ad btn-primary" >
			                   Create Slot <i class="fa fa-plus"></i>
			              </button>   
			          </div>   
    			</form>
            </div>
        </div>
    </div>
    <!-- UpdateSLotModal -->
    <div id="ex2" class="modal" style="display: none">
        <div class='modal-dialog'>
        	
            <div class='modal-content'>
	            <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title">Update Slots</h4>
			    </div>
                <form action="{{URL::to('/backend')}}/slots/update" method="post">

                	<input type="hidden" name="_token" value="{{ csrf_token() }}">

				 <div class="form-group">
		                  <input type="hidden" name="id_time" id="id_time" class="form-control"  required/>
		                  <label class="hide">Hub Id</label>
		                  <select class="form-control hide" name="hub_id" id="hub_id" style="width: 100%;">
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
		                     <label>Vehicle</label>
		                      <select class="form-control" name="vehicle_edit" id="vehicle_edit" style="width: 100% !important; ">
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
		             <input type="time" name="start_time_edit" id="start_time_edit" class="form-control"  required style="width: 100% !important;" />
		          </div>

		          <div class="form-group">
		             <label>End Time</label>
		             <input type="time" name="end_time_edit" id="end_time_edit" class="form-control"  required style="width: 100% !important; "/>
		          </div>

		        <!--   <div class="form-group">
		              <label>Postal Codes :</label>
		              <div class="addInputs">
		              </div>
		              <div class="addMoresec">
		                <button class="addmore btn green-gradient" id="addmore" type="button" style=" margin-right: 0;">Add more <i class="fa fa-plus"></i></button>
		              </div> 
		          </div> -->

		          <div class="form-group">
		              <label>Joeys Count</label>
		              <input type="number" name="joey_count_edit" id="joey_count_edit" class="form-control" style="width: 100% !important;"   required/>    
		          </div>

                  <div class="form-group">
                    <label>Custom Capacity</label>
                    <input type="number" name="custom_capacity_edit" id="custom_capacity_edit" class="form-control" style="width: 100% !important;"  />    
                  </div>

		          <!-- <div class="form-group">
		              <label>Orders Count</label>
		              <input type="number" name="orders_count_edit" id="orders_count_edit" class="form-control"  required/>    
		          </div> -->

	          	  <div class="form-group">
	              <button type="submit" class="btn sub-ad  btn-primary" >
	                   Update Slot</i>
	              </button>
	              </div>      
    			</form>
            </div>
        </div>
    </div>

    <!-- DetailSlotsModal -->
    <div id="ex3" class="modal" style="display: none">
        <div class='modal-dialog'>
            
            <div class='modal-content'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Details Slots</h4>
                </div>
                    <div class="form-group d-flex">
                        <label style="width:30% !important">Slot ID :</label>
                        <p id="slot_id"></p>
                    </div>
                    <div class="form-group d-flex">
                        <label style="width:30% !important">Vehicle :</label>
                        <p id="vehicle_d">ss</p>
                    </div>
                    <div class="form-group d-flex">
                        <label style="width:30% !important">Slot Start Time :</label>
                        <p id="start_time_d">ss</p>
                    </div>
                    <div class="form-group d-flex">
                        <label style="width:30% !important">Slot End Time :</label>
                        <p id="end_time_d">ss</p>
                    </div>
                    <!-- <div class="form- d-flexgroup">
                        <label style="width:30% !important">Postal Codes :</label>
                        <p id="postal_code_d">ss</p>
                    </div> -->
                    <div class="form-group d-flex">
                        <label style="width:30% !important">Joeys :</label>
                        <p id="joey_count_d">ss</p>
                    </div>


                    <div class="form-group d-flex">
                        <label style="width:30% !important">Custom Capacity :</label>
                        <p id="custom_capacity_d"></p>
                    </div>
                   <!--  <div class="form-group">
                        <label>orders Limit :</label>
                        <p id="orders_count_d">ss</p>
                    </div> -->
                  </div>      
                </form>
            </div>
        </div>
    </div>

     <!-- DeleteSlotsModal -->
    <div id="ex4" class="modal" style="display: none">
        <div class='modal-dialog'>
            
            <div class='modal-content'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Slot</h4>
                </div>
            <form action="{{URL::to('/backend')}}/slots/deleteslot" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="delete_id" name="delete_id" value="">


                    <div class="form-group">
                        <p><b>Are you sure you want to delete this?</b></p>
                    </div>
                    <div class="d-flex ">
                      <button type="submit" class="btn sub-ad green-gradient btn-xs" >Yes</button>
                      <button type="button" class="btn sub-ad red-gradient btn-xs" data-dismiss="modal" >No</button>

                    </div>  

           </form>  

    
            </div>
        </div>
    </div>









<script type="text/javascript">
// $(document).ready(function() 
//     {
//         $( ".accordion" ).click(function() 
//         {
//             //toggleactiveclass
//             if ($(this).hasClass('active')) {
//                 $(this).removeClass('active');
//             } else {
//                 $(this).addClass('active');
//             }

//             //addcssClass   
//             if ($(this).hasClass('active')) {
//                 $(this).parent().find(".panell").css({ 
//                     "maxHeight": "20px", 
//                 });
//             } else {
//                 $(this).parent().find(".panell").css({ 
//                     "maxHeight": "0px", 
//                 });
//             }
//         });


//         var scntDiv = $('#add_words');
//         var wordscount = 1;
//         // var i = $('.line').size() + 1;
//         var i = 0;
//         $('#add').click(function() {
//         	// alert()
//             var inputFields = parseInt($('#inputs').val());
//             for (var n = i; n < inputFields; ++ n){
//                 wordscount++;
//                 $('<div class="line"><label>Postal Code </label><input type="text" value="" name="postal_code[]" maxlength="3 " /> <button class="remScnt btn red-gradient">x</button></div>').appendTo(scntDiv);
//                 i++;
//             }  
//             return false;
//         });

//         //    Remove button
//         $('#add_words').on('click', '.remScnt', function() {
//         if (i > 1) {
//             $(this).parent().remove();
//             i--;
//         }
//         return false;
//     });
// });


// detailsFunc
$(document).ready(function(){
  $(".details").click(function(){
    var a;
    var element = $(this);
    var del_id = element.attr("data-id");
    // console.log(del_id);
    var b_url="{{URL::to('/backend')}}";
    $.ajax({
        type: "GET",
        url: b_url+'/slots/'+del_id+'/detail',
        success: function(data)
        {   
         a = JSON.parse(data);
          console.log(a);
           // console.log(a['postalcodedata']);
           $('#slot_id').html(''+a['data']['id']);
          $('#start_time_d').html(''+a['data']['start_time']);
          $('#end_time_d').html(''+a['data']['end_time']);
          $('#vehicle_d').html(''+a['data']['vehicle']);
          $('#joey_count_d').html(''+a['data']['joey_count']);
          $('#custom_capacity_d').html(''+a['data']['custom_capacity']);
          // $('#orders_count_d').html(''+a['data']['orders_count']);
          // arrNew_d = [];
          // var post='';
          // $.each(a['postalcodedata'],function (i , val) {
          //   //  arrNew_d.push(val['postal_code'])
          //   if (post=="") {
          //       post=val['postal_code'];
          //   } else {
          //       post=post+','+val['postal_code'];
          //   }
          //       $('#postal_code_d').html(''+post);
          // })
          // $('#postal_code_d').html(''+arrNew_d[i]);

           $('#ex3').modal();

         
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
    var b_url="{{URL::to('/backend')}}";
    // console.log(del_id);
    $.ajax({
        type: "GET",
        url: b_url+'/slots/'+del_id+'/update',
        success: function(data)
        {   
         a = JSON.parse(data);
          console.log(a);
          $('#id_time').val(''+a['data']['id']);
          $('#start_time_edit').val(''+a['data']['start_time']);
          $('#end_time_edit').val(''+a['data']['end_time']);
          $('#vehicle_edit').val(''+a['data']['vehicle']);
          $('#joey_count_edit').val(''+a['data']['joey_count']);
          $('#custom_capacity_edit').val(''+a['data']['custom_capacity']);
          // $('#orders_count_edit').val(''+a['data']['orders_count']);
    //       arrNew = [];
    //       $.each(a['postalcodedata'], function (i , val) 
    //       {
    //          arrNew.push(val['postal_code'])  
    //       })

    //       var addInputs = $('.addInputs');
    //       var inputcount = arrNew.length;

    //       var i = 0;
    //       $(addInputs).empty();
    //       for (var n = i; n < inputcount; ++ n)
    //       {
    //         $('<div class="lineEdit"><input type="text" value='+arrNew[i]+' name="postal_code_edit[]" maxlength="3" class="form-control"><button class="remScntedit btn red-gradient" >x</button></div>').appendTo(addInputs);
    //         i++;
    //       }  

    //       $('.addInputs').on('click', '.remScntedit', function() {
    //         if (i > 1) {
    //         	// alert("sssad");
    //             $(this).parent().remove();
    //             i--;
    //      }
    //       return false;
    // });
    //       // var addMoresec = $('.addMoresec');

    //       $("#addmore").click(function(){
    //         $('<div class="lineEdit"><input type="text" value="" name="postal_code_edit[]" maxlength="3" class="form-control"><button class="remScntedit btn red-gradient" >x</button></div>').appendTo(addInputs);
    //       });

          $('#ex2').modal();

         
        }
      });
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

 </script>
@endsection