@extends( 'backend.layouts.app' )

@section('title', 'Route Volume State')

@section('CSSLibraries')
<style>
.dashboard-statistics-box
{
    min-height: 400px;
    margin: 15px 0px;
    position: relative;
    box-sizing: border-box;
}
.dashboard-statistics-box.dashboard-statistics-tbl-show td {
    padding-top: 52px;
    padding-bottom: 52px;
}
@media only screen and (max-width: 767px){
    .download-btn{width: 100%; margin: 0;}
}
</style>
@endsection
@section('JSLibraries')
  

  {{--<script src="{{ backend_asset('libraries/jquery/dist/jquery.min.js') }}"></script>--}}
  <script src="{{ backend_asset('libraries/Chart.js/dist/Chart.min.js') }}"></script>
  <script src="{{ backend_asset('libraries/Chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ backend_asset('nprogress/nprogress.js') }}"></script>
    <script src="{{ backend_asset('libraries/gauge.js/dist/gauge.min.js') }}"></script>
    <script src="{{ backend_asset('libraries/skycons/skycons.js') }}"></script>
    <script src="{{ backend_asset('libraries/Chart.js/dist/Chart.min.js') }}"></script>
  {{--<script src="{{ backend_asset('libraries/bootstrap/dist/js/bootstrap.min.js') }}"></script>--}}
  
@endsection
@section('inlineJS')
  
  

@endsection

