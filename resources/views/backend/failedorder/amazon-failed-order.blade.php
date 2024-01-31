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

@section('title', 'Amazon Failed Orders')

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
button.btn.btn {
    color: #333;
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

textarea 
  {
    /* padding: 10px; */
    vertical-align: top;
    width: 200px;
    width: 85%;
    height: 29px;
    border: 1px solid #aaa;
    border-radius: 4px;
    margin: 0px 5px;
    outline: none;
    padding: 8px;
    box-sizing: border-box;
    transition: 0.3s;
    line-height: 10px;
}
form#myform1 {
    width: 50%;
    float: left;
}
form#myform2 {
    width: 30%;
    float: right;
}
input#excelFile {
    float: left;
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

button#search {
    width: 10% !important;
    height: 46px !important;
}
img:hover {
  box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
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
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
}
.form-control:focus {
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102,175,233,.6);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102,175,233,.6);
}
.form-group {
    margin-bottom: 15px;
}
.orders-table tbody td {
    padding: 12px;
}
.data-table th, .data-table td {
    padding: 15px 5px;
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
}

#filter {
    margin-top: 15px;
    display: flex;
}
#filter select.form-control {
    margin-left: 10px;
    height: 48px;
}
select{
  width: 150px;
  height: 30px;
  padding: 5px;
  
}
select option { color: black; }

