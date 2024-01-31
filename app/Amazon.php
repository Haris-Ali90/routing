<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Amazon extends Authenticatable
{
    protected $table = 'amazon_dashboard';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'order_id','route','joey','address','scheduled_duetime','arrival_time','departure_time','picked_hub_time','sorter_time','start_time','end_time','dropoff_eta','delivery_time','tracking_id','signature','sprint_id','sprint_status','task_status','merchant_order_num','image','vendor_id'
    ];

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
}
