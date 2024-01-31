<?php

namespace App\Http\Controllers\Backend;

use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Backend\BackendController;


use App\Amazon;
use App\JoeyRoute;
use DB;
use Carbon\Carbon;

class DashboardController extends BackendController
{
    public function getIndex()
    {

      $startdate = date('Y').'-01-01 00:00:00';
      $enddate = date('Y').'-12-31 23:59:59';
      $todaydate = Carbon::now()->format('Y-m-d');
       //dd($todaydate);
      $count_montreal = DB::table('joey_routes')
          // ->select(DB::raw('sum(id) as `total`'),  DB::raw('MONTH(created_at) as  month'))
         ->where('date','like',$todaydate."%")
         ->whereNull('deleted_at')
          ->where(['hub' => 16])
          ->whereNull('deleted_at')
          ->count();
   
      $count_ottawa = DB::table('joey_routes')
          // ->select(DB::raw('sum(id) as `total`'),  DB::raw('MONTH(created_at) as month'))
          ->where('date','like',$todaydate."%")
          ->where('hub',19)
          ->whereNull('deleted_at')
          ->count();
         
      $count_ctc = DB::table('joey_routes')
      ->where('date','like',$todaydate."%")
          ->where(['hub' => 17])
          ->whereNull('deleted_at')
          ->count();

          $count_vanc = DB::table('joey_routes')
          ->where('date','like',$todaydate."%")
              ->where(['hub' => 129])
              ->whereNull('deleted_at')
              ->count();

        
     
      $startdate = date('y') . '-01-01 00:00:00';
      $enddate = date('y') . '-12-31 23:59:59';

      // JoeyRoute::where('date', '>=', $startdate)
      // ->where('date', '<=', $enddate)->whereIn('hub',[16,19,17])->get()->toArray();
      $total_dashboard_count_data = JoeyRoute::orderBy('created_at',"asc")->whereNull('deleted_at')->where('date', '>=', $startdate)
      ->where('date', '<=', $enddate)->whereIn('hub',[16,19,17,129])->get()->toArray();
      
      // dd($amazon_dashboard_count);
      //$ctc_dashboard_count = JoeyRoute::orderBy('created_at',"asc")->where('hub',17)->get()->toArray();
  
      //array_merge($amazon_dashboard_count,$ctc_dashboard_count);
      // $labels =  ['Month','Amazon Montreal Orders','Amazon Ottawa Orders','Canadian Tire Orders'];
      $months_array = [
          '1'=>['month'=>'Jan','montreal_total'=>0,'ottawa_total'=>0,'ctc_total'=>0,'vanc_total'=>0],
          '2'=>['month'=>'Feb','montreal_total'=>0,'ottawa_total'=>0,'ctc_total'=>0,'vanc_total'=>0],
          '3'=>['month'=>'Mar','montreal_total'=>0,'ottawa_total'=>0,'ctc_total'=>0,'vanc_total'=>0],
          '4'=>['month'=>'Apr','montreal_total'=>0,'ottawa_total'=>0,'ctc_total'=>0,'vanc_total'=>0],
          '5'=>['month'=>'May','montreal_total'=>0,'ottawa_total'=>0,'ctc_total'=>0,'vanc_total'=>0],
          '6'=>['month'=>'Jun','montreal_total'=>0,'ottawa_total'=>0,'ctc_total'=>0,'vanc_total'=>0],
          '7'=>['month'=>'Jul','montreal_total'=>0,'ottawa_total'=>0,'ctc_total'=>0,'vanc_total'=>0],
          '8'=>['month'=>'Aug','montreal_total'=>0,'ottawa_total'=>0,'ctc_total'=>0,'vanc_total'=>0],
          '9'=>['month'=>'Sep','montreal_total'=>0,'ottawa_total'=>0,'ctc_total'=>0,'vanc_total'=>0],
          '10'=>['month'=>'Oct','montreal_total'=>0,'ottawa_total'=>0,'ctc_total'=>0,'vanc_total'=>0],
          '11'=>['month'=>'Nov','montreal_total'=>0,'ottawa_total'=>0,'ctc_total'=>0,'vanc_total'=>0],
          '12'=>['month'=>'Dec','montreal_total'=>0,'ottawa_total'=>0,'ctc_total'=>0,'vanc_total'=>0]
      ];
      foreach($total_dashboard_count_data as $data)
      {
       
          // getting month
       
          $getting_month = (int) explode('-',$data['date'])[1];
         

          //checking data for every type
          if($data['hub']==17) // checking for ctc
          {
              $months_array[$getting_month]['ctc_total']=  $months_array[$getting_month]['ctc_total']+1;
          }
          elseif($data['hub'] == 16) // checking for montreal 477260
          {
              $months_array[$getting_month]['montreal_total']= $months_array[$getting_month]['montreal_total']+1 ;
          }
          elseif($data['hub'] == 19) // checking for ottawa 477282
          {
              $months_array[$getting_month]['ottawa_total']= $months_array[$getting_month]['ottawa_total']+1;
          }

          elseif($data['hub'] == 129) // checking for ottawa 477282
          {
              $months_array[$getting_month]['vanc_total']= $months_array[$getting_month]['vanc_total']+1;
          }


      }
    


      // setting months data
      $bar_chart_data = $months_array;
      $bar_chart_data =  json_encode($bar_chart_data,JSON_FORCE_OBJECT);

      
      
      return backend_view( 'dashboard', compact(
            
          
           
        'count_montreal',
        'count_ottawa',
        'count_ctc',
        'count_vanc',
        'bar_chart_data',
        "todaydate"
    ));
    }