label {
  width:200px;
  float: left;
  font-size: 15px;
}
td.ab .view {
    display: none !important;
}
table.dataTable thead > tr > th {
     padding-left: 9px ! important; 
   
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
button.btn.btn.info {
    color: #333;
    background-color: #c6dd38;
    border-color: #c6dd38;
}
.btn.btn-blue
{
    color: #333 ! important;
    background-color: #c6dd38 ! important;
    border-color: #c6dd38 ! important;
}
button.btn.btn {
    color: #333;
    background-color: #c6dd38;
    border-color: #c6dd38;
}
.pac-container {width: 400px !important;}
.input-error {
            color: red;
            padding: 10px 0px;
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
    <script src="<?php echo e(backend_asset('js/sweetalert2.all.min.js')); ?>"></script>
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="{{ backend_asset('js/jquery-ui.js') }}"></script>
    <link href="{{ backend_asset('js/jquery-ui.css') }}" rel="stylesheet"> -->

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
        
      $(document).on('click','.toggle-button',function(){     
        $(this).closest("tr").find("input, span.view").toggle();
      
                        var error=null;
                         if($(this).context.innerText=='Create Order')
                         {
                           
                          setupRows($(this).closest("tr"));
                          
                        
                            currentRow=$(this).closest("tr"); 
                            var del_id = $(this).attr("data-id");
                            console.log(currentRow.find("td:eq(0)").html("<input type='checkbox' data-id='"+del_id+"' id='check' class='checkboxx' name='del[]' >"));
                            var name=currentRow.find("td:eq(4)").text();
                            var phone=currentRow.find("td:eq(5)").text();
                            var addressline=currentRow.find("td:eq(6)").text();
                            var addressline2=currentRow.find("td:eq(7)").text();
                            var addressline3=currentRow.find("td:eq(8)").text();
                            var postal_code=currentRow.find("td:eq(9)").text();
                           
                            var data = new FormData();
                            data.append('id', del_id);
                            data.append('name', name);
                            data.append('mob', phone);
                            data.append('line', addressline);
                            data.append('line2', addressline2);
                            data.append('line3', addressline3);
                            data.append('postal_code',postal_code)
                            var regex = /^[a-zA-Z0-9\s]+$/; 
                            var m_regex = /^([0-9]{10})$/;   
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
                            else if(postal_code.replace(/\s/g,"") == "")
                            {
                                error=1;
                                $(this).context.innerText="Edit";
                                $.confirm({
                                    title: 'Alert',
                                    content: 'postal code is required.',
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
                            //     $.confirm({
                            //         title: 'Alert',
                            //         content: 'phone  is invalid.',
                            //         icon: 'fa fa-question-circle',
                            //         animation: 'scale',
                            //         closeAnimation: 'scale',
                            //         opacity: 0.5,
                            //         buttons: {
                            //     'confirm': {
                            //         text: 'OK',
                            //         btnClass: 'btn-info',
                            //         action: function () {

                            //             // location.reload();

                            //         }
                            //     }
                            //     }
                            // });
                            //     // bootprompt.alert("phone  is invalid");
                            //     // $(this).closest("tr").find("input, span.view").toggle();               
                           
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
                $("<span />", { text: this.value, "class":"view" }).insertAfter(this);
         
                $(this).hide();
            });
        }

        function sendData(data,context) {
            // $(".loader").show();
            //                            $(".loader-background").show();
            //                console.log('in function');
                            context.context.disabled =true;
                            context.context.style.opacity=.65;
                            context.context.innerText="Creating";
                        $.ajax({
                url: '../../amazon/failed/orders',
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
                        // $(window).scrollTop(0);
                        $('#datatable').DataTable().row( context.parents('tr') ).remove().draw();
                        
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

                                        // location.reload();

                                    }
                                }
                                }
                            });
                    // $('.div-alert').html("<div class='alert alert-success alert-block' style ='margin-top: 50px;'><button type='button' class='close' data-dismiss='alert'>×</button><strong>"+data.success+"</strong></div>");
                              
           
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

                                        context.context.innerText="Edit";
                                        context.context.disabled =false;
                                        context.context.style.opacity=1;
                                        // location.reload();

                                    }
                                }
                                }
                            });
                    // $('.div-alert').html("<div class='alert alert-error alert-block' style ='margin-top: 50px;'><button type='button' class='close' data-dismiss='alert'>×</button><strong>"+data.error+"</strong></div>");
                     
            
                }
                    //  $(window).scrollTop(0);
                    // location.reload();
                    // console.log(data)
                },
                failure: function(result){
                    $(".loader").hide();
                                       $(".loader-background").hide();
                                       $.confirm({
                                    title: 'Alert',
                                    content: 'FAILED',
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
                                       
                    // $('.div-alert').html("<div class='alert alert-error alert-block' style ='margin-top: 50px;'><button type='button' class='close' data-dismiss='alert'>×</button><strong>FAILED,</strong></div>");
                     
                    //    $(window).scrollTop(0);
                    
                }
                ,
              error:function (error) {
                $(".loader").hide();
                $(".loader-background").hide();
              
                $.confirm({
                                    title: 'Alert',
                                    content: 'Server error occured',
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
              }
            });
                    }
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
    title: 'Create Multiple Selected Order',
    content: "<label>Select Address type:</label><select class='form-control' required name='select_address_type' id='select_address_type' ><option value=''>Please Select option</option><option value='1'>Orders By FSA</option><option value='2'>Orders By Address</option></select><p style='Display:none' class='input-error'>This field is required!</p>",
    icon: 'fa fa-question-circle',
    animation: 'scale',
    closeAnimation: 'scale',
    opacity: 0.5,
    buttons: {
        formSubmit: {
            text: 'Submit',
            btnClass: 'btn-blue',
            action: function () {
                
				 var r=$( "#select_address_type" ).find('option:selected').val();
                  if(r=="")
                   {   
                    $('#select_address_type').attr('required', true);
                    $('.input-error').show();
                    return false;
                   }
                   $('.input-error').hide();
				      $(".loader").show();
                                       $(".loader-background").show();
                    $.ajax({
                            type: "POST",
                            url: '../../amazon/create/all/order',
                            data:{ids : del_id,selectedaddres:r},
                         
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
            //close
        },
    },
    onContentReady: function () {
        // bind to events
        var jc = this;
        this.$content.find('form').on('submit', function (e) {
            // if the user submits the form by pressing enter in the field.
            e.preventDefault();
            jc.$$formSubmit.trigger('click'); // reference the button and click it
        });
    }
});
                       
                    }
                    });
                    });   
                    $("#checkAll").click(function () {
             $('input:checkbox').not(this).prop('checked', this.checked);
              // $('.transfer').prop('disabled', true);
         });  
  
   $(document).on('click', '.checkboxx', function(e) {
        var checked = $(this).prop('checked');
        // console.log(checked);
        // if(checked){
        //     $('.dselect').prop('disabled', false);
        // } else{
        //     $('.dselect').prop('disabled', true);
        // }
   });
</script>
    


    <!-- /#page-wrapper -->
<script type="text/javascript">

var textarea = document.querySelector('textarea');
textarea.addEventListener('keydown', autosize);           
function autosize(){
  var el = this;
  setTimeout(function(){
    el.style.cssText = 'height:auto; padding:0';
    // for box-sizing other than "content-box" use:
    // el.style.cssText = '-moz-box-sizing:content-box';
    el.style.cssText = 'height:' + el.scrollHeight + 'px';
  },0);
}



