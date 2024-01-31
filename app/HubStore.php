<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HubStore extends Model
{

    protected $table = 'hub_stores';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $guarded = [];

    public function vendor()
    {
        return $this->belongsToMany(Vendor::class, 'hub_stores');
    }



}
