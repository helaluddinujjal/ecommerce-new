<?php
namespace Database\Seeders;
use App\Brand;
use Illuminate\Database\Seeder;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brandRecord=[
            [
                'id'=>1,
                'name'=>'Cats Eye',
                'status'=>1,
                'url'=>'cats-eye',
            ],
            [
                'id'=>2,
                'name'=>'Kay Kraft',
                'status'=>1,
                'url'=>'kay-kraft',
            ],
            [
                'id'=>3,
                'name'=>'Infinity',
                'status'=>1,
                'url'=>'infinity',
            ],
            [
                'id'=>4,
                'name'=>'Freeland',
                'status'=>1,
                'url'=>'freeland',
            ],
            [
                'id'=>5,
                'name'=>'Le Reve',
                'status'=>1,
                'url'=>'le-reve',
            ],
       ];
       Brand::insert($brandRecord);
    }
}
