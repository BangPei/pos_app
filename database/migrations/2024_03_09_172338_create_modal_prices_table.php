<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModalPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modal_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_detail_id');
            $table->decimal('current_price', 10, 2)->default(0);
            $table->decimal('dpp', 10, 2)->default(0);
            $table->decimal('new_price', 10, 2)->default(0);
            $table->decimal('tax_paid', 10, 2)->default(0);
            $table->timestamp('periode');
            $table->string('product_barcode');
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
        Schema::dropIfExists('modal_prices');
    }
}
