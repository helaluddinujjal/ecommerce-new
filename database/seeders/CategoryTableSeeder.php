<?php
namespace Database\Seeders;
use App\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryRecord=[
            [
                'id'=>1,
                'parent_id'=>0,
                'section_id'=>1,
                'category_name'=>'T-Shirts',
                'category_image'=>'',
                'discount'=>0,
                'description'=> '',
                'url'=> 't-shirts',
                'meta_title'=> '',
                'meta_description'=> '',
                'meta_keyward'=> '',
                'status'=> 1,
            ],
            [
                'id'=>2,
                'parent_id'=>1,
                'section_id'=>1,
                'category_name'=>'Casual T-Shirts',
                'category_image'=>'',
                'discount'=>0,
                'description'=> '',
                'url'=> 'casual-t-shirts',
                'meta_title'=> '',
                'meta_description'=> '',
                'meta_keyward'=> '',
                'status'=> 1,
            ],
        ];

        Category::insert($categoryRecord);
    }
}
