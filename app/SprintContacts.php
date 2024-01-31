<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SprintContacts extends Model
{


    protected $table = 'sprint__contacts';


    protected $fillable = ['id', 'name', 'phone', 'email'];


}
