<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->unique();
            $table->string('name');
            $table->integer('convertion')->default(1);
            $table->float('price')->default(0);
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('category_id')->nullable();
            $table->foreignId('uom_id')->nullable();
            $table->foreignId('stock_id')->nullable();
            $table->foreignId('created_by_id')->nullable();
            $table->foreignId('edit_by_id')->nullable();
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
        Schema::dropIfExists('products');
    }
}
