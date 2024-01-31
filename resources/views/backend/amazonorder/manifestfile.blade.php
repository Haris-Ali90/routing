@extends( 'backend.layouts.app' )
@section('title', 'Manifest Routes')
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
   /* span.select2-selection.select2-selection--multiple {
   height: 39px;
   } */
   .form-control {
   height: 39px !important;
   border-radius: 5px
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
   select {
   margin: 0px 5px 0 0 !important;
   }
   span.select2.select2-container.select2-container--default {
   width: 100% !important;
   }
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
   #file_id_chosen {
   width: 280px !important;
   margin-right: 5px !important;
   }
   .file_id input {
   padding: 18px !important;
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
   .loader {
   position: relative;
   right: 0%;
   top: 0%;
   justify-content: center;
   text-align: center;
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
   td.ab .view {
   display: none !important;
   }
   .loader-iner-warp {
   position: relative;
   width: 100%;
   text-align: center;
   top: 40%;
   }
   ul.select2-selection__rendered {
      width:"200px !important"
}
@media screen and (max-width : 1000px) {
   /* span.select2.select2-container.select2-container--default {
   width: 300px !important;
   } */
   .submitbutton
   {
      /* margin-top: 23px ! important; */
      margin-left: 10px;
   }
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://cdn.rawgit.0com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>

@endsection
@section('inlineJS')
<script>
   var context=null;
   // function for format item into row in table
   function formatItem(item) {
         if(item.not_in_route)
         {
            return [item.zone_id,item.zone_name,item.order_count,item.not_in_route,item.joeycount,item.vehicles_data,item.custom_capacity,"<button class='btn green-gradient createJobId "+item.zone_id+"' data-toggle='modal' data-hubid='"+item.hub_id+"' data-zoneid='"+item.zone_id+"' data-not_in_route_ids='"+item.not_in_route_ids+"'  data-target='#ex1'> <i class='fa fa-plus'></i> Create Job Id</button></td> <a href='{{ backend_url('/')}}/slots/list/hubid/"+item.hub_id+"/zoneid/"+item.zone_id+"'  target='_blank' class='btn btn orange-gradient actBtn'>View Slots <i class='fa fa-eye'></i></button>"];
         }
         return [item.zone_id,item.zone_name,item.order_count,item.not_in_route,item.joeycount,item.vehicles_data,item.custom_capacity,"<button class='btn green-gradient createJobId' data-toggle='modal' data-hubid='"+item.hub_id+"' data-zoneid='"+item.zone_id+"' data-not_in_route_ids='"+item.not_in_route_ids+"'  data-target='#ex1' disabled > <i class='fa fa-plus' ></i> Create Job Id</button></td><a href='{{ backend_url('/')}}/slots/list/hubid/"+item.hub_id+"/zoneid/"+item.zone_id+"' target='_blank' class='btn btn orange-gradient actBtn'>View Slots <i class='fa fa-eye'></i></button>"];
    
   
   }
   $(document).ready(function() {
   
      $('.Createjobid').submit(function(event) {
        
          event.preventDefault();
         
   
   //    event.preventDefault();
    
     // get the form data
     //$('#datatable').DataTable().row( context.parents('tr') ).data( ['2','3','2','3','2','3','s'] ).draw();
                             var data = new FormData();
                             data.append('zone_id', $('input[name=zone_id]').val());
                             data.append('hub_id', $('input[name=hub_id]').val());
                             data.append('not_in_route_ids',$('input[name=not_in_route_ids]').val());
                             data.append('date', $('input[name=date_]').val());
                        
       
     // process the form
     $(".loader").show();
                         $(".loader-background").show();
                         
                         $.ajax({
                                     url: "{{ URL::to('backend/manifest/routes/create')}}",
                                     type: 'POST',
                                     contentType: false,
                                     processData: false,
                                     data:data,
                             beforeSend: function (request) {
                                     return request.setRequestHeader('X-CSRF-Token',"{{ csrf_token() }}");
                                         },
                             
                                     success: function(data){
                                      $('#ex6').modal('toggle');
                                      var t = $('#datatable').DataTable();
                                       $(".loader").hide();
                                       $(".loader-background").hide();
                                       if(data.status_code==200)
                                       {
                                    
                                    //   $('#datatable').DataTable().row(context.parents('tr') ).remove().draw();
                                    $('.'+$('input[name=zone_id]').val()).prop('disabled', true);
                                         bootprompt.alert("Job created and Job Id is "+data.Job_id);
                                       
                                     
                                       }
                                       else if(data.status_code==400)
                                       {
                                          $('#ex6').modal('toggle');
                                         bootprompt.alert(data.error);
                                       }
                                       else
                                       {
                                          $('#ex6').modal('toggle');
                                         bootprompt.alert("Job Id Could not Created");
                                         
                                       }
                                      
                                     },
                                     failure: function(result){
                                      $('#ex6').modal('toggle');
                                         $(".loader").hide();
                                         $(".loader-background").hide();
                                         
                                        
                                         bootprompt.alert(result);
                                     }
                                 });
   
     // stop the form from submitting the normal way and refreshing the page
     event.preventDefault();
   });
   
      $('.Createorder').submit(function(event) {
     event.preventDefault();
    
     // get the form data
                           var data = new FormData();
                          
                             data.append('files',$("#file_id :selected").map((_, e) => e.value).get());
                             data.append('vendor_id', $('input[name=vendor_id]').val());
                             data.append('date', $('input[name=date]').val());
                        
       
     // process the form
     $(".loader").show();
                         $(".loader-background").show();
                         
                         $.ajax({
                                     url: "{{ URL::to('backend/manifest/routes/data')}}",
                                     type: 'POST',
                                     contentType: false,
                                     processData: false,
                                     data:data,
                             beforeSend: function (request) {
                                     return request.setRequestHeader('X-CSRF-Token',"{{ csrf_token() }}");
                                         },
                             
                                     success: function(data){
                                       //  $("#file_id").val("");
                                        $("#file_id").trigger("change");
                                      var t = $('#datatable').DataTable();
                                       $(".loader").hide();
                                       $(".loader-background").hide();
                                    //    if(.rows().count()>1)
                                    //    {

                                    //    }
                                    //    $("#datatable tr").remove(); 
                                       if(data.status_code==200)
                                       {
                                          
         $(".submitbutton").prop('disabled', true); 
                                          data.orders.forEach(function(order){
                                                 var value =
                                                 {"zone_id":order.zone_id,"not_in_route_ids":order.not_in_route_ids,"zone_name":order.zone_name,"not_in_route":order.not_in_route,"order_count":order.order_count,"capacity":order.capacity,"mainfest_no":data.mainfest_no,"hub_id":data.hub_id,'custom_capacity':order.custom_capacity,'joeycount':order.joeycount,'vehicles_data':order.vehicles_data};
                                                   
                                         // $('<tr>', { html: formatItem(value) }).appendTo($("#tbdata"));
                                        
                                         t.row.add( formatItem(value) ).draw();
                                      //    $('#datatable').DataTable().row( context.parents('tr') ).data( formatItem(value) ).draw();
                                         // $('#datatable').DataTable().row.add(formatItem(value) ).draw();
                                          $(window).scrollTop(0);
                                          });
                                      //    bootprompt.alert("Route Created");
                                     
                                       }
                                       else if(data.status_code==400)
                                       {
                                         bootprompt.alert(data.error);
                                       }
                                       else
                                       {
                                     
   
                                     
                                         bootprompt.alert("Route Could not Created");
                                         
                                       }
                                      
                                     },
                                     failure: function(result){
          
                                         $(".loader").hide();
                                         $(".loader-background").hide();
                                         
                                        
                                         bootprompt.alert(result);
                                     }
                                 });
   
     // stop the form from submitting the normal way and refreshing the page
     event.preventDefault();
   });
   // $("#myselect").select2({ width: 'resolve' });
   $('#file_id').select2({
      width: 'resolve',
      tags: true
      });
   
   $('#zone').select2({
      maximumSelectionLength: 1
   });
   });
   //createJobId
   $(document).on('click','.createJobId',function(){
      var element = $(this);
     
          context=element;
   var del_id = element.attr("data-zoneid");
   $('#zone_id').val(del_id);
   $('#date_').val( $('#date__').val());
   var hub_id = element.attr("data-hubid");
   let not_in_route_ids=element.attr("data-not_in_route_ids");
   $('#not_in_route_ids').val(not_in_route_ids);
   $('#hub_id').val(hub_id);
   
   // console.log(order_id);
   // document.getElementById('main_form').innerHTML ="<div class='modal-content'><div class='modal-header'><button type='button' class='close' data-dismiss='modal'>&times;</button><h4 class='modal-title'>Create Job Id</h4></div><form action='../../manifest/routes/"+del_id+"/create' class='Createjobid' method='get'><div class='form-group'><input class='check' id='zone_id' type='hidden' name='zone_id' value='"+del_id+"'><input class='check' id='hub_id' type='hidden' name='hub_id' value='"+hub_id+"'><input class='check' id='orders' type='hidden' name='manifest_no' value='"+order_id+"'><p><b>Are you sure you want to Create Job Id?</b></p></div><div class='form-group'><button type='submit' class='btn green-gradient btn-xs' >Yes</button><button type='button' class='btn red-gradient btn-xs' data-dismiss='modal' >No</button></div>  </form></div>";
   
   $('#ex6').modal();
             
      });
   $(document).on('click','#checkAll',function(){
              //  aler('s');
              $('input:checkbox').not(this).prop('checked', this.checked);
      });
   $(document).on('click','.markIncomplete',function(){
      var ids = [];
      $.each($("input[name='check']:checked"), function(){
          ids.push($(this).val());
          });
          if(ids==0)
          {
              bootprompt.alert('Please  select the  order to mark them incomplete');
          }
          else
          {
              bootprompt.confirm({
              
              message: "Are you sure you want to mark these Orders incomplete?",
              callback: (result) => { 
              if(result)
              {
                  $.ajax({
                type: "post",
                url: "{{ URL::to('backend/mark/incomplete')}}",
                data:{ids:ids},
                beforeSend: function (request) {
                          return request.setRequestHeader('X-CSRF-Token',"{{ csrf_token() }}");
                      },
                success: function (data) {
                  $(".loader").hide();
                  $(".loader-background").hide();
                  if(data.status_code==200)
                   {
                      location.reload();
                  }
                  else
                  {
                      bootprompt.alert('Error.');
                  }
                 
                 
                },
                error:function (error) {
                  $(".loader").hide();
                  $(".loader-background").hide();
                
                                  bootprompt.alert('some error');
                }
            });
                
   
              }
          }
      });   
          }
         
          
          
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
<script type="text/javascript"></script>
<script type="text/javascript">
    $(document).on('click', '.check', function(e) {
   var checked = $(this).prop('checked');
   // console.log(checked);
   if(checked){
       $('.transfer').prop('disabled', false);
   } else{
       $('.transfer').prop('disabled', true);
   }
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
   <div class="">
      <div class="page-title">
         <div class="title_left amazon-text">
            <h1><b>Manifest Routes</b>
               <small></small>
            </h1>
         </div>
      </div>
      <div class="clearfix"></div>
      {{--@include('backend.layouts.modal')
      @include( 'backend.layouts.popups')--}}
      <div class="row">
         <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
               <div class="x_title">
                  <!-- <button style="margin-left:10px" class="btn green-gradient" data-toggle="modal" data-target="#ex1"> <i class="fa fa-plus"></i> Create Slot</button> -->
                  <div class="clearfix"></div>
               </div>
               <!-- <div class="x_title"> -->
               <form method="get" action="">
                  <div class="row">
                     <div class="col-md-3 col-xs-8">
                        <label>Date  </label>
                        <input type="date" name="date" class="form-control" value='{{$date}}' required="">
                     </div>
                     <div class="col-md-2 col-xs-4">
                        <button class="btn btn-lg green-gradient" type="submit" style="margin-top: 24px;">
                        Submit
                        </button>
                     </div>
                  </div>
               </form>
               <div class="x_title">
                  <h3 style="color: #333;position: relative;padding-right: 116px;"><b>Filter Files </b> </h3>
                  <!-- <button style="margin-left:10px" class="btn green-gradient" data-toggle="modal" data-target="#ex1"> <i class="fa fa-plus"></i> Create Slot</button> -->
                  <div class="clearfix"></div>
               </div>
               <form method="get" action="" class="Createorder">
                  <div class="row">
                     <div class="col-md-3 col-xs-8">
                        <label>Select Manifest No </label>
                        <input type="hidden" name="vendor_id" value="{{$vendor_id}}">
                        <input type="hidden" id="date__"  name="date" class="form-control" value='{{$date}}' required="">
                        <select class="js-example-basic-multiple col-md-3 col-xs-8 form-control" style="width:200px !important"  name="file_id[]" id='file_id' required="" multiple="multiple">
                        <?php
                           foreach($files as  $file){ 
                              echo "<option value='".$file->manifestNumber."'>".$file->warehouseLocationID."-".$file->manifestNumber."</option>";
                              }
                                ?>
                        </select>
                     </div>
                     <div class="col-md-2 col-xs-4">
                        <button class="btn btn-lg green-gradient submitbutton" type="submit" style="margin-top: 23px;">
                        Submit
                        </button>
                     </div>
                  </div>
               </form>
               <!-- </div> -->
               <div class="x_title">
                  <!---x_title-->
                  <h3 style="color: #333;position: relative;padding-right: 116px;"><b>Order Detail</b>  </h3>
                  <div class="clearfix">
                     <!---clearfix-->
                  </div>
                  <!---clearfix end-->
               </div>
               <!---x_title end-->
               <!---x_content end-->
               <div class="x_content">
                  <!---x_content start-->
                  @include( 'backend.layouts.notification_message' )
                  <div class="table-responsive">
                     <div class="loader-background" style="
                        position: fixed;
                        top: 0px;
                        left: 0px;
                        z-index: 9999;
                        width: 100%;
                        height: 100%;
                        background-color: #000000ba; display: none "
                        >
                        <div class="loader-iner-warp">
                           <div class="loader" style="display: none" ></div>
                        </div>
                     </div>
                     <!---table-responsive start-->
                     <table class="table table-striped table-bordered"  id="datatable" border="2">
                        <thead>
                           <tr>
                              <!-- <th><input class='check' type='checkbox' name='check' value="0" id="checkAll"> </th>  -->
                              <th>Zone Id </th>
                              <th> Title  </th>
                              <th> Order Count </th>
                              <th> Order Not In Route </th>
                              <th> Joey Count </th>
                              <th> Slot Detail </th>
                              <th> Custom Capacity </th>
                              <th> Action </th>
                           </tr>
                        </thead>
                        <tbody>
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
<!-- /#page-wrapper -->
<!-- CreateSLotsModal -->
<!-- UpdateSLotModal -->
<div id="ex6" class="modal" style="display: none">
   <div class='modal-dialog'>
      <div id='main_form'>
         <div class='modal-content'>
            <div class='modal-header'>
               <button type='button' class='close' data-dismiss='modal'>&times;</button>
               <h4 class='modal-title'>Create Job Id</h4>
            </div>
            <form action='../../manifest/routes/create' class='Createjobid' method='get'>
               <div class='form-group'>
                  <input class='check' id='date_' type='hidden' name='date_' value=''>
                  <input class='check' id='zone_id' type='hidden' name='zone_id' value=''>
                  <input class='check' id='hub_id' type='hidden' name='hub_id' value=''>
                  <input class='check' id='not_in_route_ids' type='hidden' name='not_in_route_ids' value=''>
                  <p><b>Are you sure you want to Create Job Id?</b></p>
               </div>
               <div class='form-group'>
                  <button type='submit'   class='btn green-gradient btn-xs' >Yes</button>
                  <button type='button' class='btn red-gradient btn-xs' data-dismiss='modal' >No</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection