<?php

namespace App\Http\Controllers\Admin;

use App\DeliveryCharge;
use App\DeliveyChargeByWeight;
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
    // delivery charges by weight
    public function viewDeliveryChargesByWeight(){
        Session::forget('page');
        Session::put('page','admin-delivery-charges-by-weight');
        $deliveryCharges=DeliveyChargeByWeight::get();
        return view('admin.delivery.delivery-charge-weight')->with(compact('deliveryCharges'));
    }
    public function updateStatusDeliveryChargeByWeight(Request $request){
        if ($request->ajax()) {
            $data=$request->all();
            if ($data['status']=='Active') {
                $status=0;
            }else{
                $status=1;
            }
            DeliveyChargeByWeight::where('id',$data['id'])->update(['status'=>$status]);
            return response()->json(['get_id'=>$data['id'],'status'=>$status]);

        }
    }
    public function editDeliveryChargesByWeight(Request $request,$id=null){
        if ($request->isMethod('post')) {
            $rules=[
                'from'=>'required|numeric|min:0',
                'to'=>'required|min:-1|not_in:0',
                'delivery_charges'=>'required|numeric|min:0',
            ];
            $this->validate($request,$rules);
            $data[0]=$request->except('_token');
            $data[0]['from']=str_replace("+", "", $data[0]['from']);
            $data[0]['to']=$data[0]['to']==="+1"?"+1":str_replace("+", "", $data[0]['to']);
            $data[0]['delivery_charges']=str_replace("+", "", $data[0]['delivery_charges']);
           $deliverChargeByWeight= DeliveyChargeByWeight::findOrFail($id);
            if (!empty($deliverChargeByWeight->delivery_charges_by_weight)) {
                $delivery_charges_by_weight=unserialize($deliverChargeByWeight->delivery_charges_by_weight);
              $data=  array_merge($delivery_charges_by_weight,$data);
              $data=serialize($data);
            }else {
                //$data[0]=$data;
                $data=serialize($data);
            }
            $deliverChargeByWeight->delivery_charges_by_weight=$data;
            $deliverChargeByWeight->save();
            Session::flash('success_msg','Delivery Charges has been saved successfully.');
            return redirect()->back();
        }
        $deliveryChargesData=DeliveyChargeByWeight::findOrFail($id);
        if (!empty($deliveryChargesData->delivery_charges_by_weight)) {
            $deliveryChargesData['delivery_charges_by_weight']=unserialize($deliveryChargesData->delivery_charges_by_weight);
        }
        //return  $deliveryChargesData;
        return view('admin.delivery.add-edit-weight')->with(compact('deliveryChargesData'));
    }
    public function deliveryWeightValueDeleted($id){
        $getArr=explode("-",$id);
        $deliveryChargesData=DeliveyChargeByWeight::findOrFail($getArr[0]);
        $delivery_charges_by_weight=unserialize($deliveryChargesData->delivery_charges_by_weight);
        unset($delivery_charges_by_weight[$getArr[1]]);
        $delivery_charges_by_weight=array_values($delivery_charges_by_weight);
        $deliveryChargesData->delivery_charges_by_weight=serialize( $delivery_charges_by_weight);
        $deliveryChargesData->save();
        Session::flash('success_msg','Delivery Charges has been Deleted.');
        return redirect()->back();
    }
}