@section('content')
<!--right_col open-->
<?php $hubname=''; ?>
    <div class="right_col" role="main">
        @include( 'backend.layouts.notification_message' )

        {{-- FORM --}}
  <div class="x_panel">
          
            <div stlye="padding: 50px 0;" class="x_title">
                <form action="{{url('backend/route-volume-state')}}" method="GET">
                  
                    <div>
                      
                        <div class="form-group row">
                            <div class="col-lg-3 col-md-6 col-xs-12">
                                <label for="hub">Select Hub:</label>
                                <select class="form-control" style="width:100% !important" name="hub" id="hub">
                                    <option value="">Select Hub</option>
                                    <option <?php if(isset($hubid)){if($hubid==16){echo "selected"; $hubname="Montreal";}} ?> value="{{base64_encode(16)}}">Montreal</option>
                                    <option <?php if(isset($hubid)){if($hubid==19){echo "selected"; $hubname="Ottawa";}} ?> value="{{base64_encode(19)}}">Ottawa</option>
                                    <option <?php if(isset($hubid)){if($hubid==17){echo "selected"; $hubname="Toronto";}} ?> value="{{base64_encode(17)}}">Toronto</option>
                                    <option <?php if(isset($hubid)){if($hubid==129){echo "selected"; $hubname="Vancouver";}} ?> value="{{base64_encode(129)}}">Vancouver</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-6 col-xs-12 datepicker_wrap">
                                <label for="week_ww_yyyy">Select a week:</label>
                                <input name="weekpicker" type="text" id="week_ww_yyyy" class="form-control" style="width:100% !important ;display:block!important">
                            </div>
                            <div class="col-lg-1 col-md-2 col-xs-12">
                                <button type="submit" class="btn btn-primary sub-ad" style="margin-top: 23px;">GO</button>
                            </div>   
                            <div class="col-lg-5 col-xs-12" style="margin-top:22px;">
                                @if(isset($hubid))
                                    <button type="button" onclick="tableToExcel('export_table', 'W3C Example Table')" class="btn btn-success pull-right download-btn sub-ad btn-primary" value="" >Download Report</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>    
            </div>   
       
        {{-- FORM --}}
        @if(isset($hubid))
            <div  style="overflow: auto;">
                <table style="width:100%;margin-bottom: 10px;" class="table table-bordered table-hover display nowrap" id="export_table">
                    <thead>
                        <tr>
                            <th colspan="17" style="text-align: center;background-color:orange;color:black;border: 1px solid black;">{{date('l, F d Y',strtotime($this_week_sd))}}
                                {{-- {{$this_week_sd}}-{{$this_week_ed}} --}} Till {{date('l, F d Y',strtotime($this_week_ed))}}
                            </th>
                        </tr>
                        <tr>
                            <th colspan="3" style="text-align: center;background-color:orange;color:black;border: 1px solid black;">Route Volume ({{$hubname}})
                            </th>
                            <?php foreach($period as $key => $value){
                            ?>
                            <th colspan="2" style="text-align: center;background-color:orange;color:black;border: 1px solid black;">{{$value->format('l')}}
                            </th>
                            <?php } ?>
                        </tr>
                        <tr>
                            <th style="text-align: center;background-color:#f5c876;color:black;border: none;border-left: 1px solid;">
                            </th>
                            <th style="text-align: center;background-color:#f5c876;color:black;border: none;">
                            </th>
                            <th style="text-align: center;background-color:#f5c876;color:black;border: none;">
                            </th>
                            <?php foreach($period as $key => $value){
                                ?>
                                <th style="text-align: center;background-color:#f5c876;color:black;border: 1px solid black;">
                                    @if ($value->format('D')=='Mon')
                                        {{$totalRoutes['Mon-routes']}}
                                        
                                    @elseif ($value->format('D')=='Tue')
                                        {{$totalRoutes['Tue-routes']}}
                                    
                                    @elseif ($value->format('D')=='Wed')
                                        {{$totalRoutes['Wed-routes']}}
                                    
                                    @elseif ($value->format('D')=='Thu')
                                        {{$totalRoutes['Thu-routes']}}
                                    
                                    @elseif ($value->format('D')=='Fri')
                                        {{$totalRoutes['Fri-routes']}}
                                    
                                    @elseif ($value->format('D')=='Sat')
                                        {{$totalRoutes['Sat-routes']}}
                                    
                                    @elseif ($value->format('D')=='Sun')
                                        {{$totalRoutes['Sun-routes']}}
                                        
                                    @endif
                                </th>
                                <th style="text-align: center;background-color:#f5c876;color:black;border: 1px solid black;">
                                    @if ($value->format('D')=='Mon')
                                    {{$totalRoutes['Mon-drops']}}
                                    
                                    @elseif ($value->format('D')=='Tue')
                                        {{$totalRoutes['Tue-drops']}}
                                    
                                    @elseif ($value->format('D')=='Wed')
                                        {{$totalRoutes['Wed-drops']}}
                                    
                                    @elseif ($value->format('D')=='Thu')
                                        {{$totalRoutes['Thu-drops']}}
                                    
                                    @elseif ($value->format('D')=='Fri')
                                        {{$totalRoutes['Fri-drops']}}
                                    
                                    @elseif ($value->format('D')=='Sat')
                                        {{$totalRoutes['Sat-drops']}}
                                    
                                    @elseif ($value->format('D')=='Sun')
                                        {{$totalRoutes['Sun-drops']}}
                                        
                                    @endif
                                </th>
                                <?php } ?>
                        </tr>    
                        <tr>
                            <th style="text-align: center;background-color:#f5c876;color:black;border: 1px solid black;">Zone ID
                            </th>
                            <th style="text-align: center;background-color:#f5c876;color:black;border: 1px solid black;">Zone Name
                            </th>
                            <th style="text-align: center;background-color:#f5c876;color:black;border: 1px solid black;">Zone Type
                            </th>
                            <?php foreach($period as $key => $value){
                            ?>
                            <th style="text-align: center;background-color:#f5c876;color:black;border: 1px solid black;">Total Routes
                            </th>
                            <th style="text-align: center;background-color:#f5c876;color:black;border: 1px solid black;">Total Drops
                            </th>
                            <?php } ?>

                            <th style="text-align: center;border: 1px solid black;">Avg Routes
                            </th>
                            <th style="text-align: center;border: 1px solid black;">Avg Drops
                            </th>
                            <th style="text-align: center;border: 1px solid black;">Total Drops

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($result)==0)
                            <td style="text-align: center;    border: 1px solid;" colspan="20">No Data Found</td>
                        @else
                            @foreach ($result as $key => $value)
                            <tr>
                                <td style="text-align: center;    border: 1px solid;">{{$value['id']}}</td>
                                <td style="text-align: center;    border: 1px solid;">{{$value['name']}}</td>
                                <td style="text-align: center;    border: 1px solid;">{{$value['type']}}</td>
                                <td style="text-align: center;    border: 1px solid;">{{$value['Mon-routes']}}</td>
                                <td style="text-align: center;    border: 1px solid;">{{$value['Mon-drops']}}</td>
                                <td style="text-align: center;    border: 1px solid;">{{$value['Tue-routes']}}</td>
                                <td style="text-align: center;    border: 1px solid;">{{$value['Tue-drops']}}</td>
                                <td style="text-align: center;    border: 1px solid;">{{$value['Wed-routes']}}</td>
                                <td style="text-align: center;    border: 1px solid;">{{$value['Wed-drops']}}</td>
                                <td style="text-align: center;    border: 1px solid;">{{$value['Thu-routes']}}</td>
                                <td style="text-align: center;    border: 1px solid;">{{$value['Thu-drops']}}</td>
                                <td style="text-align: center;    border: 1px solid;">{{$value['Fri-routes']}}</td>
                                <td style="text-align: center;    border: 1px solid;">{{$value['Fri-drops']}}</td>
                                <td style="text-align: center;    border: 1px solid;">{{$value['Sat-routes']}}</td>
                                <td style="text-align: center;    border: 1px solid;">{{$value['Sat-drops']}}</td>
                                <td style="text-align: center;    border: 1px solid;">{{$value['Sun-routes']}}</td>
                                <td style="text-align: center;    border: 1px solid;">{{$value['Sun-drops']}}</td>
                                <td style="text-align: center;    border: 1px solid;">{{round(($value['Mon-routes']+ $value['Tue-routes']+$value['Wed-routes']+ $value['Thu-routes']+ $value['Fri-routes']+  $value['Sat-routes']+ $value['Sun-routes'])/$divideDays)}}</td>
                                <td style="text-align: center;    border: 1px solid;">{{round(($value['Mon-drops']+ $value['Tue-drops']+$value['Wed-drops']+ $value['Thu-drops']+ $value['Fri-drops']+  $value['Sat-drops']+ $value['Sun-drops'])/$divideDays)}}</td>
                                <td style="text-align: center;    border: 1px solid;">{{$value['Mon-drops']+ $value['Tue-drops']+$value['Wed-drops']+ $value['Thu-drops']+ $value['Fri-drops']+  $value['Sat-drops']+ $value['Sun-drops']}}</td>



                            </tr>
                            @endforeach
                        @endif    
                    </tbody>
                </table>
            </div>

        @endif
    
  </div>
                
            
            
            
        
    </div>
    
 
              



