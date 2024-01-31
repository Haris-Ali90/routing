<?php

namespace App\Classes;

use App\UserDevice;
use App\UserNotification;

class Client {

    private $host = 'https://api.routific.com';
    private $resource = '/';
    private $version = 'v1';
    private $endPoint = 'pdp-long';
    private $endPoint2 = 'jobs';

    public function getJobId($result) {

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->host.$this->resource.$this->version.$this->resource.$this->endPoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $result,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJfaWQiOiI1MzEzZDZiYTNiMDBkMzA4MDA2ZTliOGEiLCJpYXQiOjEzOTM4MDkwODJ9.PR5qTHsqPogeIIe0NyH2oheaGR-SJXDsxPTcUQNq90E'
            ),
        ));

        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        if (empty($error)) {
            $response = explode("\n", $response);
            $results = $response[count($response) - 1];
            $results = json_decode($results);
        } else {
            $results = [];
        }

        return $results;
    }




    /**
     * @param $id
     * @param $response
     * @param $shiftId
     * @param $orderId
     * @return string
     */
    public function getJobResponseByJobId($id)
    {
        sleep(4);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->host.$this->resource.$this->endPoint2.$this->resource.$id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $result = json_decode($response, true);



        $results = array_values($result['output']['solution']);

        if($result['output']['unserved'] == null){
            $jobCreation = ['job_id' => $id];

            $jobId = JoeyRoutificJob::create($jobCreation);

            foreach($results as $key => $res){
                $route = [
                    'joey_id' => $res[0]['location_id'],
                    'job_id' => $jobId->id,
                ];
                $routeJob = JoeyRoutificJobRoute::create($route);

                foreach($res as $index => $rrr){
                    if($index != 0){
                        $locations = [
                            'route_id' => $routeJob->id,
                            'sprint_id' => $rrr['location_id'],
                            'location_name' => $rrr['location_name'],
                            'type' => $rrr['type'],
                            'arrival_time' => $rrr['arrival_time'],
                            'finish_time' => $rrr['finish_time'],
                        ];

                        JoeyRoutificJobLocation::create($locations);
                    }
                }

                $deviceIds = UserDevice::where('user_id', $res[0]['location_id'])->pluck('device_token');

                $subject = 'Subject';
                $message = 'Your Route Notifications';

                Fcm::sendPush($subject, $message, 'suggestedRoute', null, $deviceIds);

                $payload = ['notification' => ['title' => $subject, 'body' => $message, 'click_action' => 'suggestedRoute'],
                    'data' => ['data_title' => $subject, 'data_body' => $message, 'data_click_action' => 'suggestedRoute']];
                $createNotification = [
                    'user_id' => $res[0]['location_id'],
                    'user_type' => 'Joey',
                    'notification' => $subject,
                    'notification_type' => 'suggestedRoute',
                    'notification_data' => json_encode(["body" => $message]),
                    'payload' => json_encode($payload),
                    'is_silent' => 0,
                    'is_read' => 0,
                    'created_at' => date('Y-m-d H:i:s')
                ];

                UserNotification::create($createNotification);
            }
            return json_encode([
                "output"=>$results,
                "status" => 'Route Created Successfully'
            ]);
        }else{
            return json_encode([
                "status" => "Route Creation Error",
                "output"=>$result['output']['unserved']
            ]);
        }

    }

}
