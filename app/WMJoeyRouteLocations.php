<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class WMJoeyRouteLocations extends Authenticatable
{
   // use SoftDeletes;
  
    protected $table = 'wm_joey_route_locations';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
  //  protected $fillable = [
  //       'route_id','task_id'
//    ];
//protected $dates = ['deleted_at'];
    // public function JoeyrouteLocations(){
    //     return $this->has_many(new JoeyRouteLocations(),'route_id');
    // }
}

