<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class BannerController extends Controller
{
    public function banners(){
        Session::forget('page');
        Session::put('page','admin-banner');
        $banners=Banner::get();
        // $banners=json_decode(json_encode($banners),true);
        // echo "<pre>";print_r($banners);die;
        return view('admin.banner.banners')->with(compact('banners'));
    }
    public function updateBannerStatus(Request $request){
        if ($request->ajax()) {
            $data=$request->all();
            if ($data['status']=='Active') {
                $status=0;
            }else{
                $status=1;
            }
            Banner::where('id',$data['id'])->update(['status'=>$status]);
            return response()->json(['get_id'=>$data['id'],'status'=>$status]);

        }
    }
    public function bannerAddEdit(Request $request,$id=null){
        
        if($id==""){
            $title="Add Banner";
            $banner=new Banner;
            $bannerData=array();
            $massege="Banner has been saved";
        }else {
            $title="Edit Banner";
            $bannerData=Banner::where('id',$id)->first();
            $massege="Banner has been updated";
            $banner= Banner::find($id);
        }
        if ($request->isMethod('post')) {
            $data=$request->all();
            $rule=[
                'image'=>'mimes:jpeg,jpg,png',
            ];
            $customMsg=[
                'link'=>"Link must be valid ",
                'image.mimes'=>"Image must be jpeg/jpg/png format",
            ];
            $this->validate($request,$rule,$customMsg); 
            if ($request->hasFile('image')) {
                $temp_img=$request->file('image');
                if ($temp_img->isValid()) {
                    //delete image
                    if (!empty($banner->image)) {
                        $path=public_path("images/banner/");
                            if(file_exists($path.$banner->image)){
                                unlink($path.$banner->image);
                            }
                    }
                        //create image name
                    $extension=$temp_img->getClientOriginalExtension();
                    $imageName="banner_".rand(1,999).'.'.$extension;
                    $imagePath=public_path('images/banner/'.$imageName);
                    Image::make($temp_img)->save($imagePath);
                }

            }else{
                if ($data['current_img']) {
                    $imageName=$request['current_img'];
                }
            }
            $banner->title=$data['title'];
            $banner->image=$imageName;
            $banner->link=$data['link'];
            $banner->alt=$data['alt'];
            $banner->status=1;
            $banner->save();
            Session::flash('success_msg',$massege);
            return redirect('admin/banners');
        }
        return view('admin.banner.add-edit')->with(compact('title','bannerData',));
    }
    //delete banner
    public function deleteBanner($id){
       $banner= Banner::find($id);
        $path=public_path("images/banner/");
        if(file_exists($path.$banner->image)){
            unlink($path.$banner->image);
        }
        $banner->delete();
        Session::flash('success_msg','banner has been deleted successfully.');
        return redirect('/admin/banners');
    }
}
