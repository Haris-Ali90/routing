<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainfestFields extends Authenticatable
{
   
  
    protected $table = 'mainfest_fields';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   
    // public function JoeyrouteLocations(){
    //     return $this->has_many(new JoeyRouteLocations(),'route_id');
    // }

    public function Manifestcount()
    {
        return $this->hasMany( MainfestFields::class,'manifestNumber', 'manifestNumber');
    }

}

