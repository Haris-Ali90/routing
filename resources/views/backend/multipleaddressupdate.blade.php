<?php
use App\AddressApproval;

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
    "140" => "Delivery missorted, may cause delay",
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
    "255" => 'Order Delay',
    '147' => 'Scanned at Hub',
    '148' => 'Scanned at Hub and labelled',
    '149' => 'pick from hub',
    '150' => 'drop to other hub',
        '153' => 'Miss sorted to be reattempt',
        '154' => 'Joey unable to complete the route', '155' => 'To be re-attempted tomorrow'
);



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
    "145" => 'Returned To Merchant',
    "146" => "Delivery Missorted, Incorrect Address",
    "255" => 'Order Delay',
    '147' => 'Scanned at Hub',
    '148' => 'Scanned at Hub and labelled',
    '149' => 'pick from hub',
    '150' => 'drop to other hub',
    '153' => 'Miss sorted to be reattempt',
    '154' => 'Joey unable to complete the route', '155' => 'To be re-attempted tomorrow');
    
?>
@extends( 'backend.layouts.app' )

@section('title', 'Update Address')

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
.label-success {
    background-color: #5cb85c;
}
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
@media (max-width: 1280px){
    .jc-bs3-row{
        display: flex;
        justify-content: center;
    }
    .jconfirm-box-container {
        display: table;
        max-width: 50%;
    }
}
@media (max-width: 667px){
    .jconfirm-box-container {
        display: table;
        max-width: 80%;
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
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="{{ backend_asset('js/jquery-ui.js') }}"></script>
    <link href="{{ backend_asset('js/jquery-ui.css') }}" rel="stylesheet"> -->

@endsection

@section('inlineJS')
<div id="map"></div>
     
    <!-- /#page-wrapper -->
<script type="text/javascript">

// var textarea = document.querySelector('textarea');
// textarea.addEventListener('keydown', autosize);           
// function autosize(){
//   var el = this;
//   setTimeout(function(){
//     el.style.cssText = 'height:auto; padding:0';
//     // for box-sizing other than "content-box" use:
//     // el.style.cssText = '-moz-box-sizing:content-box';
//     el.style.cssText = 'height:' + el.scrollHeight + 'px';
//   },0);
// }
// $(function(){


//     // เมื่อฟอร์มการเรียกใช้ evnet submit ข้อมูล        
//     $("#excelFile").on("change",function(e){
//         e.preventDefault(); 

       
//        var formData = new FormData($("#myform1")[0]);

//         $.ajax({
//             url: '../../excel/read',
//             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
//             type: 'POST',
//             data: formData,
//             /*async: false,*/
//             cache: false,
//             contentType: false,
//             processData: false
//         }).done(function(data){
//                 console.log(data);  
//                 // $("#fname").val(data.A2);
//                 // $("#lname").val(data.B2);
//         });     

//     });


// });
function disableOrEnablebutton(context)
{
    if($("#merchant_order_no").val().trim()=="" && $("#phone_no").val().trim()=="" && $("#tracking_ids").val().trim()=="")
    {
        $("#search_btn").prop('disabled', true);
    }
    else
    {
        $("#search_btn").prop('disabled', false);
    }
}

function exportTableToCSV(filename) {
    var csv = [];
    var rows = document.querySelectorAll("#datatable tr");
    var  cols = rows[1].querySelectorAll("td, th");
   
    if(cols.length>1)
    {
        for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        
        for (var j = 0; j < cols.length-2; j++) {
            
            if(j==5)
                {
                    let value=cols[j].innerText.replace(',',' ').replace(',',' ').replace(',',' ').replace(',',' ');
                 
                        value= value.replace('é',"e");
                    value= value.replace('è',"e");
                    value= value.replace('ê',"e");
                    value= value.replace('ë',"e");
                   
                        value= value.replace('à',"a");
                    value= value.replace('â',"a");
                   
                        value= value.replace('î',"i");
                    value= value.replace('ï',"i");
                   
                        value= value.replace('û',"u");
                        value= value.replace('ù',"u");
                   
                    value= value.replace('ç',"c");
                 
                    value= value.replace('ô',"o");
                    value= value.replace("d’","d");
                    
                    row.push(value);
                }
                else
                {
                    row.push(cols[j].innerText.replace(',',' ').replace(',',' ').replace(',',' ').replace(',',' '));

                }
           
          
        }
            
        
        csv.push(row.join(","));        
    }

    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
    }
    else
    {
        $('#ex66').modal();   
    }
   
 }

 //statusFunc
$(function() {
$(".Status").click(function(){
    // alert("");
      var element = $(this);
      context=element;
    currentRow=element.closest("tr"); 
    var sprint_id=currentRow.find("td:eq(1)").text();
    var tracking_id=currentRow.find("td:eq(0)").text();
    var resp_address=currentRow.find("td:eq(5)").children().val();
    var resp_lat=currentRow.find("td:eq(5)").children().attr("data-lat");
    var resp_lng=currentRow.find("td:eq(5)").children().attr("data-lng");
    var resp_city=currentRow.find("td:eq(5)").children().attr("data-city");
    var resp_state=currentRow.find("td:eq(5)").children().attr("data-state");
    var resp_state_code=currentRow.find("td:eq(5)").children().attr("data-state-code");
    var resp_postal_code=currentRow.find("td:eq(5)").children().attr("data-postal-code");
    //   var del_id = element.attr("data-id");
     
     

    var del_id = element.attr("data-id");
       $('#sprint_id').val(''+sprint_id);
       $('#tracking_id').val(''+tracking_id);
       $('#resp_address').val(''+resp_address);
       $('#resp_lat').val(''+resp_lat);
       $('#resp_lng').val(''+resp_lng);
       $('#resp_state').val(''+resp_state);
       $('#resp_state_code').val(''+resp_state_code);
       $('#resp_city').val(''+resp_city);
       $('#resp_postal_code').val(''+resp_postal_code);

       $('#ex4').modal();

});
});

function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();



}











