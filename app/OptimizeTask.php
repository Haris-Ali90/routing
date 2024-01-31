<?php

namespace App;


use App\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OptimizeTask extends Model
{
    use SoftDeletes;
    public $table = 'optimize_itineraries_details';

    protected $fillable = [
        'itinerary_id', 'task_id', 'ordinal'
    ];

//    protected $hidden = ['created_at','updated_at'];

    /**
     * The attributes that should be append to toArray.
     *
     * @var array
     */
    protected $appends = [];

    public function itinerary()
    {
        return $this->belongsTo(OptimizeItinerary::class, 'itinerary_id', 'id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }
}

