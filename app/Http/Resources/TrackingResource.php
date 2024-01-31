<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class TrackingResource extends JsonResource
{


    public function __construct($resource)
    {

        parent::__construct($resource);

    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'tracking_id' => $this->tracking_id,
            'vendor_id' => $this->vendor_id,
            'name' => $this->name ,
            'phone' => $this->contact_no ,
            'address' => $this->address ,
            'postal_code' => $this->postal_code ,
            'date' => $this->route_enable_date 
        ];
    }
}
