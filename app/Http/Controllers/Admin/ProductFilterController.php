<?php

namespace App\Http\Controllers\Admin;

use App\ProductFilter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ProductFilterController extends Controller
{
    public function productFilters(){
        Session::forget('page');
        Session::put('page','admin-filter');
        $filters=ProductFilter::get();
        // $filters=json_decode(json_encode($filters),true);
        // echo "<pre>";print_r($filters);die;
        return view('admin.product-filter.filters')->with(compact('filters'));
    }

    public function updateFilterStatus(Request $request){
        if ($request->ajax()) {
            $data=$request->all();
            if ($data['status']=='Active') {
                $status=0;
            }else{
                $status=1;
            }
            ProductFilter::where('id',$data['id'])->update(['status'=>$status]);
            return response()->json(['get_id'=>$data['id'],'status'=>$status]);

        }
    }

    public function updateFilterStatusValue(Request $request){
        if ($request->ajax()) {
            $data=$request->all();
            if ($data['status']=='Active') {
                $status=0;
            }else{
                $status=1;
            }
             $getId=explode('-',$data['id']);
            //echo $getId[0];die;
            $filterData=ProductFilter::where('id',$getId[0])->first();
            $filterArr=json_decode($filterData->value);
            $filterArr[$getId[1]]->status=$status;
            $filterData->value=json_encode($filterArr);
            $filterData->save();
            return response()->json(['get_id'=>$getId[1],'status'=>$status]);

        }
    }
       
    public function editFilter(Request $request,$id=null){
        $productFilterData=ProductFilter::find($id);
        if ($request->isMethod('post')) {
            $data=$request->all();
            if (!empty($data['filter_title'])) {
                $title=$data['filter_title'];
            } else {
                $title='';
            }
            
            if (!empty($data['filter_value'][0])) { 
                    $filterValue = json_decode($productFilterData->value, true);
                        $names = collect($filterValue)->pluck('name')->toArray();
                        foreach($data['filter_value'] as $value) {
                            if(!in_array(ucwords($value), $names)){
                            $names[] = ucwords($value);
                            //print_r($names);die;
                        $filterValue[] = [
                        'name' => ucwords($value),
                        'status' => 1
                        ];
                    } else {
                        //print_r($filterValue);die; 
                    Session::flash('error_msg', 'Duplicate value '.$value);
                    //return back();
                    }
                    }
                    $productFilterData->update([
                    'value' => json_encode($filterValue)
                    ]);  
            }
            $productFilterData->title=$title;
            $productFilterData->save();
            Session::flash('success_msg','Filter Value has been Saved');
        }
        return view('admin.product-filter.edit')->with(compact('productFilterData'));
    }
    public function deleteFilterValue($data=null){
        $getArr=explode("-",$data);
        $productFilterData=ProductFilter::find($getArr[0]);
        $valArr=json_decode($productFilterData->value,true);
            unset($valArr[$getArr[1]]);
        $productFilterData->value=json_encode($valArr);
        $productFilterData->save();
        Session::flash('success_msg','Filter Value has been Deleted');
        return view('admin.product-filter.edit')->with(compact('productFilterData'));
    }

    public function checkFilterValue(Request $request){
        if ($request->ajax()) {
            $data=$request->all();
            
               // $getData=str_replace(' ','-',$data['getData']);
               $countData=ProductFilter::searchForFilterValue($data['getId'],$data['getData']);
              // $countData=array_search($data['getData'],array_column($filterValue, 'name'));
            if ($countData>0) {
                $countData=1;
            }else {
                $countData=0;
            }
            return response()->json(['countData'=>$countData]);
            
        }
    }
}
