<?php

namespace App\Http\Controllers\Auth;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(){
        return view('frontend.user.login_registration');
    }

    public function login(Request $request)
    {
        
        if ($request->isMethod('post')) {
            $data=$request->all();
            if (Auth::attempt(['email' => $data['login_email'], 'password' => $data['login_password']])) {
                if (!empty(Session::get('session_id'))) {
                    $userId=Auth::user()->id;
                    $session_id=Session::get('session_id');
                    Cart::where('session_id',$session_id)->update(['user_id'=>$userId]);
                }
                return redirect('cart');
            }else{

                toast('Email or password not match','error');
                return redirect()->back();
            } 
        }
        return view('frontend.user.login_registration');
    }
}
