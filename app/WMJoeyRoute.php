<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class WMJoeyRoute extends Authenticatable
{
    //use SoftDeletes;
  
    protected $table = 'wm_joey_routes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
  
    // public function JoeyrouteLocations(){
    //     return $this->has_many(new JoeyRouteLocations(),'route_id');
    // }
}
