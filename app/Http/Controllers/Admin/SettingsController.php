<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SettingsController extends Controller
{
    public function siteSettings(Request $request){
        Session::forget('page');
        Session::put('page','admin-site-settings');
        if ($request->isMethod("post")) {
            $rules=[
               'site_currency'=>'required|in:$,€,¢,£,৳,₹', 
               'delivery_charge_type'=>'required|in:Country,Weight', 
               'weight_measurement'=>'required|in:g,kg', 
            ];
            $data=$request->all();
            $settings=SiteSetting::firstOrNew(['id'=>1]);
            $settings->site_currency=$data['site_currency'];
            $settings->delivery_charge_type=$data['delivery_charge_type'];
            $settings->weight_measurement=$data['weight_measurement'];
            $settings->save();
            Session::flash('success_msg','Settings has been Saved');
            return redirect()->back();

        }
        return view('admin.settings.site-settings');
    }
}
