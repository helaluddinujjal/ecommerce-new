<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
{
    public function brands(){
        Session::forget('page');
        Session::put('page','admin-brand');
        $brands=Brand::get();
        // $brands=json_decode(json_encode($brands),true);
        // echo "<pre>";print_r($brands);die;
        return view('admin.brand.brands')->with(compact('brands'));
    }
    public function updateBrandStatus(Request $request){
        if ($request->ajax()) {
            $data=$request->all();
            if ($data['status']=='Active') {
                $status=0;
            }else{
                $status=1;
            }
            Brand::where('id',$data['id'])->update(['status'=>$status]);
            return response()->json(['get_id'=>$data['id'],'status'=>$status]);

        }
    }
    public function brandAddEdit(Request $request,$id=null){

        if($id==""){
            $title="Add Brand";
            $brand=new Brand;
            $brand->status=1;
            $brandData=array();
            $massege="Brand has been saved";
        }else {
            $title="Edit Brand";
            $brandData=brand::where('id',$id)->first();
            $massege="Brand has been updated";
            $brand= Brand::find($id);
        }
        if ($request->isMethod('post')) {
            $data=$request->all();
            if (!empty($data['url'])) {
                $data['url']=Str::slug($data['url']);
            }else {
                $data['url']=Str::slug($data['name']);
            }
            $rule=[
                'name'=>'required|regex:/^[A-Za-z- ]+$/',
                'url'=>['required','regex:/^[A-Za-z-]+$/',Rule::unique('brands')->where(function($query) use ($data,$brandData){
                    if (!empty($brandData->id)) {
                     return   $query->where('url',$data['url'])->where('id','!=',$brandData->id);
                    }else {
                        //return $data;die;
                      return  $query->where('url',$data['url']);
                    }
                })
                ],
            ];
            $customMsg=[
                'name.required'=>"Brand Name must not be empty",
                'name.regex'=>"Brand Name formate invalid.only latter and - will allow",
                'url.regex'=>"Url formate invalid.only latter and - will allow",
                'url.unique'=>"Url already exists.Please change the Url",
                'url.required'=>"Url must not be empty",
            ];
            $this->validate($request,$rule,$customMsg);

            $brand->name=$data['name'];
            $brand->url=$data['url'];
            $brand->meta_title=$data['meta_title'];
            $brand->meta_description=$data['meta_description'];
            $brand->meta_keyward=$data['meta_keyward'];
            $brand->save();
            Session::flash('success_msg',$massege);
            return redirect('admin/brands');
        }
        return view('admin.brand.add-edit')->with(compact('title','brandData',));
    }
    //delete brand
    public function deleteBrand($id){
        Brand::where('id',$id)->delete();
        Session::flash('success_msg','Brand has been deleted successfully.');
        return redirect('/admin/brands');
    }
    //check brand slug
    public function checkBrandUrl(Request $request){
        if ($request->ajax()) {
            $data=$request->all();
            $url=Str::slug($data['getSlug']);
            if (!empty($data['getId'])) {
                $currentSlug=Brand::where(['url'=>$url,'id'=>$data['getId']])->count();
            }else{
                $currentSlug=0;
            }
            $countSlug=Brand::where('url',$url)->count();
            if ($countSlug>0) {
                $countSlug=1;
            }else {
                $countSlug=0;
            }
            return response()->json(['countSlug'=>$countSlug,'currentSlug'=>$currentSlug]);

        }
    }
}
