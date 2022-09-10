<?php
namespace Database\Seeders;
use App\Section;
use Illuminate\Database\Seeder;

class SectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $sectionRecord=[
            [
                'id'=>1,
                'name'=>'Men',
                'url'=>'men',
                'status'=>1,
            ],
            [
                'id'=>2,
                'name'=>'Women',
                'url'=>'women',
                'status'=>1,
            ],
            [
                'id'=>3,
                'name'=>'Kides',
                'url'=>'kides',
                'status'=>1,
            ],
       ];
       Section::insert($sectionRecord);
    }
}
