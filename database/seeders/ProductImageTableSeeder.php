<?php
namespace Database\Seeders;
use App\ProductImage;
use Illuminate\Database\Seeder;

class ProductImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $proImageRecord=[
            [
                'id'=>1,
                'product_id'=>1,
                'image'=>'demo.png',
                'status'=>1,
            ],
       ];
       ProductImage::insert($proImageRecord);
    }
}
