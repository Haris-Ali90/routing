<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Classes\Google\GoogleAuthenticator;
use App\Http\Requests\Backend\GoogleAuthRequest;
use App\RoutingLoginIp;
use Validator;
// use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\BackendController;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class AuthController extends BackendController
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $loginView           = 'backend.auth.login';
    protected $redirectTo          = 'backend/dashboard';
    protected $redirectAfterLogout = 'backend/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getCredentials(Request $request)
    {
        return $request->only($this->loginUsername(), 'password') + ['role_id' => '3'] + ['status' => '1'];
    }

    public function adminLogin(Request $request) {

        if ( $request->isMethod('GET') )
            return $this->showLoginForm();

        return $this->login($request);

       /* $admin = User::where('email', '=', $request->get('email'))->where('role_id','3')->first();
        if ($admin) {

            $adminLoginIpTrusted = RoutingLoginIp::where('dashboard_user_id', '=', $admin['id'])
                ->whereNull('deleted_at')
                ->where('ip', '=', $this->get_ipaddress())
                ->whereNotNull('trusted_date')
                ->where('trusted_date', '>', date('Y-m-d'))
                ->first();
            if (!is_null($adminLoginIpTrusted)) {
                return $this->login($request);
            } else {
                $passwordencode = base64_encode($request->get('password'));
                $id = base64_encode($admin->id);
                $mail = base64_encode($admin->is_email);
                $scan = base64_encode($admin->is_scan);
                return redirect('backend/type-auth?id=' . $id . '&key=' . $passwordencode . '&mail=' . $mail . '&scan=' . $scan);

            }
        }
        else{
            return redirect('backend/login')->withErrors('Invalid Email Address!');
        }*/
    }

    public function getType(Request $request){
        return backend_view('auth.logintype',$request->all() );
    }

    public function posttypeauth(Request $request)
    {
        $data=$request->all();
        if(strcmp("Scan",$data['type'])==0){

            return redirect('backend/google-auth?id=' . $data['id'] . "&key=" . $data['key']);
        }
        else{

            $randomid = mt_rand(100000,999999);

            $admin = User::where('id','=', base64_decode($data['id']))->first();
            $admin['emailauthanticationcode'] = $randomid;

            $admin->save();

            //\JoeyCo\Tools\PHPMail::send("JOEYCO",$admin->attributes['email'], "Your 6 digit code for Authentication", "Your code is ".$randomid);
            $admin->sendWelcomeEmail($randomid);

            $data['email'] = base64_encode($admin['email']);

            return redirect('backend/verify-code?key=' . $data['key'] . '&email=' . $data['email']);

        }
    }

    public function getgoogleAuth(Request $request){

        $admin = User::where('id', '=', base64_decode($request->get('id')))->first();
        $authenticator = new GoogleAuthenticator();

        if( empty($admin['googlecode']) ){

            $admin['googlecode'] = $authenticator->createSecret();
            $admin->save();
        }

        $adminLoginIpTrusted = RoutingLoginIp::where( 'dashboard_user_id','=', $admin['id'] )->whereNull('deleted_at')->first();

        if( is_null($adminLoginIpTrusted) ){
            $qrUrl =  $authenticator->getQRCodeGoogleUrl($admin['email'], $admin['googlecode']);
        }else{
            $qrUrl = null;
        }

        $data = ['secret' => $admin['googlecode'], 'qrUrl' => $qrUrl, 'email' => $admin['email'], 'key' => $request->get('key') ];

        return backend_view('auth.googleauth', $data );
    }

    public function postgoogleAuth(GoogleAuthRequest $request){


        $inputs = $request->all();

        $admin = User::where('email', '=', $request->get('email'))->where('role_id','3')->first();

        $passworddecode = base64_decode($request->get('key'));
        $request['password'] = $passworddecode;

        $authenticator = new GoogleAuthenticator();


        if( !$authenticator->verifyCode( $request->get('secret'),  $request->get('code'))) {
            return redirect('backend/google-auth?id=' . base64_encode($admin['id']) . "&key=" . $inputs['key'])->withErrors('Your Verification Code is not Valid!.');
        }
        else if (!Auth::attempt(['email'=>$request->get('email'),'password'=>$passworddecode,'role_id'=>'3','status'=>'1']))
        {
            return redirect('backend/login')->withErrors('Invalid Username or Password.');
        }
        else {
            if (isset($inputs['is_trusted'])) {
                $now = new \DateTime();

                RoutingLoginIp::where('dashboard_user_id', '=', $admin['id'])->where('ip', '=', $this->get_ipaddress())->update(['deleted_at' => date('Y-m-d H:i:s')]);
                RoutingLoginIp::create(['dashboard_user_id' => $admin['id'], 'ip' => $this->get_ipaddress(), 'trusted_date' => $now->modify('+30 days')]);
            } else {

                RoutingLoginIp::create(['dashboard_user_id' => $admin['id'], 'ip' => $this->get_ipaddress()]);
            }
            return $this->login($request);
        }

    }


    public function getverifycode(Request $request){

        return backend_view('auth.verificationcode', $request->all());
    }

    public function postverifycode(Request $request){


        $code=$request->get('code');

        $data= User::where('email','=', base64_decode($request->get('email')))->where('role_id','3')->where('emailauthanticationcode','=',$code)->first();

        $email = base64_decode($request->get('email'));
        $passworddecode = base64_decode($request->get('key'));
        $request['email'] = $email;
        $request['password'] = $passworddecode;

        $email = $request->get('email');
        $key = $request->get('key');
        if(empty($data)){
            return redirect('backend/verify-code?key=' . $key . '&email=' . base64_encode($email))->withErrors('Invalid verification code!');
        }
        else if (!Auth::attempt(['email'=>$email,'password'=>$passworddecode,'role_id'=>'3','status'=>'1']))
        {
            return redirect('backend/login')->withErrors('Invalid Username or Password.');
        }
        return $this->login($request);
    }

    private function get_ipaddress() {
        $ipaddress = null;
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        return $ipaddress;
    }

}
