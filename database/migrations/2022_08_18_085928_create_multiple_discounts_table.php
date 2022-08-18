<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMultipleDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multiple_discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('min_qty');
            $table->float('discount');
            $table->foreignId('created_by_id');
            $table->foreignId('edit_by_id');
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('multiple_discounts');
    }
}
