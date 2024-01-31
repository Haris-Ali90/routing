<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hub extends Model
{

    use SoftDeletes;

    protected $table = 'hubs';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'title','parent_hub_id','address', 'created_at','updated_at','deleted_at',
    ];


    public Static function getHubAdressFromVendorId($vendorId)
    {
        
        return VendorZone::where('vendor_id', '=', $vendorId)
        ->join('hub_zones', 'zone_vendor_relationship.zone_id', '=', 'hub_zones.zone_id')
        ->join('hubs', 'hub_zones.hub_id', '=', 'hubs.id')
        ->leftjoin('vendors','vendor_id','=','vendors.id')
        // ->where('with_hub','=',1)
        ->whereNull('hubs.deleted_at')
        ->first();
    }
    public function HubProcess()
    {
        return $this->hasMany(HubProcess::class,'hub_id');
    }
    public function HubPostalCode()
    {
        return $this->hasMany(MicroHubPostalCodes::class,'hub_id');
    }

    public function vendor()
    {
        return $this->belongsToMany(Vendor::class, 'hub_stores');
    }

    public function zone()
    {
        return $this->belongsToMany(Zone::class, 'hub_zones');
    }

    public function zoneRouting()
    {
        return $this->belongsToMany(RoutingZones::class, 'microhub_zones_external', 'zone_id');
    }

    public function hubStores()
    {
        return $this->hasMany(HubStore::class);
    }

    public function jobDetails()
    {
        return $this->hasMany(MiJobDetail::class,'locationid', 'id');
    }
}
