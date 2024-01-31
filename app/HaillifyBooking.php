<?php

namespace App;


use Illuminate\Database\Eloquent\Model;


class HaillifyBooking extends Model
{

    /**
     * Table name.
     *
     * @var array
     */
    public $table = 'haillify_bookings';
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

    public function sprint()
    {
        return $this->belongsTo(Sprint::class);
    }

    public function SprintCount($bookingId)
    {
        $sprintCount = HaillifyBooking::join('sprint__sprints', 'sprint__sprints.id', '=', 'haillify_bookings.sprint_id')
            ->whereNull('sprint__sprints.deleted_at')
            ->whereNull('haillify_bookings.deleted_at')
            ->whereNotIn('sprint__sprints.status_id', [36])
            ->where('haillify_bookings.booking_id', $bookingId)
            ->count();
//
//
//            HaillifyBooking::whereHas('sprint', function ($query){
//                $query->whereNotIn('status_id', [36])->whereNull('deleted_at');
//            })->where('booking_id', $bookingId)
//                ->whereNull('deleted_at')->count();

        return $sprintCount;
    }

    public function joeyExists($bookingId)
    {
        $sprintIds = HaillifyBooking::where('booking_id', $bookingId)->whereNull('deleted_at')->pluck('sprint_id');
        $joeyIds = Sprint::whereNull('deleted_at')->whereIn('id', $sprintIds)->whereNotIn('status_id', [36])->pluck('joey_id');
        $joeyName = Joey::whereIn('id', $joeyIds)->first();
        if(isset($joeyName)){
            return $joeyName->id;
        }else{
            return null;
        }
    }


}
