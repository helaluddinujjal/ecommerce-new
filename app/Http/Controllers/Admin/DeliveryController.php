<?php

namespace App\Http\Controllers\Admin;

use App\DeliveryCharge;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DeliveryController extends Controller
{
    public function viewDeliveryCharges(){
        Session::forget('page');
        Session::put('page','admin-delivery-charges');
        $deliveryCharges=DeliveryCharge::get();
        return view('admin.delivery.delivery-charges')->with(compact('deliveryCharges'));
    }
    public function updateStatusDeliveryCharge(Request $request){
        if ($request->ajax()) {
            $data=$request->all();
            if ($data['status']=='Active') {
                $status=0;
            }else{
                $status=1;
            }
            DeliveryCharge::where('id',$data['id'])->update(['status'=>$status]);
            return response()->json(['get_id'=>$data['id'],'status'=>$status]);

        }
    }
    public function editDeliveryCharges(Request $request,$id=null){
        if ($request->isMethod('post')) {
            $data=$request->all();
            DeliveryCharge::where('id',$id)->update(['delivery_charges'=>$data['delivery_charges']]);
            Session::flash('success_msg','Delivery Charges has been updated successfully.');
            return redirect('/admin/view-delivery-charges');
        }
        $deliveryChargesData=DeliveryCharge::findOrFail($id);
        return view('admin.delivery.add-edit')->with(compact('deliveryChargesData'));
    }
}
