<?php

namespace Database\Seeders;

use App\DeliveryAddress;
use Illuminate\Database\Seeder;

class DeliveryAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $deliverAddressRecord=[
            [
                'id'=>1,
                'user_id'=>'1',
                'first_name'=>'	Kelly C',
                'last_name'=>'	Gallagher',
                'address_1'=>'4169  Dane Street',
                'address_2'=>'Spokane',
                'city'=>'Aberdeen',
                'state'=>'Washington',
                'country'=>'United States',
                'pincode'=>'99201',
                'mobile'=>'509-288-8535',
                'status'=>1,
            ],
            [
                'id'=>2,
                'user_id'=>'2',
                'first_name'=>'John J',
                'last_name'=>'Twedt',
                'address_1'=>'3704  Hickman Street',
                'address_2'=>'Oak Brook',
                'city'=>'Abingdon',
                'state'=>'Illinois',
                'country'=>'United States',
                'pincode'=>'60523',
                'mobile'=>'630-520-7099',
                'status'=>1,
            ],
       ];
       DeliveryAddress::insert($deliverAddressRecord);
    }
}
