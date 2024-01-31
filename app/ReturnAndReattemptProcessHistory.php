<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnAndReattemptProcessHistory extends Model
{

    const Processed = 1;
    const NotProcessed = 0;
    const CustomerSupportType = 'customer_support';


    protected $table = 'return_and_reattempt_process_history';

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
    ];

    // local scopes
    /**
     * Scope a query to only include not processed data
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotProcessed($query)
    {
        return $query->where('is_processed',self::NotProcessed);
    }

    /**
     * Scope a query to only which are not in customer  data
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotInCustomerSupport($query)
    {
        return $query->where('process_type','!=',self::CustomerSupportType);
    }

    /**
     * Scope a query to only include not deleted
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotDeleted($query)
    {
        return $query->whereNull('deleted_at');
    }

    /*
    * Relation with User Model For Order Scan By User
    * */
    public function ScanByUser()
    {
        return $this->belongsTo( User::class,'created_by', 'id');
    }

    public function scopeIsProcessed($query)
    {
        return $query->where('is_processed',self::Processed);
    }

    /*
    * Relation with User Model For Verified Order
    * */
    public function VerifiedByUser()
    {
        return $this->belongsTo( User::class,'verified_by', 'id');
    }

    public function ReturnTransferStatus()
    {
        $statusId = array("136" => "Client requested to cancel the order",
            "137" => "Delay in delivery due to weather or natural disaster",
            "118" => "left at back door",
            "117" => "left with concierge",
            "135" => "Customer refused delivery",
            "108" => "Customer unavailable-Incorrect address",
            "106" => "Customer unavailable - delivery returned",
            "107" => "Customer unavailable - Left voice mail - order returned",
            "109" => "Customer unavailable - Incorrect phone number",
            "142" => "Damaged at hub (before going OFD)",
            "143" => "Damaged on road - undeliverable",
            "144" => "Delivery to mailroom",
            "103" => "Delay at pickup",
            "139" => "Delivery left on front porch",
            "138" => "Delivery left in the garage",
            "114" => "Successful delivery at door",
            "113" => "Successfully hand delivered",
            "120" => "Delivery at Hub",
            "110" => "Delivery to hub for re-delivery",
            "111" => "Delivery to hub for return to merchant",
            "121" => "Pickup from Hub",
            "102" => "Joey Incident",
            "104" => "Damaged on road - delivery will be attempted",
            "105" => "Item damaged - returned to merchant",
            "129" => "Joey at hub",
            "128" => "Package on the way to hub",
            "140" => "Delivery missorted, may cause delay",
            "116" => "Successful delivery to neighbour",
            "132" => "Office closed - safe dropped",
            "101" => "Joey on the way to pickup",
            "32"  => "Order accepted by Joey",
            "14"  => "Merchant accepted",
            "36"  => "Cancelled by JoeyCo",
            "124" => "At hub - processing",
            "38"  => "Draft",
            "18"  => "Delivery failed",
            "56"  => "Partially delivered",
            "17"  => "Delivery success",
            "68"  => "Joey is at dropoff location",
            "67"  => "Joey is at pickup location",
            "13"  => "At hub - processing",
            "16"  => "Joey failed to pickup order",
            "57"  => "Not all orders were picked up",
            "15"  => "Order is with Joey",
            "112" => "To be re-attempted",
            "131" => "Office closed - returned to hub",
            "125" => "Pickup at store - confirmed",
            "61"  => "Scheduled order",
            "37"  => "Customer cancelled the order",
            "34"  => "Customer is editting the order",
            "35"  => "Merchant cancelled the order",
            "42"  => "Merchant completed the order",
            "54"  => "Merchant declined the order",
            "33"  => "Merchant is editting the order",
            "29"  => "Merchant is unavailable",
            "24"  => "Looking for a Joey",
            "23"  => "Waiting for merchant(s) to accept",
            "28"  => "Order is with Joey",
            "133" => "Packages sorted",
            "55"  => "ONLINE PAYMENT EXPIRED",
            "12"  => "ONLINE PAYMENT FAILED",
            "53"  => "Waiting for customer to pay",
            "141" => "Lost package",
            "60"  => "Task failure");
        return $statusId;
    }
	
	/**
     * Get Notes.
     */
    public function CustomerNotes()
    {
        return $this->hasMany( CustomerSupportReturnNotes::class,'rarph_ref_id', 'id');
    }

}
