<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatepickerSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datepicker_settings', function (Blueprint $table) {
            $table->id();
            $table->string('timezone')->nullable();
            $table->string('holiday')->nullable();
            $table->string('weekend')->nullable();
            $table->string('cutOffDay')->nullable();
            $table->tinyInteger('timeFieldShow')->default(0);
            $table->string('shopOpenTime')->nullable();
            $table->string('shopCloseTime')->nullable();
            $table->string('type')->default('Delivery Pickup');
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
        Schema::dropIfExists('datepicker_settings');
    }
}
