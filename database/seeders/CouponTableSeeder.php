<?php

namespace Database\Seeders;

use App\Coupon;
use Illuminate\Database\Seeder;

class CouponTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $couponRecord=[
            [
                'id'=>1,
                'coupon_option'=>"Manual",
                'coupon_code'=>"test_1",
                'categories'=>'1,2',
                'users'=>'user@user.com,demo@yopmail.com',
                'coupon_type'=>"Single",
                'amount_type'=> 'Percentage',
                'amount'=> '10',
                'start_date'=> '2021-12-1',
                'expiry_date'=> '2021-12-31',
                'status'=> 1,
            ],
        ];

        Coupon::insert($couponRecord);
    }
}
