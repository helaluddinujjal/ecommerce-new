<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Product;
use App\Section;
use App\Category;
use App\ProductImage;
use App\ProductFilter;
use App\ProductAttribute;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    /*
    ******Product
     */
    public function products(){
        Session::forget('page');
        Session::put('page','admin-product');
        $products=Product::with(['category'=>function($query){
            $query->select('id','category_name');
        },'section'=>function($query){
            $query->select('id','name');
        }])->get();
        // $products=json_decode(json_encode($products),true);
        // echo "<pre>";print_r($products);die;
        return view('admin.product.products')->with(compact('products'));
    }
    //update status
    public function updateStatusProduct(Request $request){
        if ($request->ajax()) {
            $data=$request->all();
            if ($data['status']=='Active') {
                $status=0;
            }else{
                $status=1;
            }
            Product::where('id',$data['id'])->update(['status'=>$status]);
            return response()->json(['get_id'=>$data['id'],'status'=>$status]);

        }
    }
    //delete method
    public function deleteProductImage($id){
        $image=Product::select('main_image')->where('id',$id)->first();
        $smallpath=public_path("images/product/small/");
        $mediumpath=public_path("images/product/medium/");
        $largepath=public_path("images/product/large/");
        if(file_exists($smallpath.$image->main_image)){
            unlink($smallpath.$image->main_image);
        }
        if(file_exists($mediumpath.$image->main_image)){
            unlink($mediumpath.$image->main_image);
        }
        if(file_exists($largepath.$image->main_image)){
            unlink($largepath.$image->main_image);
        }
        Product::where('id',$id)->update(['main_image'=>'']);
        Session::flash('success_msg','Product image has been deleted successfully.');
        return redirect()->back();
    }
    public function deleteProductVideo($id){
        $video=Product::select('product_video')->where('id',$id)->first();
        $path=public_path("videos/product/");
        if(file_exists($path.$video->product_video)){
            unlink($path.$video->product_video);
        }

        Product::where('id',$id)->update(['product_video'=>'']);
        Session::flash('success_msg','Product video has been deleted successfully.');
        return redirect()->back();
    }
    public function deleteProduct($id){
        Product::where('id',$id)->delete();
        Session::flash('success_msg','Product has been deleted successfully.');
        return redirect('/admin/products');
    }
    public function addEditProduct(Request $request,$id=null){
        if ($id=='') {
            $title="Add Products";
            $product=new Product;
            $productData='';
            $massege="Product has been created";

        } else {
            $title="Edit Products";
            $productData=Product::find($id);
            $product=Product::find($id);
            $massege="Product has been Updated";
        }
        if ($request->isMethod('post')) {
            $data= $request->all();
            //get section id
            $categoryDetails=Category::find($data['category_id']);
            //slug

            if (!empty($data['url'])) {
                $data['url']=Str::slug($data['url']);
            }else {
                if (isset($data['name'])&&!empty($data['name'])) {
                    $name=$data['name'];
                }else{
                    $name='';
                }
                $data['url']=Str::slug($name);
            }
            $rule=[
                'product_name'=>'required|regex:/^[A-Za-z- ]+$/',
                'product_code'=>'required|regex:/^[a-zA-Z0-9\s-]+$/|unique:products,product_code,'.(!empty($productData->id)?$productData->id:''),
                'product_price'=>'required|numeric|min:.1',
                'product_discount'=>'nullable|numeric|min:.1',
                'product_weight'=>'required|numeric|min:.1',
                'product_color'=>'required|regex:/^[A-Za-z- ]+$/',
                'category_id'=>'required|numeric|min:1',
                'product_image'=>'image|mimes:jpeg,jpg,png',
                'url'=>'required|regex:/^[A-Za-z-]+$/|unique:products,url,'.(isset($productData->id)&&!empty($productData)?$productData->id:''),
                // 'url'=>['required','regex:/^[A-Za-z-]+$/',Rule::unique('products')->where(function($query) use ($data,$productData,$categoryDetails){
                //     if (!empty($productData->id)) {
                //      return   $query->where(['url'=>$data['url'],'section_id'=>$categoryDetails['section_id'],'category_id'=>$data['category_id']])->where('id','!=',$productData->id);
                //     }else {
                //         //return $data;die;
                //       return  $query->where(['url'=>$data['url'],'section_id'=>$categoryDetails['section_id'],'category_id'=>$data['category_id']]);
                //     }
                // })
               // ],
            ];
            $customMsg=[
                'product_name.required'=>"Product Name must not be empty",
                'product_name.regex'=>"Product Name formate invalid.only latter and - will allow",
                'product_color.required'=>"Product Color must not be empty",
                'product_color.regex'=>"Product Color formate invalid.only latter and - will allow",
                'product_code.required'=>"Product Code must not be empty",
                'product_code.regex'=>"Product Code formate invalid.only latter and number will allow",
                'product_price.required'=>"Product Price must not be empty",
                'product_price.numeric'=>"Product Price formate invalid.only number will allow",
                'product_weight.required'=>"Product Weight must not be empty",
                'product_weight.numeric'=>"Product Weight formate invalid.only number will allow",
                'category_id.required'=>"Product Category must not be empty",
                'category_id.numeric'=>"Product Category ID formate invalid.only number will allow",
                'url.required'=>"Url must not be empty",
                'url.regex'=>"Url formate invalid.only latter and - will allow",
                'url.unique'=>"Url already exists.Please change the Url",
                'product_image.mimes'=>"Image must be jpeg/jpg/png format",
            ];
            $this->validate($request,$rule,$customMsg);
            // check image field has file
            if ($request->hasFile('main_image')) {
                //get temporary name
                $tempName=$request->file('main_image');
                if ($tempName->isValid()) {
                    //get image name and extension
                    $orginalName=$tempName->getClientOriginalName();
                    $orginalName = pathinfo($orginalName,PATHINFO_FILENAME);
                    $orginalExt=$tempName->getClientOriginalExtension();
                    $imgName="products_".$orginalName.'_'.rand(111,99999).'.'.$orginalExt;
                    //path selection
                    $largePath=public_path('images/product/large/'.$imgName);
                    $mediumPath=public_path('images/product/medium/'.$imgName);
                    $smallPath=public_path('images/product/small/'.$imgName);
                    //save image by intervension
                    Image::make($tempName)->save($largePath);
                    Image::make($tempName)->resize(520,600)->save($mediumPath);
                    Image::make($tempName)->resize(260,300)->save($smallPath);

                }
            }elseif (!empty($productData->main_image)) {
                $imgName=$productData->main_image;
            }else {
                // if image field empty
                $imgName='';
            }

            // check video field has file
            if ($request->hasFile('product_video')) {
                //get temporary name
                $tempName=$request->file('product_video');
                if ($tempName->isValid()) {
                    //get image name and extension
                    $orginalName=$tempName->getClientOriginalName();
                    $orginalName = pathinfo($orginalName,PATHINFO_FILENAME);
                    $orginalExt=$tempName->getClientOriginalExtension();
                    $product_video='product_'.$orginalName.'_'.rand(111,9999).'.'.$orginalExt;
                     //path selection
                    $path=public_path('videos/product/');
                     //save video
                    $tempName->move($path,$product_video);
                }
            }elseif (!empty($productData->product_video)) {
                $product_video=$productData->product_video;
            }else {
                $product_video='';
            }
            if (empty($data['product_discount'])) {
                $data['product_discount']=0.00;
            }
            if (empty($data['description'])) {
                $data['description']='';
            }
            if (empty($data['wash_care'])) {
                $data['wash_care']='';
            }
            if (empty($data['fabric'])) {
                $data['fabric']='';
            }
            if (empty($data['pattern'])) {
                $data['pattern']='';
            }
            if (empty($data['sleeve'])) {
                $data['sleeve']='';
            }
            if (empty($data['fit'])) {
                $data['fit']='';
            }
            if (empty($data['occation'])) {
                $data['occation']='';
            }
            if (empty($data['meta_title'])) {
                $data['meta_title']='';
            }
            if (empty($data['meta_description'])) {
                $data['meta_description']='';
            }
            if (empty($data['meta_keyword'])) {
                $data['meta_keyword']='';
            }
            if (!empty($data['is_featured'])) {
                $data['is_featured']='Yes';
            }else{
                $data['is_featured']='No';
            }

            $product->product_name=$data['product_name'];
            $product->product_code=str_replace(' ','-',$data['product_code']);
            $product->section_id=$categoryDetails['section_id'];
            $product->brand_id=$data['brand'];
            $product->category_id=$data['category_id'];
            $product->product_color=$data['product_color'];
            $product->product_price=$data['product_price'];
            $product->product_weight=$data['product_weight'];
            $product->product_discount=$data['product_discount'];
            $product->description=$data['description'];
            $product->wash_care=$data['wash_care'];
            $product->fabric=$data['fabric'];
            $product->pattern=$data['pattern'];
            $product->sleeve=$data['sleeve'];
            $product->fit=$data['fit'];
            $product->occation=$data['occation'];
            $product->group_code=$data['group_code'];
            $product->product_video=$product_video;
            $product->main_image=$imgName;
            $product->status=1;
            $product->url=$data['url'];
            $product->meta_title=$data['meta_title'];
            $product->meta_description=$data['meta_description'];
            $product->meta_keyword=$data['meta_keyword'];
            $product->is_featured=$data['is_featured'];
            $product->save();
            Session::flash('success_msg',$massege);
            return redirect('admin/products');
        }
        $productFilters=ProductFilter::get();
        $fabricArray=json_decode($productFilters[0]->value);
        $sleeveArray=json_decode($productFilters[1]->value);
        $patternArray=json_decode($productFilters[2]->value);
        $fitArray=json_decode($productFilters[3]->value);
        $occationArray=json_decode($productFilters[4]->value);
        // $fabricArray=['Cotton','Polyester','Wool'];
        // $sleeveArray=['Full Sleeve','Half Sleeve','Short Sleeve','Sleeveless'];
        // $patternArray=['Checked','Plain','Printed','Solid','Self'];
        // $fitArray=['Slim','Regular'];
        // $occationArray=['Formal','Casual'];
        //category functionality
        $categories=Section::with('categories')->get();
        // $categories=json_decode(json_encode($categories),true);
        // echo "<pre>";print_r($categories);die;
        $brands=Brand::where('status',1)->get();
        return view('admin.product.add-edit')->with(compact('title','categories','productData','fabricArray','sleeveArray','patternArray','fitArray','occationArray','brands','productFilters'));

    }

    /*
    ******Product Attribute
     */
    public function addAttribute(Request $request,$id){
        $productData=Product::select(['id','product_name','product_code','product_color','product_price','main_image'])->with('attributes')->find($id);
        // $productData=json_decode(json_encode($productData),true);
        // echo "<pre>"; print_r($productData);die;
        if ($request->isMethod('post')) {
            $data=$request->all();
            foreach ($data['sku'] as $key => $value) {
                if (!empty($value)) {
                    //check SKU exist
                    $attrCountSKU=ProductAttribute::where('sku',$value)->count();
                    if ($attrCountSKU>0) {
                        Session::flash('error_msg','SKU already exists.Please add another SKU!');
                        return redirect()->back();
                    }
                    //check product size exist
                    $attrCountSize=ProductAttribute::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
                    if ($attrCountSize>0) {
                        Session::flash('error_msg','Size already exists.Please add another Size!');
                        return redirect()->back();
                    }
                    $attribute=new ProductAttribute;
                    $attribute->product_id=$id;
                    $attribute->size=$data['size'][$key];
                    $attribute->sku=$value;
                    $attribute->price=$data['price'][$key];
                    $attribute->stock=$data['stock'][$key];
                    $attribute->weight=$data['weight'][$key];
                    $attribute->save();
                }
            }
            Session::flash('success_msg','Product Attribute has been Saved');
            return redirect()->back();
        }
        return view('admin.product.add-attribute')->with(compact('productData'));
    }
    public function editAttribute(Request $request,$id){
        if ($request->isMethod('post')) {
             $data=$request->all();
             foreach ($data['attrId'] as $key => $value) {
                 if (!empty($value)) {
                     ProductAttribute::where('id',$value)->update(['price'=>$data['price'][$key],'stock'=>$data['stock'][$key],'weight'=>$data['weight'][$key]]);
                 }
             }
             Session::flash('success_msg','Product Attribute has been Updated');
             return redirect()->back();
        }
    }

    public function updateStatusAttribute(Request $request){
        if ($request->ajax()) {
            $data=$request->all();
            if ($data['status']=='Active') {
                $status=0;
            }else{
                $status=1;
            }
            ProductAttribute::where('id',$data['id'])->update(['status'=>$status]);
            return response()->json(['get_id'=>$data['id'],'status'=>$status]);

        }
    }
    public function deleteAttribute($id){
        ProductAttribute::where('id',$id)->delete();
        Session::flash('success_msg','Attribute has been deleted successfully.');
        return redirect()->back();
    }


    /*
    ******Product Image
     */
    public function addImage(Request $request,$id){
        $productData=Product::select(['id','product_name','product_code','product_color','product_price','main_image'])->with('images')->find($id);
        // $productData=json_decode(json_encode($productData),true);
        // echo "<pre>"; print_r($productData);die;
        if ($request->isMethod('post')) {
            if ($request->hasFile('images')) {
                $images=$request->file('images');
                foreach ($images as $key => $image) {
                  if ($image->isValid()) {
                    $orginalName=$image->getClientOriginalName();
                    $orginalName = pathinfo($orginalName,PATHINFO_FILENAME);
                    $orginalExt=$image->getClientOriginalExtension();
                    $imgName="products_".$orginalName.'_'.rand(111,99999).'.'.$orginalExt;
                    //path selection
                    $largePath=public_path('images/product/large/'.$imgName);
                    $mediumPath=public_path('images/product/medium/'.$imgName);
                    $smallPath=public_path('images/product/small/'.$imgName);
                    //save image by intervension
                    Image::make($image)->save($largePath);
                    Image::make($image)->resize(520,600)->save($mediumPath);
                    Image::make($image)->resize(260,300)->save($smallPath);
                    $proImage=new ProductImage;
                    $proImage->product_id=$id;
                    $proImage->image=$imgName;
                    $proImage->save();
                  }

                }
                Session::flash('success_msg','Product Image has been Saved');
                return redirect()->back();
            }
        }
        return view('admin.product.add-image')->with(compact('productData'));
    }
    public function updateStatusImage(Request $request){
        if ($request->ajax()) {
            $data=$request->all();
            if ($data['status']=='Active') {
                $status=0;
            }else{
                $status=1;
            }
            ProductImage::where('id',$data['id'])->update(['status'=>$status]);
            return response()->json(['get_id'=>$data['id'],'status'=>$status]);

        }
    }
    public function deleteImage($id){

        $images=ProductImage::where('id',$id)->first();
        $imgName=$images->image;
        $largePath=public_path('images/product/large/'.$imgName);
        $mediumPath=public_path('images/product/medium/'.$imgName);
        $smallPath=public_path('images/product/small/'.$imgName);
        if (file_exists($largePath)) {
            unlink($largePath);
        }
        if (file_exists($mediumPath)) {
            unlink($mediumPath);
        }
        if (file_exists($smallPath)) {
            unlink($smallPath);
        }
        $images->delete();
        Session::flash('success_msg','Image has been deleted successfully.');
        return redirect()->back();
    }

     //check product url
     public function checkProductUrl(Request $request){
        if ($request->ajax()) {
            $data=$request->all();
           //return $data=$request->all();die;
           // $categoryDetails=Category::find($data['category_id']);
            $url=Str::slug($data['getSlug']);
            if (!empty($data['getId'])) {
               // $currentSlug=Product::where(['url'=>$url,'section_id'=>$categoryDetails['section_id'],'category_id'=>$data['category_id'],'id'=>$data['getId']])->count();
                $currentSlug=Product::where(['url'=>$url,'id'=>$data['getId']])->count();
            }else{
                $currentSlug=0;
            }
           // $countSlug=Product::where(['url'=>$url,'section_id'=>$categoryDetails['section_id'],'category_id'=>$data['category_id']])->count();
            $countSlug=Product::where('url',$url)->count();
            if ($countSlug>0) {
                $countSlug=1;
            }else {
                $countSlug=0;
            }
            return response()->json(['countSlug'=>$countSlug,'currentSlug'=>$currentSlug]);

        }
    }
     //check product Code
     public function checkProductCode(Request $request){
        if ($request->ajax()) {
            $data=$request->all();
            $getCode=str_replace(' ','-',$data['getCode']);
            if (!empty($data['getId'])) {
                $currentSlug=Product::where(['product_code'=>$getCode,'id'=>$data['getId']])->count();
            }else{
                $currentSlug=0;
            }
            $countSlug=Product::where(['product_code'=>$getCode])->count();
            if ($countSlug>0) {
                $countSlug=1;
            }else {
                $countSlug=0;
            }
            return response()->json(['countSlug'=>$countSlug,'currentSlug'=>$currentSlug]);

        }
    }
     //check attribute Code
     public function checkAttributeCode(Request $request){
        if ($request->ajax()) {
            $data=$request->all();
            if ($data['getSize']==1) {
                $countData=ProductAttribute::where(['product_id'=>$data['getId'],'size'=>$data['getData']])->count();
            }else {
                $getData=str_replace(' ','-',$data['getData']);
                $countData=ProductAttribute::where(['product_id'=>$data['getId'],'sku'=>$data['getData']])->count();

            }
            if ($countData>0) {
                $countData=1;
            }else {
                $countData=0;
            }
            return response()->json(['countData'=>$countData]);

        }
    }
}
