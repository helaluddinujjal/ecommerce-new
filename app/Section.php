<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public static function sections(){
        $sections=Section::with('categories')->where('status',1)->get();
        $sections=json_decode(json_encode($sections),true);
        return $sections;
    }
    public function categories(){
        return $this->hasMany('App\Category','section_id')->where(['parent_id'=>0,'status'=>1])->with('childcategories');
    }
    public static function sectionDetails($sec){
        $sectionDetails=Section::select('id','name','url')->where('url',$sec)->first();
        //breadcrumbs
            if ($sectionDetails->id>0) {
            $breadcumbs='<li aria-current="page" class="breadcrumb-item"><a href="'.url($section->url).'"><b>'.$section->name.'</b></a></li>';
            }
        return array('secId'=>$sectionDetails,'sectionDetails'=>$sectionDetails,'breadcumbs'=>$breadcumbs);
    }
}
