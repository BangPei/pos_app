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
            "name" => "Chil go 1+ Vanilla 700 gr",
            "product_id" => 12,
            "is_active" => true,
            "uom_id" => 3,
            "price" => 65000,
            "qtyConvertion" => 1,
        ]);
        ItemConvertion::create([
            "barcode" => "8992802108065",
            "name" => "Chil go 1+ Madu 700 gr",
            "product_id" => 11,
            "is_active" => true,
            "uom_id" => 3,
            "price" => 65000,
            "qtyConvertion" => 1,
        ]);
        ItemConvertion::create([
            "barcode" => "8992802108133",
            "name" => "Chil go 3+ Madu 700 gr",
            "product_id" => 10,
            "is_active" => true,
            "uom_id" => 3,
            "price" => 65000,
            "qtyConvertion" => 1,
        ]);
        ItemConvertion::create([
            "barcode" => "8992802108126",
            "name" => "Chil go 3+ Vanilla 700 gr",
            "product_id" => 9,
            "is_active" => true,
            "uom_id" => 3,
            "price" => 65000,
            "qtyConvertion" => 1,
        ]);
        ItemConvertion::create([
            "barcode" => "8993005121011",
            "name" => "Caladine cream 15 gr",
            "product_id" => 2,
            "is_active" => true,
            "uom_id" => 3,
            "price" => 12000,
            "qtyConvertion" => 1,
        ]);
        ItemConvertion::create([
            "barcode" => "8998103010809",
            "name" => "Carex Sabun Cuci Tangan Aloe Vera 2x200 ml",
            "product_id" => 6,
            "is_active" => true,
            "uom_id" => 3,
            "price" => 22500,
            "qtyConvertion" => 1,
        ]);
        ItemConvertion::create([
            "barcode" => "8888103209108",
            "name" => "Cussons Baby Cologne Soft Touch 100 ml",
            "product_id" => 3,
            "is_active" => true,
            "uom_id" => 3,
            "price" => 22500,
            "qtyConvertion" => 1,
        ]);
        ItemConvertion::create([
            "barcode" => "8851818936812",
            "name" => "Laurier Relax Night 30cm 16pcs",
            "product_id" => 8,
            "is_active" => true,
            "uom_id" => 3,
            "price" => 16500,
            "qtyConvertion" => 1,
        ]);
        ItemConvertion::create([
            "barcode" => "8999909000544",
            "name" => "Marlboro Black 20 btg",
            "product_id" => 4,
            "is_active" => true,
            "uom_id" => 3,
            "price" => 32000,
            "qtyConvertion" => 1,
        ]);
        ItemConvertion::create([
            "barcode" => "8992802021166",
            "name" => "Prenagen Lactamom Stroberi 200 gr",
            "product_id" => 7,
            "is_active" => true,
            "uom_id" => 3,
            "price" => 48000,
            "qtyConvertion" => 1,
        ]);
        ItemConvertion::create([
            "barcode" => "8992736211275",
            "name" => "Sasa Saus Tomat 24&#039;s x 8 gr",
            "product_id" => 1,
            "is_active" => true,
            "uom_id" => 3,
            "price" => 7000,
            "qtyConvertion" => 1,
        ]);
        ItemConvertion::create([
            "barcode" => "8992946523533",
            "name" => "Shinzui Sakura 420 ml",
            "product_id" => 5,
            "is_active" => true,
            "uom_id" => 3,
            "price" => 21500,
            "qtyConvertion" => 1,
        ]);
    }
}
