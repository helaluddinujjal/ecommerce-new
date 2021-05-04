<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('address_1')->after('last_name')->nullable();
            $table->string('address_2')->after('address_1')->nullable();
            $table->string('city')->after('address_2')->nullable();
            $table->string('state')->after('city')->nullable();
            $table->string('country')->after('state')->nullable();
            $table->string('pincode')->after('country')->nullable();
            $table->string('mobile')->after('pincode')->nullable();
            $table->string('status')->after('password')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('address_1');
            $table->dropColumn('address_2');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('country');
            $table->dropColumn('pincode');
            $table->dropColumn('mobile');
            $table->dropColumn('status');
        });
    }
}