</script>
<script type="text/javascript">
         // Datatable 
        $(document).ready(function () {

            $('#datatable').DataTable({
              "lengthMenu": [ 250, 500, 750, 1000 ]
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
                    <h3>Amazon Failed Orders<small></small></h3>
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
                        <?php 
                                if(empty($_REQUEST['date'])){
                                    $date = date('Y-m-d');
                                }
                                else{
                                    $date = $_REQUEST['date'];
                                }
                                ?>
                        <div class="x_title">
                        
            
            <form method="get" action="" id="">   
                                
                                
                                <div class="row">
      
  
                                <input rows='1' cols="180" style="width: 300px;height: 35px; margin-top:5px; margin-bottom:5px; border-radius: 5px; margin-right:5px;float: left" id="date_id" name="date" type="date"  placeholder='Select a date'  class="form-control" value=<?php echo $date;?>  >
                                                     
                                       
                                <select  rows='1' cols="180" id='vendor_id' style="width: 300px;height: 35px; margin-top:5px; margin-bottom:5px; border-radius: 5px; margin-right:5px;float: left"  name='vendor_id' required class='form-control' > 
                                    <option value=''>Please Select </option>
                                    <option <?php echo ($vendor_id==477260) ? "selected" : "" ; ?> value='477260'> Amazon Montreal</option>
                                    <option <?php echo ($vendor_id==477282) ? "selected" : "" ; ?> value='477282'> Amazon Ottawa</option>
                                </select> 
                                          <button class="btn green-gradient" id="search_btn" type="submit" style="margin-top:7px; margin-bottom:5px;  margin-right:5px;float: left" >Search </button>
                                          <button  style="margin-top:7px; margin-bottom:5px;  margin-right:5px;float: left" type="button" class="dselect btn orange-gradient">Create Selected Order</button>
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
                                <th> ID </th>
                                <th>Tracking ID </th> 
                                <th>Merchant Order Number</th>   
                                <th> Name </th>
                                <th> Phone No </th>
                                <th> Address1 </th>
                                <th> Address2 </th>
                                <th> Address3 </th>
                                <th> Postal code </th>
                                <th> Action </th>
                                </tr>
                          </thead>
                          <tbody>
                          <?php 
             $i=1;
           
             foreach($data as $order) {
               
                 echo "<tr>";
                 echo "<td class='checkboxcss' ><input type='checkbox' data-id='".$order->id."'  id='check' class='checkboxx'  name='del[]'  ></td>";
                 //echo "<td><input type='checkbox' data-id='".$order->sprint_id."' class='delete_check' id='vehicle1' name='del[]' value='Bike'></td>";
                 echo "<td>".$i."</td>";
                 echo "<td class ='ab'>".$order->tracking_id." </td>";
                 echo "<td>".$order->merchant_order_num ."</td>";
                 
                 ?>
                  <td><input type="text"  style="display: none;" value = "<?php echo $order->consigneeaddressname;?>"  >
                     <span class="view"><?php echo  $order->consigneeaddressname ?></span></td>
                 <td><input type="text"  style="display: none;" value = "<?php echo  $order->consigneeaddresscontactphone;?>"  >
                     <span class="view"><?php echo  $order->consigneeaddresscontactphone; ?></span></td>
                 <td><input type="text" class="google-address" style="display: none;" value = "<?php echo   $order->consigneeaddressline1;?>"  >
                     <span class="view"><?php echo   $order->consigneeaddressline1; ?></span></td>
                     <td><input type="text" class="google-address"   style="display: none;" value = "<?php echo   $order->consigneeaddressline2;?>"  >
                     <span class="view"><?php echo   $order->consigneeaddressline2; ?></span></td>
                     <td><input type="text" class="google-address"  style="display: none;" value = "<?php echo   $order->consigneeaddressline3;?>"  >
                     <span class="view"><?php echo   $order->consigneeaddressline3; ?></span></td>
                     <td><input type="text"  style="display: none;" value = "<?php echo   $order->consigneeaddresszip;?>"  >
                     <span class="view"><?php echo   $order->consigneeaddresszip; ?></span></td>
                     
                
                 <?php
                 echo  "<td><button data-id='".$order->id."' class='btn green-gradient toggle-button'>Edit</button>";?>
                 <?php
                 echo "</tr>";
                 $i++; } ?>
                          </tbody>
                        </table>
                    </div>
                    <!-- <?php $date //= //date('Y-m-d H:i:s');  ?>
                    <button onclick="exportTableToCSV('ctc-reprt-<?php //echo $date ?>.csv')" class="btn green-gradient">Generate Report in CSV</button> -->


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