<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionOnlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_onlines', function (Blueprint $table) {
            $table->id();
            $table->string('create_time_online');
            $table->string('update_time_online');
            $table->string('message_to_seller')->nullable();
            $table->string('order_no');
            $table->string('order_id')->nullable();
            $table->string('order_status');
            $table->string('tracking_number')->unique();
            $table->string('delivery_by');
            $table->string('pickup_by');
            $table->string('product_picture')->nullable();
            $table->string('package_picture')->nullable();
            $table->double('total_amount');
            $table->integer('total_qty');
            $table->integer('status');
            $table->foreignId('online_shop_id');
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
        Schema::dropIfExists('transaction_onlines');
    }
}
