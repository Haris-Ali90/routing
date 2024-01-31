<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class CTCEntry extends Model
{
   // const ctc_vendors=[475874];
    protected $table = 'ctc_entries';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id' , 'sprint_id' , 'task_id' , 'creator_id' , 'route_id' , 'ordinal' , 'tracking_id' , 'joey_id' ,'eta_time','store_name','customer_name','weight' ,'joey_name' , 'picked_up_at' , 'sorted_at' , 'delivered_at' , 'returned_at' , 'hub_return_scan' , 'task_status_id' , 'order_image' , 'address_line_1' , 'address_line_2' , 'address_line_3' , 'created_at' , 'updated_at' , 'deleted_at' , 'is_custom_route'  
  
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public function onOrderCreationCTCEntries($sprint,$is_custom_route)
    {
        
     if (!$sprint instanceof Sprint) {
      return false;   
     }
     $this->sprint_id=$sprint->id;
     $task=$sprint->dropoffTask;
     $vendor=$sprint->Vendor;
     $merchantid=$task->taskMerchant;
     $sprint_contact=$task->sprint_contact;
     if (!$task instanceof Task) {
         return false;   
        }
     if (!$merchantid instanceof Merchantids) {
        
         return false;   
        }
        $location=$task->location;
     if (!$location instanceof LocationUnencrypted) {
         
         return false;   
        }   
       
        $this->task_id=$task->id;
        $this->eta_time=$task->eta_time;
        $this->creator_id=$sprint->creator_id;
        $this->store_name=$vendor->name;
        $this->tracking_id=$merchantid->tracking_id;
        $this->weight=$merchantid->weight;
        $this->customer_name=$sprint_contact->name;
        $this->address_line_1=$location->address;
        $this->address_line_2=$merchantid->address_line2;
        $this->is_custom_route=$is_custom_route;
        return true;
    }



}
