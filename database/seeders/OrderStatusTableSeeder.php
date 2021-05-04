<?php

namespace Database\Seeders;

use App\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orderStatusRecord=[
            [
                'id'=>1,
                'name'=>"New",
                'status'=>1,
            ],
            [
                'id'=>2,
                'name'=>"Pending",
                'status'=>1,
            ],
            [
                'id'=>3,
                'name'=>"Hold",
                'status'=>1,
            ],
            [
                'id'=>4,
                'name'=>"Cancelled",
                'status'=>1,
            ],
            [
                'id'=>5,
                'name'=>"In Proccessing",
                'status'=>1,
            ],
            [
                'id'=>6,
                'name'=>"Paid",
                'status'=>1,
            ],
            [
                'id'=>7,
                'name'=>"Shipped",
                'status'=>0,
            ],
            [
                'id'=>8,
                'name'=>"Delivered",
                'status'=>1,
            ],
        ];
        OrderStatus::insert($orderStatusRecord);
    }
}
