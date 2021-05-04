<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function childcategories(){
        return $this->hasMany('App\Category','parent_id')->where('status',1);
    }
    public function parentcategory(){
        return $this->belongsTo('App\Category','parent_id')->select(['id','category_name']);
    }
    public function section(){
        return $this->belongsTo('App\Section','section_id')->select(['id','name']);
    }
    public static function categoryDetails($sec,$url){
        //echo $url;die;
        $section=Section::where('url',$sec)->first(); 
        $categoryDetails=Category::select('id','parent_id','category_name','url','description')->with(['childCategories'=>function($query){
            $query->select('id','parent_id','category_name','url','description')->where('status',1);
        }])->where(['section_id'=>$section->id,'url'=>$url,'status'=>1])->first();
        //breadcrumbs

        if ($categoryDetails->parent_id==0) {
           $breadcumbs='<li aria-current="page" class="breadcrumb-item"><a href="'.url($section->url).'"><b>'.$section->name.'</b></a></li><li aria-current="page" class="breadcrumb-item active">'.$categoryDetails->category_name.'</li>';
        }else {
            $getParrentCat=Category::select('id','category_name','url')->where('id',$categoryDetails->parent_id)->first();
            $breadcumbs='<li aria-current="page" class="breadcrumb-item"><a href="'.url($section->url).'"><b>'.$section->name.'</b></a></li><li aria-current="page" class="breadcrumb-item"><a href="'.$getParrentCat->url.'">'.$getParrentCat->category_name.'</a></li> <li aria-current="page" class="breadcrumb-item active">'.$categoryDetails->category_name.'</li>';
            
        }
        $catIds=[];
        $catIds[]=$categoryDetails['id'];
        foreach ($categoryDetails->childCategories as $key => $childCat) {
            $catIds[]=$childCat->id;
        }

        return array('catIds'=>$catIds,'categoryDetails'=>$categoryDetails,'breadcumbs'=>$breadcumbs);
    }

}
