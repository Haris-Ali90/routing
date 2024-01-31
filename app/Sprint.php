<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sprint extends Model
{

    protected $table = 'sprint__sprints';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'id', 'name', 'created_at','updated_at','deleted_at',
    // ];
	
	/**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
    ];

    //Relation With Vendor
    public function Vendor()
    {
        return $this->belongsTo(Vendor::class,'creator_id' , 'id');
    }

    ### for multiple task from sprint id
    public  function sprintTask(){
        return $this->hasMany(Task::class,'sprint_id','id')->orderBy('ordinal','ASC');
    }

    public function joey()
    {
        return $this->belongsTo(Joey::class, 'joey_id')
            ->select('id',DB::raw("concat(first_name,' ',last_name) as joey_name"));
    }

    public function sprintTasks()
    {
        return $this->hasone(Task::class, 'sprint_id', 'id');
    }

}
