<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model {

    protected $table = 'vendors';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   

    /*public function subcategory()
    {
        return $this->hasMany('App\Subcategory','parent_id');
    }*/
     /*public function area()
    {
        return $this->hasMany('App\Area','id');
    }  */
    public function getId() {
        return (int) $this->attributes['id'];
    }
    public function getName() {
        return $this->attributes['name'];
    }
    public function getEmail() {
        return $this->attributes['email'];
    }
    public function getPhone() {
        return $this->attributes['business_phone'];
    }
    public function getVehicle()
    {
        return  $this->belongsTo(new Vehicle(),'vehicle_id');
    }
    public function getContact()
    {
        return  $this->belongsTo(new VendorContact(),'contact_id');
    }
    public static function findEnabled($vendorId) {
        
       

        $vendor = self::whereNull('deleted_at')
            ->where('is_registered', '=', 1)
            ->where('id', '=', $vendorId)
            ->first();
        
        if ($vendor instanceof Vendor ) {
          
            return $vendor;
        }
        
        return null;
    }

    public function sprint(){
        return $this->hasMany(Sprint::class,'creator_id', 'id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function jobDetails()
    {
        return $this->hasMany(MiJobDetail::class,'locationid', 'id');
    }
}
