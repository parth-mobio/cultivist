<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebhookResponseLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webhook_response_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->nullable();
            $table->string('webhook_event')->nullable();
            $table->longtext('response')->nullable();
            $table->integer('created_by');
            $table->integer('last_modified_by');
            $table->dateTime('created_date');
            $table->dateTime('last_modified_date');
            $table->index(['customer_id']);
            $table->index(['created_by','last_modified_by']);
            $table->longText('sf_response')->nullable();
            $table->longText('error_response')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('webhook_response_log');
    }
}
