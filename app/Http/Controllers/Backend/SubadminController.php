<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\StoreSubadminRequest;
use App\Http\Requests\Backend\UserUpdateRequest;
use App\Http\Requests\Frontend\ChangePasswordRequest;
use Config;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

// use App\Http\Requests;
use App\Http\Requests\Backend\UserRequest;
use App\Http\Requests\Backend\ChangepwdRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as FacadeRequest;
use App\Http\Controllers\Backend\BackendController;
//use Validator;
use App\Http\Requests\Frontend\UserRegisterRequest;

use App\Http\Requests\Frontend\EditProfileRequest;
use App\User;
use App\City;
use App\Cms;
use App\Post;
use Hash;

class SubadminController extends BackendController
{

    use ResetsPasswords;
    public function getIndex()
    {
        $users = User::where(['role_id' => User::ROLE_ROUTING])
        ->where('email','!=','admin@gmail.com')
        // ->where('rights','=','montreal_routes')
        // ->orWhere('rights','=','ottawa_routes')
        // ->orWhere('rights','=','ctc_routes')
        // ->orWhere('rights','=','wm_routes')
        // ->orWhere('rights','=','subadmins')

        ->get();
               return backend_view( 'subadmin.index', compact('users') );
    }

    public function active(User $record)
    {

        $record->activate();
        session()->flash('alert-success', 'Sub Admin has been Active successfully!');
        return redirect( 'backend/subadmins');
    }


    public function inactive(User $record)
    {
        $record->deactivate();
        session()->flash('alert-success', 'Sub Admin has been Inactive successfully!');
        return redirect( 'backend/subadmins');

    }

    public function edit($id)
    {
        $sub_id = base64_decode($id);
        $user = User::find($sub_id);

//        dd($user);
        $permissions = explode(',',$user->permissions);
        $rights = explode(',',$user->rights);
        return backend_view( 'subadmin.edit', compact('user','permissions','rights') );
    }

    public function add()
    {
        return backend_view( 'subadmin.add' );
    }

    public function create(StoreSubadminRequest $request,User $user)
    {
        $postData = $request->all();
        $rights = implode(',', $postData['rights']);
        $postData['rights'] = $rights;
        $permissions = implode(',', $postData['permissions']);
        $postData['permissions'] = $permissions;

        if ( $request->has('password') && $request->get('password', '') != '' ) {
            $postData['password'] = \Hash::make( $postData['password'] );
        }

        if ($request->hasFile('profile_picture')) {
            $imageName = \Illuminate\Support\Str::random(12) . '.' . $request->file('profile_picture')->getClientOriginalExtension();
            $path = public_path(Config::get('constants.front.dir.profilePicPath'));

            $request->file('profile_picture')->move($path, $imageName);
            $postData['profile_picture'] = url('/').'/images/profile_images/'.$imageName;
        }
        else{
            $imageName="default.png";
            $postData['profile_picture'] = url('/').'/images/profile_images/'.$imageName;
        }

        $postData['role_id'] = User::ROLE_ROUTING;
        // $postData['role_id'] = User::ROLE_ADMIN;
        $postData['status'] = 1;


        $user->create( $postData );
       // config(['auth.passwords.users.email' => 'backend.emails.password']);
        //$this->sendResetLinkEmail($request);
        $token = hash('ripemd160',uniqid(rand(),true));
        DB::table('password_resets')
            ->insert(['email'=> $postData['email'],'role_id' =>  User::ROLE_ADMIN,'token' => $token]);

        $email = base64_encode ($postData['email']);
        $user->sendSubAdminPasswordResetEmail($email,$postData['full_name'],$token,User::ROLE_ADMIN);


        session()->flash('alert-success', 'Sub Admin has been created successfully!');
        return redirect( 'backend/subadmins' . $user->id );

    }


    public function update(Request $request, User $user)
    {
        $this->validate($request,[
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        ]);
        $postData = $request->all();
        $rights = implode(',', $postData['rights']);
        $postData['rights'] = $rights;
        $permissions = implode(',', $postData['permissions']);
        $postData['permissions'] = $permissions;
        if ( $request->has('password') && $request->get('password', '') != '' ) {
            $postData['password'] = \Hash::make( $postData['password'] );
        }
        else{
            unset($postData['password']);
        }

        if($file = $request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture') ;

            $imageName = $user->id . '-' . \Illuminate\Support\Str::random(12) . '.' . $request->file('profile_picture')->getClientOriginalExtension();

            $path = public_path().'/images/profile_images' ;

            $file->move($path,$imageName);
            $postData['profile_picture'] = url('/').'/images/profile_images/'.$imageName ;
        }
        // dd($request);
        $user->update( $postData );

        session()->flash('alert-success', 'Subadmin has been updated successfully!');
        return redirect( 'backend/subadmins');
    }

