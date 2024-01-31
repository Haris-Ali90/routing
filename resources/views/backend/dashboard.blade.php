@extends( 'backend.layouts.app' )

@section('title', 'Dashboard')

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

    <div class="right_col" role="main">
        
        <div class="container">
            <div class="row">
                    <div class="text-center">
                        <h3>{{$todaydate}}</h3>
                    </div>
            </div>
        </div>

        <div class="row c-m">
            <div class="row c-m">
                <div class="col-sm-3" >  
                    <div class="page-title">
                            <div class="title_left amazon-text">
                                <h3>Montreal Routes<small></small></h3>
                            </div>
                    </div>

                    <div class="clearfix"></div>
                        <!--Count Div Row Open-->
                        <div class="row ">

                            <!--top_tiles Div Open-->
                            <div class="top_tiles montreal-dashbord-tiles">

                                <!--Animated-a Div Open-->
                                <div class="animated flipInY col-md-12 col-sm-12 ">
                                    <div class="tile-stats">
                                        <div class="icon">
                                            <i class="fa fa-cubes"></i>
                                        </div>
                                        <div class="count">{{ isset($count_montreal)?$count_montreal:0 }}</div>
                                        <h3>Total Routes</h3>
                                    </div>
                                </div>
                                <!--Animated-a Div Close-->
                            </div>
                            <!--top_tiles Div Close-->

                        </div>
                        <!--Count Div Row Close-->
                </div>

                <div class="col-sm-3" >
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="page-title">
                            <div class="title_left amazon-text">
                                <h3>Ottawa Routes<small></small></h3>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <!--Count Div Row Open-->
                        <div class="row ">

                            <!--top_tiles Div Open-->
                            <div class="top_tiles montreal-dashbord-tiles">

                                <!--Animated-a Div Open-->
                                <div class="animated flipInY  col-md-12 col-sm-12 ">
                                    <div class="tile-stats">
                                        <div class="icon">
                                            <i class="fa fa-cubes"></i>
                                        </div>
                                        <div class="count">{{ isset($count_ottawa)?$count_ottawa:0 }}</div>
                                        <h3>Total Routes</h3>
                                    </div>
                                </div>
                                <!--Animated-a Div Close-->
                            </div>
                            <!--top_tiles Div Close-->

                        </div>
                        <!--Count Div Row Close-->
                    </div>
                </div>

                <div class="col-sm-3" >
                    <div class="page-title">
                            <div class="title_left amazon-text">
                                <h3>Toronto Routes<small></small></h3>
                            </div>
                    </div>

                    <div class="clearfix"></div>
                        <!--Count Div Row Open-->
                    <div class="row">

                            <!--top_tiles Div Open-->
                            <div class="top_tiles montreal-dashbord-tiles">

                                <!--Animated-a Div Open-->
                                <div class="animated flipInY  col-md-12 col-sm-12 ">
                                    <div class="tile-stats">
                                        <div class="icon">
                                            <i class="fa fa-cubes"></i>
                                        </div>
                                        <div class="count">{{ isset($count_ctc)?$count_ctc:0 }}</div>
                                        <h3>Total Routes</h3>
                                    </div>
                                </div>
                                <!--Animated-a Div Close-->

                            </div>
                            <!--top_tiles Div Close-->

                    </div>
                </div>

                <div class="col-sm-3" >
                    <div class="page-title">
                            <div class="title_left amazon-text">
                                <h3>Vancouver Routes<small></small></h3>
                            </div>
                    </div>

                    <div class="clearfix"></div>
                        <!--Count Div Row Open-->
                    <div class="row">

                            <!--top_tiles Div Open-->
                            <div class="top_tiles montreal-dashbord-tiles">

                                <!--Animated-a Div Open-->
                                <div class="animated flipInY  col-md-12 col-sm-12 ">
                                    <div class="tile-stats">
                                        <div class="icon">
                                            <i class="fa fa-cubes"></i>
                                        </div>
                                        <div class="count">{{ isset($count_vanc)?$count_vanc:0 }}</div>
                                        <h3>Total Routes</h3>
                                    </div>
                                </div>
                                <!--Animated-a Div Close-->

                            </div>
                            <!--top_tiles Div Close-->

                    </div>
                </div>

            </div>
        </div>
        
        <div class="row">              
        @include('backend.dashboard-layout.barchat-graph')
        </div>
                
    </div>


<!-- footer content -->

<!-- /footer content -->
<!-- /#page-wrapper -->
@endsection