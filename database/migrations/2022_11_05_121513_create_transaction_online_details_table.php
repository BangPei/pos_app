<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionOnlineDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_online_details', function (Blueprint $table) {
            $table->id();
            $table->string("image_url");
            $table->string("item_name");
            $table->string("item_sku");
            $table->string("variation");
            $table->string("order_type");
            $table->integer("order_item_id");
            $table->integer("order_id");
            $table->integer("qty");
            $table->float("original_price");
            $table->float("discounted_price");
            $table->unsignedBigInteger('transaction_online_id');
            $table->foreign('transaction_online_id')->references('id')->on('transaction_onlines');
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
        Schema::dropIfExists('transaction_online_details');
    }
}
