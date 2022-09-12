<?php

namespace Database\Seeders;

use App\CmsPage;
use Illuminate\Database\Seeder;

class CmsPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cmsPageRecord=[
            [
                'id'=>1,
                'title'=>'About Us',
                'description'=> 'Comming Soon',
                'url'=> 'about-us',
                'meta_title'=> 'About Us Ecommerce Pages',
                'meta_description'=> 'About Us Ecommerce Pages',
                'meta_keyward'=> 'about,about us,about us ecommerce',
                'status'=> 1,
                'is_nav'=> 1,
            ],
            [
                'id'=>2,
                'title'=>'Privacy Policy',
                'description'=> 'Comming Soon',
                'url'=> 'privacy-policy',
                'meta_title'=> 'Privacy Policy Ecommerce Pages',
                'meta_description'=> 'Privacy Policy Ecommerce Pages',
                'meta_keyward'=> 'policy,privacy policy,privacy policy ecommerce',
                'status'=> 1,
                'is_nav'=> 1,
            ],

        ];
        CmsPage::insert($cmsPageRecord);
    }
}
