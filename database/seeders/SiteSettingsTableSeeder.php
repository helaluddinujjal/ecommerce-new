<?php

namespace Database\Seeders;

use App\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $siteSettingRecord=[
            [
                'id'=>1,
                'site_currency'=>'&#36;',
                'delivery_charge_type'=>"Country",
                'weight_measurement'=>"g",
            ],
       ];
       SiteSetting::insert($siteSettingRecord);
    }
}
