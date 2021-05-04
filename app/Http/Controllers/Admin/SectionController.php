<?php

namespace App\Http\Controllers\Admin;

use App\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class SectionController extends Controller
{
    public function sections(){
        Session::forget('page');
        Session::put('page','admin-section');
        $sections=Section::all();
        return view('admin/section/sections')->with(compact('sections'));
    }
    public function updateSectionStatus(Request $request){
      if ($request->ajax()) {
         $data=$request->all();
         if ($data['status']=="Active") {
             $status=0;
         } else {
            $status=1;
         }
         
         Section::where('id',$data['id'])->update(['status'=>$status]);
         return response()->json(['status'=>$status,'get_id'=>$data['id']]);
      }
     
    }
}
