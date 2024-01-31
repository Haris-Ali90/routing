<?php
?>
@extends( 'backend.layouts.app' )

@section('title', 'CTC Order Limit')

@section('CSSLibraries')
    <!-- DataTables CSS -->
    <link href="{{ backend_asset('libraries/datatables-plugins/dataTables.bootstrap.css') }}" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="{{ backend_asset('libraries/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">
    <!-- Image Viewer CSS -->
    <link href="{{ backend_asset('libraries/galleria/colorbox.css') }}" rel="stylesheet">
    <style>
        @media screen and (max-width: 766px) {
            .dataTables_length{
          padding-top: 8px;
            }

            .dataTables_filter{
                margin-right: 50px;
            }
        }

        .green-gradient, .green-gradient:hover {
            color: #fff;
            background: #bad709;
            background: -moz-linear-gradient(top, #bad709 0%, #afca09 100%);
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #bad709), color-stop(100%, #afca09));
            background: -webkit-linear-gradient(top, #bad709 0%, #afca09 100%);
            background: linear-gradient(to bottom, #bad709 0%, #afca09 100%);
        }

        .black-gradient,
        .black-gradient:hover {
            color: #fff;
            background: #535353;
            background: -moz-linear-gradient(top, #535353 0%, #353535 100%);
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #535353), color-stop(100%, #353535));
            background: -webkit-linear-gradient(top, #535353 0%, #353535 100%);
            background: linear-gradient(to bottom, #535353 0%, #353535 100%);
        }

        .red-gradient,
        .red-gradient:hover {
            color: #fff;
            background: #da4927;
            background: -moz-linear-gradient(top, #da4927 0%, #c94323 100%);
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #da4927), color-stop(100%, #c94323));
            background: -webkit-linear-gradient(top, #da4927 0%, #c94323 100%);
            background: linear-gradient(to bottom, #da4927 0%, #c94323 100%);
        }

        .orange-gradient,
        .orange-gradient:hover {
            color: #fff;
            background: #f6762c;
            background: -moz-linear-gradient(top, #f6762c 0%, #d66626 100%);
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #f6762c), color-stop(100%, #d66626));
            background: -webkit-linear-gradient(top, #f6762c 0%, #d66626 100%);
            background: linear-gradient(to bottom, #f6762c 0%, #d66626 100%);
        }

        .btn {
            font-size: 12px;
        }

        span.select2-selection.select2-selection--multiple {
            height: 39px;
        }

        .form-control {
            height: 39px !important;
        }

        .modal-header .close {
            opacity: 1;
            margin: 5px 0;
            padding: 0;
        }

        .modal-footer .close {
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
            width: 65% !important;
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

        #tracking_id_chosen {
            width: 280px !important;
            margin-right: 5px !important;
            float: left;

        }

        /* #sprint_id_chosen {
            width: 280px !important;
            margin-right: 5px !important;
            float: left;
        } */
        select {
            margin: 0px 5px 0 0 !important;
        }

        /* .tracking_id input {
            padding: 18px !important;
        }
        .sprint_id input {
            padding: 18px !important;
        } */
       

        /* span.select2-selection.select2-selection--multiple {
            height: 35px !important;
        } */
        .tracking_id {
            width: 25%;
            margin-right: 5px;
            float: left;
        }

        .sprint_id {
            width: 25%;
            margin-right: 5px;
            float: left;
        }
        button.btn.btn {
    color: #333;
}
button.btn.btn-primary.bootprompt-accept {
    
    background-color: #c6dd38;
    border-color: #c6dd38;
    margin: 6px;
}
button.btn.btn-secondary.btn-default.bootprompt-cancel {
    margin: 6px;
}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 16px;
    
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

/* textarea 
  {
    /* padding: 10px; */
    /* vertical-align: top;
    width: 200px;
    width: 85%;
    height: 29px;
    border: 1px solid #aaa;
    border-radius: 4px;
    
    outline: none;
    padding: 8px;
    box-sizing: border-box;
    transition: 0.3s;
    line-height: 10px;
} 
*/
form#myform1 {
    width: 50%;
    
}
form#myform2 {
    width: 30%;
    
}
textarea {
    max-width:300px;
    min-width:300px;
    min-height:35px;
    
}
.alert.alert {
    margin-top: 50px;
}
span.select2.select2-container.select2-container--default {
            width: 100% !important;
        }
        .form-control {
    width: 100%  !important;;
}
    </style>
@endsection

@section('JSLibraries')
    <!-- DataTables JavaScript -->
    <script src="{{ backend_asset('libraries/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ backend_asset('libraries/datatables-plugins/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ backend_asset('libraries/datatables-responsive/dataTables.responsive.js') }}"></script>
    <script src="{{ backend_asset('libraries/galleria/jquery.colorbox.js') }}"></script>
    <script src="https://unpkg.com/bootprompt@6.0.2/bootprompt.js"></script>
    <!-- <script src="{{ backend_asset('libraries\bootstrap\js\bootprompt.js') }}"></script> -->
   
    <!-- <script src="https://unpkg.com/bootprompt@6.0.2/bootprompt.js"></script> -->
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="{{ backend_asset('js/jquery-ui.js') }}"></script>
    <link href="{{ backend_asset('js/jquery-ui.css') }}" rel="stylesheet"> -->

@endsection

@section('inlineJS')
<script>
    //DeleteFunc
    $(function() {
$(".MarkReturnmerchant").click(function(){

      var element = $(this);
      var del_id = element.attr("data-id");
       $('#ex4 #sprint_id').val(''+del_id);
       $('#ex4').modal();
});
});

$(function() {
$(".EnableForRoutes").click(function(){

      var element = $(this);
      var del_id = element.attr("data-id");
       $('#ex5 #sprint_id').val(''+del_id);
       $('#ex5').modal();
});
});



</script>
<script type="text/javascript">
      
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

    <div class="right_col" role="main">
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
        <div class="">
            <div class="page-title">
                <div class="title_left amazon-text">
                    <!-- <h1><b>Route Engine </b>
                        <small></small>
                    </h1> -->
                </div>
            </div>

            <div class="clearfix"></div>

            {{--@include('backend.layouts.modal')
            @include( 'backend.layouts.popups')--}}
            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">

                        <h2>
                        Route Engine 
                        </h2>
                            <!-- <button style="margin-left:10px" class="btn green-gradient" data-toggle="modal" data-target="#ex1"> <i class="fa fa-plus"></i> Create Slot</button> -->
                         
                        </div>

                       
                           
                            <!---x_title end-->
                                <!---x_content end-->
                                <div class="x_content">
                                    <!---x_content start-->
                                            @include( 'backend.layouts.notification_message' )

                                                <div class="table-responsive">
                                                <!---table-responsive start-->
                                                <table class="table table-striped table-bordered"  id="datatable" border="2">
                                                <thead>
                                                <tr>
                                                <th>S.No </th>
                                                <th>Hub </th>
                                                <th>Routing Type </th>
                                                <th>Engine</th>
                                                <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                {{--*/ $i = 1 /*--}}
                                @foreach( $rountingControls as $rountingControl )

                                    <tr class="">
                                    <td>{{ $i }}</td>
                                    <td>{{$rountingControl->hub_id}} </td>
                                    <td>{{ $rountingControl->routing_type }}</td>
                                    <td>
                                    <select id="engine_id" name="engine"  class='form-control'> 
                                    <option value="">Please Select Engine</option>            
                                    <option {{ $rountingControl->engine == "1" ? "Selected" : "" }} value="1"> Routifc Routing</option>
                                    <option {{ $rountingControl->engine == "2" ? "Selected" : "" }} value="2"> Routifc V3 Routing</option>
                                    <option {{ $rountingControl->engine == "3" ? "Selected" : "" }} value="3"> Logistics OS Routing</option>
                                    </select>
                                    </td> 
                                    <td>
                                    <a class="Engine btn green-gradient btn "   data-id='<?php echo $rountingControl->id; ?>'>Update Engine</a>
                                    </td> 
                                    </tr>
                                    {{--*/ $i++ /*--}}
                                @endforeach
                      </tbody>
                                                </table>      
                                                </div>
                                    <!---table-responsive end-->
                                </div>
                                <!---x_content end-->
                    </div>
                    
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
                    <h4 class="modal-title">Update Engine For Hub </h4>
                </div>
            <form action="{{ URL::to('backend/routing/engine')}}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="id" name="id" value="">
                <input type="hidden" id="egine_iid" name="egine_iid" value="">


                    <div class="form-group">
                        <p><b>Are you sure you want to Update this request?</b></p>
                    </div>
                    <div class="d-flex justify-content-end">
                      <button type="submit" class="btn sub-ad green-gradient btn-xs" >Yes</button>
                      <button type="button" class="btn sub-ad red-gradient btn-xs" data-dismiss="modal" >No</button>

                    </div>  

           </form>  

    
            </div>
        </div>
    </div>
    <!-- /#page-wrapper -->
    <div id="ex5" class="modal" style="display: none">
        <div class='modal-dialog'>
            
            <div class='modal-content'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Enable For Routes </h4>
                </div>
            <form action="{{ URL::to('backend/ctc/enable/for/route')}}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="sprint_id" name="sprint_id" value="">


                    <div class="form-group">
                        <p><b>Are you sure you want to Enable For Routes this order?</b></p>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn green-gradient btn-xs" >Yes</button>
                      <button type="button" class="btn red-gradient btn-xs" data-dismiss="modal" >No</button>

                    </div>  

           </form>  

    
            </div>
        </div>
    </div>
    <div id="ex7" class="modal" style="display: none">
        <div class='modal-dialog'>
            
            <div class='modal-content'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Alert </h4>
                   
                </div>
                <div class="form-group">
                        <p><b>Please Select Routing Engine Type?</b></p>
                    </div>
          
    
            </div>
        </div>
    </div>

    <!-- CreateSLotsModal -->

    <!-- UpdateSLotModal -->


<script type="text/javascript">
    $(function() {
$(".Engine").click(function(){
 
      var element = $(this);
    let id=element.attr('data-id');
    context=element;
    currentRow=element.closest("tr");
    var engine_id=currentRow.find("td:eq(3)").find('option:selected').val();
 
if(engine_id == ''){
 $('#ex7').modal();
}
else{
var del_id = element.attr("data-id");
$('#egine_iid').val(''+engine_id);
       $('#id').val(''+id);
       $('#ex4').modal();
}
      
});
});

</script>






    
@endsection