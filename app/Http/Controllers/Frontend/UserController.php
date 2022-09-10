<?php

namespace App\Http\Controllers\Frontend;

use App\Cart;
use App\Country;
use App\Http\Controllers\Controller;
use App\State;
use App\City;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
class UserController extends Controller
{
    public function login(Request $request){
        if ($request->isMethod('post')) {
            Session::forget('success_msg');
            Session::forget('confirm_msg');
            Session::forget('error_msg');
            $data=$request->all();

            if (Auth::attempt(['email' => $data['login_email'], 'password' => $data['login_password']])) {
                $statusCheck=User::where('email',$data['login_email'])->first();
            if ($statusCheck->status==0) {
               Auth::logout();
               Session::flash('error_msg',"Your account is not activated yet! Please confirm your email to activate!");
               return redirect()->back();
            }
                if (!empty(Session::get('session_id'))) {
                    $userId=Auth::user()->id;
                    $session_id=Session::get('session_id');
                    Cart::where('session_id',$session_id)->update(['user_id'=>$userId]);
                }
                return redirect('cart');
            }else{

                toast('Email or password not match','error');
            }
        }
        if (Auth::check()) {
            return redirect('cart');
        }
        return view('frontend.user.login_registration');

    }
    public function registration(Request $request){
        if ($request->isMethod('post')) {
            $rules=[
                'reg_first_name'=>'required',
                'reg_last_name'=>'required',
                'reg_email'=>'required|email|unique:users,email',
                'reg_password'=>'required|min:4',
                'reg_mobile'=>'required|numeric',
            ];
            $msg=[
                'reg_first_name.required'=>"Please input your first name",
                'reg_last_name.required'=>"Please input your last name",
                'reg_email.required'=>"Please input your Email",
                'reg_email.email'=>"Please input valid Email",
                'reg_email.unique'=>"Email already exists",
                'reg_password.required'=>"Please input your Password",
                'reg_password.min'=>"Password length must be 4 latters",
                'reg_mobile.required'=>"Please input your mobile number",
                'reg_mobile.numeric'=>"Please input valid mobile number",
            ];
            $this->validate($request,$rules,$msg);
            $data=$request->all();
            $userCount=User::where('email',$data['reg_email'])->count();
            if ($userCount>0) {
                toast('Email aleady exists','error');
                return redirect()->back();
            }else{
                $user=new User();
                $user->first_name=$data['reg_first_name'];
                $user->last_name=$data['reg_last_name'];
                $user->mobile=$data['reg_mobile'];
                $user->email=$data['reg_email'];
                $user->password=bcrypt($data['reg_password']);
                $user->status=0;
                $user->save();
                $email=$data['reg_email'];
                $name=$data['reg_first_name'].' '.$data['reg_last_name'];
                $appName="E-commerce Website";
                $code=base64_encode($email);
                $msg="Please click on bellow link to activate your account";
                $subject="Confirm Your E-Commerce Account";
                $message=['name'=>$name,'email'=>$email,'msg'=>$msg,'appName'=>$appName,'code'=>$code];
                Mail::send('mail.register-confirm', $message, function ($message) use($email,$subject,$name){
                    $message->to($email, $name)->subject($subject);
                });

                Session::flash('confirm_msg','Please confirm your email to activate your account.');
                return redirect()->back();
            }
        }
        return view('frontend.user.login_registration');
    }

    public function checkUserEmail(Request $request){
        $data=$request->all();
        $userCount=User::where('email',$data['reg_email'])->count();
        if ($userCount>0) {
           // return response()->json("Email address already exists");
          echo 'false';
        }else {
            echo 'true';
        }
    }

