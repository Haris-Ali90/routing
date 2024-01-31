<?php 
use App\Joey;
use App\Vehicle;
use App\SlotsPostalCode;
use App\Slots;
use App\Sprint;

?>
@extends( 'backend.layouts.app' )

@section('title', 'Routing Zones List')

@section('CSSLibraries')
    <!-- DataTables CSS -->
    <link href="{{ backend_asset('libraries/datatables-plugins/dataTables.bootstrap.css') }}" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="{{ backend_asset('libraries/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">
    <!-- Image Viewer CSS -->
    <link href="{{ backend_asset('libraries/galleria/colorbox.css') }}" rel="stylesheet">
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
           

             @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            
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

                    <h3> <?php echo $zonetitle?> Zones<small></small></h3>
                </div>
            </div>

            <div class="clearfix"></div>
           
            {{--@include('backend.layouts.modal')
            @include( 'backend.layouts.popups')--}}






            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panell">
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
                                <label>Search By Date</label>
                                 <input type="date" name="date" required="" placeholder="Search" value="<?php echo $date ?>">
                                 <button class="btn btn-primary" type="submit" style="margin-top: -3%,4%">Go</a> </button>
                           </form>
                       
                            <button style="margin-left:10px" class="btn green-gradient" data-toggle="modal" data-target="#ex1"> <i class="fa fa-plus"></i> Create Zone</button>
                            <div class="clearfix"></div>
                        </div>


                        <div class="x_content">

                         @include( 'backend.layouts.notification_message' )

	                <div class="table-responsive">
	                    <table id="datatable-" class="table table-striped table-bordered">
	                      <thead stylesheet="color:black;">
	                      		<tr>
                                      <th>ID</th>
	                      			<th>Zone ID </th>
                                    <th>Zone Title</th>
                                   <!--  <th>Hub ID</th> 
                                    <th>Address</th> --> 
                                    <th style="width: 11%;">Postal Codes</th>
                                    <th>Order Count</th>
                                    <th>Not In Route</th>
                                    <th>Total Joeys Count</th>   
                                    <th>Slots Detail</th>        
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
                        echo "<td>".$zones->title."</td>";
                       // echo "<td>".$zones->hub_id."</td>";
                        //echo "<td>".$zones->address."</td>";
                        echo "<td>";
                        echo "<ol><button class='btn green-gradient btn-xs accordion'><i class='fa fa-angle-down'></i></button>";
                            $SlotsPostalCode = SlotsPostalCode::where('slots_postal_code.zone_id' ,'=', $zones->id)->WhereNull('slots_postal_code.deleted_at')->get();

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
                                        echo "<li class='panell'>$j :".$postalCode->postal_code."</li>";
                                     }
                                       

                                       $j++;

                                      }
                        echo "</ol>";              
                        echo"</td>";

                        $SlotsPostalCode = SlotsPostalCode::where('zone_id' ,'=', $zones->id)->WhereNull('slots_postal_code.deleted_at')->first([\DB::raw('group_concat(postal_code) as postals')]);
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
                            SUM(CASE WHEN (in_hub_route = 0) AND (".$statusCond.")  THEN 1 ELSE 0 END) AS d_counts
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
                            SUM(CASE WHEN (in_hub_route = 0) AND (sprint__sprints.status_id IN(13,61))  THEN 1 ELSE 0 END) AS d_counts
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
                            SUM(CASE WHEN in_hub_route = 0  THEN 1 ELSE 0 END) AS d_counts
                            FROM sprint__sprints 
                            join sprint__tasks ON(sprint_id=sprint__sprints.id  AND type='dropoff')
                            join merchantids on(task_id=sprint__tasks.id and tracking_id IS NOT NULL and tracking_id!='')
                            join locations on(location_id=locations.id)
                            WHERE creator_id IN(477340,477341,477342,477343,477344,477345,477346) 
                            AND SUBSTRING(locations.postal_code,1,3) IN (".$postals.")
                            AND sprint__sprints.`deleted_at` IS NULL
                            AND sprint__sprints.status_id IN(13,124)
                            AND date(sprint__sprints.created_at) > '2021-01-05'";

                            $ctcordercount = DB::select($ordercountQury2);

                            $orders = $amazonordercount[0]->counts + $ctcordercount[0]->counts;
                            $d_orders  = $amazonordercount[0]->d_counts + $ctcordercount[0]->d_counts;

                        }

                        if ($zones->hub_id == 17)
                        {                           
                            $vendor = "477255,477254,477283,477284,477286,477287,477288,477289,477307,477308,477309,477310,477311,477312,477313,477314,477292,477294,477315,477317,477316,477295,477302,477303,477304,477305,477306,477296,477290,477297,477298,477299,477300,477320,477301,477318,477328,476294,477334,477335,477336,477337,477338,477339";
                            
                            $ordercountQury = "SELECT 
                            COUNT(*) AS counts,
                            SUM(CASE WHEN in_hub_route = 0 THEN 1 ELSE 0 END) AS d_counts
                            FROM sprint__sprints 
                            join sprint__tasks ON(sprint_id=sprint__sprints.id  AND type='dropoff')
                            join merchantids on(task_id=sprint__tasks.id and tracking_id IS NOT NULL and tracking_id!='')
                            join locations on(location_id=locations.id)
                            WHERE creator_id IN(".$vendor.") 
                            AND SUBSTRING(locations.postal_code,1,3) IN (".$postals.")
                            AND sprint__sprints.`deleted_at` IS NULL
                            AND sprint__sprints.status_id IN(13,124)
                            AND date(sprint__sprints.created_at) > '2021-01-05'";

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
                        }

                        echo "</td>";
                        echo "<td>";
                            echo "<button type='button'  class='update btn btn green-gradient actBtn'  data-id='".$zones->id."'>Edit <i class='fa fa-pencil'></i></button>"; 
                            echo "<button type='button'  class='delete btn btn red-gradient actBtn' data-id='".$zones->id."'>Delete <i class='fa fa-trash'></i></button>";
                            echo "<button type='button'  class='details btn btn orange-gradient actBtn'  data-id='".$zones->id."'>Details <i class='fa fa-eye'></i></button>";
                            echo "<button type='button'  class='route btn btn black-gradient actBtn'  data-id='".$zones->id."'>Submit For Route <i class='fa fa-eye'></i></button>";
                    if(auth()->user()->id == 2077){
                   echo "<button type='button'  class='routetest btn btn black-gradient actBtn'  data-id='".$zones->id."'>Submit For Route test <i class='fa fa-eye'></i></button>";
                   }
                             echo "<a href='../../slots/list/hubid/".$zones->hub_id."/zoneid/".$zones->id."' class='btn btn orange-gradient actBtn'>View Slots <i class='fa fa-eye'></i></button>";
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

                	  <input type="hidden" name="_token" value="{{ csrf_token() }}">

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
			             <label>Zone Title</label>
			             <input type="text" name="title" id="title" class="form-control"  required/>
			          </div>

			          <!-- <div class="form-group">
			             <label>Address</label>
			             <input type="text" name="address" id="address" class="form-control"  required/>
			          </div> -->


                      <div class="form-group">
                          <label>No. of postal Code</label>
                          <input id="inputs" type="number" name="" style="width:40%!important;" placeholder="No of Postal Code">
                          <button class="btn green-gradient" id="add" href="#" type="button" style="margin-top: 2px;line-height: 13px;padding: 8px;">Add <i class="fa fa-plus"></i></button>
                          <div id="add_words"></div>
                      </div>


			          <div class="form-group">
			              <button type="submit" class="btn orange-gradient" >
			                   Create Zone <i class="fa fa-plus"></i>
			              </button>   
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
			        <h4 class="modal-title">Update ZOne</h4>
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
		             <input type="text" name="title_edit" id="title_edit" class="form-control"  required/>
		          </div>

                  <!-- <div class="form-group">
                         <label>Address</label>
                         <input type="text" name="address_edit" id="address_edit" class="form-control"  required/>
                  </div> -->

                  <div class="form-group">
                      <label>Postal Codes :</label>
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
                        <label>Postal Codes :</label>
                        <p id="postal_code_d">ss</p>
                    </div>
                  </div>      
                </form>
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
            <form action='../../zones/deletezone' method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="delete_id" name="delete_id" value="">


                    <div class="form-group">
                        <p><b>Are you sure you want to delete this?</b></p>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn green-gradient btn-xs" >Yes</button>
                      <button type="button" class="btn red-gradient btn-xs" data-dismiss="modal" >No</button>

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
                <?php if($hub==19) 
                {
                echo "<form action='../../ottawa/routes/add' method='post'>";
                }
                elseif($hub==16)
                {
                    echo "<form action='../../montreal/routes/add' method='post'>";
                }
                elseif($hub==17)
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



