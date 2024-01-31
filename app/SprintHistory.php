<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SprintHistory extends Model
{

    protected $table = 'sprint__sprints_history';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'id', 'name', 'created_at','updated_at','deleted_at',
    // ];


    public $timestamps = false;

}
