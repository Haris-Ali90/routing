<?php

namespace App;
use App\JoeyRoute;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JoeyRouteLocations extends Model
{

    protected $table = 'joey_route_locations';
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'id', 'name', 'created_at','updated_at','deleted_at',
    // ];


    public static  function getDurationOfRoute($id)
    {
        $data=self::where('route_id','=',$id)->whereNull('deleted_at')->orderby('id');
       //$first_element=" 11:30:00";
       
       $first_element=$data->first();
    //   dd($first_element);
       $last_element=self::where('route_id','=',$id)->whereNull('deleted_at')->orderby('id','DESC')->first();
    //   print_r($first_element->arrival_time);
       //" 12:30:00";
       //$data->last();
       if(isset($first_element->arrival_time)){
           if(strpos($first_element->arrival_time,'-') && strpos($first_element->arrival_time,'T'))
       {
        //   dd('asdasd');
        $arrival_time=explode("T",$first_element->arrival_time);
        $last_element=explode("T",$last_element->finish_time);
        $arrival_time=$arrival_time[0]." ".explode("-",$arrival_time[1])[0];
        $last_element=$last_element[0]." ".explode("-",$last_element[1])[0];
           $date1= new \DateTime($arrival_time);
           $date2 = new \DateTime($last_element);
           $interval = $date1->diff($date2);
           // echo($interval->h.":".$interval->i."".$interval->s);
           return $interval->format("%H:%I:%S");    
        
       }
       if(!empty($first_element) && !empty($last_element))
       {

            $arrival_time=explode(":",$first_element->arrival_time);
            $finish_time=explode(":",$last_element->finish_time);
            if(isset($arrival_time[1]) && isset($finish_time[1]))
            {
                
                $duration[0]=$finish_time[0]-$arrival_time[0];
                $duration[1]=$finish_time[1]-$arrival_time[1];
                if($duration[1]<0)
                {
                    $duration[0]--;
                    $duration[1]=60+$duration[1];
                }
                if($duration[0]<10)
                {
                    $duration[0]="0".$duration[0];
                }
                if($duration[1]<10)
                {
                    $duration[1]="0".$duration[1];
                }
              
                return $duration[0].':'.$duration[1].':00';  
            }
         
      

      
    
       }
       }
       
       return 0;

    }
 public function getJoeyRoute()
    {
        return  $this->belongsTo(new JoeyRoute(),'route_id')->whereNull('deleted_at');
    }

    public static function getOrderCount($routeId)
    {
        $date = date('Y-m-d');
        // get all tasks ids in joey locations table
        $taskIds = JoeyRouteLocations::where('route_id',$routeId)->pluck('task_id')->toArray();

        $miJobRoute = MiJobRoute::where('route_id', $routeId)->first();

        $miJobLocationId = MiJobDetail::where('type', 'pickup')->where('mi_job_id', $miJobRoute->mi_job_id)->whereIn('locationid', $taskIds)->pluck('locationid')->toArray();

        $scannedBy = User::whereIn('hub_id', $miJobLocationId)->pluck('id')->toArray();

        //get sprint ids against ids variable
        $microHubOrderSprintId = MicroHubOrder::whereHas('sprint', function($query){
            $query->where('status_id', 148)->whereNotIn('status_id', [36])->whereNull('deleted_at');
        })->where('is_my_hub', 0)
            ->whereIn('scanned_by', $scannedBy)
//            ->where('created_at', 'LIKE', $date.'%')
            ->whereNull('deleted_at')
            ->groupBy('hub_id')
            ->pluck('sprint_id')
            ->toArray();


        $sprintIds = CurrentHubOrder::whereIn('hub_id', $miJobLocationId)->where('is_actual_hub', 0)->pluck('sprint_id');

        $hubBundleOther = MicroHubOrder::whereHas('sprint', function($query) {
            $query->whereIn('status_id', [150])->whereNotIn('status_id', [36])->whereNull('deleted_at');
        })->whereIn('sprint_id',$sprintIds)
//            ->whereDate('created_at', 'LIKE', $date.'%')
            ->whereNull('deleted_at')
            ->groupBy('bundle_id')
            ->pluck('sprint_id')
            ->toArray();

//        dd($microHubOrderSprintId, $hubBundleOther);

        $microhubBundle = array_merge($microHubOrderSprintId, $hubBundleOther);

        $sprintId = Sprint::whereIn('creator_id', $taskIds)
            ->where('status_id', 61)
            ->whereNotIn('status_id', [36])
//            ->where('created_at', 'LIKE', $date.'%')
            ->whereNull('deleted_at')
            ->pluck('id')
            ->toArray();

        // merge all sprint ids through array merge
        $mergeSprintIds = array_merge($sprintId, $microhubBundle);
//        dd($mergeSprintIds);
        // remove duplicate sprint ids in array merge
        $uniqueSprintIds  = array_unique($mergeSprintIds);

        $orderCount = Task::join('sprint__contacts','sprint__tasks.contact_id','=','sprint__contacts.id')
            ->join('locations','sprint__tasks.location_id','=','locations.id')
            ->where('sprint__tasks.type', '=', 'pickup')
            ->where('ordinal','=',1)
            ->whereIn('sprint__tasks.sprint_id', $uniqueSprintIds)->count();

        return $orderCount;

    }
}
