<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//use Illuminate\Database\Eloquent\SoftDeletes;

class JoeyRoute extends Model
{
	 public $timestamps = false;

    use SoftDeletes; //add this line
    protected $table = 'joey_routes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_incomplete'
    ];
 
    // new work
    public function joeyRouteLocations()
    {
        return $this->hasMany(JoeyRouteLocations::class,'route_id','id')->whereNull('deleted_at');
    }

    //new model helper function
    public function getConvertedDateAttribute()
    {
        return ConvertTimeZone($this->date,'UTC','America/Toronto');
    }
    /*Added By Muhammad Raqib @date 20/09/2022*/
    public function joey()
    {
        return $this->belongsTo(Joey::class);
    }

    public static  function getCartnoOfRoute($id)
    {
        $zone_route_data=self::
        //join('zones_routing','zones_routing.id','=','joey_routes.zone')->
        where('joey_routes.id','=',$id)
         ->whereNull('joey_routes.deleted_at')
        ->orderby('joey_routes.id')
        ->first(['joey_routes.date','joey_routes.zone','joey_routes.hub']);
       if($zone_route_data==null)
       {
          return null;
       }
        $data=date('Y-m-d',strtotime($zone_route_data->date));
        $routedata=self::where('zone','=',$zone_route_data->zone)->where('date','like',$data."%")->orderby('id')->get();
        $zone_data=RoutingZones::where('hub_id',$zone_route_data->hub)
        ->whereNull('deleted_at')
        ->get();
        // dd($zone_data);
        $j=0;
        $order_range=null;
        foreach($zone_data as $data)
        {
            if($data->id==$zone_route_data->zone)
            {
                $order_range=$data->order_range;
                break;
            }
            $j++;
        }
        $i=65;
        foreach($routedata as $data)
        {
            if($data->id==$id)
            {
                break;
            }
            $i++;
        }
        if($order_range==null)
        {
            $order_range=10;
        }
        //dd($j)
       return ['zone_cart_no'=>($j%26)+65,'route_cart_no'=>$i,'order_range'=>$order_range];
    }
        
    public static  function getCartnoOfOrder($joey_location_id)
    {
            $zone_route_data=self::join('joey_route_locations','joey_route_locations.route_id','=','joey_routes.id')
            //->join('zones_routing','zones_routing.id','joey_routes.zone')
            ->where('joey_route_locations.id',$joey_location_id)
            ->first(['joey_routes.hub','joey_routes.date','joey_routes.zone','joey_route_locations.route_id','joey_routes.hub','joey_route_locations.ordinal']);
            $date= date('Y-m-d',strtotime($zone_route_data->date));
            $routedata=self::where('zone','=',$zone_route_data->zone)->where('date','like',$date."%")->orderby('id')->get();
            $i=65;
            foreach($routedata as $data)
            {
                if($data->id==$zone_route_data->route_id)
                {
                    break;
                }
                $i++;
            }
            
            $zone_data=RoutingZones::where('hub_id',$zone_route_data->hub)
            ->whereNull('deleted_at')->orderby('id')
            ->get();
            $j=0;
            $order_range=null;

            foreach($zone_data as $data)
            {
                if($data->id==$zone_route_data->zone)
                {
                    $order_range=$data->order_range;
                    break;
                }
                $j++;
            }
            if($order_range==null)
            {
                $order_range=10;
            }
                return ['OrderCartNo'=>chr(($j%26)+65).chr($i).chr(ceil($zone_route_data->ordinal/$order_range)+64)."-".$zone_route_data->ordinal];
    }

}
