<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Country;
use App\Http\Controllers\Controller;
use App\PincodeCod;
use App\PincodePrepaid;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PincodeController extends Controller
{
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

    //pincode Cod
    public function addEditCod(Request $request,$id=null){
        if($id==""){
            $title="Add COD Pincode";
            $pincode=new PincodeCod();
            $pincodeData=array();
            $massege="COD Pincode has been saved";
            $states='';
            $cities='';
        }else {
            $title="Edit COD Pincode";
            $pincodeData=PincodeCod::where('id',$id)->first();
            if (!empty($pincodeData->state_id)) {
                $states=State::where('country_id',$pincodeData->country_id)->get();
            }else{
                $states='';
            }
            if (!empty($pincodeData->city_id)) {
                $cities=City::where('state_id',$pincodeData->state_id)->get();
            }else{
                $cities='';
            }
            $massege="COD Pincode has been updated";
            $pincode= PincodeCod::find($id);
        }
        if ($request->isMethod('post')) {


            $rule=[
                'delivery_country'=>'required|numeric',
                'delivery_state_status'=>'in:true,',
                'delivery_state'=>'required_if:delivery_state_status,true|numeric',
                'delivery_city_status'=>'in:true,',
                'delivery_city'=>'required_if:delivery_city_status,true|numeric',
                'pincode_status'=>'in:true,',
                'pincode'=>'required',


            ];

               $data=$request->all();
            $pincode->country_id=$data['delivery_country'];
            if (!empty($data['delivery_state_status'])) {
                $pincode->state_id_status=true;
            $pincode->state_id=$data['delivery_state'];
            }else{
                $pincode->state_id_status=false;
                $pincode->state_id=null;
            }

            if (!empty($data['delivery_city_status'])) {
                $pincode->city_id_status=true;
                $pincode->city_id=$data['delivery_city'];
            }else{
                $pincode->city_id_status=false;
                $pincode->city_id=null;
            }

            if (!empty($data['pincode_status'])) {
                $pincode->pincode_status=true;
            }else{
                $pincode->pincode_status=false;
            }

            $pincode->pincode=trim($data['pincode']);
            $pincode->save();
            Session::flash('success_msg',$massege);

            return redirect('admin/pincode/cod');
        }
        $countries=Country::get();
        return view('admin.pincode.add-edit-cod')->with(compact('title','pincodeData','countries','states','cities'));
    }
    public function pincodeCod(){
        Session::forget('page');
        Session::put('page','admin-pincode-cod');
        $pincodes=PincodeCod::get();
        return view('admin.pincode.pincodes-cod')->with(compact('pincodes'));
    }
    public function updatePincodeCodStatus(Request $request){
        if ($request->ajax()) {
            $data=$request->all();
            if ($data['status']=='Active') {
                $status=0;
            }else{
                $status=1;
            }
            PincodeCod::where('id',$data['id'])->update(['status'=>$status]);
            return response()->json(['get_id'=>$data['id'],'status'=>$status]);

        }

    }
      //delete pincode cod
      public function pincodeCodDeleted($id){
        PincodeCod::where('id',$id)->delete();
        Session::flash('success_msg','Data has been deleted successfully.');
        return redirect('/admin/pincode/cod');
    }

    //pincode prepaid

     //pincode Cod
     public function addEditPrepaid(Request $request,$id=null){
        if($id==""){
            $title="Add Prepaid Pincode";
            $pincode=new PincodePrepaid();
            $pincodeData=array();
            $massege="Prepaid Pincode has been saved";
            $states='';
            $cities='';
        }else {
            $title="Edit Prepaid Pincode";
            $pincodeData=PincodePrepaid::where('id',$id)->first();
            if (!empty($pincodeData->state_id)) {
                $states=State::where('country_id',$pincodeData->country_id)->get();
            }else{
                $states='';
            }
            if (!empty($pincodeData->city_id)) {
                $cities=City::where('state_id',$pincodeData->state_id)->get();
            }else{
                $cities='';
            }
            $massege="Prepaid Pincode has been updated";
            $pincode= PincodePrepaid::find($id);
        }
        if ($request->isMethod('post')) {


            $rule=[
                'delivery_country'=>'required|numeric',
                'delivery_state_status'=>'in:true,',
                'delivery_state'=>'required_if:delivery_state_status,true|numeric',
                'delivery_city_status'=>'in:true,',
                'delivery_city'=>'required_if:delivery_city_status,true|numeric',
                'pincode_status'=>'in:true,',
                'pincode'=>'required',


            ];
          
               $data=$request->all();
            $pincode->country_id=$data['delivery_country'];
            if (!empty($data['delivery_state_status'])) {
                $pincode->state_id_status=true;
            $pincode->state_id=$data['delivery_state'];
            }else{
                $pincode->state_id_status=false;
                $pincode->state_id=null;
            }

            if (!empty($data['delivery_city_status'])) {
                $pincode->city_id_status=true;
                $pincode->city_id=$data['delivery_city'];
            }else{
                $pincode->city_id_status=false;
                $pincode->city_id=null;
            }

            if (!empty($data['pincode_status'])) {
                $pincode->pincode_status=true;
            }else{
                $pincode->pincode_status=false;
            }

            $pincode->pincode=trim($data['pincode']);
            $pincode->save();
            Session::flash('success_msg',$massege);

            return redirect('admin/pincode/prepaid');
        }
        $countries=Country::get();
        return view('admin.pincode.add-edit-prepaid')->with(compact('title','pincodeData','countries','states','cities'));
    }
    public function pincodePrepaid(){
        Session::forget('page');
        Session::put('page','admin-pincode-prepaid');
        $pincodes=PincodePrepaid::get();
        return view('admin.pincode.pincodes-prepaid')->with(compact('pincodes'));
    }
    public function updatePincodePrepaidStatus(Request $request){
        if ($request->ajax()) {
            $data=$request->all();
            if ($data['status']=='Active') {
                $status=0;
            }else{
                $status=1;
            }
            PincodePrepaid::where('id',$data['id'])->update(['status'=>$status]);
            return response()->json(['get_id'=>$data['id'],'status'=>$status]);

        }

    }
      //delete pincode cod
      public function pincodePrepaidDeleted($id){
        PincodePrepaid::where('id',$id)->delete();
        Session::flash('success_msg','Data has been deleted successfully.');
        return redirect('/admin/pincode/prepaid');
    }
}
