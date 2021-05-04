<?php

namespace App\Http\Controllers\Admin;

use App\Coupon;
use App\Http\Controllers\Controller;
use App\Section;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    public function coupons(){
        Session::forget('page');
        Session::put('page','admin-coupon');
        $coupons=Coupon::get();
        // $coupons=json_decode(json_encode($coupons),true);
        // echo "<pre>";print_r($coupons);die;
        return view('admin.coupon.coupons')->with(compact('coupons'));
    }
    public function updateCouponStatus(Request $request){
        if ($request->ajax()) {
            $data=$request->all();
            if ($data['status']=='Active') {
                $status=0;
            }else{
                $status=1;
            }
            Coupon::where('id',$data['id'])->update(['status'=>$status]);
            return response()->json(['get_id'=>$data['id'],'status'=>$status]);

        }
    }
    public function couponAddEdit(Request $request,$id=null){
        if ($id=='') {
            $title="Add Coupun";
            $couponData="";
            $coupon=new Coupon;
            $selCat=[];
            $selUsers=[];
         }else {
             $title="Edit Coupon";
             $couponData=Coupon::findOrFail($id);
             $selCat=explode(',',$couponData->categories);
             $selUsers=explode(',',$couponData->users);
             $coupon=Coupon::findOrFail($id);
         }
        if ($request->isMethod('post')) {
            $rule=[
                'coupon_option'=>'required|in:Manual,Automatic',
                'coupon_code'=>'required_if:coupon_option,Manual',
                'coupon_type'=>'required|in:Single,Multiple',
                'amount_type'=>'required|in:Percentage,USD',
                'amount'=>'required|numeric',
                'expiry_date'=>'required',
            ];
            $customMsg=[
                'coupon_option.required'=>"Please select coupon option",
                'coupon_option.in'=>"Selected value must be Manual or Automatic",
                'coupon_code.required_if'=>"Coupon code must not be empty",
                'coupon_type.required'=>"Please select coupon type",
                'coupon_type.in'=>"Selected value must be Single or Multiple",
                'amount_type.required'=>"Please select amount type",
                'amount_type.in'=>"Selected value must be Percentage or USD",
                'amount.required'=>"Amount must not be empty",
                'expiry_date.required'=>"Expiry date must not be empty",
            ];
            $this->validate($request,$rule,$customMsg); 
             $data=$request->all(); 
             if ($data['coupon_code']=="Manual") {
                 $coupon_code=$data['coupon_code'];
                } else {
                    $coupon_code=str_random(8);
                }
                if (isset($data['categories'])) {
                    $categories= implode(',',$data['categories']);
                } else {
                    $categories="";
                }
                if (isset($data['users'])) {
                    $users= implode(',',$data['users']);
                } else {
                    $users="";
                }
                if (isset($data['expiry_date'])) {
                    $dates= explode(' to ',$data['expiry_date']);
                } 
                $coupon->coupon_option=$data['coupon_option'];
                $coupon->coupon_code=$coupon_code;
                $coupon->categories=$categories;
                $coupon->users=$users;
                $coupon->coupon_type=$data['coupon_type'];
                $coupon->amount_type=$data['amount_type'];
                $coupon->amount=$data['amount'];
                $coupon->start_date=$dates[0];
                $coupon->expiry_date=$dates[1];
                $coupon->status=1;
                 $coupon->save();
                toast("Coupon has been saved",'success');
                return redirect('admin/coupons');
            }
        $categories=Section::with('categories')->get();
        $users=User::select('email')->where('status','1')->get();
        return view("admin.coupon.add-edit")->with(compact('title','couponData','categories','users','selCat','selUsers'));
    }
     //delete coupon
     public function deleteCoupon($id){
        Coupon::where('id',$id)->delete();
        toast("Coupon code has been deleted successfully.","success");
        return redirect('/admin/coupons');
    }
}