</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTK4viphUKcrJBSuoidDqRhVA4AWnHOo0&libraries=places" type="text/javascript"></script>

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

            // ajax function to show google map address suggestion
            $(document).on('focus', '.update-address-on-change', function () {

                let triggerAjax = true;

                // var acInputs = document.getElementsByClassName("google-address");
                var acInputs = this;
                var element = $(this);

                // remove error class if exist
                element.removeClass('input-error');

                const map = new google.maps.Map(document.getElementById("map"), {
                    center: {lat: 40.749933, lng: -73.98633},
                    zoom: 13,
                });

                const options = {
                    componentRestrictions: {country: "ca"},
                    fields: ["formatted_address", "geometry", "name","address_components"],
                    origin: map.getCenter(),
                    strictBounds: false,
                    //types: ["establishment"],
                };
                var autocomplete = new google.maps.places.Autocomplete(acInputs, options);

                var address_sorted_object = {};
                google.maps.event.addListener(autocomplete, 'place_changed', function () {

                    // removing alert
                    $(".session-wrapper").find('.alert').remove();

                    var place = autocomplete.getPlace();
                    var address_components = place.address_components;
                    address_components.forEach(function (currentValue) {
                        address_sorted_object[currentValue.types[0]] = currentValue;
                    });

                    //var last_element = hh[hh.length - 1];
                    // add lat lng
                    $(element).attr('data-lat',place.geometry.location.lat());
                    $(element).attr('data-lng',place.geometry.location.lng());
                    // checking data is completed
                    if(!("postal_code" in address_sorted_object) && !("postal_code_prefix" in address_sorted_object))
                    {
                        // show session alert
                        ShowSessionAlert('danger', 'Your selected address does not contain a Postal Code. Kindly select a nearby address! ');
                        element.val(element.attr('data-old-val'));
                        element.siblings(".datatable-input-update-btn").hide();
                        element.addClass('input-error');
                        console.log(address_sorted_object);
                        return;
                    }
                    else if(!("locality" in address_sorted_object))
                    {
                        // show session alert
                        ShowSessionAlert('danger', 'Your Selected address does not contain city kindly select near by address !');
                        element.val(element.attr('data-old-val'));
                        element.siblings(".datatable-input-update-btn").hide();
                        element.addClass('input-error');
                        console.log(address_sorted_object);
                        return;
                    }

                    if(!address_sorted_object.postal_code){
                        element.attr('data-postal-code',address_sorted_object.postal_code_prefix.long_name);
                    }
                    else{
                        element.attr('data-postal-code',address_sorted_object.postal_code.long_name);
                    }
                    element.attr('data-city',address_sorted_object.locality.long_name);
                    element.attr('data-state',address_sorted_object.administrative_area_level_1.long_name);
                    element.attr('data-state-code',address_sorted_object.administrative_area_level_1.short_name);
                    console.log(address_sorted_object);
                    console.log('sss');
                    // checking the ajax is already not trigger
                    // if(triggerAjax){
                        // now making trigger ajax false for multiple trigger
                        triggerAjax = false;
                        ColumnValueChangeByAjax(element);
                    // }

                });

            });

            // checking the address changed by google select or not
            $(document).on('change','.update-address-on-change',function () {
                let el = $(this);
                let status = el.attr('data-select-from-google-status');
                let old_val = el.attr('data-old-val');
                console.log(status);
                // checking the address is updated by the google address suggestion
                if(status == 'false')
                {
                    // ShowSessionAlert('danger','Kindly select address from google suggestion');
                    el.val(old_val);

                }
                else
                {
                    // updating status address updated by google suggestion
                    el.attr('data-select-from-google-status','false');
                }
            });
        });

        // function column value change by ajax
        function ColumnValueChangeByAjax(element) {

        let el = $(element);
        //Getting Value From Ajax Request
        let type = el.attr('data-type');
        let ids = el.attr('data-match');
        let id = el.attr('data-id');
        let val = el.val();
        let lat = el.attr('data-lat');
        let lng = el.attr('data-lng');
        let postalcode = el.attr('data-postal-code');
        let city_val = el.attr('data-city');
        let old_val = el.attr('data-old-val');

        $.confirm({
            title: 'Confirmation',
            content: 'Are you sure you want to update ?',
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Proceed',
                    btnClass: 'btn-info',
                    action: function () {

                    }
                },
                cancel: function () {
                    el.val(old_val);
                }
            }
        });

        }

        function ShowSessionAlert(type = 'success' , massage = 'No Massage Set In script ! :-) ') {


        // checking any alert already exist if it is removed
        if($(".session-wrapper").find('.alert').length)
        {
            $(".session-wrapper").find('.alert').remove();
        }


        let session_alert_html =` 
            <div class="alert alert-${type}">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                ${massage}
            </div>`;
        $(".session-wrapper").prepend(session_alert_html);

        //add class show
        //$(".session-wrapper").addClass('show');

        }
