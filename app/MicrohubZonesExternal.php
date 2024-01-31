<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MicrohubZonesExternal extends Model
{

    use SoftDeletes;

    protected $table = 'microhub_zones_external';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'zone_id','hub_id'
    ];




}
