@extends( 'backend.layouts.app' )

@section('title', 'Tracking Report')

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
        textarea.form-control{
            height: 54px;
        }
        textarea {
            width:100% !important;

        }
        .alert.alert {
            margin-top: 50px;
        }

        @media only screen and (max-width: 767px){
            .m-full-w{width: 100%;}
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
            var rows = document.querySelectorAll("#datatable tr");
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
            $(".Notes").click(function(){
                // alert("");
                var element = $(this);
                context=element;
                currentRow=element.closest("tr");
                var tracking_id=currentRow.find("td:eq(0)").text();

                var note=currentRow.find("td:eq(10)").find('textarea').val();
                //   var del_id = element.attr("data-id");


                if(note == ''){
                    $('#ex7').modal();
                }
                else{
                    var del_id = element.attr("data-id");
                    $('#tracking_id').val(''+tracking_id);
                    $('#note_data').val(''+note);
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

        $(document).ready(function() {
            $('#datatable').DataTable( {
                "order": [[ 1, "Asc" ]],
                "pageLength": 50,
                "lengthMenu": [[50, 100, 150, 200], [50, 100, 150, 200]]
            } );
        } );
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
                    <!-- <h3>Tracking Report<small></small></h3> -->
                </div>
            </div>

            <div class="clearfix"></div>

            {{--@include('backend.layouts.modal')
            @include( 'backend.layouts.popups')--}}
            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Tracking Report</h2>

                            <div class="clearfix"></div>
                        </div>

                        <div class="x_title">

                            <form method="get" action="" id="">
                                <div class="col-lg-3">
                                    <textarea rows='1' cols="180"  name="tracking_id" id="tracking_ids" class="form-control cs_textarea" onchange="disableOrEnablebutton(this.value)"
                                              value="" style="margin-top:5px; margin-bottom:5px; border-radius: 5px; margin-right:5px;float: left; line-height:28px !important "
                                              placeholder="Tracking Id eg:JoeyCo001,JoeyCo002" title='Search with multiple tracking Id.'></textarea>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-2">
                                    <button class="btn green-gradient sub-ad" id="search_btn" type="submit" style="margin-top:7px; margin-bottom:5px;  margin-right:5px;float: left" >Search </button>
                                </div>
                                <div class="col-lg-6">
                                    <?php $date = date('Y-m-d');  ?>
                                    <button onclick="exportTableToCSV('tracking-report-<?php echo $date ?>.csv')" type="button" class="btn  pull-right m-full-w sub-ad btn-primary">Generate Tracking Report in CSV</button>
                                </div>
                            </form>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">

                            @include( 'backend.layouts.notification_message' )

                            <div class="table-responsive">
                                <table id="datatable" class="table table-striped table-bordered">
                                    <thead stylesheet="color:black;">
                                    <tr>
                                        <th style="width: 10%;text-align: center">Tracking Id</th>
                                        <th style="width: 10%;text-align: center">Normal Create</th>
                                        <th style="width: 10%;text-align: center">Custom Routing Create</th>
                                        <th style="width: 8%;text-align: center">Failed Order</th>
                                        <th style="width: 8%;text-align: center">Normal Route</th>
                                        <th style="width: 8%;text-align: center">Big Box Route</th>
                                        <th style="width: 8%;text-align: center">Custom Route</th>
                                        <th style="width: 12%;text-align: center">Status</th>
                                        <th style="width: 12%;text-align: center">Review</th>
                                        <th style="width: 8%;text-align: center">Route ID</th>
                                        <th style="width: 35%;text-align: center">Note</th>
                                        <th style="width: 10%;text-align: center">Control</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if(count($data)==0){?>

                                    <tr class="odd"><td valign="top" colspan="7" class="dataTables_empty">No data available in table</td></tr>

                                    <?php }
                                    else{
                                    foreach ($data as $response){

                                    ?>
                                    <tr>
                                        <td style="text-align: center"><?php echo $response['tracking_id'] ?></td>
                                        <td style="text-align: center"><?php echo $response['system_create']?></td>
                                        <td style="text-align: center"><?php echo $response['custom_create'] ?></td>
                                        <td style="text-align: center"><?php echo $response['failed_order'] ?></td>
                                        <td style="text-align: center"><?php echo $response['system_route']?></td>
                                        <td style="text-align: center"><?php echo $response['big_box_route'] ?></td>
                                        <td style="text-align: center"><?php echo $response['custom_route'] ?></td>
                                        <td style="text-align: center"><?php echo $response['sprint_status'] ?></td>
                                        <td style="text-align: center"><?php echo $response['review'] ?></td>
                                        <td style="text-align: center"><?php echo $response['route'] ?></td>
                                        <td style="text-align: center"><textarea rows='1' cols="50"  name="note" id="note" class="form-control cs_textarea"
                                                                                 value="" style="margin-top:5px; margin-bottom:5px; border-radius: 5px; margin-right:5px;float: left"
                                                                                 ><?php echo $response['note'] ?></textarea></td>
                                        <td style="text-align: center"><a class="Notes btn green-gradient btn"  data-id='<?php echo $response['tracking_id']; ?>'>Save Note</a></td>
                                    </tr>
                                    <?php
                                    }
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

    <div id="ex4" class="modal" style="display: none">
        <div class='modal-dialog'>

            <div class='modal-content'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Save Note</h4>
                </div>
                <form action="{{route('tracking-note')}}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="tracking_id" name="tracking_id" value="">
                    <input type="hidden" id="note_data" name="note_data" value="">


                    <div class="form-group">
                        <p><b>Are you sure you want to save note?</b></p>
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
                    <p><b>Please Enter note?</b></p>
                </div>


            </div>
        </div>
    </div>
@endsection