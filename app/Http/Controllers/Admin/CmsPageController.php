<?php

namespace App\Http\Controllers\Admin;

use App\CmsPage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;

class CmsPageController extends Controller
{
    public function cmsPages(){
        Session::forget('page');
        Session::put('page','admin-cms-pages');
        $cmsPages=CmsPage::get();
        // $cmsPages=json_decode(json_encode($cmsPages),true);
        // echo "<pre>";print_r($cmsPages);die;
        return view('admin.cms-page.cms-pages')->with(compact('cmsPages'));
    }
    public function updateStatusCmsPage(Request $request){
        if ($request->ajax()) {
            $data=$request->all();
            if ($data['status']=='Active') {
                $status=0;
            }else{
                $status=1;
            }
            CmsPage::where('id',$data['id'])->update(['status'=>$status]);
            return response()->json(['get_id'=>$data['id'],'status'=>$status]);

        }
    }
    public function isNavStatusCmsPage(Request $request){
        if ($request->ajax()) {
            $data=$request->all();
            if ($data['status']=='Active') {
                $status=0;
            }else{
                $status=1;
            }
            CmsPage::where('id',$data['id'])->update(['is_nav'=>$status]);
            return response()->json(['get_id'=>$data['id'],'status'=>$status]);

        }
    }
    public function addEditCmsPage(Request $request,$id=null){

        if($id==""){
            $title="Add Cms Page";
            $cmsPage=new CmsPage;
            $cmsPage->status=1;
            $cmsPage->is_nav=0;
            $cmsPageData=array();
            $massege="Cms Page has been saved";
        }else {
            $title="Edit Cms Page";
            $cmsPageData=CmsPage::where('id',$id)->first();
            $massege="Cms Page has been updated";
            $cmsPage= CmsPage::find($id);
        }
        if ($request->isMethod('post')) {
            $data=$request->all();
            if (!empty($data['url'])) {
                $data['url']=Str::slug($data['url']);
            }else {
                $data['url']=Str::slug($data['title']);
            }
            $rule=[
                'title'=>'required',
                'priority'=>'numeric|nullable',
                'url'=>['required','regex:/^[A-Za-z-]+$/',Rule::unique('cms_pages')->where(function($query) use ($data,$cmsPageData){
                    if (!empty($cmsPageData->id)) {
                     return   $query->where('url',$data['url'])->where('id','!=',$cmsPageData->id);
                    }else {
                        //return $data;die;
                      return  $query->where('url',$data['url']);
                    }
                })
                ],
            ];
            $customMsg=[
                'title.required'=>"Cms Page Title must not be empty",
                'url.regex'=>"Url formate invalid.only latter and - will allow",
                'url.unique'=>"Url already exists.Please change the Url",
                'url.required'=>"Url must not be empty",
                'priority.numeric'=>"Priority must be numeric",
            ];
            $this->validate($request,$rule,$customMsg);
            $cmsPage->title=$data['title'];
            $cmsPage->description=$data['description'];
            $cmsPage->url=$data['url'];
            $cmsPage->meta_title=$data['meta_title'];
            $cmsPage->meta_description=$data['meta_description'];
            $cmsPage->meta_keyward=$data['meta_keyward'];
            $cmsPage->priority=$data['priority'];
            $cmsPage->save();
            Session::flash('success_msg',$massege);
            return redirect('admin/cms-pages');
        }
        return view('admin.cms-page.add-edit')->with(compact('title','cmsPageData',));
    }
    //delete cmsPage
    public function deleteCmsPage($id){
        CmsPage::where('id',$id)->delete();
        Session::flash('success_msg','Cms Page has been deleted successfully.');
        return redirect('/admin/cms-pages');
    }
    //check brand slug
    public function checkCmsPageUrl(Request $request){
        if ($request->ajax()) {
            $data=$request->all();
            $url=Str::slug($data['getSlug']);
            if (!empty($data['getId'])) {
                $currentSlug=CmsPage::where(['url'=>$url,'id'=>$data['getId']])->count();
            }else{
                $currentSlug=0;
            }
            $countSlug=CmsPage::where('url',$url)->count();
            if ($countSlug>0) {
                $countSlug=1;
            }else {
                $countSlug=0;
            }
            return response()->json(['countSlug'=>$countSlug,'currentSlug'=>$currentSlug]);

        }
    }
}
