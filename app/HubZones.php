<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HubZones extends Model
{

    protected $table = 'hub_zones';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
 protected $fillable = ['hub_id', 'zone_id'];


    public function zone() {
        return $this->belongsTo(RoutingZones::class,'zone_id');
    }
}
