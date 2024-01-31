@extends( 'backend.layouts.app' )

@section('title', 'Montreal Manifest Report')

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
</style>
@endsection

@section('JSLibraries')
    <!-- DataTables JavaScript -->
    <script src="{{ backend_asset('libraries/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ backend_asset('libraries/datatables-plugins/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ backend_asset('libraries/datatables-responsive/dataTables.responsive.js') }}"></script>
    <script src="{{ backend_asset('libraries/galleria/jquery.colorbox.js') }}"></script>
    <script src="{{ backend_asset('js/joeyco-custom-script.js')}}"></script>
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="{{ backend_asset('js/jquery-ui.js') }}"></script>
    <link href="{{ backend_asset('js/jquery-ui.css') }}" rel="stylesheet"> -->

@endsection

@section('inlineJS')
     
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
    if($("#tracking_ids").val().trim()=="")
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
    var rows = document.querySelectorAll("#montreal-manifest-report tr");
    var  cols = rows[1].querySelectorAll("td, th");
   
    if(cols.length>1)
    {
        for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        
        for (var j = 0; j < cols.length; j++) {
            
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
                            
                           var status=currentRow.find("td:eq(7)").find('option:selected').val();
                           
    //   var del_id = element.attr("data-id");
     
     
if(status == ''){
 $('#ex7').modal();
}
else{
var del_id = element.attr("data-id");
$('#sprint_id').val(''+sprint_id);
       $('#statusId').val(''+status);
       $('#ex4').modal();
}
      
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



// datatable init
let datatable = $('#montreal-manifest-report').DataTable({
    scrollX: true,   // enables horizontal scrolling,
    scrollCollapse: true,
    searching: false, paging: false, ordering: false,
    columns: [
        {"data": "manifest", "className": "text-center"},
        {"data": "total_order", "className": "text-center"},
        {"data": "failed_order", "className": "text-center"},
        {"data": "created_failed_order", "className": "text-center"},
        {"data": "not_created_failed_order", "className": "text-center"},
        {"data": "sorted_order", "className": "text-center"},
    ],
    autoWidth: false,
    fixedColumns: true,
    dom: 'Bflrtip',
    buttons: ['excelHtml5'],

    "lengthMenu": [[50, 100, 150, 200], [50, 100, 150, 200]],
});


// show loader on submit
$('form').submit(function (event) {
    //ShowSessionAlert('info','The downloading will start in a moment please be patient !');
    // stopping form submit
    event.preventDefault()

    // get from inputs data
    let method = $(this).attr('method');
    let url = $(this).attr('action');
    let all_inputs = $(this).serializeArray();
    let request_data = {};
    all_inputs.forEach(function (data, index) {
        request_data[data.name] = data.value;
    });

    // override ta date variable
    // setting limit
    request_data['limit'] = 1;
    // setting page
    request_data['current_page'] = 1;

    // clear datatable for new request data
    datatable.clear().draw(false);

    // calling ajax
    getDataByjax(url, method, request_data, true, 0);

});

//function for call ajax for download file
function getDataByjax(url ='', method = '', request_data = {}, progress_bar_create = false, pregress_per = 0) {
    //create progress bar
    if (progress_bar_create) {
        showProgressBar('Page data is loading please be patient . .');
    }
    else // update progress bar
    {
        updateProgressBar(pregress_per);
    }

    // sending ajax
    $.ajax({
        type: method,
        url: url,
        data: request_data,
        success: function (response) {

            // hide error connection alert
            progressBarErrorHide();

            // setting data to variables
            let request_data = response.metaData;

            let totalRecords = parseInt(request_data.total_pages);
            let completed_records = parseInt(request_data.current_page);
            let Percentage_Completed = 100;
            let datatable_data = response.body;//Object.values(response.body);
            // checking  the total records is not zero
            if (totalRecords > 0) {
                Percentage_Completed = (completed_records / totalRecords ) * 100;
            }
            // checking the record is grather then 0
            if (completed_records >= totalRecords) {
               // alert();
                // update progress bar
                updateProgressBar(100);

                // add final data to datatable and re-draw table
                datatable.row.add(datatable_data).draw(true);

                //calculate_totals();

                // remove progress bar
                setTimeout(function () {
                    hideProgressBar()
                }, 1000);
            }
            else if (completed_records < totalRecords) {
                // add final data to datatable and re-draw table
                datatable.row.add(datatable_data).draw(false);
                // sending next page request
                request_data['current_page'] = parseInt(request_data.current_page) + 1;
                // calling ajax
                getDataByjax(url, method, request_data, false, Percentage_Completed.toFixed(2));

            }

        },
        error: function (error) {

            console.log(error);

            // checking the date validaion
            // checking key exist
            if ('errors' in error.responseJSON) {

                let errors = error.responseJSON.errors;
                // looping the errors
                for (const index in  errors) {
                    var single_error = errors[index];
                    // checking the type of error
                    if (typeof single_error == 'object') {
                        // showing errors by loop
                        single_error.forEach(function (value) {
                            ShowSessionAlert('danger', value);
                        });

                    }
                    else {
                        ShowSessionAlert('danger', single_error);
                    }
                }

                // removeing header
                hideProgressBar();
                // return with error show and stop the ajax
                return false;

            }
            else if ('error' in error.responseJSON) // session end error handling
            {
                if (error.responseJSON.error == 'Unauthenticated.') {
                    alert("Your Session is expired");
                    location.reload();
                    return false;
                }
            }

            // show error connection alert
            progressBarErrorShow();

            request_data['error'] = 'block';
            let metaData = request_data.metaData;
            // checking metaData is exsit or not
            if (typeof metaData !== 'undefined') {
                let totalRecords = parseInt(metaData.total_pages);
                let completed_records = parseInt(metaData.current_page) * parseInt(metaData.limit);
                let Percentage_Completed = 100;
                // checking  the total records is not zero
                if (totalRecords > 0) {
                    Percentage_Completed = (completed_records / totalRecords ) * 100;
                }

                getDataByjax(url, method, request_data, false, Percentage_Completed.toFixed(2));
            }
            else {
                var current_persent = parseFloat($('.progress-main-wrap').find('.progress-bar').text());
                getDataByjax(url, method, request_data, false, current_persent);
            }

        }
    });
}

</script>
@endsection

@section('content')

<div class="right_col" role="main">
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
                    <h3>Montreal Manifest Report<small></small></h3>
                </div>
            </div>

            <div class="clearfix"></div>

            {{--@include('backend.layouts.modal')
            @include( 'backend.layouts.popups')--}}            
            <div class="row">
                @include('backend.layouts.loader')
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            
                            <div class="clearfix"></div>
                        </div>
                
                        <div class="x_title">
                            
                        <form method="get" action="{{route('montreal-manifest-report.data')}}" id="">
                                
                                
                              <div class="row">
                                  <div class="col-md-3">

                                  <?php
                                  if(empty($_REQUEST['date'])){
                                      $date = date('Y-m-d');
                                  }
                                  else{
                                      $date = $_REQUEST['date'];
                                  }
                                  ?>
                                  <input type="date" name="date" class="form-control" required="" placeholder="Search" value="<?php echo $date ?>">
                                  </div>
                                  <div class="col-md-3">
                                  <button class="btn btn-primary" type="submit" style="margin-top: -3%,4%">Go</a> </button>
                                  </div>

                           <div class="col-md-6">
                                        <!-- csv download btn -->
                                        <?php $date = date('Y-m-d');  ?>
                                       <button onclick="exportTableToCSV('manifest-report-<?php echo $date ?>.csv')" style="margin-top:7px; margin-bottom:5px;  margin-right:5px;float: right" type="button" class="btn orange-gradient">Generate Tracking Report in CSV</button>
                           </div>
                           </div>
                               </form>


                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">

                         @include( 'backend.layouts.notification_message' )

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="montreal-manifest-report">
                          <thead stylesheet="color:black;">
                                <tr>
                                    <th style="width: 30%;text-align: center">Manifest Number</th>
                                    <th style="width: 10%;text-align: center">Total Orders</th>
                                    <th style="width: 10%;text-align: center">Failed Orders</th>
                                    <th style="width: 10%;text-align: center">Created Failed Order</th>
                                    <th style="width: 10%;text-align: center">Not Created Failed Order</th>
                                    <th style="width: 10%;text-align: center">Sorted Orders</th>

                                </tr>
                          </thead>
                          <tbody>

                          </tbody>
                        </table>
                    </div>

                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>

  
@endsection