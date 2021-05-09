<?php

namespace Database\Seeders;
use App\ProductAttribute;
use Illuminate\Database\Seeder;

class ProductAttributeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productAttributeRecord=[
            [
                'id'=>1,
                'product_id'=>1,
                'size'=>'Small',
                'price'=>1000.00,
                'stock'=>15,
                'weight'=>150,
                'sku'=>'BT001-S',
                'status'=>1,
            ],
            [
                'id'=>2,
                'product_id'=>1,
                'size'=>'Medium',
                'price'=>1200.00,
                'stock'=>12,
                'weight'=>200,
                'sku'=>'BT001-M',
                'status'=>1,
            ],
            [
                'id'=>3,
                'product_id'=>1,
                'size'=>'Large',
                'price'=>1400.00,
                'stock'=>14,
                'weight'=>300,
                'sku'=>'BT001-L',
                'status'=>1,
            ],
       ];
       ProductAttribute::insert($productAttributeRecord);
    }
}
