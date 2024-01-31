<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class ContactEnc extends Model
{

    protected $table = 'contacts_enc';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    private $key;
    private $cipher;

    public function __construct()
    {
        $this->key = 'c9e92bb1ffd642abc4ceef9f4c6b1b3aaae8f5291e4ac127d58f4ae29272d79d903dfdb7c7eb6e487b979001c1658bb0a3e5c09a94d6ae90f7242c1a4cac60663f9cbc36ba4fe4b33e735fb6a23184d32be5cfd9aa5744f68af48cbbce805328bab49c99b708e44598a4efe765d75d7e48370ad1cb8f916e239cbb8ddfdfe3fe';
        $this->cipher = 'f13c9f69097a462be81995330c7c68f754f0c6026720c16ad2c1f5f316452ee000ce71d64ed065145afdd99b43c0d632b1703fc6a6754284f5d19b82dc3697d664dc9f66147f374d46c94cf23a78f14f0c6823d1cbaa19c157b4cb81e106b79b11593dcddf675951bc07f54528fc8c03cf66e9c437595d1cac658a737ab1183f';
    }


    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
    ];


    public function setNameAttribute($value)
    {
        $this->attributes['name'] = DB::raw("AES_ENCRYPT('".$value."', '".$this->key."', '".$this->cipher."')");
    }
    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = DB::raw("AES_ENCRYPT('".$value."', '".$this->key."', '".$this->cipher."')");
    }
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = DB::raw("AES_ENCRYPT('".$value."', '".$this->key."', '".$this->cipher."')");
    }

}
