<?php

namespace App\Http\Controllers\Backend;

use App\Joey;
use App\JoeyJobSchedule;
//use Illuminate\Support\Str;

class MidMileJoeysController extends BackendController
{

    public function index()
    {
        $joeys = Joey::whereNull('deleted_at')->get();
        $joeyData = [];
        foreach($joeys as $joey){
            $joeyJobSchedule = JoeyJobSchedule::where('joey_id', $joey->id)->first();
            if($joeyJobSchedule['joey_id'] == $joey->id){
                $joeyData[] = $joey;
            }
        }

        return backend_view('midmile.index', compact('joeyData'));
    }




}