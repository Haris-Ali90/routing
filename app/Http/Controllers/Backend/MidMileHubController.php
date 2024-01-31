<?php

namespace App\Http\Controllers\Backend;

use App\Hub;
use App\Joey;
use App\JoeyJobSchedule;

class MidMileHubController extends BackendController
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


    }



}