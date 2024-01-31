<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class XmlFailedOrders extends Authenticatable
{
    //use SoftDeletes;
  
    protected $table = 'xml_failed_orders';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $fillable = ['sprint__tasks_id','sprint_id','status_id','active','resolve_time','date','created_at'];

    
    
    //protected $dates = ['deleted_at'];
    // public function JoeyrouteLocations(){
    //     return $this->has_many(new JoeyRouteLocations(),'route_id');
    // }
   
}
