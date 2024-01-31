@extends( 'backend.layouts.app' )

@section('title', 'Csv File Uploader')

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
        div#transfer select#joey_id {
            width: 100% !important;
        }
        #transfer .custom_dropdown {
            width: 100%;
            margin-bottom: 10px;
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
        .modal-dialog.map-model {
            width: 94%;
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

        #ex1 form{
            padding: 10px;
        }
        div#transfer .modal-content, div#details .modal-content {
            padding: 20px;
        }

        #details .modal-content {
            overflow-y: scroll;
            height: 500px;
        }
        div#map5 {
            width: 100% !important;
        }

        .jconfirm .jconfirm-box{
            border : 5px solid #bad709
        }
        .btn-info {
            color: #fff;
            background-color: #cd692e;
        }
        .jconfirm .jconfirm-box .jconfirm-buttons button.btn-default {
            background-color: #b8452b;
            color: #fff !important;
        }

        .jconfirm-content {
            color: #535353;
            font-size: 16px;
        }

        .jconfirm button.btn:hover {
            background: #e46d29 !important;
        }
        .select2 {
            width: 70% !important;
            margin: 0 0 5px 10px;
        }

        /* start */
        .form-group label {
            width: 50px;
        }
        div#route .form-group {
            width: 25%;
            float: left;
        }

        div#route {
            position: absolute;
            z-index: 9999;
            top: 83px;
            width: 97%;
        }

        .
        div {
            display: block;
        }
        .iycaQH {
            position: absolute;
            background-color: white;
            border-radius: 0.286em;
            box-shadow: rgba(86, 102, 108, 0.24) 0px 1px 5px 0px;
            overflow: hidden;
            margin: 1.429em 0px 0px;
            z-index: 9999;
            width: 30%;
            top: 70px;
            left: 26px;
        }
        .cBZXtz {
            display: flex;
            -webkit-box-pack: justify;
            justify-content: space-between;
            -webkit-box-align: center;
            align-items: center;
        }
        .bdDqgn {
            padding: 0.6em 1em;
            background-color: white;
            border-bottom-left-radius: 0.286em;
            border-bottom-right-radius: 0.286em;
            max-height: 28.571em;
            overflow: scroll;
        }
        .cBZXtz {
            display: flex;
            -webkit-box-pack: justify;
            justify-content: space-between;
            -webkit-box-align: center;
            align-items: center;
        }
        .kikQSm {
            display: inline-block;
            max-width: 100%;
            font-size: 0.857em;
            font-family: Lato;
            font-weight: 700;
            color: rgb(86, 102, 108);
            margin-bottom: 0.429em;
        }
        .gdoBAT {
            font-size: 12px;
            margin: 0px 0px 5px 10px;
            color: rgb(86, 102, 108);
        }
        .control-size {
            width: 100px;
        }



        /*boxes css*/
        .montreal-dashbord-tiles h3 {
            color: #fff;
        }
        .montreal-dashbord-tiles .count {
            color: #fff;
        }
        .montreal-dashbord-tiles .tile-stats
        {
            border: 1px solid #c6dd38;
            background: #c6dd38;
        }

        .montreal-dashbord-tiles .tile-stats {
            border: 1px solid #c6dd38;
            background: #c6dd38;
        }
        .montreal-dashbord-tiles .icon {
            color: #e36d28;
        }
        .tile-stats .icon i {
            margin: 0;
            font-size: 60px;
            line-height: 0;
            vertical-align: bottom;
            padding: 0;
        }
        .select2-container {
            width: 100% !important;
            margin-bottom: 10px !important;
        }
        .headingGrid_divider {
            display: grid;
            grid-gap: 2%;
            grid-template-columns: 49% 49%;
            float: left;
            width: 100%;
            align-items: center;
        }
        .gridCol button.btn.btn-danger {
            display: table;
            margin: 0 auto;
            margin-right: 0;
            margin-bottom: 0;
        }
        .headingGrid_divider h3 {
            color: #000;
        }
        .headingGrid_divider {
            margin-bottom: 20px;
        }
        .gridCol {
            float: left;
            width: 100%;
        }

        @media only screen and (max-width: 1680px){
            .top_tiles .tile-stats {
                padding-right: 70px;
            }
            .tile-stats .count {
                font-size: 30px;
                font-weight: bold;
                line-height: 1.65857;
                overflow: hidden;
                box-sizing: border-box;
                text-overflow: ellipsis;
            }
            .tile-stats h3 {
                font-size: 12px;
            }
            .top_tiles .icon {
                font-size: 40px;
                position: absolute;
                right: 10px;
                top: 0px;
                width: auto;
                height: auto;
                font-size: 40px;
            }
            .top_tiles .icon .fa {
                vertical-align: middle;
                font-size: inherit;
            }
        }
        @media only screen and (max-width: 768px) {
            .headingGrid_divider {
                grid-template-columns: 100%;
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

@endsection

@section('inlineJS')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#datatable').DataTable({
                "lengthMenu": [1000 ],
                "ordering": false,
            });
            $(".group1").colorbox({height:"50%",width:"50%"});
        });
    </script>
