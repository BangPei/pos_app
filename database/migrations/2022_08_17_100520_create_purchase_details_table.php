<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            // $table->unsignedInteger('purchase_id');
            $table->foreignId('purchase_id')->references('id')->on('purchases');
            // $table->unsignedInteger('product_id');
            $table->foreignId('product_id');
            $table->float('invoice_price')->default(0);
            $table->float('pcs_price')->default(0);
            $table->integer('qty')->default(0);
            $table->float('tax_paid')->default(0);
            $table->float('total')->default(0);
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
        Schema::dropIfExists('purchase_details');
    }
}
