<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderStatusToTransactionOnlineDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_online_details', function (Blueprint $table) {
            $table->string('order_status');
            $table->string('tracking_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction_online_details', function (Blueprint $table) {
            //
        });
    }
}
