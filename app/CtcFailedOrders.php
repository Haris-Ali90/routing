<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class CtcFailedOrders extends Authenticatable
{
    protected $table = 'ctc_failed_orders';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   
}
