<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectSalesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direct_sales_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('direct_sales_id');
            $table->string('product_barcode');
            $table->float('price');
            $table->integer('qty');
            $table->float('discount');
            $table->decimal('subtotal', 10, 2);
            $table->float('program');
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
        Schema::dropIfExists('direct_sales_details');
    }
}