    //Montreal Function
    public function getMontreal(Request $request)
    { 
      $todaydate = Carbon::now()->format('Y-m-d');
      $date = $request->input('datepicker');
       if ($date) {
         $amazon_dash = Amazon::Where('created_at','like',$date."%")
                              ->where(['vendor_id' => 477260])
                              ->get();
       }
       else{
        $amazon_dash = Amazon::Where('created_at','like',$todaydate."%")
                              ->Where(['vendor_id' => 477260])
                              ->get();
       }
        //$montreal = Amazon::where(['vendor_id' => 477260])->count();
        //$ottawa = Amazon::where(['vendor_id' => 477282])->count();
        return backend_view( 'montrealdashboard.montreal_dashboard', compact('amazon_dash'/*,'montreal','ottawa'*/));
    }


    public function montrealProfile(Request $request, $id)
    {
        $amazon_montreal  = Amazon::where(['id' => $id])->get();
        $amazon_montreal = $amazon_montreal[0];
        
        return backend_view( 'montrealdashboard.montreal_profile', compact('amazon_montreal' ) );
    }

    //Ottawa Function
    public function getOttawa(Request $request)
    { $todaydate = Carbon::now()->format('Y-m-d');
      $date = $request->input('datepicker');
       if ($date) {
          $ottawa_dash = Amazon::Where('created_at','like',$date."%")
                                ->where(['vendor_id' => 477282])
                                ->get(); 
       }
       else{
       $ottawa_dash = Amazon::Where('created_at','like',$todaydate."%")
                            ->Where(['vendor_id' => 477282])
                            ->get();
       }

        return backend_view( 'ottawadashboard.ottawa_dashboard', compact('ottawa_dash'));
    }


    public function ottawaProfile(Request $request, $id)
    {
        $amazon_ottawa  = Amazon::where(['id' => $id])->get();
        $amazon_ottawa = $amazon_ottawa[0];
        
        return backend_view( 'ottawadashboard.ottawa_profile', compact('amazon_ottawa' ) );
    }

    //Sub Menus Of Montreal And Ottawa

    public function getSorter(Request $request)
    {
      $todaydate = Carbon::now()->format('Y-m-d');
      $date = $request->input('datepicker');
       if ($date) {
         $sort_order = Amazon::Where('created_at','like',$date."%")
                             ->where(['vendor_id' => 477260])
                             ->where(['task_status' => 133])
                             ->get();
       }
       else{
        $sort_order = Amazon::Where('created_at','like',$todaydate."%")
                            ->where(['task_status' => 133  , 'vendor_id' => 477260])
                            ->get();
       }

      return backend_view( 'submenu.sorted_order', compact('sort_order'));
    }



    public function getOttawatsort(Request $request)
    {
      $todaydate = Carbon::now()->format('Y-m-d');
       $date = $request->input('datepicker');

       if ($date) {
         $sort_order = Amazon::Where('created_at','like',$date."%")
                             ->where(['vendor_id' => 477282])
                             ->where(['task_status' => 133])
                             ->get();
       }
       else{
        $sort_order = Amazon::Where('created_at','like',$todaydate."%")
                            ->where(['task_status' => 133  , 'vendor_id' => 477282])
                            ->get();
       }

      return backend_view( 'submenu.sorted_order', compact('sort_order'));
    }

