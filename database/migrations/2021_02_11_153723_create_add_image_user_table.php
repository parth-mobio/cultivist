<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddImageUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table) {
            $table->string('contact')->nullable();
            $table->text('image')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('zipcode')->nullable();
            $table->enum('status', array('0', '1'))->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('paid');
            $table->dropColumn('contact');
            $table->dropColumn('image');
            $table->dropColumn('country');
            $table->dropColumn('city');
            $table->dropColumn('address');
            $table->dropColumn('zipcode');
            $table->dropColumn('status');
        });
    }
}
