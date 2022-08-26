<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            "barcode" => "8992736211275",
            "name" => "Sasa Saus Tomat 24's x 8 gr",
            "is_active" => true,
            "category_id" => 1,
            "created_by_id" => 2,
            "edit_by_id" => 2,
        ]);
        Product::create([
            "barcode" => "8993005121011",
            "name" => "Caladine cream 15 gr",
            "is_active" => true,
            "category_id" => 1,
            "created_by_id" => 2,
            "edit_by_id" => 2,
        ]);
        Product::create([
            "barcode" => "8888103209108",
            "name" => "Cussons Baby Cologne Soft Touch 100 ml",
            "is_active" => true,
            "category_id" => 3,
            "created_by_id" => 2,
            "edit_by_id" => 2,
        ]);
        Product::create([
            "barcode" => "8999909000544",
            "name" => "Marlboro Black 20 btg",
            "is_active" => true,
            "category_id" => 3,
            "created_by_id" => 2,
            "edit_by_id" => 2,
        ]);
        Product::create([
            "barcode" => "8992946523533",
            "name" => "Shinzui Sakura 420 ml",
            "is_active" => true,

            "category_id" => 3,
            "created_by_id" => 2,
            "edit_by_id" => 2,
        ]);
        Product::create([
            "barcode" => "8998103010809",
            "name" => "Carex Sabun Cuci Tangan Aloe Vera 2x200 ml",
            "is_active" => true,

            "category_id" => 3,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Product::create([
            "barcode" => "8992802021166",
            "name" => "Prenagen Lactamom Stroberi 200 gr",
            "is_active" => true,

            "category_id" => 3,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Product::create([
            "barcode" => "8851818936812",
            "name" => "Laurier Relax Night 30cm 16pcs",
            "is_active" => true,

            "category_id" => 3,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Product::create([
            "barcode" => "8992802108126",
            "name" => "Chil go 3+ Vanilla 700 gr",
            "is_active" => true,

            "category_id" => 3,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Product::create([
            "barcode" => "8992802108133",
            "name" => "Chil go 3+ Madu 700 gr",
            "is_active" => true,

            "category_id" => 3,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Product::create([
            "barcode" => "8992802108065",
            "name" => "Chil go 1+ Madu 700 gr",
            "is_active" => true,

            "category_id" => 3,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Product::create([
            "barcode" => "8992802108096",
            "name" => "Chil go 1+ Vanilla 700 gr",
            "is_active" => true,

            "category_id" => 3,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
    }
}
