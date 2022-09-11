<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function users(){

        Session::forget('page');
        Session::put('page','admin-brand');
        $users=User::get();
        return view('admin.user.users')->with(compact('users'));

    }

    public function updateUserStatus(Request $request){
        if ($request->ajax()) {
            $data=$request->all();
            if ($data['status']=='Active') {
                $status=2;
            }else{
                $status=1;
            }
            User::where('id',$data['id'])->update(['status'=>$status]);
            return response()->json(['get_id'=>$data['id'],'status'=>$status]);

        }
    }
}
