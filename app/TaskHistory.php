<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskHistory extends Authenticatable
{
    //use SoftDeletes;
  
    protected $table = 'sprint__tasks_history';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $fillable = ['sprint__tasks_id','sprint_id','status_id','active','resolve_time','date','created_at'];

    public $timestamps = false;
    
    //protected $dates = ['deleted_at'];
    // public function JoeyrouteLocations(){
    //     return $this->has_many(new JoeyRouteLocations(),'route_id');
    // }
	
	/**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
    ];
}
