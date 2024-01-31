<?php

namespace App\Http\Controllers\Backend;


use App\Http\Requests\Backend\CsvImportRequest;
use App\SprintHistory;
use App\Task;
use App\Sprint;
use App\TaskHistory;

class CsvFileUploaderController extends BackendController{

    public function index(){
        return backend_view('csv_file_uploader.index');
    }

    function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }

    public function processImport(CsvImportRequest $request)
    {
        return redirect()->back()->with('success', 'success');
        // Get CSV file
        $file = $request->file('csv_file');

        //CSV File Data Convert To Array
        $array = $this->csvToArray($file);

        $ordinal=0;
        // Create loop for order creation
        for ($i = 0; $i < count($array); $i ++)
        {

            $data =[
                'creator_id' => $array[$i]['creator_id'],
                'vehicle_id' => $array[$i]['vehicle_id'],
                'creator_type' => $array[$i]['creator_type'],
                'status_id' => $array[$i]['status_id'],

            ];
            $sprint = Sprint::create($data);
            $Pickuptask = [
                'sprint_id' => $sprint->id,
                'ordinal' =>1,
                'type' => 'pickup',
                'due_time' => 1668432004,
                'eta_time' => 1668432004,
                'etc_time' => 1668432004,
            ];
            $pickupTask = Task::create($Pickuptask);

            TaskHistory::create([
                'sprint__tasks_id' => $pickupTask->id,
                'sprint_id' => $sprint->id,
                'status_id' => 61,
            ]);

            foreach($array[$i] as $key => $dropoff){

                if ( strstr( $key, 'address_dropoff' ) ) {
                    $dropofftask = [
                        'sprint_id' => $sprint->id,
                        'ordinal' =>$ordinal++,
                        'type' => 'dropoff',
                        'due_time' => 1668432004,
                        'eta_time' => 1668432004,
                        'etc_time' => 1668432004,
                    ];
                    $dropoffTask = Task::create($dropofftask);

                    TaskHistory::create([
                        'sprint__tasks_id' => $dropoffTask->id,
                        'sprint_id' => $sprint->id,
                        'status_id' => 61,
                    ]);
                }
            }


        }


        return redirect()->back()->with('success', 'success');
    }



}