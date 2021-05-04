<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderStatusController extends Controller
{
    public function orderStatuses(){
        Session::forget('page');
        Session::put('page','admin-order-status');
        $statuses=OrderStatus::get();
        return view('admin.order-status.statuses')->with(compact('statuses'));
    }
    public function updateStatusOrderstatus(Request $request){
        if ($request->ajax()) {
            $data=$request->all();
            if ($data['status']=='Active') {
                $status=0;
            }else{
                $status=1;
            }
            OrderStatus::where('id',$data['id'])->update(['status'=>$status]);
            return response()->json(['get_id'=>$data['id'],'status'=>$status]);

        }
    }

    public function addEditOrderStatus(Request $request,$id=null){
        if($id==""){
            $title="Add Order Status";
            $orderStatus=new OrderStatus;
            $orderStatusData=array();
            $massege="Order Status has been saved";
        }else {
            $title="Edit OrderStatus";
            $orderStatusData=OrderStatus::where('id',$id)->first();
            $massege="OrderStatus has been updated";
            $orderStatus= OrderStatus::find($id);
        }
        if ($request->isMethod('post')) {
            $data=$request->all();
            $rule=[
                'statusName'=>'required|regex:/^[A-Za-z- ]+$/',
            ];
            $customMsg=[
                'statusName.required'=>"Status Name must not be empty",
                'statusName.regex'=>"Status Name formate invalid.only latter and - will allow",
            ];
            $this->validate($request,$rule,$customMsg); 
            
            $orderStatus->name=$data['statusName'];
            $orderStatus->status=1;
            $orderStatus->save();
            Session::flash('success_msg',$massege);
            return redirect('admin/order-statuses');
        }
        return view('admin.order-status.add-edit')->with(compact('title','orderStatusData',));
    }
    public function deleteOrderStatus($id){
        OrderStatus::where('id',$id)->delete();
        Session::flash('success_msg','Order Status has been deleted successfully.');
        return redirect('/admin/order-statuses');
    }
}
