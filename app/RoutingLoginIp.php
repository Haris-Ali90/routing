<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoutingLoginIp extends Model
{

    protected $table = 'routing_login_ips';
    use SoftDeletes;

    protected $guarded = [];



}
