<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $table = 'sprint__tasks';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'id' , 'sprint_id' , 'ordinal' , 'type'  ,  'due_time' , 'eta_time' , 'etc_time' , 'location_id' , 'contact_id' , 'payment_type' , 'payment_amount' , 'description' , 'pin'  ,   'status_id' , 'status_copy' , 'created_at' , 'updated_at' , 'deleted_at' , 'payment_service_charge' , 'charge' , 'active' , 'notify_by' , 'is_notified' , 'merchant_charge' , 'joey_pay' , 'joey_tax_pay' , 'joeyco_pay' , 'weight_charge' , 'weight_estimate' , 'confirm_pin' , 'confirm_signature' , 'confirm_image' , 'confirm_seal' , 'staging_charge' , 'cc_number_used' , 'resolve_time'  

    ];

	/**
     * The attributes that are guarded.
     *
     * @var array
     */
    private $sprint;
    protected $guarded = [
    ];

    public static function getDropOffTrackingId($sprintId)
    {
        return Task::join('merchantids','merchantids.task_id','=','sprint__tasks.id')
            ->where('sprint__tasks.type', '=', 'dropoff')
            ->where('sprint__tasks.sprint_id',$sprintId)->get(['merchantids.tracking_id','merchantids.merchant_order_num']);
    }

    public function task_Location()
    {
        return $this->belongsTo(Locations::class, 'location_id', 'id');
    }

    public function taskMerchant()
    {
        return $this->belongsTo(MerchantIds::class,'id','task_id')->whereNotNull('merchantids.tracking_id');
    }

    ### for merchantids
    public  function merchantIds(){
        return $this->belongsTo(MerchantIds::class,'id','task_id');
    }

	public function location()
    {
        return $this->belongsTo(LocationUnencrypted::class,'location_id','id');
    }

    public function location_enc()
    {
        return $this->belongsTo(LocationEnc::class,'location_id','id');
    }

    public function sprint_contact()
    {
        return $this->belongsTo(ContactUncrypted::class,'contact_id','id');
    }

    public function contact_enc()
    {
        return $this->belongsTo(ContactEnc::class,'contact_id','id');
    }

    public function getSprint()
    {
            return  $this->belongsTo(new Sprint(),'sprint_id')->whereNull('deleted_at');
    }
    public function getJoeyRouteLocations()
    {
        return  $this->hasone(new JoeyRouteLocations(),'Task_id')->whereNull('deleted_at');
    }
    public function setSprint(Sprint $sprint) {
        $this->sprint = $sprint;
    }
    public function duplicate($sprintId) {
        $date = new \DateTime();

        unset($this->id);
        $this->exists = 0;

        $this->active = 0;
        $this->sprint_id = $sprintId;
        $this->status_id = 38;
        $this->created_at = $date->format('Y-m-d H:i:s');
        $this->updated_at = $date->format('Y-m-d H:i:s');
        $this->resolve_time = null;
        $this->eta_time = null;
        $this->etc_time = null;

        $this->merchant_charge = 0;
        $this->joey_pay = 0;
        $this->joey_tax_pay = 0;
        $this->joeyco_pay = 0;
        

        $this->generatePin();
     

        $this->save();

        
    }
    public function generatePin() {
        $this->pin = (string) rand(1000, 9999);
    }

    public function setStatus($status, $copy = null) {
        $this->status_id = $status;
        $this->status_copy = $copy;
    
    }
}
