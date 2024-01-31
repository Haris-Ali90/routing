<?php

namespace App\Http\Controllers\Backend;

use Config;

use App\Hub;

// use App\Http\Requests;
use App\Task;
use App\Zone;
use DateTime;
use App\Client;
use App\Sprint;

use App\Vendor;
use DatePeriod;
use App\SlotJob;
use DateInterval;
use App\AmazonEntry;
use App\MerchantIds;
use App\TaskHistory;
use App\RoutingZones;
use App\UserEntities;
use App\EnableRouteFile;
use App\SprintReattempt;
use App\ContactUncrypted;
use App\CustomRoutingFile;
use App\JoeyCapacityDetail;
use App\LocationUnencrypted;
use Illuminate\Http\Request;
use App\CustomRoutingTrackingId;

//use Validator;

use App\EnableForRoutesTrackingId;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Backend\CategoryRequest;
use App\Http\Controllers\Backend\BackendController;
use Illuminate\Support\Facades\Request as FacadeRequest;

class RouteVolumeStateController extends BackendController
{
    public function routeVolumeState(Request $request)
    {
        $hubid=$request->get('hub');
        $weekpicker=$request->get('weekpicker');
        $hubid=base64_decode($hubid);
        // if($hubid==null || $hubid==''){
        //     return backend_view('route_volume_state/route_volume_state-report');
        // }
        // else
        // {
            // echo $weekpicker;die;
            // ----------------------For selected week---------------------------------------------------
            if(!empty($weekpicker)){  
                $ddate = $weekpicker;
                $date = new DateTime($ddate);
                $week_number = $date->format("W");
                // echo "Weeknummer: $week";die;

                // $week_number = $week; 
                $year = date('Y', strtotime($weekpicker));
                $s_day='';
                $e_day='';
                for($day=1; $day<=7; $day++)
                {
                    // echo date('Y-m-d', strtotime($year."W".$week_number.$day))."\n";
                    if($day==1){
                        $s_day=date('Y-m-d', strtotime($year."W".$week_number.$day));
                    }
                    elseif($day==7){
                        $e_day=date('Y-m-d', strtotime($year."W".$week_number.$day));
                    }
                }
                // echo $s_day."\n".$e_day;
                // die;


                $this_week_sd = $s_day;
                $this_week_ed = $e_day;
                // die;
            }
            // ----------------------For selected week---------------------------------------------------

            // ----------------------For current week---------------------------------------------------
                //Get curent week first and last date;
            else{
                $date = new DateTime(date('Y-m-d'));
                $week_number = $date->format("W");
                
                $monday = strtotime("last monday");

                $monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;

                $sunday = strtotime(date("Y-m-d",$monday)." +6 days");
                $this_week_sd = date("Y-m-d",$monday);
                $this_week_ed = date("Y-m-d",$sunday);
            }

            // --------------------------For current week-----------------------------------------------
            $divideDays=7;
            $currentdate = new DateTime(date('Y-m-d'));
            $currentweek = $currentdate->format("W");
            // echo date('w'); 
            // echo "current Weeknummer: $currentweek"."   selected Weeknummer: $week_number";die;
            if($currentweek==$week_number){ //date('w') 0 for sunday and 6 for saturday
                if(date('w')!=0){
                    $divideDays=date('w');
                }
            }

            //Get curent week dates between above two dates;
             $start  = new DateTime($this_week_sd);
             $end    = new DateTime($this_week_ed);

            //$start  = new DateTime('2021-02-01');
            //$end    = new DateTime('2021-02-07');
    
            $end->modify('+1 day');
            $period = new DatePeriod($start, new DateInterval('P1D'), $end);
            $day=[];
            foreach ($period as $key => $value) {

                $day[] = $value->format('Y-m-d');
            }
            $totalRoutes['Mon-routes']=0;
            $totalRoutes['Mon-drops']=0;
            $totalRoutes['Tue-routes']=0;
            $totalRoutes['Tue-drops']=0;
            $totalRoutes['Wed-routes']=0;
            $totalRoutes['Wed-drops']=0;
            $totalRoutes['Thu-routes']=0;
            $totalRoutes['Thu-drops']=0;
            $totalRoutes['Fri-routes']=0;
            $totalRoutes['Fri-drops']=0;
            $totalRoutes['Sat-routes']=0;
            $totalRoutes['Sat-drops']=0;
            $totalRoutes['Sun-routes']=0;
            $totalRoutes['Sun-drops']=0;
            $result=[];
            $zones_routing=RoutingZones::where('hub_id',$hubid)->whereNull('deleted_at')->whereNull('is_custom_routing')->get();

            if(count($zones_routing)==0){
                // session()->flash('alert-danger', 'No data found!');
                // return redirect( 'backend/route-volume-state');
                return backend_view( 'route_volume_state/route_volume_state-report',compact('hubid','period','result','totalRoutes','this_week_sd','this_week_ed','divideDays'));
            }else{
                $count=0;


                foreach ($zones_routing as $zone_routing_key => $zone_routing_value) {
                    $result[$count]['id']=$zone_routing_value->id;
                    $result[$count]['name']=$zone_routing_value->title;
                    $result[$count]['type']=isset($zone_routing_value->zoneType)?$zone_routing_value->zoneType->title:'';


                    $result[$count]['Mon-routes']=0;
                    $result[$count]['Mon-drops']=0;

                    $result[$count]['Tue-routes']=0;
                    $result[$count]['Tue-drops']=0;

                    $result[$count]['Wed-routes']=0;
                    $result[$count]['Wed-drops']=0;

                    $result[$count]['Thu-routes']=0;
                    $result[$count]['Thu-drops']=0;

                    $result[$count]['Fri-routes']=0;
                    $result[$count]['Fri-drops']=0;

                    $result[$count]['Sat-routes']=0;
                    $result[$count]['Sat-drops']=0;

                    $result[$count]['Sun-routes']=0;
                    $result[$count]['Sun-drops']=0;

                    if(count($zone_routing_value->joeyRoutes)>0){

                        foreach ($zone_routing_value->joeyRoutes as $joeyRoutes_key => $joeyRoutes_value) {


                            if($joeyRoutes_value->ConvertedDate >= $day[0]." 00:00:00" && $joeyRoutes_value->ConvertedDate <=  $day[0]." 23:59:59" && $joeyRoutes_value->deleted_at==null){ //Mon
                                $totalRoutes['Mon-drops']+=count($joeyRoutes_value->joeyRouteLocations);
                                $result[$count]['Mon-drops']+=count($joeyRoutes_value->joeyRouteLocations);
                                if(count($joeyRoutes_value->joeyRouteLocations)>0){
                                    $totalRoutes['Mon-routes']+=1;
                                    $result[$count]['Mon-routes']+=1;    
                                }
                            }
                            elseif($joeyRoutes_value->ConvertedDate >= $day[1]." 00:00:00" && $joeyRoutes_value->ConvertedDate <= $day[1]." 23:59:59" && $joeyRoutes_value->deleted_at==null){ //Tue
                                $totalRoutes['Tue-drops']+=count($joeyRoutes_value->joeyRouteLocations);
                                $result[$count]['Tue-drops']+=count($joeyRoutes_value->joeyRouteLocations);
                                if(count($joeyRoutes_value->joeyRouteLocations)>0){
                                    $totalRoutes['Tue-routes']+=1;
                                    $result[$count]['Tue-routes']+=1;
    
                                }


                            }
                            elseif($joeyRoutes_value->ConvertedDate >= $day[2]." 00:00:00" && $joeyRoutes_value->ConvertedDate <=  $day[2]." 23:59:59" && $joeyRoutes_value->deleted_at==null){ //Wed
                                $totalRoutes['Wed-drops']+=count($joeyRoutes_value->joeyRouteLocations);
                                $result[$count]['Wed-drops']+=count($joeyRoutes_value->joeyRouteLocations);
                                if(count($joeyRoutes_value->joeyRouteLocations)>0){
                                    $totalRoutes['Wed-routes']+=1;
                                    $result[$count]['Wed-routes']+=1;
    
                                }

                            }
                            elseif($joeyRoutes_value->ConvertedDate >= $day[3]." 00:00:00" && $joeyRoutes_value->ConvertedDate <=  $day[3]." 23:59:59" && $joeyRoutes_value->deleted_at==null){ //Thu
                                $totalRoutes['Thu-drops']+=count($joeyRoutes_value->joeyRouteLocations);
                                $result[$count]['Thu-drops']+=count($joeyRoutes_value->joeyRouteLocations);
                                if(count($joeyRoutes_value->joeyRouteLocations)>0){
                                    $totalRoutes['Thu-routes']+=1;
                                    $result[$count]['Thu-routes']+=1;
    
                                }

                            }
                            elseif($joeyRoutes_value->ConvertedDate >= $day[4]." 00:00:00" && $joeyRoutes_value->ConvertedDate <= $day[4]." 23:59:59" && $joeyRoutes_value->deleted_at==null){ //Fri
                                $totalRoutes['Fri-drops']+=count($joeyRoutes_value->joeyRouteLocations);
                                $result[$count]['Fri-drops']+=count($joeyRoutes_value->joeyRouteLocations);
                                if(count($joeyRoutes_value->joeyRouteLocations)>0){
                                    $totalRoutes['Fri-routes']+=1;
                                    $result[$count]['Fri-routes']+=1;
    
                                }

                            }
                            elseif($joeyRoutes_value->ConvertedDate >= $day[5]." 00:00:00" && $joeyRoutes_value->ConvertedDate <=  $day[5]." 23:59:59" && $joeyRoutes_value->deleted_at==null){ //Sat
                                $totalRoutes['Sat-drops']+=count($joeyRoutes_value->joeyRouteLocations);
                                $result[$count]['Sat-drops']+=count($joeyRoutes_value->joeyRouteLocations);
                                if(count($joeyRoutes_value->joeyRouteLocations)>0){
                                    $totalRoutes['Sat-routes']+=1;
                                    $result[$count]['Sat-routes']+=1;
    
                                }

                            }
                            elseif($joeyRoutes_value->ConvertedDate >= $day[6]." 00:00:00" && $joeyRoutes_value->ConvertedDate <= $day[6]." 23:59:59" && $joeyRoutes_value->deleted_at==null){ //Sun
                                $totalRoutes['Sun-drops']+=count($joeyRoutes_value->joeyRouteLocations);
                                $result[$count]['Sun-drops']+=count($joeyRoutes_value->joeyRouteLocations);
                                if(count($joeyRoutes_value->joeyRouteLocations)>0){
                                    $totalRoutes['Sun-routes']+=1;
                                    $result[$count]['Sun-routes']+=1;
    
                                }

                            }

                        }

                    }
                    $count++;
                }
            }
            // echo $divideDays;die; 
            return backend_view( 'route_volume_state/route_volume_state-report',compact('hubid','period','result','totalRoutes','this_week_sd','this_week_ed','divideDays'));
        // }
    }
}
