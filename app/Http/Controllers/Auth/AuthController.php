<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use DB;
use Mail;
use Notification;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignUpRequest;

class AuthController extends Controller
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
     protected $username            = 'email';
      protected $redirectTo          = '/projects';
      protected $redirectAfterLogout = 'login';
      protected $maxLoginAttempts    = 3;
      protected $lockoutTime         = 60;

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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
     protected function create(array $data)
     {
         return User::create([
             'name' => $data['name'],
             'email' => $data['email'],
             'password' => bcrypt($data['password']),
         ]);
     }

     public function getLogin()
     {
       return view('auth.login');
     }

     public function postLogin(Request $request)
     {
       // Login Attempt Check
       $loginRequest = new LoginRequest();
       $validator    = Validator::make($request->all(), $loginRequest->rules(), $loginRequest->messages());
       if ($validator->fails()) {
         return back()->withErrors($validator)->withInput();
       }
       $throttles = $this->isUsingThrottlesLoginsTrait();

       if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
         Notification::error('Account Exceeded Maximum No. of Attempt.');
           $this->fireLockoutEvent($request);

           return $this->sendLockoutResponse($request);
       }

       $credentials = $this->getCredentials($request);
       if (auth()->guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {

           if(auth()->user()->verified == '0'){
                 $this->logout();
                 Notification::warning('Please Verify Your Email to Login!');
                 return back();
             }
           if(auth()->user()->google2fa_on == true){
               $userId = auth()->user()->id;
               $request->session()->put('userid', $userId);
               $this->logout();
               Notification::info('Provide Token from Your Google Authenticator App.');
               return redirect()->route('auth.get2FA');
             }
             return $this->handleUserWasAuthenticated($request, $throttles);
       }
       if($throttles && ! $lockedOut){
         $this->incrementLoginAttempts($request);
       }
       Notification::error('Invalid Credentials!');
       return back()->withInput($request->except('password'));
     }
     public function getRegister()
     {
       return view('auth.register');
     }
     /**
      * Register new user
      *
      * @param  array  $data
      * @return User
      */
     public function postRegister(Request $request)
     {
         $signup = new SignUpRequest();
         $validator    = Validator::make($request->all(), $signup->rules(), $signup->messages());
         if ($validator->fails()) {
           return back()->withErrors($validator)->withInput();
         }
         $user = $this->create($request->all())->toArray();
         $user['link'] = str_random(15).$request->input('email');

         DB::table('user_activations')->insert(['id_user'=>$user['id'],'token'=>$user['link']]);

         Mail::send('emails.activation', $user, function($message) use ($user) {
             $message->to($user['email']);
             $message->subject(config('jarvis.site.name') . ' - Verify Your Email');
         });
         Notification::success('We Have Email You. Please Check and Verify your Email.');
         return redirect()->to('login');
     }

     /**
      * Check for user Activation Code
      *
      * @param  array  $data
      * @return User
      */
     public function userActivation($token)
     {
         $check = DB::table('user_activations')->where('token',$token)->first();

         if(!is_null($check)){
             $user = User::find($check->id_user);

             if($user->verified == 1){
             Notification::success('You Have Already Verified Your Email!.');
                 return redirect()->to('login');
             }

             $user->update(['verified' => 1]);
             DB::table('user_activations')->where('token',$token)->delete();
             Notification::success('You Have Successfully Verified Your Email.');
             auth()->loginUsingId($check->id_user);
             return redirect()->intended('/projects');
         }
         return redirect()->to('login');
     }

     public function getGoogle2fa(Request $request)
     {
       if($request->session()->has('userid'))
       {
         Notification::info('Check Google Authenticator in Your Mobile Phone For Token.');
         $request->session()->reflash();
         $request->session()->keep(['userid']);
         return view()->make('auth.google2fa');
       }
       return redirect()->to('login');
     }

     public function postGoogle2fa(Request $request)
     {
       $request->session()->reflash();
       $request->session()->keep(['userid']);
       $user = User::find($request->session()->get('userid'));
       $google2fa = app()->make('PragmaRX\Google2FA\Contracts\Google2FA');
       $secret = $request->input('secret');
       if(!$secret){
         Notification::warning('Please Enter a Token!');
         return redirect()->route('auth.get2FA');
       }
       $valid = $google2fa->verifyKey($user->google2fa_secret, $secret);
       if($valid){
         auth()->login($user);
         return redirect()->intended('/projects');
       }else {
         Notification::error('Invalid Token!');
         return redirect()->route('auth.get2FA');
       }
       return back();
     }

     public function logout()
     {
         auth()->logout();
         session()->flush();
         return redirect()->to('login');
     }
}
