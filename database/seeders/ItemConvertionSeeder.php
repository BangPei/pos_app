<?php

namespace Database\Seeders;

use App\Models\ItemConvertion;
use Illuminate\Database\Seeder;

class ItemConvertionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ItemConvertion::create([
            "barcode" => "8992802108096",
            "name" => "1x700 gr",
            "product_id" => 12,
            "is_active" => true,
            "uom_id" => 3,
            "price" => 65000,
            "qtyConvertion" => 1,
        ]);
        ItemConvertion::create([
            "barcode" => "8992802108065",
            "name" => "1x700 gr",
            "product_id" => 11,
            "is_active" => true,
            "uom_id" => 3,
            "price" => 65000,
            "qtyConvertion" => 1,
        ]);
        ItemConvertion::create([
            "barcode" => "8992802108133",
            "name" => "1x700 gr",
            "product_id" => 10,
            "is_active" => true,
            "uom_id" => 3,
            "price" => 65000,
            "qtyConvertion" => 1,
        ]);
        ItemConvertion::create([
            "barcode" => "8992802108126",
            "name" => "1x700 gr",
            "product_id" => 9,
            "is_active" => true,
            "uom_id" => 3,
            "price" => 65000,
            "qtyConvertion" => 1,
        ]);
        ItemConvertion::create([
            "barcode" => "8993005121011",
            "name" => "1x15 gr",
            "product_id" => 2,
            "is_active" => true,
            "uom_id" => 3,
            "price" => 12000,
            "qtyConvertion" => 1,
        ]);
        ItemConvertion::create([
            "barcode" => "8998103010809",
            "name" => "2x200 ml",
            "product_id" => 6,
            "is_active" => true,
            "uom_id" => 3,
            "price" => 22500,
            "qtyConvertion" => 1,
        ]);
        ItemConvertion::create([
            "barcode" => "8888103209108",
            "name" => "1x100 ml",
            "product_id" => 3,
            "is_active" => true,
            "uom_id" => 3,
            "price" => 22500,
            "qtyConvertion" => 1,
        ]);
        ItemConvertion::create([
            "barcode" => "8851818936812",
            "name" => "1x 30cm 16pcs",
            "product_id" => 8,
            "is_active" => true,
            "uom_id" => 3,
            "price" => 16500,
            "qtyConvertion" => 1,
        ]);
        ItemConvertion::create([
            "barcode" => "8999909000544",
            "name" => "1 Bungkus",
            "product_id" => 4,
            "is_active" => true,
            "uom_id" => 3,
            "price" => 32000,
            "qtyConvertion" => 1,
        ]);
        ItemConvertion::create([
            "barcode" => "8992802021166",
            "name" => "1x200 gr",
            "product_id" => 7,
            "is_active" => true,
            "uom_id" => 3,
            "price" => 48000,
            "qtyConvertion" => 1,
        ]);
        ItemConvertion::create([
            "barcode" => "8992736211275",
            "name" => "24x8gr",
            "product_id" => 1,
            "is_active" => true,
            "uom_id" => 3,
            "price" => 7000,
            "qtyConvertion" => 1,
        ]);
        ItemConvertion::create([
            "barcode" => "8992946523533",
            "name" => "1x420 ml",
            "product_id" => 5,
            "is_active" => true,
            "uom_id" => 3,
            "price" => 21500,
            "qtyConvertion" => 1,
        ]);
    }
}