<div id="ex101" class="modal" style="display: none">
    <div class='modal-dialog'>

        <div class='modal-content'>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Submit For Route</h4>
            </div>
            <?php if($hub==19)
            {
                echo "<form action='../../ottawa/routes/add' method='post'>";
            }
            elseif($hub==16)
            {
                echo "<form action='../../test/montreal/routes/add' method='post'>";
            }
            elseif($hub==17)
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







<script type="text/javascript">


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


        var scntDiv = $('#add_words');
        var wordscount = 1;
        // var i = $('.line').size() + 1;
        var i = 0;
        $('#add').click(function() {
            // alert()
            var inputFields = parseInt($('#inputs').val());
            for (var n = i; n < inputFields; ++ n){
                wordscount++;
                $('<div class="line"><label>Postal Code </label><input type="text" value="" name="postal[]" maxlength="3 " required  /> <button class="remScnt btn red-gradient">x</button></div>').appendTo(scntDiv);
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
    var element = $(this);
    var del_id = element.attr("data-id");
    // console.log(del_id);
    $.ajax({
        type: "GET",
        url: '../../zones/'+del_id+'/detail',
        success: function(data)
        {   
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


// updateFunc
$(document).ready(function(){
  $(".update").click(function(){
    var a;
    var element = $(this);
    var del_id = element.attr("data-id");
    // console.log(del_id);
    $.ajax({
        type: "GET",
        url: '../../zones/'+del_id+'/update',
        success: function(data)
        {   
         a = JSON.parse(data);
          console.log(a);
          $('#id_time').val(''+a['data']['id']);
          $('#title_edit').val(''+a['data']['title']);
          $('#address_edit').val(''+a['data']['address']);


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
            $('<div class="lineEdit"><input type="text" value='+arrNew[i]+' name="postal_code_edit[]" maxlength="3" class="form-control"  /><button class="remScntedit btn red-gradient" >x</button></div>').appendTo(addInputs);
            i++;
          }  



          $("#addmore").click(function(){

            $('<div class="lineEdit"><input type="text" value="" name="postal_code_edit[]" maxlength="3" class="form-control" required><button class="remScntedit btn red-gradient" >x</button></div>').appendTo(addInputs);
            $('#addInputs').append(lineEdit.clone());
          });



          $('.addInputs').on('click', '.remScntedit', function() {
            if (i > 1) {
                // alert("sssad");
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
//route
$(function() {
$(".route").click(function(){

      var element = $(this);
      var del_id = element.attr("data-id");
      console.log(del_id);
       $('#zone').val(''+del_id);
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
 </script>
@endsection