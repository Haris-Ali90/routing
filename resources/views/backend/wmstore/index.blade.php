<?php 
use App\Joey;
use App\Vehicle;
use App\SlotsPostalCode;
use App\WMSlots;
use App\Sprint;

?>
@extends( 'backend.layouts.app' )

@section('title', 'WM Store')

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
    list-style: decimal;
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

         

                    <h3>WM Store <small></small></h3>
                </div>
            </div>

            <div class="clearfix"></div>
           
            {{--@include('backend.layouts.modal')
            @include( 'backend.layouts.popups')--}}






            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panell">
                        <div class="x_title">
                          
                            <div class="clearfix"></div>
                        </div>


                        <div class="x_content">

                         @include( 'backend.layouts.notification_message' )

	                <div class="table-responsive">
	                    <table id="datatable" class="table table-striped table-bordered">
	                      <thead stylesheet="color:black;">
	                      		<tr>
	                      			<th> ID </th>
                                    <th>Store No</th>
                                    <th>Store Name</th>
                                    <th>Order Count</th>
                                    <th>Not In Route</th>
                                    <th>Total Joeys Count</th>   
                                    <th>Slots Detail</th>      
                                    <th>Address</th>   
                                    <th>Action</th>
	                      		</tr>
	                      </thead>
	                      <tbody>
	           <?php 
               $i=1;
               $hub='';
               foreach($stores as $data) 
               {
                 
                        
               
                echo "<tr>";
                echo "<td>".$i."</td>";
                        echo "<td>".$data->store_num."</td>";
                        echo "<td>".$data->store_name."</td>";
                      
                        $ordercountQury = "SELECT 
                        COUNT(*) AS counts,
                        SUM(CASE WHEN (in_hub_route IS NULL)  THEN 1 ELSE 0 END) AS d_counts
                        FROM sprint__sprints 
                        WHERE store_num IN(".$data->store_num.")
                        AND status_id IN(61)
                        AND sprint__sprints.`deleted_at` IS NULL";

                       // dd($ordercountQury);

                        $ordercount = DB::select($ordercountQury);
                       
            echo "<td>".$ordercount[0]->counts."</td>";
            echo "<td>".$ordercount[0]->d_counts."</td>";
            
            $joeyCount = WMSlots::where('store_num','=',$data->store_num)
            ->WhereNull('wm_slots.deleted_at')
            ->sum('joey_count');
                     
            echo "<td>".$joeyCount."</td>";

            $vehicleTyp = WMSlots::where('store_num','=',$data->store_num)->join('vehicles','vehicles.id','=','wm_slots.vehicle')->WhereNull('wm_slots.deleted_at')->get(['vehicles.name','wm_slots.joey_count']);
            // dd($vehicleTyp);
            echo "<td>";

            foreach ($vehicleTyp as $key) {
                // dd($key);
               // echo $key->joey_count;
               echo $key->name ." : ".$key->joey_count."</br>" ;
            }

            echo "</td>";
                      
                        echo "<td>".$data->address."</td>";
                        echo "<td>";
                            // echo "<button type='button'  class='update btn btn green-gradient actBtn'  data-id='".$data->id."'>Edit <i class='fa fa-pencil'></i></button>"; 
                          
                            // echo "<button type='button'  class='details btn btn orange-gradient actBtn'  data-id='".$data->id."'>Details <i class='fa fa-eye'></i></button>";
                            echo "<button type='button'  class='route btn btn black-gradient actBtn'  data-id='".$data->store_num."'>Submit For Route <i class='fa fa-eye'></i></button>";
                             echo "<a href='../wm/".$data->store_num."/slots' class='btn btn orange-gradient actBtn'>View Slots <i class='fa fa-eye'></i></button>";
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

  
    <div id="ex10" class="modal" style="display: none">
        <div class='modal-dialog'>
            
            <div class='modal-content'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> Submit For Route</h4>
                </div>
                <form action='../wm/routes' method='post'>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="store_id" name="store_id" value="">
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
                $('<div class="line"><label>Postal Code </label><input type="text" value="" name="postal_code[]" maxlength="3 " required  /> <button class="remScnt btn red-gradient">x</button></div>').appendTo(scntDiv);
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
       $('#store_id').val(''+del_id);
       $('#ex10').modal();
});
})
 </script>
@endsection