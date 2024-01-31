<?php
    $status = array("136" => "Client requested to cancel the order",
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
    "121" => "Pickup from Hub",
    "102" => "Joey Incident",
    "104" => "Damaged on road - delivery will be attempted",
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
    "133" => "Package sorted",
        "255" => 'Order Delay',
        '153' => 'Miss sorted to be reattempt',
        '154' => 'Joey unable to complete the route', '155' => 'To be re-attempted tomorrow');



$statusid = array("136" => "Client requested to cancel the order",
    "137" => "Delay in delivery due to weather or natural disaster",
    "118" => "left at back door",
    "117" => "left with concierge",
    "135" => "Customer refused delivery",
    "108" => "Customer unavailable-Incorrect address",
    "106" => "Customer unavailable - delivery returned",
    "107" => "Customer unavailable - Left voice mail - order returned",
    "109" => "Customer unavailable - Incorrect phone number",
    "142" => "Damaged at hub (before going OFD)",
    "143" => "Damaged on road - undeliverable",
    "144" => "Delivery to mailroom",
    "103" => "Delay at pickup",
    "139" => "Delivery left on front porch",
    "138" => "Delivery left in the garage",
    "114" => "Successful delivery at door",
    "113" => "Successfully hand delivered",
    "120" => "Delivery at Hub",
    "110" => "Delivery to hub for re-delivery",
    "111" => "Delivery to hub for return to merchant",
    "121" => "Pickup from Hub",
    "102" => "Joey Incident",
    "104" => "Damaged on road - delivery will be attempted",
    "105" => "Item damaged - returned to merchant",
    "129" => "Joey at hub",
    "128" => "Package on the way to hub",
    "140" => "Delivery missorted, may cause delay",
    "116" => "Successful delivery to neighbour",
    "132" => "Office closed - safe dropped",
    "101" => "Joey on the way to pickup",
    "32"  => "Order accepted by Joey",
    "14"  => "Merchant accepted",
    "36"  => "Cancelled by JoeyCo",
    "124" => "At hub - processing",
    "38"  => "Draft",
    "18"  => "Delivery failed",
    "56"  => "Partially delivered",
    "17"  => "Delivery success",
    "68"  => "Joey is at dropoff location",
    "67"  => "Joey is at pickup location",
    "13"  => "At hub - processing",
    "16"  => "Joey failed to pickup order",
    "57"  => "Not all orders were picked up",
    "15"  => "Order is with Joey",
    "112" => "To be re-attempted",
    "131" => "Office closed - returned to hub",
    "125" => "Pickup at store - confirmed",
    "61"  => "Scheduled order",
    "37"  => "Customer cancelled the order",
    "34"  => "Customer is editting the order",
    "35"  => "Merchant cancelled the order",
    "42"  => "Merchant completed the order",
    "54"  => "Merchant declined the order",
    "33"  => "Merchant is editting the order",
    "29"  => "Merchant is unavailable",
    "24"  => "Looking for a Joey",
    "23"  => "Waiting for merchant(s) to accept",
    "28"  => "Order is with Joey",
    "133" => "Packages sorted",
    "55"  => "ONLINE PAYMENT EXPIRED",
    "12"  => "ONLINE PAYMENT FAILED",
    "53"  => "Waiting for customer to pay",
    "141" => "Lost package",
    "60"  => "Task failure",
    "255" => 'Order Delay',
    '153' => 'Miss sorted to be reattempt',
    '154' => 'Joey unable to complete the route', '155' => 'To be re-attempted tomorrow');
    
?>
@extends( 'backend.layouts.app' )

@section('title', 'CTC Failed Orders')

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
.modal {
    top: 0 !important;
    left: 0;
    margin: 0px;
}
.modal.fade{
    opacity: 1
}
/* .modal a.close-modal{
    top: -5px;
    right: -5px
} */


img:hover {
  box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
}

.form-control1 {
    margin: 0 15px 0 0;
    padding: 0 10px;
    border: 1px solid #aaa;
    border-radius: 4px;
    color: #555;
    height: 27px;
    width: 200px;
}
.select2.select2-container.select2-container--default {
    width: 35% !important;
    margin: 0 15px 0 0;
}
.form-control1:focus {
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102,175,233,.6);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102,175,233,.6);
}
.form-group {
    margin-bottom: 15px;
}

    .modal-header{
        font-size:16px;
    }
    .modal-body h4 {
    background: #f6762c;
    padding: 8px 10px;
    margin-bottom: 10px;
    font-weight: bold;
    color: #fff;
    height:200px
}