<!-- footer content -->
{{-- <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script> --}}
{{-- <script src="{{ asset('backend/js/jquery.table2excel.js') }}"></script> --}}
<script src="{{ asset('backend/js/jquery-toExcel.min.js') }}"></script>



{{-- <script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script> --}}
<script type="text/javascript">
    var tableToExcel = (function () {
        // Define your style class template.
        var name="Route-volume-state-{{$hubname}}";
        var style = "<style>.green { background-color: green; }</style>";
        var uri = 'data:application/vnd.ms-excel;base64,',
             template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns=""><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->' + style + '</head><body><table>{table}</table></body></html>'
            , base64 = function (s) {
                return window.btoa(unescape(encodeURIComponent(s)))
            }
            , format = function (s, c) {
                return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; })
            }
        return function (table, name) {
            if (!table.nodeType) table = document.getElementById(table)
            var ctx = { worksheet: "Route-volume-state-{{$hubname}}" || "Route-volume-state-{{$hubname}}", table: table.innerHTML }
            // window.location.href = uri + base64(format(template, ctx))
            var a = document.createElement('a');
            a.href = uri + base64(format(template, ctx))
            a.download = "Route-volume-state-{{$hubname}}"+'.xls';
            //triggering the function
            a.click();
        }
    })()
</script>
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
{{-- <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script> --}}
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="{{ backend_asset('js/weekpicker/weekpicker.js') }}"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/flick/jquery-ui.css">
<!-- <script>
    (function ( $ ) {
        $( "#week_ww_yyyy" ).weekpicker({

            // set start day of the week
            firstDay: 1,

            // custom date format
            dateFormat: "yy/m/dd",

            // shows other months
            showOtherMonths: true,

            // allows to select other months
            selectOtherMonths: true,

            // shows the current week number
            showWeek: true,

            // supported keywords:
            //  w  = week number, eg. 3
            //  ww = zero-padded week number, e.g. 03
            //  o  = short (week) year number, e.g. 18
            //  oo = long (week) year number, e.g. 2018
            weekFormat: "w/oo",
            
            });
    } )(jQuery)
</script> -->

<script>



//     $(document).ready(function(){
//     $("#button_create_excel").click(function() {
//         let table = document.getElementsByTagName("table");
//         TableToExcel.convert(table[0], { // html code may contain multiple tables so here we are refering to 1st table tag
//            name: `export.xls`, // fileName you could use any name
//            sheet: {
//               name: 'Sheet 1' // sheetName
//            }
//         });
//     });
// });
    $('form').submit(function () {

        // Get the Login Name value and trim it
        var hub = $.trim($('#hub').val());

        // Check if empty of not
        if (hub  === '') {
            alert('Select a hub to search.');
            return false;
        }
    });
    // $("#button_create_excel").click(function(){
    //         $("#export_table").table2excel({
    //             // exclude CSS class
    //             exclude: ".noExl",
    //             name: "Worksheet Name",
    //             filename: "Route-volume-state-{{$hubname}}", //do not include extension
    //             fileext: ".xls", // file extension
    //             preserveColors:true

    //         });
    //         });
</script>
<!-- /footer content -->
<!-- /#page-wrapper -->
@endsection