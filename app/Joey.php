<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Joey extends Model
{

    protected $table = 'joeys';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'id', 'name', 'created_at','updated_at','deleted_at',
    // ];


    public static function joeyName($id){
        $joey = self::find($id);
        return $joey->first_name." ".$joey->last_name;
    }


}