    public function userConfirmEmail($email){
        $email=base64_decode($email);
        $userCount=User::where('email',$email)->count();
        if ($userCount>0) {
            $user=User::where('email',$email)->first();
        if ($user->status==1) {
            Session::flash('warning_msg',"Your email account already activated! Please login.");
            return redirect('/login');
        }else{
            User::where('email',$user->email)->update(['status'=>1]);
                $email=$user->email;
                $name=$user->first_name.' '.$user->last_name;
                $appName="E-commerce Website";
                $msg="Welcome to E-commerce Website.Your account details are as bellow";
                $subject="Welcome to E-commerce Website";
                $message=['name'=>$name,'email'=>$email,'password'=>"****(As chosen by you)",'mobile'=>$user->mobile,'msg'=>$msg,'appName'=>$appName];
                Mail::send('mail.registration', $message, function ($message) use($email,$subject,$name){
                    $message->to($email, $name)->subject($subject);
                });

                toast('Your email account is activated. You can login now.','success');
                return redirect('/login');
        }
        } else {
            abort(404);
        }


    }
    public function forgetPassword(Request $request){
        if ($request->isMethod('post')) {

            $emailCount=User::where('email',$request->email)->count();
            if ($emailCount==0) {
                Session::flash('error_msg',"Email does not exists!");
                return redirect()->back();
            } else {
                $userDetals=User::select('name')->where('email',$request->email)->first();
                $randPass=Str::random(8);
                User::where('email',$request->email)->update(['password'=>bcrypt($randPass)]);
                $email=$request->email;
                $name=$userDetals->name;
                $msg="You have requested torecover your password.Your new password is as bellow :-";
                $appName="Ecommerce Site";
                $data=[
                    'name'=>$name,'password'=>$randPass,'appName'=>$appName,'msg'=>$msg
                ];
                $subj="New password-Ecommerce Site";
                Mail::send('mail.forget-password', $data, function ($message) use($email,$name,$subj){
                    $message->to($email, $name)->subject($subj);
                });
                Session::flash('success_msg',"Please check your email for new password.");
                return redirect()->back();
            }
        }

        return view('frontend.user.forget-password');
    }
    public function myAccount(Request $request){
        if (Auth::check()) {
            $userId=Auth::user()->id;
            if ($request->isMethod('post')) {
                $user=User::findOrFail($userId);
                $user->first_name=$request->first_name;
                $user->last_name=$request->last_name;
                $user->address_1=$request->address_1;
                $user->address_2=$request->address_2;
                $user->city=$request->city;
                $user->state=$request->state;
                $user->country=$request->country;
                $user->pincode=$request->pincode;
                $user->mobile=$request->mobile;
                $user->save();
                toast('Account has been updated','success');
                return redirect()->back();
            }
            $userDetails=User::where('id',$userId)->first();
            $countries=Country::select('id','name')->get();
            //echo "<pre>";print_r($countries->toArray());die;

            return view('frontend.user.account')->with(compact('userDetails','countries'));
        } else {
            toast('Please Login First','warning');
            return redirect('login');
        }

    }
    public function getState(Request $request){
        if ($request->ajax()) {
            $emoji=Country::flag($request->country_id);
            $states=State::select('id','name')->where('country_id',$request->country_id)->get()->toArray();
            return response()->json(['states'=>$states,'emoji'=>$emoji->emoji]);
        }
    }
    public function getCities(Request $request){
        if ($request->ajax()) {
            $cities=City::select('id','name')->where('state_id',$request->state_id)->get()->toArray();
            return response()->json(['cities'=>$cities]);
        }
    }
    public function checkPassword(Request $request){
        if ($request->ajax()) {
            $user=User::select('password')->where('id',Auth::user()->id)->first();
            if (Hash::check($request->password_old,$user->password)) {
                echo 'true';
            } else {
                echo 'false';
            }

        }
    }
    public function updatePassword(Request $request){
        if ($request->isMethod('post')) {
            $user=User::select('password')->where('id',Auth::user()->id)->first();
            if (Hash::check($request->password_old,$user->password)) {
                User::where('id',Auth::user()->id)->update(['password'=>bcrypt($request->password_new)]);
                toast('Password has been updated','success');
                return redirect()->back();
            } else {
                toast('Old password not matched','error');
                return redirect()->back();
            }
        }
    }
    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
