<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePurchaseDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id');
            $table->integer('convertion')->default(1);
            $table->string('product_barcode');
            $table->foreignId('stock_id');
            $table->integer('qty')->default(0);
            $table->foreignId('uom_id')->nullable();
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('price_per_pcs', 10, 2)->default(0);
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
        Schema::dropIfExists('purchase_detail');
    }
}