@endsection

@section('content')
    <meta type="hidden" name="csrf-token" content="{{ csrf_token() }}" />

    <div class="right_col" role="main">

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block" style="margin-top: 60px;">
                <button type="button" class="close" data-dismiss="alert">X</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block" style="margin-top: 60px;">
                <button type="button" class="close" data-dismiss="alert">X</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        <div class="alert-message"></div>

        <div>
            <div class="headingGrid_divider">
                <div class="gridCol title_left amazon-text">
                    <!-- <h3>Csv File Uploader<small></small></h3> -->
                </div>
            </div>
            <div class="clearfix"></div>
{{--            <form class="form-horizontal" method="POST" action="{{ route('import_process') }}" enctype="multipart/form-data">--}}
{{--                {{ csrf_field() }}--}}

{{--                <div class="form-group{{ $errors->has('csv_file') ? ' has-error' : '' }}">--}}
{{--                    <label for="csv_file" class="col-md-4 control-label">CSV file to import</label>--}}

{{--                    <div class="col-md-6">--}}
{{--                        <input id="csv_file" type="file" class="form-control" name="csv_file" required>--}}

{{--                        @if ($errors->has('csv_file'))--}}
{{--                            <span class="help-block">--}}
{{--                                        <strong>{{ $errors->first('csv_file') }}</strong>--}}
{{--                                    </span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="form-group">--}}
{{--                    <div class="col-md-8 col-md-offset-4">--}}
{{--                        <button type="submit" class="btn btn-primary">--}}
{{--                            Parse CSV--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </form>--}}
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>
                            CSV File Uploader
                            </h2>
                        </div>
                        <div class="x_title">
                            <form class="form-horizontal" method="POST" action="{{ route('import_process') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                             <div class="row d-flex align-items-center">
                             <div class="col-lg-3">
                              <div class="form-group">
                                    <label>CSV file to import</label>
                                    <input id="csv_file" type="file" class="form-control" name="csv_file" required style="line-height:28px !important">
                              </div>
                              </div>
                                    @if ($errors->has('csv_file'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('csv_file') }}</strong>
                                        </span>
                                    @endif
                                    <button class="btn btn-primary sub-ad" type="submit" style=" margin: 8px 0px 0px 0px !important">Import Csv</a> </button>
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
                                        <th>Id</th>
                                        <th>File Name</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
{{--                                    @foreach($processedXmlFile as $key => $data)--}}
{{--                                        @php--}}
{{--                                            $duplicateFile = $data->checkDuplicateFile($data->file_name);--}}
{{--                                            $exploded = explode('/', $data->file_name);--}}
{{--                                            $fileName = end($exploded);--}}
{{--                                        @endphp--}}
{{--                                        <tr>--}}
{{--                                            <td>{{ $key+1 }}</td>--}}
{{--                                            <td>{{ $fileName }}</td>--}}
{{--                                            @if($data->is_completed == 0)--}}
{{--                                                @if($duplicateFile > 1)--}}
{{--                                                    <td class="duplicate-file" style="background-color: #dd9f1f; color: black;">--}}
{{--                                                        Duplicate but Processing.....--}}
{{--                                                    </td>--}}
{{--                                                @else--}}
{{--                                                    <td class="processing-file" style="background-color: #dd9f1f; color: black;">--}}
{{--                                                        Processing<strong>......</strong>--}}
{{--                                                    </td>--}}
{{--                                                @endif--}}
{{--                                            @else--}}
{{--                                                @if($duplicateFile > 1)--}}
{{--                                                    <td class="duplicate-file" style="background-color: #c94b25; color: black;">--}}
{{--                                                        Duplicate Completed--}}
{{--                                                    </td>--}}
{{--                                                @else--}}
{{--                                                    <td class="complete-file" style="background-color: #7bc925; color: black;">--}}
{{--                                                        Completed--}}
{{--                                                    </td>--}}
{{--                                                @endif--}}
{{--                                            @endif--}}
{{--                                            <td><button class='addInZone  green-gradient btn control-size'  title='Add In Zone'>Add In Zone</button></td>--}}
{{--                                        </tr>--}}
{{--                                    @endforeach--}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="wait" style="display:none;position:fixed;top:50%;left:50%;padding:2px;"><img
                src="{{app_asset('images/loading.gif')}} " width="104" height="64"/><br></div>

    <script>
        $( document ).ready(function() {
            setTimeout(() => {   i=$('#datatable').DataTable().rows()
                .data().length;

                if(i!=0)
                {
                    $(".right_col").css({"min-height": "auto"});
                } }, 1000);
        });
    </script>
@endsection