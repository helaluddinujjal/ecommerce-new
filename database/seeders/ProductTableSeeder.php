<?php
namespace Database\Seeders;
use App\Product;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productRecord=[
            [
                'id'=>1,
                'category_id'=>2,
                'section_id'=>1,
                'product_name'=>'Blue Casual T-Shirts',
                'product_code'=>'BT001',
                'product_color'=>"Blue",
                'product_price'=> 1500,
                'product_discount'=> 10,
                'product_weight'=> 200,
                'product_video'=> '',
                'main_image'=> '',
                'description'=> '',
                'wash_care'=> '',
                'fabric'=> '',
                'pattern'=> '',
                'sleeve'=> '',
                'fit'=> '',
                'occation'=> '',
                'meta_title'=> '',
                'meta_description'=> '',
                'meta_keyword'=> '',
                'is_featured'=> 'Yes',
                'status'=> 1,
            ],
            [
                'id'=>2,
                'category_id'=>2,
                'section_id'=>1,
                'product_name'=>'Red Casual T-Shirts',
                'product_code'=>'BT001',
                'product_color'=>"Red",
                'product_price'=> 1500,
                'product_discount'=> 10,
                'product_weight'=> 200,
                'product_video'=> '',
                'main_image'=> '',
                'description'=> '',
                'wash_care'=> '',
                'fabric'=> '',
                'pattern'=> '',
                'sleeve'=> '',
                'fit'=> '',
                'occation'=> '',
                'meta_title'=> '',
                'meta_description'=> '',
                'meta_keyword'=> '',
                'is_featured'=> 'Yes',
                'status'=> 1,
            ],
            
        ];

        Product::insert($productRecord);
    }
}
