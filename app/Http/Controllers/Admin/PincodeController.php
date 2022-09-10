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
    //pincode Cod
    public function addEditCod(Request $request,$id=null){
        if($id==""){
            $title="Add COD Pincode";
            $pincode=new PincodeCod();
            $pincodeData=array();
            $massege="COD Pincode has been saved";
            $rule=[
                'delivery_country'=>'required|numeric|unique:pincode_cod,country_id,',
                'pincode_status'=>'in:true,',
                'pincode'=>'required',
            ];
        }else {
            $title="Edit COD Pincode";
            $pincodeData=PincodeCod::where('id',$id)->first();

            $massege="COD Pincode has been updated";
            $pincode= PincodeCod::find($id);
            $rule=[
                'delivery_country'=>'required|numeric|unique:pincode_cod,country_id,'.$id,
                'pincode_status'=>'in:true,',
                'pincode'=>'required',
            ];
        }
        if ($request->isMethod('post')) {

$this->validate($request,$rule);


               $data=$request->all();
            $pincode->country_id=$data['delivery_country'];


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
        return view('admin.pincode.add-edit-cod')->with(compact('title','pincodeData','countries'));
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
            $rule=[
                'delivery_country'=>'required|numeric|unique:pincode_prepaids,country_id,',
                'pincode_status'=>'in:true,',
                'pincode'=>'required',
            ];
        }else {
            $title="Edit Prepaid Pincode";
            $pincodeData=PincodePrepaid::where('id',$id)->first();

            $massege="Prepaid Pincode has been updated";
            $pincode= PincodePrepaid::find($id);

            $rule=[
                'delivery_country'=>'required|numeric|unique:pincode_prepaids,country_id,'.$id,
                'pincode_status'=>'in:true,',
                'pincode'=>'required',
            ];
        }
        if ($request->isMethod('post')) {
            $this->validate($request,$rule);

               $data=$request->all();
            $pincode->country_id=$data['delivery_country'];

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
        return view('admin.pincode.add-edit-prepaid')->with(compact('title','pincodeData','countries'));
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
