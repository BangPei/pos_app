<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Uom;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // \App\Models\User::factory(10)->create();
        Uom::create([
            "name" => "KG",
            "description" => "Kilogram",
            "is_active" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Uom::create([
            "name" => "GR",
            "description" => "Gram",
            "is_active" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Uom::create([
            "name" => "PCS",
            "description" => "Pieces",
            "is_active" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Uom::create([
            "name" => "Box",
            "description" => "Box",
            "is_active" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Uom::create([
            "name" => "Dus",
            "description" => "Karton",
            "is_active" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);

        Category::create([
            "name" => "Makanan dan Minuman",
            "description" => "Katagori untuk makanan dan minuman",
            "is_active" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Category::create([
            "name" => "Susu Formula",
            "description" => "Katagori untuk susu formula",
            "is_active" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Category::create([
            "name" => "Ibu dan Bayi",
            "description" => "Katagori untuk Ibu dan Bayi",
            "is_active" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Category::create([
            "name" => "Perawatan Tubuh",
            "description" => "Katagori untuk perawatan tubuh",
            "is_active" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);

        Category::create([
            "name" => "Perawatan Rumah",
            "description" => "Katagori untuk perawatan rumah",
            "is_active" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Category::create([
            "name" => "Rokok",
            "description" => "Katagori untuk rokok",
            "is_active" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
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

        User::factory(5)->create();
    }
}