#filter {
    margin-top: 15px;
    display: flex;
}
/*#filter select.form-control {
    margin: 0px 10px;
    height: 48px;
}*/
label {
  width:200px;
  float: left;
  font-size: 15px;
}
select{
  width: 150px;
  height: 30px;
  padding: 5px;
  
}
.alert.alert {
    margin-top: 50px;
}
select option { color: black; }
/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
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
.loader-iner-warp {
    position: relative;
    width: 100%;
    text-align: center;
    top: 40%;
}
button.btn.btn {
    color: #333;
    background-color: #c6dd38;
    border-color: #c6dd38;
}
table.dataTable thead > tr > th {
     padding-left: 9px ! important; 
   
}
.pac-container {width: 400px !important;}
</style>
@endsection

@section('JSLibraries')
<script src="{{ backend_asset('libraries/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ backend_asset('libraries/datatables-plugins/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ backend_asset('libraries/datatables-responsive/dataTables.responsive.js') }}"></script>
    <script src="{{ backend_asset('libraries/galleria/jquery.colorbox.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="https://unpkg.com/bootprompt@6.0.2/bootprompt.js"></script>

@endsection

@section('inlineJS')
    
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTK4viphUKcrJBSuoidDqRhVA4AWnHOo0&libraries=places" type="text/javascript" ></script>
    <script >
  
        function initialize() {

            var acInputs = document.getElementsByClassName("google-address");

            for (var i = 0; i < acInputs.length; i++) {

                var autocomplete = new google.maps.places.Autocomplete(acInputs[i],null);
                autocomplete.setComponentRestrictions({
                                country: ["ca"],
                            });
                autocomplete.inputId = acInputs[i].id;
            }
        }

        initialize();
    </script>

    <script>
                            $(document).ready(function(){
                    $(".dselect").click(function(){
                        console.log('dsfs');
                        var del_id=[];
                    $('.checkboxx').each(function(){
                        if($(this).is(':checked')){
                            var element = $(this);
                            if(element.attr("data-id")!=null)
                            {
                                del_id.push(element.attr("data-id")); 
                            }
                           
                        }
                    });
                        if(del_id.length==0)
                    {
                        $.confirm({
                                    title: 'Alert',
                                    content: 'Please Select Order to Create.',
                                    icon: 'fa fa-question-circle',
                                    animation: 'scale',
                                    closeAnimation: 'scale',
                                    opacity: 0.5,
                                    buttons: {
                                'confirm': {
                                    text: 'OK',
                                    btnClass: 'btn-info',
                                    action: function () {

                                        // location.reload();

                                    }
                                }
                                }
                            });
                        // $('.div-alert').html("<div class='alert alert-error alert-block' style ='margin-top: 50px;'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Please Select Order to Create.</strong></div>");
                       // alert('Please Select Order to Create.');
                    //    $(window).scrollTop(0);
                    }
                    else{
                        $.confirm({
                    title: 'A secure action',
                    content: 'Are you sure you want to Craete Order ?',
                    icon: 'fa fa-question-circle',
                    animation: 'scale',
                    closeAnimation: 'scale',
                    opacity: 0.5,
                    buttons: {
                        'confirm': {
                            text: 'Proceed',
                            btnClass: 'btn-info',
                            action: function () {
                                $(".loader").show();
                                       $(".loader-background").show();
                    $.ajax({
                            type: "POST",
                            url: '../../ctc/create/all/order',
                            data:{ids : del_id},
                         
              beforeSend: function (request) {
                        return request.setRequestHeader('X-CSRF-Token',"{{ csrf_token() }}");
                    },
                            success: function(data){
                                $(".loader").hide();
                                       $(".loader-background").hide();
                                if(data.status_code==200) {

                                    $.confirm({
                                    title: 'Alert',
                                    content: 'Order Created Successfully.',
                                    icon: 'fa fa-question-circle',
                                    animation: 'scale',
                                    closeAnimation: 'scale',
                                    opacity: 0.5,
                                    buttons: {
                                'confirm': {
                                    text: 'OK',
                                    btnClass: 'btn-info',
                                    action: function () {

                                        location.reload();

                                    }
                                }
                                }
                            });
                    //                 $.alert('you clicked on <strong>ok</strong>');
                    //     // $(window).scrollTop(0);
                       
                        
                    //  $('.div-alert').html("<div class='alert alert-success alert-block' style ='margin-top: 50px;'><button type='button' class='close' data-dismiss='alert'>×</button><strong>"+data.success+"</strong></div>");
                              
           
                }
                else
                {
                    // $(window).scrollTop(0);
                    $.confirm({
                                    title: 'Alert',
                                    content: data.error,
                                    icon: 'fa fa-question-circle',
                                    animation: 'scale',
                                    closeAnimation: 'scale',
                                    opacity: 0.5,
                                    buttons: {
                                'confirm': {
                                    text: 'OK',
                                    btnClass: 'btn-info',
                                    action: function () {

                                        // location.reload();

                                    }
                                }
                                }
                            });
                    // $('.div-alert').html("<div class='alert alert-error alert-block' style ='margin-top: 50px;'><button type='button' class='close' data-dismiss='alert'>×</button><strong>"+data.error+"</strong></div>");
                     
            
                }
                        },
                failure: function(result){
                    $(".loader").hide();
                                       $(".loader-background").hide();
                    // $(window).scrollTop(0);
                    $.confirm({
                                    title: 'Alert',
                                    content: "Order Could not Created",
                                    icon: 'fa fa-question-circle',
                                    animation: 'scale',
                                    closeAnimation: 'scale',
                                    opacity: 0.5,
                                    buttons: {
                                'confirm': {
                                    text: 'OK',
                                    btnClass: 'btn-info',
                                    action: function () {
                                        context.context.innerText="Edit";
                                        context.context.disabled =false;
                                        context.context.style.opacity=1;
                                        // location.reload();

                                    }
                                }
                                }
                            });
                    // $('.div-alert').html("<div class='alert alert-error alert-block' style ='margin-top: 50px;'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Order Could not Created</strong></div>");
                     
                    
                },
              error:function (error) {
                $(".loader").hide();
                $(".loader-background").hide();
                $.confirm({
                                    title: 'Alert',
                                    content: 'some error',
                                    icon: 'fa fa-question-circle',
                                    animation: 'scale',
                                    closeAnimation: 'scale',
                                    opacity: 0.5,
                                    buttons: {
                                'confirm': {
                                    text: 'OK',
                                    btnClass: 'btn-info',
                                    action: function () {

                                        // location.reload();

                                    }
                                }
                                }
                            });
                               
              }
                            

                    });
                              

                            }
                        },
                        cancel: function () {
                            //$.alert('you clicked on <strong>cancel</strong>');
                        }
                    }
                });
                       
                    }
                    });
                    });   
                    $("#checkAll").click(function () {
             $('input:checkbox').not(this).prop('checked', this.checked);
              // $('.transfer').prop('disabled', true);
         });  
        
      $(document).on('click','.toggle-button',function(){     
        $(this).closest("tr").find("input, span.view").toggle();
        
                        var error=null;
                         if($(this).context.innerText=='Create Order')
                         {
                           
                          setupRows($(this).closest("tr"));
                          
                        
                            currentRow=$(this).closest("tr"); 
                           
                       
                            var name=currentRow.find("td:eq(4)").text();
                            var phone=currentRow.find("td:eq(5)").text();
                            var email=currentRow.find("td:eq(6)").text();
                            var addressline=currentRow.find("td:eq(7)").text();
                            var addressline2=currentRow.find("td:eq(8)").text();
                            var del_id = $(this).attr("data-id");
                            var data = new FormData();
                            data.append('id', del_id);
                            data.append('name', name);
                            data.append('mob', phone);
                            data.append('email', email);
                            data.append('line', addressline);
                            data.append('line2', addressline2);
                          
                            var regex = /^[a-zA-Z\s]+$/; 
                            var m_regex = /^[1-9]\d{9}$/;   
                            var p_regex=  new RegExp(/^[ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ]( )?\d[ABCEGHJKLMNPRSTVWXYZ]\d$/i);
                            
                           
                             if(name.replace(/\s/g,"") == "")
                            {
                                error=1;
                                $(this).context.innerText="Edit";
                               
                                $.confirm({
                                    title: 'Alert',
                                    content: 'name is required.',
                                    icon: 'fa fa-question-circle',
                                    animation: 'scale',
                                    closeAnimation: 'scale',
                                    opacity: 0.5,
                                    buttons: {
                                'confirm': {
                                    text: 'OK',
                                    btnClass: 'btn-info',
                                    action: function () {

                                        // location.reload();

                                    }
                                }
                                }
                            });
                                // $('.div-alert').html("<div class='alert alert-error alert-block' style ='margin-top: 50px;'><button type='button' class='close' data-dismiss='alert'>×</button><strong>name is required</strong></div>");
                              
                                //$(this).closest("tr").find("input, span.view").toggle();
                            }
                            else if(regex.test(name) === false)
                            {
                                error=1;
                                $(this).context.innerText="Edit";
                                $.confirm({
                                    title: 'Alert',
                                    content: 'invalid name .',
                                    icon: 'fa fa-question-circle',
                                    animation: 'scale',
                                    closeAnimation: 'scale',
                                    opacity: 0.5,
                                    buttons: {
                                'confirm': {
                                    text: 'OK',
                                    btnClass: 'btn-info',
                                    action: function () {

                                        // location.reload();

                                    }
                                }
                                }
                            });
                                // $('.div-alert').html("<div class='alert alert-error alert-block' style ='margin-top: 50px;'><button type='button' class='close' data-dismiss='alert'>×</button><strong>invalid name </strong></div>");
                               
                                // $(this).closest("tr").find("input, span.view").toggle();               
                            
                            }
                            else if(phone.replace(/\s/g,"") == "")
                            {
                                error=1;
                                $(this).context.innerText="Edit";
                                $.confirm({
                                    title: 'Alert',
                                    content: 'phone no is required.',
                                    icon: 'fa fa-question-circle',
                                    animation: 'scale',
                                    closeAnimation: 'scale',
                                    opacity: 0.5,
                                    buttons: {
                                'confirm': {
                                    text: 'OK',
                                    btnClass: 'btn-info',
                                    action: function () {

                                        // location.reload();

                                    }
                                }
                                }
                            });
                                // $('.div-alert').html("<div class='alert alert-error alert-block' style ='margin-top: 50px;'><button type='button' class='close' data-dismiss='alert'>×</button><strong>phone is required</strong></div>");
                              
                               
                              
                                // $(this).closest("tr").find("input, span.view").toggle();
                            }
                            // else if(m_regex.test(phone) === false)
                            // {
                               
                            //     bootprompt.alert("phone  is invalid");
                            //     $(this).closest("tr").find("input, span.view").toggle();               
                           
                            // }
                            else if(addressline.replace(/\s/g,"") == "")
                            {
                                error=1;
                                $(this).context.innerText="Edit";
                                $.confirm({
                                    title: 'Alert',
                                    content: 'address is required.',
                                    icon: 'fa fa-question-circle',
                                    animation: 'scale',
                                    closeAnimation: 'scale',
                                    opacity: 0.5,
                                    buttons: {
                                'confirm': {
                                    text: 'OK',
                                    btnClass: 'btn-info',
                                    action: function () {

                                        // location.reload();

                                    }
                                }
                                }
                            });
                                // $('.div-alert').html("<div class='alert alert-error alert-block' style ='margin-top: 50px;'><button type='button' class='close' data-dismiss='alert'>×</button><strong>address is required</strong></div>");
                              
                        
                                // $(this).closest("tr").find("input, span.view").toggle();
                                
                            }
                            else
                            {
                                
                                // $(this).text("Edit");
                                // $(this).closest("tr").find("input, span.view").toggle();
                                
                                sendData(data,$(this));
                            }
                        }
                        if($(this).context.innerText=="Edit")
                      {
                          if(error==null)
                          {
                            console.log(error);
                             $(this).context.innerText = "Create Order";
                          }
                      }
                    //   else
                    //   {
                    //     console.log("Create Order");
                    //     $(this).context.innerText = "Edit";
                    //   }
                     
                        
  
    });
                    
                   
                    

       

        function setupRows(context) {
            $("span.view", context).remove();
            $('input', context).each(function() {
                if(this.value=="on")
                {

                }
                else
                {
                    $("<span />", { text: this.value, "class":"view" }).insertAfter(this);
                    $(this).hide();
                }
         
            });
        }

        function sendData(data,context) {
                            //   $(".loader").show();
                            //            $(".loader-background").show();
                            context.closest("tr").find("span.view").remove();

                            context.context.disabled =true;
                            context.context.style.opacity=.65;
                            context.context.innerText="Creating";
                        $.ajax({
                url: '../../ctc/failed/orders',
                type: 'POST',
              beforeSend: function (request) {
                        return request.setRequestHeader('X-CSRF-Token',"{{ csrf_token() }}");
                    },
                contentType: false,
                processData: false,
                data:data,
                // dataType: "json",
                success: function(data){
                    $(".loader").hide();
                    $(".loader-background").hide();

                   if(data.status_code==200) {
                        
                      
                        $.confirm({
                                    title: 'Alert',
                                    content: data.success,
                                    icon: 'fa fa-question-circle',
                                    animation: 'scale',
                                    closeAnimation: 'scale',
                                    opacity: 0.5,
                                    buttons: {
                                'confirm': {
                                    text: 'OK',
                                    btnClass: 'btn-info',
                                    action: function () {

                                        $('#datatable').DataTable().row( context.parents('tr') ).remove().draw();

                                    }
                                }
                                }
                            });
                    // $('.div-alert').html("<div class='alert alert-success alert-block' style ='margin-top: 50px;'><button type='button' class='close' data-dismiss='alert'>×</button><strong>"+data.success+"</strong></div>");
                              
                //     $(".loader").hide();
                // $(".loader-background").hide();
                //     bootprompt.alert("Order Enable for Routing Successfully");
                }
                else
                {
                    $.confirm({
                                    title: 'Alert',
                                    content: data.error,
                                    icon: 'fa fa-question-circle',
                                    animation: 'scale',
                                    closeAnimation: 'scale',
                                    opacity: 0.5,
                                    buttons: {
                                'confirm': {
                                    text: 'OK',
                                    btnClass: 'btn-info',
                                    action: function () {
                                       
                                        context.closest("tr").find("input.checkboxx").show();
                                        // context.closest("tr").find("input, span.view").toggle();
                                        context.context.innerText="Edit";
                                        context.context.disabled =false;
                                        context.context.style.opacity=1;
                                                    

                                    }
                                }
                                }
                            });
                    // $('.div-alert').html("<div class='alert alert-error alert-block' style ='margin-top: 50px;'><button type='button' class='close' data-dismiss='alert'>×</button><strong>"+data.error+"</strong></div>");
                     
                //     $(".loader").hide();
                // $(".loader-background").hide();
                //     bootprompt.alert(data['error']);
                }
                   
                   
                },
                failure: function(result){
                    $(".loader").hide();
                    $(".loader-background").hide();
                    $.confirm({
                                    title: 'Alert',
                                    content:"FAILED",
                                    icon: 'fa fa-question-circle',
                                    animation: 'scale',
                                    closeAnimation: 'scale',
                                    opacity: 0.5,
                                    buttons: {
                                'confirm': {
                                    text: 'OK',
                                    btnClass: 'btn-info',
                                    action: function () {

                                       

                                    }
                                }
                                }
                            });
                   
                  
                }
            });
                    }
    </script>




