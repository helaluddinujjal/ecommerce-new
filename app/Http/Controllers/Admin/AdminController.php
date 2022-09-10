<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    //dashboard
    public function dashboard(){
        Session::forget('page');
        Session::put('page','dashboard');
        return view('admin.dashboard');
    }

    //settings
    public function checkPass(Request $request){

        if (Hash::check($request->current_pass,Auth::guard('admin')->user()->password)) {
            echo 'true';
        }else {
            echo 'false';
        }
    }
    public function updatePass(Request $request){
        if ($request->isMethod('post')) {
            $rule=[
                'current_pass'=>'required',
                'new_pass'=>'required',
                'confirm_pass'=>'required',
            ];
            $customMsg=[
                'current_pass.required'=>"Current password must not be empty",
                'new_pass.required'=>"New password must not be empty",
                'confirm_pass.required'=>"Confirm password must not be empty",
            ];
            $this->validate($request,$rule,$customMsg);
            if (Hash::check($request->current_pass,Auth::guard('admin')->user()->password)) {
                if ($request->confirm_pass==$request->new_pass) {
                    Admin::where('id',Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($request->new_pass)]);
                    Session::flash('success_msg','Password has been successfully change');
                    return redirect()->back();
                }else {
                    Session::flash('error_msg','Confirm password is not match');
                    return redirect()->back();
                }
            }else {
                Session::flash('error_msg','Current password is incorrect');
                return redirect()->back();
            }
        }
    }
    public function accountSettings(Request $request){
        Session::forget('page');
        Session::put('page','admin-account-settings');
        $adminDetails=Admin::where('email',Auth::guard('admin')->user()->email)->first();
        if ($request->isMethod('post')) {
            $rule=[
                'name'=>'required|regex:/^[A-Za-z. ]+$/',
                'mobile'=>'required|numeric',
                'image'=>'image|mimes:jpeg,jpg,png',
            ];
            $customMsg=[
                'name.required'=>"Name must not be empty",
                'name.regex'=>"Name formate invalid.only latter and . will allow",
                'mobile.required'=>"Mobile must not be empty",
                'image.mimes'=>"Image must be jpeg/jpg/png format",
            ];
            $this->validate($request,$rule,$customMsg);
            if ($request->hasFile('image')) {
                $temp_img=$request->file('image');
                if ($temp_img->isValid()) {
                    $extension=$temp_img->getClientOriginalExtension();
                    $imageName="profile_".rand(111,9999999).'.'.$extension;
                    $imagePath=public_path('images/admin/profile/'.$imageName);
                    Image::make($temp_img)->save($imagePath);
                }

            }else{
                if ($request->current_image) {
                    $imageName=$request->current_image;
                }else {
                    $imageName='';
                }
            }
            Admin::where('email',Auth::guard('admin')->user()->email)->update([
                'name'=>$request->name,
                'mobile'=>$request->mobile,
                'image'=>$imageName,
            ]);
            Session::flash('success_msg','Admin Details has been updated');
            return redirect()->back();

        }
        return view('admin.settings_details')->with(compact('adminDetails'));
    }

    //login & logout
    public function login(Request $request){
        if ($request->isMethod('post')) {
            $rule=[
                'email'=>'required|email|max:255',
                'password'=>'required',
            ];
            $customMsg=[
                'email.required'=>"Email must not be empty",
                'email.email'=>"Email must be valid",
                'email.max'=>"Email length will be max 255 words",
                'password.required'=>"Password must not be empty",
            ];
            $this->validate($request,$rule,$customMsg);
           //return $request->all();
           if (Auth::guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password])) {
               return redirect('admin/dashboard');
           }else {
               Session::flash('error_msg','Email or Password is invalid');
               return redirect()->back();
           }
        }
        if (Auth::guard('admin')->user()) {
            return redirect('admin/dashboard');
        }
            return view('admin.login');


    }
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('admin');
    }


}
