<?php
namespace Database\Seeders;
use App\Banner;
use Illuminate\Database\Seeder;

class BannerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bannerRecord=[
            [
                'id'=>1,
                'image'=>'banner1.jpg',
                'title'=>'Now 50% Off- Hurry up!!',
                'status'=>1,
                'link'=>'',
                'alt'=>'',
            ],
            [
                'id'=>2,
                'image'=>'banner2.jpg',
                'title'=>'Now 50% Off- Hurry up!!',
                'status'=>1,
                'link'=>'',
                'alt'=>'',
            ],
            [
                'id'=>3,
                'image'=>'banner1.jpg',
                'title'=>'Now 50% Off- Hurry up!!',
                'status'=>1,
                'link'=>'',
                'alt'=>'',
            ],
       ];
       Banner::insert($bannerRecord);
    }
}
