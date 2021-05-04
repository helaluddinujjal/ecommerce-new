<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductFilter extends Model
{
    protected $fillable=['value','title','status'];
    public static function searchForFilterValue($id, $data) {
        $filterData=ProductFilter::where('id',$id)->first();
        $filterValue=json_decode($filterData->value,true);
        foreach ($filterValue as $key => $val) {
            if (ucwords($val['name']) === ucwords($data)) {
                return 1;
            }
        }
        return null;
     }
}
