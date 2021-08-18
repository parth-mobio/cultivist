<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email',191);
            $table->string('firstname',191);
            $table->string('lastname',191);
            $table->string('phone_number',191);
            $table->string('product_id',191);
            $table->string('product_name',191);
            $table->string('product_handle',191);
            $table->string('product_price',191);
            $table->enum('status', array('0', '1'))->default(0);
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
        Schema::dropIfExists('customer');
    }
}
