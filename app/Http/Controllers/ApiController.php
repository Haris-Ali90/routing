<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Request;
use Hash;
use Config;
use Gregwar\Image\Image;
use JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use App\Setting;
use App\User;
use App\Vehicle;
use App\Report;
use App\VehicleModel;
use App\Http\Requests\Frontend\UserRegisterRequest;
use App\Http\Requests\Frontend\EditProfileRequest;
use App\Helpers\RESTAPIHelper;
use Validator;
use App\Http\Requests\Frontend\UserRegisterRequest2;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Notification;
use App\Teachers;
use Auth;
use App\CoursesRequest;
use App\CourseBatch;
use App\Courses;
class ApiController extends ApiBaseController
{

    public function courseBatch($id)
    {
        // return $id;
        $checkStatus = CourseBatch::where('courses_id', $id)->get();
        // if($checkStatus->status == '1' )
        // {
        //     Teachers::where('id', $id)->update(['status'=>'0']);
        //     return 0;
        // }else{

        //     Teachers::where('id', $id)->update(['status'=>'1']);
        //     return 1;
        // }
        // $getUser  =  Teachers::where('id', $id)->first()->toArray();;

        return RESTAPIHelper::Response($checkStatus);
    }



    public function init()
    {
        return RESTAPIHelper::response([
            'tutorial_video' => Setting::extract('app.link.tutorial_video', ''),
        ]);
    }

    public function getGuideBook()
    {
        return RESTAPIHelper::response([
            'guidebook' => Setting::extract('app.link.guide_book', ''),
        ]);
    }

    public function changeTeacherStatus($id)
    {
        $checkStatus = Teachers::where('id', $id)->first();
        if($checkStatus->status == '1' )
        {
            Teachers::where('id', $id)->update(['status'=>'0']);
            return 0;
        }else{

            Teachers::where('id', $id)->update(['status'=>'1']);
            return 1;
        }
        $getUser  =  Teachers::where('id', $id)->first()->toArray();;

        return RESTAPIHelper::Response($getUser);
    }

    
    public function changeApprovalStatus($id)
    {
        $checkStatus = Teachers::where('id', $id)->first();
        if($checkStatus->approval_status == '1' )
        {
            Teachers::where('id', $id)->update(['approval_status'=>'0']);
            $teacherdata = Teachers::where('id',$id)->first();
            Notification::Create(
    ['sender_id' => 1,
    'reciever_id' => $teacherdata->institute_id, 'message' =>$checkStatus->name.' Approval request has been rejected by Admin']
);

            return 0;

        }else{

            Teachers::where('id', $id)->update(['approval_status'=>'1']);
            $teacherdata = Teachers::where('id',$id)->first();
            Notification::Create(
    ['sender_id' => 1,
    'reciever_id' => $teacherdata->institute_id, 'message' =>$checkStatus->name.' Approval request has been accepted by Admin']
);
            return 1;
        }
        $getUser  =  Teachers::where('id', $id)->first()->toArray();;

        return RESTAPIHelper::Response($getUser);
    }

    public function changeUserStatus($id)
    {
        $checkStatus = User::where('id', $id)->first();
        if($checkStatus->status == '1' )
        {
            User::where('id', $id)->update(['status'=>'0','is_verify'=>0,'is_verified'=>0]);
            return 0;
        }else{

            User::where('id', $id)->update(['status'=>'1','is_verify'=>1,'is_verified'=>1]);
            return 1;
        }
        $getUser  =  User::where('id', $id)->first()->toArray();;

        return RESTAPIHelper::Response($getUser);
    }
    public function courseRequestStatusD($id)
    {
        $data = Notification::where('id', $id)->first();
        $checkStatus = CoursesRequest::where('user_id', $data->sender_id)->first();
        if($checkStatus->status == '2' )
        {  
              
             Notification::Create(
    ['sender_id' => $data->reciever_id,
    'reciever_id' => $data->sender_id, 'message' =>$checkStatus->name.' Your course request has been removed from rejection list by Institute']
);
            CoursesRequest::where('id', $checkStatus->id)->update(['status'=>'0']);
            return 0;
        }
        else
        {
            $user = User::where('id', $data->sender_id)->first();
            $device = $user->device_token;
    $message = $user->first_name.' Your course request has been declined by Institute';
    $title = "Edulights";
    $postArray = array('alert'=>$message,'sound'=>'default','title'=>$title,'message'=>$message);
    $response = $this->sendPushNotificationAndroid($device,$postArray);
Notification::Create(
    ['sender_id' => $data->reciever_id,
    'reciever_id' => $data->sender_id, 'message' =>$user->first_name.' Your course request has been declined by Institute']
);
            CoursesRequest::where('id', $checkStatus->id)->update(['status'=>'2']);
            
            return 2;
        }
        $getUser  =  User::where('id', $id)->first()->toArray();;

        return RESTAPIHelper::Response($getUser);
    }
    
    public function courseRequestStatus($id)
    {
        $data = Notification::where('id', $id)->first();
        $checkStatus = CoursesRequest::where('user_id', $data->sender_id)->first();
        if($checkStatus->status == '1' )
        {
            CoursesRequest::where('id', $checkStatus->id)->update(['status'=>'0']);
            return 0;
        }
        else
        {
            $user = User::where('id', $data->sender_id)->first();
            $device = $user->device_token;
    $message = $user->first_name.' Your course request has been accepted by Institute';
    $title = "Edulights";
    $postArray = array('alert'=>$message,'sound'=>'default','title'=>$title,'message'=>$message);
    $response = $this->sendPushNotificationAndroid($device,$postArray);
    Notification::Create(
    ['sender_id' => $data->reciever_id,
    'reciever_id' => $data->sender_id, 'message' =>$user->first_name.' Your course request has been accepted by Institute']
);  
        CoursesRequest::where('id', $checkStatus->id)->update(['status'=>'1']);
        $userRequested = User::where([
            'id'   => $data->sender_id
        ])->first();
        $course_id = CoursesRequest::where('id', $checkStatus->id)->select('course_id')->first();
        // dd($course_id->course_id);
        $course = Courses::where('id',$course_id->course_id)->first();
        $data = ['student'=>$userRequested,'course'=>$course];
        \Mail::send('feerecipt' , $data, function($m) use($userRequested)
        {
         // $m->attachData($pdf, 'invoice.pdf', ['mime' => 'application/pdf']);
         $m->to($userRequested->email)->from(env('MAIL_USERNAME'))->subject('Student Fee Recipt - Edulights');
        });
            
            return 1;
        }
        $getUser  =  User::where('id', $id)->first()->toArray();;

        return RESTAPIHelper::Response($getUser);
    }

    public function changeVehicleStatus($id,$status)
    {
        Vehicle::where('id', $id)->update(['status'=>$status]);
        $getVehicle  =  Vehicle::where('id', $id)->first()->toArray();

        return RESTAPIHelper::Response($getVehicle);
    }


    public function getModel($id)
    {
        $getSubCat  =  VehicleModel::where('manufacture_id', $id)->get()->toArray();

        $resultArray = array();
        $i = 0;
        foreach ($getSubCat as $cat) {
            $resultArray[$i] = $cat;
            $i++;
        }
        return RESTAPIHelper::Response($resultArray);
    }


}
