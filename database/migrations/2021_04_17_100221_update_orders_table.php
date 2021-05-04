<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders',function($table){
            $table->string('courier_name')->after('total')->nullable();
            $table->string('tracking_number')->after('courier_name')->nullable();
            $table->dateTime('delivery_pickup_dateTime')->after('tracking_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders',function($table){
            $table->dropColumn('courier_name');
            $table->dropColumn('tracking_number');
            $table->dropColumn('delivery_pickup_dateTime');
        });
    }
}