    //Hub Orders
    public function getMontrealhub(Request $request)
    {
      $todaydate = Carbon::now()->format('Y-m-d');
      $date = $request->input('datepicker');

       if ($date) {
         $hub_order = Amazon::Where('created_at','like',$date."%")
                            ->where(['vendor_id' => 477260])
                            ->where(['task_status' => 121])
                            ->get();
       }
       else{
        $hub_order = Amazon::Where('created_at','like',$todaydate."%")
                           ->where(['task_status' => 121  , 'vendor_id' => 477260])
                           ->get();
       }

      return backend_view( 'submenu.pickup_hub', compact('hub_order'));
    }


    public function getOttawathub(Request $request)
    {
      $todaydate = Carbon::now()->format('Y-m-d');
      $date = $request->input('datepicker');

       if ($date) {
         $hub_order = Amazon::Where('created_at','like',$date."%")
                            ->where(['vendor_id' => 477282])
                            ->where(['task_status' => 121])
                            ->get();
       }
       else{
        $hub_order = Amazon::Where('created_at','like',$todaydate."%")
                           ->where(['task_status' => 121  , 'vendor_id' => 477282])
                           ->get();
       }

      return backend_view( 'submenu.pickup_hub', compact('hub_order'));
    }



    //Not Scan
    public function getMontnotscan(Request $request)
    {
      $todaydate = Carbon::now()->format('Y-m-d');
      $date = $request->input('datepicker');

       if ($date) {
         $notscan_order = Amazon::Where('created_at','like',$date."%")
                                ->where(['vendor_id' => 477260])
                                ->where(['task_status' => 61])
                                ->get();
       }
       else{
         $notscan_order = Amazon::Where('created_at','like',$todaydate."%")
                                ->where(['task_status' => 61  , 'vendor_id' => 477260])
                                ->get();
       }

      return backend_view( 'submenu.not_scanned_orders', compact('notscan_order'));
    }



    public function getOttawatnotscan(Request $request)
    {
      $todaydate = Carbon::now()->format('Y-m-d');
      $date = $request->input('datepicker');

       if ($date) {
         $notscan_order = Amazon::Where('created_at','like',$date."%")
                                ->where(['vendor_id' => 477282])
                                ->where(['task_status' => 61])
                                ->get();
       }
       else{
         $notscan_order = Amazon::Where('created_at','like',$todaydate."%")
                                ->where(['task_status' => 61  , 'vendor_id' => 477282])
                                ->get();
       }
      
      return backend_view( 'submenu.not_scanned_orders', compact('notscan_order'));
    }



    //Delivered Orders
    public function getMontdelivered(Request $request)
    {
       $todaydate = Carbon::now()->format('Y-m-d');
      $date = $request->input('datepicker');
      
       if ($date) {
         $delivered_order = DB::table('amazon_dashboard')
                    ->Where('created_at','like',$date."%")
                    ->whereNotIn('task_status', [133, 121, 61])
                    ->where('vendor_id', [477260])
                    ->get();
       }
       else{
         $delivered_order = DB::table('amazon_dashboard')
                    ->Where('created_at','like',$todaydate."%")
                    ->whereNotIn('task_status', [133, 121, 61])
                    ->where('vendor_id', [477260])
                    ->get();
       }

      /*$delivered_order = Amazon::where(['task_status' => 73  , 'vendor_id' => 477260])->get();*/
      
      return backend_view( 'submenu.delivered_orders', compact('delivered_order'));
    }

    public function getOttawadelivered(Request $request)
    {
       $todaydate = Carbon::now()->format('Y-m-d');

      $date = $request->input('datepicker');
       if ($date) {
                     $delivered_order = DB::table('amazon_dashboard')
                    ->Where('created_at','like',$date."%")
                    ->whereNotIn('task_status', [133, 121, 61])
                    ->where('vendor_id', [477282])
                    ->get();
       }
       else{
          $delivered_order = DB::table('amazon_dashboard')
                    ->Where('created_at','like',$todaydate."%")
                    ->whereNotIn('task_status', [133, 121, 61])
                    ->where('vendor_id', [477282])
                    ->get();
       }

      /*$delivered_order = Amazon::where(['task_status' => 73  , 'vendor_id' => 477282])->get();*/
      /*$delivered_order = Amazon::whereIn(['task_status' => [73, 32, 24]  , 'vendor_id' => 477282])->get();*/
     
      return backend_view( 'submenu.delivered_orders', compact('delivered_order'));
    }

}
