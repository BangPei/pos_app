<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_order_details', function (Blueprint $table) {
            $table->id();
            $table->integer("buyer_id");
            $table->string("cancel_return_initiator");
            $table->string("created_at_order");
            $table->string("updated_at_order");
            $table->string("currency");
            $table->integer("delivery_option_sof");
            $table->string("digital_delivery_info");
            $table->string("extra_attributes");
            $table->string("invoice_number");
            $table->boolean("is_digital")->default(false);
            $table->boolean("is_fbl")->default(false);
            $table->boolean("is_reroute")->default(false);
            $table->float("item_price");
            $table->string("product_name");
            $table->string("order_flag");
            $table->integer("order_id");
            $table->integer("order_item_id");
            $table->string("order_type");
            $table->string("package_id");
            $table->float("paid_price");
            $table->string("product_detail_url");
            $table->string("product_id");
            $table->string("product_main_image");
            $table->string("promised_shipping_time");
            $table->string("purchase_order_id");
            $table->string("purchase_order_number");
            $table->string("reason");
            $table->string("reason_detail");
            $table->string("return_status");
            $table->string("shipment_provider");
            $table->float("shipping_amount");
            $table->float("shipping_fee_discount_platform");
            $table->float("shipping_fee_discount_seller");
            $table->float("shipping_fee_original");
            $table->string("shipping_provider_type");
            $table->float("shipping_service_cost");
            $table->string("shipping_type");
            $table->string("shop_id");
            $table->string("shop_sku");
            $table->string("sku_product");
            $table->string("sku_id");
            $table->string("sla_time_stamp");
            $table->string("stage_pay_status");
            $table->string("status_order");
            $table->float("tax_amount");
            $table->string('tracking_code');
            $table->foreign('tracking_code')->references('tracking_number')->on('online_orders');
            $table->string('tracking_code_pre');
            $table->string('variation');
            $table->float('voucher_amount');
            $table->string('voucher_code');
            $table->string('voucher_code_platform');
            $table->string('voucher_code_seller');
            $table->float('voucher_platform');
            $table->float('voucher_platform_lpi');
            $table->float('voucher_seller');
            $table->float('voucher_seller_lpi');
            $table->float('wallet_credits');
            $table->float('warehouse_code');
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
        Schema::dropIfExists('online_order_details');
    }
}
