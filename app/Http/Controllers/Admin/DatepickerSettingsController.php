<?php

namespace App\Http\Controllers\Admin;

use App\DatepickerSetting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DatepickerSettingsController extends Controller
{
    public function localpickupSettings(Request $request){
        Session::forget('page');
        $request->session()->put('page', "admin-datepicker-localpickup");
        if ($request->isMethod('post')) {
            $rules=[
                'timezone'=>'required|in:Asia/Dhaka,Europe/Berlin,Europe/London,Europe/Paris,Europe/Rome,Europe/Amsterdam',
                'holiday'=>'sometimes|nullable',
                'weekend'=>'sometimes|array|in:0,1,2,3,4,5,6',
                'cutOffDay'=>'sometimes|nullable|in:0,1',
                'timeFieldShow'=>'sometimes|nullable|in:0,1',
                'shopOpenTime'=>'required_if:shopAlwaysOpen,|nullable|date_format:H:i',
                'shopCloseTime'=>'required_if:shopAlwaysOpen,|nullable|date_format:H:i',
            ];
            $msg=[
                'shopOpenTime.required_if'=>'Shop Open Time Field is required',
                'shopCloseTime.required_if'=>'Shop Close Time Field is required',
            ];
            $this->validate($request,$rules,$msg); 
            $data=$request->all();
            $datepicker=DatepickerSetting::firstOrNew(['id'=>1]);
            $datepicker->timezone=$data['timezone'];
            $datepicker->holiday=$data['holiday'];
            $datepicker->weekend=!empty($data['weekend'])?implode(',',$data['weekend']):'';
            $datepicker->cutOffDay=$data['cutOffDay'];
            $datepicker->timeFieldShow=$data['timeFieldShow'];
            if (!empty($data['shopAlwaysOpen'])&&$data['shopAlwaysOpen']==1) {
                
                $datepicker->shopOpenTime=null;
                $datepicker->shopCloseTime=null;
            }else{

                $datepicker->shopOpenTime=$data['shopOpenTime'];
                $datepicker->shopCloseTime=$data['shopCloseTime'];
            }
            $datepicker->type="Local Pickup";
            $datepicker->save();
            Session::flash('success_msg',"Settings has been saved");
            return redirect()->back();
        }
        $datepickerSetting=DatepickerSetting::find(1);
        return view('admin.datepicker.local-pickup-settings')->with(compact('datepickerSetting'));
    }
    public function deliverypickupSettings(Request $request){
        Session::forget('page');
        $request->session()->put('page', "admin-datepicker-delivery-pickup");
        if ($request->isMethod('post')) {
            $rules=[
                'timezone'=>'required|in:Asia/Dhaka,Europe/Berlin,Europe/London,Europe/Paris,Europe/Rome,Europe/Amsterdam',
                'holiday'=>'sometimes|nullable',
                'weekend'=>'sometimes|array|in:0,1,2,3,4,5,6',
                'cutOffDay'=>'sometimes|nullable|in:0,1',
                'timeFieldShow'=>'sometimes|nullable|in:0,1',
                'shopOpenTime'=>'required_if:shopAlwaysOpen,|nullable|date_format:H:i',
                'shopCloseTime'=>'required_if:shopAlwaysOpen,|nullable|date_format:H:i',
            ];
            $msg=[
                'shopOpenTime.required_if'=>'Shop Open Time Field is required',
                'shopCloseTime.required_if'=>'Shop Close Time Field is required',
            ];
            $this->validate($request,$rules,$msg); 
             $data=$request->all();
            $datepicker=DatepickerSetting::firstOrNew(['id'=>2]);
            $datepicker->timezone=$data['timezone'];
            $datepicker->holiday=$data['holiday'];
            $datepicker->weekend=!empty($data['weekend'])?implode(',',$data['weekend']):'';
            $datepicker->cutOffDay=$data['cutOffDay'];
            $datepicker->timeFieldShow=$data['timeFieldShow'];
            if (!empty($data['shopAlwaysOpen'])&&$data['shopAlwaysOpen']==1) {
                
                $datepicker->shopOpenTime=null;
                $datepicker->shopCloseTime=null;
            }else{

                $datepicker->shopOpenTime=$data['shopOpenTime'];
                $datepicker->shopCloseTime=$data['shopCloseTime'];
            }
            $datepicker->type="Delivery Pickup";
            $datepicker->save();
            Session::flash('success_msg',"Settings has been saved");
            return redirect()->back();
        }
        $datepickerSetting=DatepickerSetting::find(2);
        return view('admin.datepicker.delivery-pickup-settings')->with(compact('datepickerSetting'));
    }
}