</script>
@endsection

@section('content')

<div class="right_col" role="main">
        <div class="session-wrapper">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if( Session::has('alert-' . $msg) )
                    <div class="alert alert-{{ $msg }} alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        {{ Session::get('alert-' . $msg) }}
                    </div>
                @endif
            @endforeach
            @if (isset($errors) && count($errors) > 0)
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger custom ">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        {{ $error }}<br/>
                    </div>
                @endforeach
            @endif
        </div>
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
                    <!-- <h3>Address Update<small></small></h3> -->
                </div>
            </div>
            
            <div class="clearfix"></div>
           
            {{--@include('backend.layouts.modal')
            @include( 'backend.layouts.popups')--}}            
            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Address Update</h2>
                            <div class="clearfix"></div>
                        </div>
                
                        <div class="x_title">
                            
                        <form method="get" action="" id="">   
                                
                                
                              <div class="row">
    
    
                                                 <div class="col-lg-3">
                                                 <textarea rows='1' style="line-height:28px !important" cols="180"  name="tracking_id" id="tracking_ids" class="form-control" onchange="disableOrEnablebutton(this.value)"
                                                   value="" style="margin-top:5px; margin-bottom:5px; border-radius: 5px; margin-right:5px;float: left"
                                                   placeholder="Tracking Id eg:JoeyCo001,JoeyCo002" title='Search with multiple tracking Id.'></textarea>
                                                 </div>
                                     
    
                               
                                      
                                       <div class="col-lg-3">
                                       <textarea rows='1' style="line-height:28px !important" cols="180"  name="merchant_order_no" id="merchant_order_no" class="form-control" onchange="disableOrEnablebutton(this.value)"
                                                   value="" style="margin-top:5px; margin-bottom:5px; border-radius: 5px; margin-right:5px;float: left"
                                                   placeholder="Merchant Order No eg:AN5-001,AN5-002" title="Search  with multiple merchants Order no." ></textarea>
                                       </div>
                                                 
                                        
                                        <div class="col-lg-3">
                                        <textarea rows='1' style="line-height:28px !important" cols="180"  name="phone_no"  id="phone_no" class="form-control" onchange="disableOrEnablebutton(this.value)"
                                                   value="" style="margin-top:5px; border-radius: 5px; margin-bottom:5px; margin-right:5px;float: left"
                                                   placeholder="Phone No eg:phone001,phone002" title="Search  with multiple phone no."></textarea>
                                        </div>
                                       
                                        <button class="btn green-gradient sub-ad" id="search_btn" type="submit" style="margin-top:2px; margin-bottom:5px;  margin-right:5px;float: left" >Search </button>
                                     
             
                                     
                                     
                                        <!-- csv download btn -->
                                        <?php $date = date('Y-m-d');  ?>
                                        <!-- <button onclick="exportTableToCSV('tracking-details-<?php echo $date ?>.csv')" style="margin-top:7px; margin-bottom:5px;  margin-right:5px;float: left" type="button" class="btn orange-gradient">Generate Report in CSV</button> -->
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
                        <table id="datatable" class="table table-striped table-bordered">
                          <thead stylesheet="color:black;">
                                <tr>
                                    <th>Tracking Id</th>
                                    <th>Order Id</th>
                                    <th>Merchant Order No</th>
                                    <th>Customer Phone </th>
                                    <th>Status</th>
                                    <th>Address</th> 
                                    <th>Date</th> 
                                    <th>Control</th>
                                </tr>
                          </thead>
                          <tbody>
                            <?php
        
                               foreach ($data as $response){
                                $check = AddressApproval::check_approval($response->tracking_id);
                                    ?>
                                    <tr>
                                        <?php
                                         if(isset($check->tracking_id)){
                                            if(is_null($check->deleted_at)){
                                                if($check->is_approved == 1){
                                                    echo "<td>$response->tracking_id</td>";
                                                }
                                                else{
                                                   echo "<td>$response->tracking_id</td>";
                                                }
                                            }
                                            else{
                                                if($check->is_approved == 1){
                                                    echo "<td>$response->tracking_id</td>";
                                                }
                                                else{
                                                    echo "<td style='color:red;'>$response->tracking_id</td>";
                                                }
                                            }
                                        }
                                        else{
                                            echo "<td>$response->tracking_id</td>";
                                        }
                                        ?>
                                        <td><?php echo $response->id ?></td>
                                        <td><?php echo $response->merchant_order_num ?></td>
                                        <td><?php echo $response->phone ?></td>

                                        <td>

                                            <?php 
                                            // dd($response->status_id);
                                            if (isset($statusid[$response->status_id])) {
                                                echo $statusid[$response->status_id];
                                            }
                                            else{
                                                echo "";
                                            }
                                             ?>
                                            
                                                
                                            </td>
                                        <td>
                                        <?php 
                                            if(isset($check->tracking_id)){
                                                if(is_null($check->deleted_at)){
                                                    if($check->is_approved == 1){
                                                        ?>
                                                        <input type="text"
                                                            data-select-from-google-status="false"
                                                            data-event-status="false"
                                                            data-type="customer_address"
                                                            data-lat=""
                                                            data-lng=""
                                                            data-state="{{$check->state}}"
                                                            data-state-code="{{$check->state_code}}"
                                                            data-city="{{$check->city}}"
                                                            data-postal-code="{{$check->postal_code}}"
                                                            data-old-val="{{$check->address}}"
                                                            class="form-control update-address-on-change google-address"
                                                            value="{{$check->address}}"
                                                            style="width: 100%; min-width: 200px;"
                                                            />
                                                            <button class="datatable-input-update-btn fa fa-pencil"
                                                            style="display: none"></button>
                                                        <?php
                                                    }
                                                    else{
                                                        echo $check->address;
                                                    }
                                                }
                                                else{
                                                ?>
                                                @if(!empty($response->address_line2))
                                        
                                                <input type="text"
                                                        data-select-from-google-status="false"
                                                        data-event-status="false"
                                                        data-type="customer_address"
                                                        data-lat=""
                                                        data-lng=""
                                                        data-state="{{$check->state}}"
                                                        data-state-code="{{$check->state_code}}"
                                                        data-city="{{$check->city}}"
                                                        data-postal-code="{{$check->postal_code}}"
                                                        data-old-val="{{$check->address}}"
                                                        class="form-control update-address-on-change google-address"
                                                        value="{{$check->address}}"
                                                        style="width: 100%; min-width: 200px;"
                                                        />
                                                <button class="datatable-input-update-btn fa fa-pencil"
                                                        style="display: none"></button>
                                                @endif
                                                <?php 
                                                }
                                            }
                                            else{
                                                ?>
                                                @if(!empty($response->address_line2))
                                        
                                                <input type="text"
                                                        data-select-from-google-status="false"
                                                        data-event-status="false"
                                                        data-type="customer_address"
                                                        data-lat=""
                                                        data-lng=""
                                                        data-state=""
                                                        data-state-code=""
                                                        data-city=""
                                                        data-postal-code=""
                                                        data-old-val="{{$response->address_line2}}"
                                                        class="form-control update-address-on-change google-address"
                                                        value="{{$response->address_line2}}"
                                                        style="width: 100%; min-width: 200px;"
                                                        />
                                                <button class="datatable-input-update-btn fa fa-pencil"
                                                        style="display: none"></button>
                                                @else
                                                <input type="text"
                                                        data-select-from-google-status="false"
                                                        data-event-status="false"
                                                        data-type="customer_address"
                                                        data-lat=""
                                                        data-lng=""
                                                        data-state=""
                                                        data-state-code=""
                                                        data-city=""
                                                        data-postal-code=""
                                                        data-old-val="{{$response->suite.' '.$response->address}}"
                                                        class="form-control update-address-on-change google-address"
                                                        value="{{$response->suite.', '.$response->address}}"
                                                        style="width: 100%; min-width: 200px;"
                                                        />
                                                <button class="datatable-input-update-btn fa fa-pencil"
                                                        style="display: none"></button>
                                                @endif
                                        <?php 
                                            }
                                        ?>
                                        </td>
                                        <td><?php echo $response->created_at; ?></td>
                                        <td>
                                            <?php
                                            if(isset($check->tracking_id)){
                                                if(is_null($check->deleted_at)){
                                                    if($check->is_approved == 1){
                                                        ?>
                                                        <a class="Status btn orange-gradient btn"  data-id='<?php echo $response->id; ?>'>Update Address</a>                                                        
                                                    <?php
                                                    }
                                                    else{
                                                        echo "<label style='
                                                        background-color:#5cb85c;
                                                        display: inline;
                                                        padding: 0.2em 0.6em 0.3em;
                                                        font-size: 75%;
                                                        font-weight: 700;
                                                        line-height: 1;
                                                        color: #fff;
                                                        text-align: center;
                                                        white-space: nowrap;
                                                        vertical-align: baseline;
                                                        border-radius: 0.25em;'>Waiting for manager to approve address</label>";
                                                    }
                                                }
                                                else{
                                                    ?>
                                                    <a class="Status btn orange-gradient btn"  data-id='<?php echo $response->id; ?>'>Update Address</a>
                                                    <?php
                                                }
                                            }
                                            else{
                                            ?>
                                                <a class="Status btn orange-gradient btn"  data-id='<?php echo $response->id; ?>'>Update Address</a>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                } 

                                ?>

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
                    <h4 class="modal-title">Update Address</h4>
                </div>
            <form action="../../update/order/address/approval" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="sprint_id" name="sprint_id" value="">
                <input type="hidden" id="tracking_id" name="tracking_id" value="">
                <input type="hidden" id="resp_address" name="resp_address" value="">
                <input type="hidden" id="resp_lat" name="resp_lat" value="">
                <input type="hidden" id="resp_lng" name="resp_lng" value="">
                <input type="hidden" id="resp_city" name="resp_city" value="">
                <input type="hidden" id="resp_state" name="resp_state" value="">
                <input type="hidden" id="resp_state_code" name="resp_state_code" value="">
                <input type="hidden" id="resp_postal_code" name="resp_postal_code" value="">


                    <div class="form-group">
                        <p><b>Are you sure you want to update address?</b></p>
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

    <div id="ex66" class="modal" style="display: none">
        <div class='modal-dialog'>
            
            <div class='modal-content'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Alert </h4>
                   
                </div>
                <div class="form-group">
                        <p><b>No data to generate CSV report.</b></p>
                    </div>
          
    
            </div>
        </div>
    </div>
    
@endsection