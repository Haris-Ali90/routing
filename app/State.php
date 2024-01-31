<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{

    protected $table = 'states';
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


}
