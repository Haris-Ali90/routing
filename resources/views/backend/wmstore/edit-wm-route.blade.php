<?php 
use App\WMJoeyRoute;
?>
@extends( 'backend.layouts.app' )

@section('title', 'WM Dashboard')

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

    div#transfer .modal-content {
    padding: 20px;
}

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
<!-- <script type="text/javascript">
   $( function() {
    $( "#datepicker" ).datepicker({changeMonth: true,
      changeYear: true, showOtherMonths: true,
      selectOtherMonths: true}).attr('autocomplete','off');
  } );
  </script> -->

    <script type="text/javascript">
        <!-- Datatable -->
        $(document).ready(function () {

            $('#datatable').DataTable({
              "lengthMenu": [ 50,100, 250, 500, 750, 1000]
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
                    btns: {
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
                                            var DataToset = '<btn type="btn" class="btn btn-warning btn-xs status_change" data-toggle="modal" data-id="'+Uid+'" data-target=".bs-example-modal-sm">Blocked</btn>';
                                            $('#CurerntStatusDiv'+Uid).html(DataToset);
                                        }
                                        else
                                        {
                                            var DataToset = '<btn type="btn" class="btn btn-success btn-xs status_change" data-toggle="modal" data-id="'+Uid+'" data-target=".bs-example-modal-sm">Active</btn>'
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
                    btns: {
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

<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left amazon-text">
                    <h3>Edit WM Route<small></small></h3>
                </div>
            </div>
            <!-- <button class="transfer-but transfer btn orange-gradient" disabled>Transfer</button> -->
            <div class="clearfix"></div>
           
            {{--@include('backend.layouts.modal')
            @include( 'backend.layouts.popups')--}}
            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                       
                        <div class="x_content">

                            @include( 'backend.layouts.notification_message' )

                    <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-bordered">
                    <thead stylesheet="color:black;">
                        <tr>
                            <!-- <th><input class='check' type='checkbox' name='check' id="checkAll"></th> -->
                            <th>Id</th>
                            <th>Task Id</th>
                            <th>Sprint Id</th>
                            <th>Type </th>
                            <th>Merchant Order Number</th>
                            <th>Delivery Window</th>
                            <th>Address</th>
                            <th>Distance</th>
                            <th>Action</th>
                       </tr>
                      </thead>
                      <tbody>
                      <?php 
             date_default_timezone_set('America/Toronto');

             $i=1;
             foreach($route as $routeLoc) {
                    echo "<tr>";
                    // echo "<td><input class='check' id='check' type='checkbox' name='check' value='".$routeLoc->id."'></td>";
                    echo "<td>".$i."</td>";
                    echo "<td>".$routeLoc->task_id."</td>";
                    echo "<td>CR-".$routeLoc->sprint_id."</td>";
                    echo "<td>".$routeLoc->type."</td>";
                    echo "<td>".$routeLoc->merchant_order_num."</td>";
                    echo "<td>".$routeLoc->arrival_time."-".$routeLoc->finish_time."</td>";
                    echo "<td>".$routeLoc->address.','.$routeLoc->postal_code."</td>";
                    echo "<td>".round($routeLoc->distance/1000,2)."km</td>";
                    echo "<td><button type='button'  class='delete btn btn red-gradient actBtn' data-id='".$routeLoc->sprint_id."'>Delete <i class='fa fa-trash'></i></button></td>";
                    echo "</tr>";
                    $i++;               
             }  ?>

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

    <div id="transfer" class="modal" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-body">
    <div class='modal-dialog'>

            <div class='modal-content'>
                    

        <p><strong class="order-id green">Transfer <span id="locs"></span> locations to</strong></p>
        <form action="../../wm/route/transfer" method="POST">
            <label>Please  Select a Route</label>
            <select multiple id="route" name="route_id" class="form-control  chosen-select s" required>
                <?php 
                $routes = WMJoeyRoute::JOIN('wm_joey_route_locations','wm_joey_routes.id','=','route_id') 
                ->JOIN('sprint__tasks','task_id','=','sprint__tasks.id')
                ->whereNull('wm_joey_routes.deleted_at')
                ->whereNull('wm_joey_route_locations.deleted_at')
                ->whereNotIn('status_id',[36,17])
                ->distinct()
                ->get(['route_id','wm_joey_routes.joey_id']);
               
                foreach($routes as $route){
                    echo "<option value=".$route->route_id.">R-".$route->route_id."(Joey : ".$route->joey_id.")</option>";
                }
                ?>
            </select><br>
            <button type="button" onclick="transferLocs()" class="btn green-gradient">Transfer</button>
            <button type="button" data-dismiss="modal" class="btn red-gradient">Close</button>
        </form></div></div>
    </div>
</div>
 <!-- DeleteSlotsModal -->
 <div id="ex4" class="modal" style="display: none">
        <div class='modal-dialog'>
            
            <div class='modal-content'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Order</h4>
                </div>
            <form action="{{URL::to('/backend')}}/wm/order/delete" method="post">
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













    <script>
//DeleteFunc
$(function() {
$(".delete").click(function(){

      var element = $(this);
      var del_id = element.attr("data-id");
       $('#delete_id').val(''+del_id);
       $('#ex4').modal();
});
});

        // $(document).ready(function() 
        //  {
        //          $('#route').select2();
        // });

        //  $("#checkAll").click(function () {
        //      $('input:checkbox').not(this).prop('checked', this.checked);
        //       // $('.transfer').prop('disabled', true);
        //  });


var locs = [];
    $(document).on('click', '.transfer', function(e) {   

       e.preventDefault();
       
        $.each($("input[name='check']:checked"), function(){
            locs.push($(this).val());
        });
        
        $('#locs').html(locs.length);
        $('#transfer').modal();
        
        return false;
    
    });

//     $(document).on('click', '.check', function(e) {
//         var checked = $(this).prop('checked');
//         // console.log(checked);
//         if(checked){
//             $('.transfer').prop('disabled', false);
//         } else{
//             $('.transfer').prop('disabled', true);
//         }
//    });

   function transferLocs(){

    $.ajax({
        type: "POST",
        data : {
            'locations' : locs,
            'route_id' : $('#route').val()
        },
        url: 'route/locations/transfer',
        success: function(){   
        // location.reload();  
        }
    });     
   }

</script>

@endsection