<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MerchantIds extends Model
{

    protected $table = 'merchantids';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'id', 'name', 'created_at','updated_at','deleted_at',
    // ];
    protected $fillable = [
        'id','task_id','merchant_order_num','item_count','package_count',
        'additional_info','end_time',
        'start_time','tracking_id','address_line2','scheduled_duetime',
             'weight','actual_address',
        'weight_unit'
    
    ];

    public function dropoffTask()
    {
        return  $this->belongsTo(new Task(),'task_id')->whereNull('deleted_at');
    }

}
