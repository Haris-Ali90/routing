<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddressApproval extends Authenticatable
{
    protected $table = 'address_approval';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /*public function zone()
    {
        return $this->belongsTo('App\Zone');
    }
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function area()
    {
        return $this->belongsTo('App\Area');
    }*/
    public static function check_approval($tracking_id){
        return self::where('tracking_id',$tracking_id)->orderBy('id','desc')->first();
    }
}
