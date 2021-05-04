<?php

namespace App\Http\Controllers\Admin;

use App\Section;
use App\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function categories(){
        Session::forget('page');
        Session::put('page','admin-category');
        $categories=Category::with('parentcategory','section')->get();
        // $categories=json_decode(json_encode($categories),true);
        // echo "<pre>";print_r($categories);die;
        return view('admin.category.categories')->with(compact('categories'));
    }
    public function updateCategoryStatus(Request $request){
        if ($request->ajax()) {
            $data=$request->all();
            if ($data['status']=='Active') {
                $status=0;
            }else{
                $status=1;
            }
            Category::where('id',$data['id'])->update(['status'=>$status]);
            return response()->json(['get_id'=>$data['id'],'status'=>$status]);

        }
    }
    public function categoryAddEdit(Request $request,$id=null){
        $sections=Section::get();
        if($id==""){
            $title="Add Category";
            $category=new Category;
            $categoryData=array();
            $getCategories=array();
            $massege="Category has been saved";
        }else {
            $title="Edit Category";
            $categoryData=Category::where('id',$id)->first();
            $getCategories=Category::with('childcategories')->where(['parent_id'=>0,'section_id'=>$categoryData->section_id,'status'=>1])->get();
            $massege="Category has been updated";
            $category= Category::find($id);
        }
        if ($request->isMethod('post')) {
            $data=$request->all();
            
            if (!empty($data['url'])) {
                $data['url']=Str::slug($data['url']);
            }else {
                $data['url']=Str::slug($data['name']);
            }
            $rule=[
                'category_name'=>'required|regex:/^[A-Za-z- ]+$/',
                'section_id'=>'required|numeric',
                'category_image'=>'image|mimes:jpeg,jpg,png',
                'url'=>['required','regex:/^[A-Za-z-]+$/',Rule::unique('categories')->where(function($query) use ($data,$categoryData){
                    if (!empty($categoryData->id)) {
                     return   $query->where(['url'=>$data['url'],'section_id'=>$data['section_id']])->where('id','!=',$categoryData->id);
                    }else {
                        //return $data;die;
                      return  $query->where(['url'=>$data['url'],'section_id'=>$data['section_id']]);
                    }
                })
                ],
            ];
            $customMsg=[
                'category_name.required'=>"Category Name must not be empty",
                'category_name.regex'=>"Category Name formate invalid.only latter and - will allow",
                'url.regex'=>"Url formate invalid.only latter and - will allow",
                'url.unique'=>"Url already exists.Please change the Url",
                'url.required'=>"Url must not be empty",
                'section_id.required'=>"Section must not be empty",
                'category_image.mimes'=>"Image must be jpeg/jpg/png format",
            ];
            $this->validate($request,$rule,$customMsg); 
            if ($request->hasFile('category_image')) {
                $temp_img=$request->file('category_image');
                if ($temp_img->isValid()) {
                    $extension=$temp_img->getClientOriginalExtension();
                    $imageName="category_".rand(111,9999999).'.'.$extension;
                    $imagePath=public_path('images/category/'.$imageName);
                    Image::make($temp_img)->save($imagePath);
                }

            }else{
                if (!empty($data['current_img'])) {
                    $imageName=$data['current_img'];
                }else {
                    $imageName='';
                }
            }
            if (empty($data['description'])) {
                $data['description']='';
            }
            if (empty($data['discount'])) {
                $data['discount']=0.00;
            }
            if (empty($data['meta_title'])) {
                $data['meta_title']='';
            }
            if (empty($data['meta_description'])) {
                $data['meta_description']='';
            }
            if (empty($data['meta_keyward'])) {
                $data['meta_keyward']='';
            }
            $category->category_name=$data['category_name'];
            $category->section_id=$data['section_id'];
            $category->parent_id=$data['parent_id'];
            $category->category_image=$imageName;
            $category->discount=$data['discount'];
            $category->description=$data['description'];
            $category->url=$data['url'];
            $category->meta_title=$data['meta_title'];
            $category->meta_description=$data['meta_description'];
            $category->meta_keyward=$data['meta_keyward'];
            $category->status=1;
            $category->save();
            Session::flash('success_msg',$massege);
            return redirect('admin/categories');
        }
        return view('admin.category.add-edit')->with(compact('title','sections','categoryData','getCategories'));
    }

    public function appendCategoryStatus(Request $request){
        if ($request->ajax()) {
            $data=$request->all();
            $categories=Category::with('childcategories')->where(['section_id'=>$data['section_id'],'parent_id'=>0,'status'=>1])->get();
            $getCategories=json_decode(json_encode($categories),true);
            return view('admin.category.append-category-lavel')->with(compact('getCategories'));
        }
    }
    //delete category
    public function deleteCategoryImage($id){
        $image=Category::select('category_image')->where('id',$id)->first();
        $path=public_path("images/category/");
        if(file_exists($path.$image->category_image)){
            unlink($path.$image->category_image);
        }
        Category::where('id',$id)->update(['category_image'=>'']);
        Session::flash('success_msg','Category image has been deleted successfully.');
        return redirect()->back();
    }
    public function deleteCategory($id){
        Category::where('id',$id)->delete();
        Session::flash('success_msg','Category has been deleted successfully.');
        return redirect('/admin/categories');
    }

    //check gategory url
    public function checkCategoryUrl(Request $request){
        if ($request->ajax()) {
            $data=$request->all();
            $url=Str::slug($data['getSlug']);
            if (!empty($data['getId'])) {
                $currentSlug=Category::where(['url'=>$url,'id'=>$data['getId']])->count();
            }else{
                $currentSlug=0;
            }
            $countSlug=Category::where(['url'=>$url,'section_id'=>$data['section_id']])->count();
            if ($countSlug>0) {
                $countSlug=1;
            }else {
                $countSlug=0;
            }
            return response()->json(['countSlug'=>$countSlug,'currentSlug'=>$currentSlug]);

        }
    }
}
