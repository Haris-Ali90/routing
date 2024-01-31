<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
// use App\Helpers\RESTAPIHelper;
// use JWTAuth;
use App\Http\Traits\JWTUserTrait;
use App\Helpers\RESTAPIHelper;

class ApiBaseController extends Controller {

    /**
     * Extract token value from request
     *
     * @return string
     */
    protected function extractToken($request=false) {
        return JWTUserTrait::extractToken($request);
    }

    /**
     * Return User instance or false if not exist in DB
     *
     * @return mixed
     */
    protected function getUserInstance($request=false) {
        return JWTUserTrait::getUserInstance($request);
    }

    protected function checkTokenValidity($userId) {

        if($userId > 0 ) {
            $userData = $this->getUserInstance();

            if ($userData) {

                if($userData->id != $userId) {

                    return 0;
                }

            }
        }
        return 1;
    }
    function sendPushNotificationAndroid($device, $postArray)
    {

        // $url = 'https://android.googleapis.com/gcm/send';
       $url            = 'https://fcm.googleapis.com/fcm/send';
       $serverApiKey = "AAAACPLy8Xc:APA91bGxmpoo_8UhiUZX5BTDcG4DqHIHoz-6QMCdIDCb3Am8PjbVOX3-U_epIYqM5YRSqQPfGIjz7aEvJT2Vo3KmMIiiQiA5_G15NaWVcCgv0qjYp_Nyemn0IQUHbm5DCD2rT5qrIk6G";
        // $serverApiKey = "AAAASo5pyB0:APA91bHn2O_BER-KXcakEjKMzZtdSNWTl4D-MfsynKRCtLO4wFd8K3dzogbP5wFc4TmIuDqAwUXeyepAMOuduNN1oyv9xQIeRkFlyAv5o__vmd5_j7BC8M8iUKJgDxMqQbKbSLLhs-Gv";
        $reg = $device;


        $postArray['url'] = $url;

        $headers = array(
            'Content-Type:application/json',
            'Authorization:key=' . $serverApiKey
        );


        $data = array(
            'registration_ids' => array($reg),
            'data' => $postArray
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        if ($headers)
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        curl_close($ch);

        //dd($response);
        return $response;
    }
    
    

    function sendPushNotification($device, $apsArray)
    {
        // echo $ckpem = $_SERVER['DOCUMENT_ROOT'].'\portfolio\albacars\app\controller\ck.pem';
        $ckpem = public_path() . '\certificates\CertificatesHospitalProduction.pem';

        $payload['aps'] = $apsArray; // array('alert' => $title, 'message' => $msg, 'sound' => 'default');


        $payload = json_encode($payload);

        $options = array('ssl' => array(
            'local_cert' => $ckpem,
            'passphrase' => 'a'
        ));

        $streamContext = stream_context_create();
        stream_context_set_option($streamContext, $options);
        $apns = stream_socket_client('ssl://gateway.push.apple.com:2195', $error, $errorString, 60, STREAM_CLIENT_CONNECT, $streamContext);
        $apnsMessage = chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $device)) . chr(0) . chr(strlen($payload)) . $payload;

        $result = fwrite($apns, $apnsMessage);
        fclose($apns);

    }


}