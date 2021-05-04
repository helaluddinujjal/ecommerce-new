<?php
namespace Database\Seeders;
use App\ProductFilter;
use Illuminate\Database\Seeder;

class ProductFilterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fabricArray=[           
            ['name'=>'Cotton','status'=>1],
            ['name'=>'Polyester','status'=>1],
            ['name'=>'Wool','status'=>1],            
        ];
        $sleeveArray=[           
            ['name'=>'Full Sleeve','status'=>1],
            ['name'=>'Half Sleeve','status'=>1],
            ['name'=>'Short Sleeve','status'=>1],            
            ['name'=>'Sleeveless','status'=>1],            
        ];
        $patternArray=[           
            ['name'=>'Checked','status'=>1],
            ['name'=>'Plain','status'=>1],
            ['name'=>'Printed','status'=>1],            
            ['name'=>'Solid','status'=>1],            
            ['name'=>'Self','status'=>1],            
        ];
        $fitArray=[           
            ['name'=>'Slim','status'=>1],
            ['name'=>'Regular','status'=>1],           
        ];
        $occationArray=[           
            ['name'=>'Formal','status'=>1],
            ['name'=>'Casual','status'=>1],          
        ];
        $fabric=json_encode($fabricArray);
        $sleeve=json_encode($sleeveArray);
        $pattern=json_encode($patternArray);
        $fit=json_encode($fitArray);
        $occation=json_encode($occationArray);
        
        $productFilterRecord=[
            [
                'id'=>1,
                'name'=>"fabric",
                'value'=>$fabric,
                'title'=>"Filter by Fabric",
                'status'=>1,
            ],
            [
                'id'=>2,
                'name'=>"sleeve",
                'value'=>$sleeve,
                'title'=>"Filter by Sleeve",
                'status'=>1,
            ],
            [
                'id'=>3,
                'name'=>"pattern",
                'value'=> $pattern,
                'title'=>"Filter by Pattern",
                'status'=>1,
            ],
            [
                'id'=>4,
                'name'=>"fit",
                'value'=>$fit,
                'title'=>"Filter by Fit",
                'status'=>1,
            ],
            [
                'id'=>5,
                'name'=>"occation",
                'value'=>$occation,
                'title'=>"Filter by Occation",
                'status'=>1,
            ],
       ];
       ProductFilter::insert($productFilterRecord);
    }
}