    public function destroy(User $user)
    {
        // if ( $user->isAdmin() )
        //     abort(404);
         //User::where('id','=',$user->id)->update(['deleted_at'=>date("Y-m-d H:i:s")]);
         $data = $user->update(['deleted_at' => date('Y-m-d H:i:s')]);


       // Post::where('user_id',$userId)->delete();

       session()->flash('alert-success', 'Subadmin has been deleted successfully!');
        return redirect( 'backend/subadmins' );
    }

    public function profile($id)
    {
        $sub_id = base64_decode($id);
        $users        = User::where(['id' => $sub_id])->get();
        $users = $users[0];
        $permissions = explode(',',$users->permissions);
        $rights = explode(',',$users->rights);
        
        return backend_view( 'subadmin.profile', compact('users','permissions','rights' ) );
    }

    public function changeStatus(Request $request,$userId)
    {
        $user        = User::where(['id' => $userId])->get();
        if($user->status = 1){
             User::where(['id' => $userId])->update(['status' => 0]);
            return 0;
        }
        else{
            User::where(['id' => $userId])->update(['status' => 1]);
            return 1;
        }


    }

    public function getChangePassword($id)
    {

        return backend_view('subadmin.changepwd',compact('id'));
    }
    public function putChangePassword(User $user,Request $request)
    {
        $postData = $request->all();
        $password=$postData['old_pwd'];

        $admin=User::where('id',$postData['id'])
            //->where('email','=',$user->email)
            ->first();
        if($postData['new_pwd'] !== $postData['confirm_pwd'])
        {
            return back()->with('alert-danger', 'new password and Confirm Password not Match!');
        }
        $hashpwd=$admin['password'];
        if (Hash::check($password, $hashpwd))
        {
//            dd($password=$postData['new_pwd']);
            if ( $request->has('new_pwd') && $request->get('new_pwd', '') != '' ) {
                $postData['new_pwd'] = \Hash::make( $postData['new_pwd'] );
                $newpwd=$postData['new_pwd'];
                User::where('id',$postData['id'])
                    //->where('email','=',$user->email)
                    ->update(['password' => $newpwd]);
                return back()->with('alert-success', 'Password has been change successfully!');

            }
        }
        else{

            return back()->with('alert-danger', 'Old password not Match!');


        }
    }

    public function adminedit($id){
        $sub_id = base64_decode($id);
        $user = User::find($sub_id);

//        dd($user);
        $permissions = explode(',',$user->permissions);
        $rights = explode(',',$user->rights);
        return backend_view( 'subadmin.adminedit', compact('user','permissions','rights') );

    }

    public function adminupdate(Request $request, User $user)
    {
        $this->validate($request,[
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        ]);
        $postData = $request->all();
        $rights = implode(',', $postData['rights']);
        $postData['rights'] = $rights;
        $permissions = implode(',', $postData['permissions']);
        $postData['permissions'] = $permissions;
        if ( $request->has('password') && $request->get('password', '') != '' ) {
            $postData['password'] = \Hash::make( $postData['password'] );
        }
        else{
            unset($postData['password']);
        }

        if($file = $request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture') ;

            $imageName = $user->id . '-' . \Illuminate\Support\Str::random(12) . '.' . $request->file('profile_picture')->getClientOriginalExtension();

            $path = public_path().'/images/profile_images' ;

            $file->move($path,$imageName);
            $postData['profile_picture'] = url('/').'/public/images/profile_images/'.$imageName ;
        }



        $user->update( $postData );

        session()->flash('alert-success', 'Admin has been updated successfully!');
        return redirect( 'backend/adminedit/'.base64_encode(auth()->user()->id));
    }

    public function accountSecurityEdit($id)
    {
        $sub_id = base64_decode($id);
        $user = User::find($sub_id);
        return backend_view( 'subadmin.security', compact('user') );
    }

    public function accountSecurityUpdate(Request $request, User $user)
    {
        $this->validate($request,[
            'is_email' => 'required',
        ]);
        $postData = $request->all();
        $updateRecord = [
            'is_email' => isset($postData['is_email'])? 1: 0,
            'is_scan' => isset($postData['is_scan'])? 1: 0,
        ];

        $user->update( $updateRecord );

        session()->flash('alert-success', 'Account Security has been updated successfully!');
        return redirect( 'backend/account/security/edit/'.base64_encode(auth()->user()->id));
    }
}
