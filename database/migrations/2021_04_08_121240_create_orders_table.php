<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('billing_first_name')->nullable();
            $table->string('billing_last_name')->nullable();
            $table->string('billing_address_1')->nullable();
            $table->string('billing_address_2')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_country')->nullable();
            $table->string('billing_pincode')->nullable();
            $table->string('billing_mobile')->nullable();
            $table->string('billing_email')->nullable();
            $table->string('delivery_first_name')->nullable();
            $table->string('delivery_last_name')->nullable();
            $table->string('delivery_address_1')->nullable();
            $table->string('delivery_address_2')->nullable();
            $table->string('delivery_city')->nullable();
            $table->string('delivery_state')->nullable();
            $table->string('delivery_country')->nullable();
            $table->string('delivery_pincode')->nullable();
            $table->string('delivery_mobile')->nullable();
            $table->string('delivery_method')->nullable();
            $table->float('delivery_charges')->nullable();
            $table->string('coupon_code')->nullable();
            $table->float('coupon_amount')->nullable();
            $table->string('order_status')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_gateway')->nullable();
            $table->float('currency');
            $table->float('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
