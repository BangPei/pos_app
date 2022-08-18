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
            "description" => "Saus tomat sasa",
            "is_active" => true,
            "uom_id" => 5,
            "category_id" => 1,
            "created_by_id" => 2,
            "edit_by_id" => 2,
            "price" => 7000,
        ]);
        Product::create([
            "barcode" => "8993005121011",
            "name" => "Caladine cream 15 gr",
            "description" => "Caladine obat kulit anak",
            "is_active" => true,
            "uom_id" => 2,
            "category_id" => 1,
            "created_by_id" => 2,
            "edit_by_id" => 2,
            "price" => 17000.00,
        ]);
        Product::create([
            "barcode" => "8888103209108",
            "name" => "Cussons Baby Cologne Soft Touch 100 ml",
            "description" => "Parfum bayi merek cussons",
            "is_active" => true,
            "uom_id" => 3,
            "category_id" => 3,
            "created_by_id" => 2,
            "edit_by_id" => 2,
            "price" => 20000.00,
        ]);
        Product::create([
            "barcode" => "8999909000544",
            "name" => "Marlboro Black 20 btg",
            "description" => "Rokok Marlboro Marlong",
            "is_active" => true,
            "uom_id" => 3,
            "category_id" => 3,
            "created_by_id" => 2,
            "edit_by_id" => 2,
            "price" => 32000.00,
        ]);
        Product::create([
            "barcode" => "8992946523533",
            "name" => "Shinzui Sakura 420 ml",
            "description" => "Sabun Cair Shinzui 420 ml",
            "is_active" => true,
            "uom_id" => 3,
            "category_id" => 3,
            "created_by_id" => 2,
            "edit_by_id" => 2,
            "price" => 27000.00,
        ]);
        Product::create([
            "barcode" => "8998103010809",
            "name" => "Carex Sabun Cuci Tangan Aloe Vera 2x200 ml",
            "description" => "Sabun Cuci Tangan Carex 2x200 ml",
            "is_active" => true,
            "uom_id" => 3,
            "category_id" => 3,
            "created_by_id" => 1,
            "edit_by_id" => 1,
            "price" => 20500.00,
        ]);
        Product::create([
            "barcode" => "8992802021166",
            "name" => "Prenagen Lactamom Stroberi 200 gr",
            "description" => "Susu Ibu Menyusui (Prenagen)",
            "is_active" => true,
            "uom_id" => 3,
            "category_id" => 3,
            "created_by_id" => 1,
            "edit_by_id" => 1,
            "price" => 45000.00,
        ]);
        Product::create([
            "barcode" => "8851818936812",
            "name" => "Laurier Relax Night 30cm 16pcs",
            "description" => "Pembalut Wanita laurier",
            "is_active" => true,
            "uom_id" => 3,
            "category_id" => 3,
            "created_by_id" => 1,
            "edit_by_id" => 1,
            "price" => 15000.00,
        ]);
        Product::create([
            "barcode" => "8992802108126",
            "name" => "Chil go 3+ Vanilla 700 gr",
            "description" => "Susu Formula Anak 3th keatas",
            "is_active" => true,
            "uom_id" => 3,
            "category_id" => 3,
            "created_by_id" => 1,
            "edit_by_id" => 1,
            "price" => 65000.00,
        ]);
        Product::create([
            "barcode" => "8992802108133",
            "name" => "Chil go 3+ Madu 700 gr",
            "description" => "Susu Formula Anak 3th keatas",
            "is_active" => true,
            "uom_id" => 3,
            "category_id" => 3,
            "created_by_id" => 1,
            "edit_by_id" => 1,
            "price" => 65000.00,
        ]);
        Product::create([
            "barcode" => "8992802108065",
            "name" => "Chil go 1+ Madu 700 gr",
            "description" => "Susu Formula Anak 1-3th keatas",
            "is_active" => true,
            "uom_id" => 3,
            "category_id" => 3,
            "created_by_id" => 1,
            "edit_by_id" => 1,
            "price" => 65000.00,
        ]);
        Product::create([
            "barcode" => "8992802108096",
            "name" => "Chil go 1+ Vanilla 700 gr",
            "description" => "Susu Formula Anak 1-3th keatas",
            "is_active" => true,
            "uom_id" => 3,
            "category_id" => 3,
            "created_by_id" => 1,
            "edit_by_id" => 1,
            "price" => 65000.00,
        ]);
    }
}
