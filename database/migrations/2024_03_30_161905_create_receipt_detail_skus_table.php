<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptDetailSkusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_detail_skus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('receipt_id');
            $table->string('product_barcode')->nullable();
            $table->string('sku')->nullable();
            $table->integer('qty')->default(0);
            $table->boolean('valid')->default(true);
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
        Schema::dropIfExists('receipt_detail_skus');
    }
}
