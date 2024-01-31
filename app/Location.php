<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;



class Location extends Model 
{

    //use SoftDeletes;
    /**
     * Table name.
     *
     * @var array
     */
    public $table = 'locations';

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];


    /**
     * Get Route City
     */
    public function City()
    {
        return $this->belongsTo( City::class,'city_id', 'id');
    }

    /**
     * Get Route City
     */
    public function States()
    {
        return $this->belongsTo( States::class,'state_id', 'id');
    }

    public Static function canadian_address($address)
    {

        if (substr($address, -1) == ' ')
        {
            $postal_code = substr($address, -8, -1);
        }
        else
        {
            $postal_code = substr($address, -7);
        }

        if (substr($postal_code, 0, 1) == ' ' || substr($postal_code, 0, 1) == ',')
        {
            $postal_code = substr($postal_code, -6);
        }

        if (substr($postal_code, -1) == ' ')
        {
            $postal_code = substr($postal_code, 0, 6);
        }

        $address1 = substr($address, 0, -7);

        //parsing address for suite-Component
        $address = explode(' ', trim($address));
        $address[0] = str_replace('-', ' ', $address[0]);
        $address = implode(" ", $address);
        // url encode the address
        $address = urlencode($address);
        // google map geocode api url
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyDTK4viphUKcrJBSuoidDqRhVA4AWnHOo0";

        // get the json response
        $resp_json = file_get_contents($url);

        // decode the json
        $resp = json_decode($resp_json, true);
        
        // response status will be 'OK', if able to geocode given address
        if ($resp['status'] == 'OK')
        {

            $completeAddress = [];
            $addressComponent = $resp['results'][0]['address_components'];

            // get the important data
            for ($i = 0;$i < sizeof($addressComponent);$i++)
            {
                if ($addressComponent[$i]['types'][0] == 'administrative_area_level_1')
                {
                    $completeAddress['division'] = $addressComponent[$i]['short_name'];
                }
                elseif ($addressComponent[$i]['types'][0] == 'locality')
                {
                    $completeAddress['city'] = $addressComponent[$i]['short_name'];
                }
                else
                {
                    $completeAddress[$addressComponent[$i]['types'][0]] = $addressComponent[$i]['short_name'];
                }
                if ($addressComponent[$i]['types'][0] == 'postal_code' && $addressComponent[$i]['short_name'] != $postal_code)
                {
                    $completeAddress['postal_code'] = $postal_code;
                }
            }

            if (array_key_exists('subpremise', $completeAddress))
            {
                $completeAddress['suite'] = $completeAddress['subpremise'];
                unset($completeAddress['subpremise']);
            }
            else
            {
                $completeAddress['suite'] = '';
            }

            if ($resp['results'][0]['formatted_address'] == $address1)
            {
                $completeAddress['address'] = $resp['results'][0]['formatted_address'];
            }
            else
            {
                $completeAddress['address'] = $address1;
            }

            $completeAddress['lat'] = $resp['results'][0]['geometry']['location']['lat'];
            $completeAddress['lng'] = $resp['results'][0]['geometry']['location']['lng'];

            unset($completeAddress['administrative_area_level_2']);
            unset($completeAddress['street_number']);

            return $completeAddress;

        }
        else
        {
            
            return 0;
            //  throw new GenericException($resp['status'],403);
            
        }

    }

    public Static function addressParser($address)
    {
       
        $pattern[] = "/^PH[0-9]+/";
        $pattern[] = "/^[0-9]+\s*-\s*[0-9]+/";
        $pattern[] = "/\sApt[0-9]+/";
        $pattern[] = "/^[0-9]+\s[0-9]+/";
        $pattern[] = "/(Apt|Apartment|Unit)\#\s*[0-9]+/";
        
       $result= preg_replace($pattern[0],'', $address);
        if($result!= $address)
        {
         
            return $result;
        }
    
        // $result= preg_replace($pattern[1],'', $address);
        // if($result!= $address)
        // {
           
        //     return $result;
        // }
        $result= preg_replace($pattern[2],'', $address);
        if($result!= $address)
        {
           
            return $result;
        }
        $result= preg_replace($pattern[4],'', $address);
        if($result!= $address)
        {
            return $result;
        }
        if(preg_match($pattern[1],$address))
        {
            
            $result= preg_replace("/^[0-9]+\s*-\s*/",'', $address);
           
            return $result;
        }
        if(preg_match($pattern[3],$address))
        {
            
            $result= preg_replace("/^[0-9]+\s/",'', $address);
           
            return $result;
        }
        return $address;
        
    }

    public Static function isAddressValid($address)
    {
        
        if( empty($address) )
          return false;

        try{
           if(!self::canadian_address($address))
           {
             
            return false;
           }


        }catch(\Exception $e){
          return false;
        }
        return true;

    }


}
