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

    public function viewUsersCharts(){
        $current_month_users=User::whereYear('created_at',date('Y'))->whereMonth('created_at',date('m'))->count();
        $last_month_users=User::whereYear('created_at',date('Y'))->whereMonth('created_at',date('m',strtotime('-1 month')))->count();
        $last_2_last_month_users=User::whereYear('created_at',date('Y'))->whereMonth('created_at',date('m',strtotime('-2 month')))->count();
        $last_3_last_month_users=User::whereYear('created_at',date('Y'))->whereMonth('created_at',date('m',strtotime('-3 month')))->count();
        $userCount=[$current_month_users,$last_month_users,$last_2_last_month_users,$last_3_last_month_users];
        return view('admin.user.view-users-charts')->with(compact('userCount'));
    }

    public function viewUsersCountryCharts(){
        $usersCountry=User::select('country',\DB::raw('count(*) as total'))->groupBy('country')->get()->toArray();
        return view('admin.user.view-users-country-charts')->with(compact('usersCountry'));
    }

}