<script type="text/javascript">
         // Datatable 
        $(document).ready(function () {

            $('#datatable').DataTable({
              "lengthMenu": [ 10, 25, 50,100, 150 ]
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
        $( document ).ready(function() {
    setTimeout(() => {   i=$('#datatable').DataTable().rows()
    .data().length;
    console.log(i);
 
if(i>15)
{
    $(".right_col").css({"min-height": "auto"});
} }, 1000);   
});
</script>
@endsection

@section('content')

<div class="right_col" role="main">
        <div class="">
            <div class="div-alert"></div>
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
                    <h3>CTC Failed Orders<small></small></h3>
                </div>
            </div>

            <div class="clearfix"></div>
           
            {{--@include('backend.layouts.modal')
            @include( 'backend.layouts.popups')--}}
            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_title">
                        <form id="filter"  style="padding: 10px;" action="" method="get">
                  
                        <div class="row">
                                <input id="vendor_id" name="vendor_id" type="text" style="margin-bottom:10px" placeholder="Vendor ID"  class="form-control1">
                                <input id="tracking_id" name="tracking_id" type="text" style="margin-bottom:10px"  placeholder="Tracking ID"  class="form-control1">
                                
                                <button style="width:100px" id="search" type="submit" class="btn green-gradient">Filter</button>
                                <button  style="width:200px" type="button" class="dselect btn orange-gradient">Create Selected Order</button>
                                </div>
                            </form>

                           <!-- <form method="post" enctype="multipart/form-data" action="../../excel/read" id="myform2">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                             <input type="file" name="excelFile" id="excelFile" />
                             <button class="btn orange-gradient" type="submit" style="margin-top: -3%,4%">Submit Excel </button>  

                            

                           </form> -->

                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">

                         @include( 'backend.layouts.notification_message' )

                    <div class="table-responsive">
                    <div class="loader-background" style="
    position: fixed;
    top: 0px;
    left: 0px;
    z-index: 9999;
    width: 100%;
    height: 100%;
    background-color: #000000ba; display: none"
    >
    <div class="loader-iner-warp">
                        <div class="loader" style="display: none" ></div>
            </div>
                        </div>
                        <table id="datatable" class="table table-striped table-bordered">
                          <thead stylesheet="color:black;">
                                <tr>
                                <th class="checkboxcss" ><input class='checkboxx' type='checkbox' name='check' id="checkAll" ></th>
                                <th>Id </th>
                                <th>Tracking ID</th>
                                <th>Vendor ID</th>                 
                                <th>Customer Name</th>
                                <th>Customer Phone</th>
                                <th>Customer Email</th>
                                <th>Customer Address</th>
                                <th>Customer Address Line 2</th>
                                <th style="width: 41px;" >Suite#</th>
                                <th>Merchant Order #</th>
                                <th>Confirm Signature</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Weight</th>
                                <th>Notification Method</th>
                                <th>Action</th>
                                </tr>
                          </thead>
                          <tbody>
                          <?php 
             $i=1;
          
             foreach($data as $failed_orders) {
                
                 echo "<tr>";
                 echo "<td class='checkboxcss' ><input type='checkbox' data-id='".$failed_orders->id."'  id='check' class='checkboxx'  name='del[]'  ></td>";
                 // echo "<td>".$i."</td>";
                 echo "<td>".$failed_orders->id."</td>";
                 echo "<td >".$failed_orders->tracking_num."  </td>";

                 echo "<td>".$failed_orders->vendor_id."</td>";
                 ?>
                 <td><input type="text"  style="display: none;" value = "<?php echo  $failed_orders->customer_name;?>"  >
                     <span class="view"><?php echo  $failed_orders->customer_name; ?></span></td>
                 <td><input type="text"  style="display: none;" value = "<?php echo  $failed_orders->customer_number;?>"  >
                     <span class="view"><?php echo  $failed_orders->customer_number; ?></span></td>
                 <td><input type="email"  style="display: none;" value = "<?php echo  $failed_orders->customer_email;?>"  >
                     <span class="view"><?php echo  $failed_orders->customer_email; ?></span></td>
                 <td><input type="text"  style="display: none;" class = "google-address" value = "<?php echo  $failed_orders->address;?>"  >
                     <span class="view"><?php echo  $failed_orders->address; ?></span></td>
                 <td><input type="text"  style="display: none;" class = "google-address" value = "<?php echo  $failed_orders->address_line_2;?>"  >
                     <span class="view"><?php echo  $failed_orders->address_line_2; ?></span></td>
                <?php
                 echo "<td>".$failed_orders->suite_number."</td>";
                 echo "<td>".$failed_orders->merchant_order_number."</td>";
                 echo "<td>".$failed_orders->confirm_signature."</td>";
                 echo "<td>".$failed_orders->start_time."</td>";
                 echo "<td>".$failed_orders->end_time."</td>";
                 echo "<td>".$failed_orders->weight."</td>";
                 echo "<td>".$failed_orders->notification_method."</td>";
                 echo  "<td><button  data-id='".$failed_orders->id."' class='btn green-gradient toggle-button'>Edit</button>";
                 echo "</td></tr>";
                     $i++; } ?>

                          </tbody>
                        </table>
                    </div>
                  


                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>

      <!-- UpdateStatusModal -->
    <div id="ex4" class="modal" style="display: none">
        <div class='modal-dialog'>
            
            <div class='modal-content'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Status</h4>
                </div>
            <form action="<?php echo URL::to('/'); ?>/backend/update/order/status" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="tracking_id" name="tracking_id" value="">
                <input type="hidden" id="statusId" name="statusId" value="">


                    <div class="form-group">
                        <p><b>Are you sure you want to update Status?</b></p>
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
                        <p><b>Please Select Status?</b></p>
                    </div>
          
    
            </div>
        </div>
    </div>
   
@endsection