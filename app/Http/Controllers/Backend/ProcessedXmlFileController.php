<?php

namespace App\Http\Controllers\Backend;


use App\JoeyRoute;
use App\ProcessedXmlFiles;
use App\Task;
use App\Sprint;
use App\BoradlessDashboard;
use App\JoeyRouteLocations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProcessedXmlFileController extends BackendController{
    /**
     * Get Route orders
     */
    public function index(Request $request){

        if(!isset($_REQUEST['date']) || empty($_REQUEST['date'])){
            $date = date('Y-m-d');
        }
        else {
            $date = $_REQUEST['date'];
        }
        $processedXmlFile = ProcessedXmlFiles::whereDate('created_at', 'LIKE', $date.'%')->orderBy('id','DESC')->get();
        return backend_view('manifest_creation.processed_xml_file_list', compact('processedXmlFile'));
    }

    public function removeDuplicateSprintIds()
    {
        $date = date('Y-m-d');
        $sprintIds = BoradlessDashboard::whereNull('deleted_at')
            ->where('creator_id', 477621)
            ->where('task_status_id', 61)
            ->whereBetween('created_at', [$date." 00:00:00", $date." 23:59:59"])
            ->groupBy('tracking_id')
            ->havingRaw('count(tracking_id) > ?', [1])
            ->pluck('sprint_id');

        $sprint = Sprint::whereIn('id',$sprintIds)->update(['deleted_at'=> date('Y-m-d H:i:s')]);
        $tasks = Task::whereIn('sprint_id', $sprintIds)->update(['deleted_at'=> date('Y-m-d H:i:s')]);
        $boradless = BoradlessDashboard::whereIn('sprint_id', $sprintIds)->update(['deleted_at'=> date('Y-m-d H:i:s')]);

        return redirect()->back()->with('success', 'deleted duplicate order successfully');
    }



}