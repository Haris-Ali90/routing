<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class BorderlessFailedOrders extends Authenticatable
{
    protected $table = 'boradless_failed_orders';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded=[];

   
}
