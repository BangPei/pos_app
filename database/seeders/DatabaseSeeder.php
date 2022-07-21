<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Uom;

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
            "is_active" => true
        ]);
        Uom::create([
            "name" => "GR",
            "description" => "Gram",
            "is_active" => true
        ]);
        Uom::create([
            "name" => "PCS",
            "description" => "Pieces",
            "is_active" => true
        ]);
        Uom::create([
            "name" => "Box",
            "description" => "Box",
            "is_active" => true
        ]);
        Uom::create([
            "name" => "Dus",
            "description" => "Karton",
            "is_active" => true
        ]);

        Category::create([
            "name" => "Makanan dan Minuman",
            "description" => "Katagori untuk makanan dan minuman",
            "is_active" => true
        ]);
        Category::create([
            "name" => "Susu Formula",
            "description" => "Katagori untuk susu formula",
            "is_active" => true
        ]);
        Category::create([
            "name" => "Ibu dan Bayi",
            "description" => "Katagori untuk Ibu dan Bayi",
            "is_active" => true
        ]);
        Category::create([
            "name" => "Perawatan Tubuh",
            "description" => "Katagori untuk perawatan tubuh",
            "is_active" => true
        ]);

        Category::create([
            "name" => "Perawatan Rumah",
            "description" => "Katagori untuk perawatan rumah",
            "is_active" => true
        ]);
        Category::create([
            "name" => "Rokok",
            "description" => "Katagori untuk rokok",
            "is_active" => true
        ]);

        // Product::factory(30)->create();
    }
}
