<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
      
        $rules=[
            'reg_name'=>'required',
            'reg_email'=>'required|email|unique:users,email',
            'reg_password'=>'required|min:4',
            'reg_mobile'=>'required|numeric',
        ];
        $msg=[
            'reg_name.required'=>"Please input your name",
            'reg_email.required'=>"Please input your Email",
            'reg_email.email'=>"Please input valid Email",
            'reg_email.unique'=>"Email already exists",
            'reg_password.required'=>"Please input your Password",
            'reg_password.min'=>"Password length must be 4 latters",
            'reg_mobile.required'=>"Please input your mobile number",
            'reg_mobile.numeric'=>"Please input valid mobile number",
        ];
        return Validator::make($data,$rules,$msg);
      // return $this->validate($data,$rules,$msg);
    }
    protected function showRegistrationForm(){
        return view('frontend.user.login_registration');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // return User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        // ]);
            $userCount=User::where('email',$data['reg_email'])->count();
            if ($userCount>0) {
                toast('Email aleady exists','error');
                return redirect()->back();
            }else{
                // $user=new User();
                // $user->name=$data['reg_name'];
                // $user->mobile=$data['reg_mobile'];
                // $user->email=$data['reg_email'];
                // $user->password=bcrypt($data['reg_password']);
                // $user->status=0;
                // $user->save();
              //  echo "<pre>";print_r($data);die;
              return  User::create([
                    'name' => $data['reg_name'],
                    'email' => $data['reg_email'],
                    'mobile' => $data['reg_mobile'],
                    'password' => bcrypt($data['reg_password']),
                    'status' => 0,
                ]);
                // if (Auth::attempt(['email' => $data['reg_email'], 'password' => $data['reg_password']])) {
                //     // if (!empty(Session::get('session_id'))) {
                //     //     $userId=Auth::user()->id;
                //     //     $session_id=Session::get('session_id');
                //     //     Cart::where('session_id',$session_id)->update(['user_id'=>$userId]);
                //     // }
                //     // $email=$data['reg_email'];
                //     // $name=$data['reg_name'];
                //     // $appName="E-commerce Website";
                //     // $msg="Welcome to E-commerce Website.Your account details are as bellow";
                //     // $subject="Welcome to E-commerce Website";
                //     // $message=['name'=>$data['reg_name'],'email'=>$email,'password'=>"****(As chosen by you)",'mobile'=>$data['reg_mobile'],'msg'=>$msg,'appName'=>$appName];
                //     // Mail::send('mail.registration', $message, function ($message) use($email,$subject,$name){
                //     //     $message->to($email, $name)->subject($subject);
                //     // });
                
                // }
                toast('Registration has been successfully done','success');
                return view('auth.verify');
            }
    }
}
