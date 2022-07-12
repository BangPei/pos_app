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
        Uom::created([
            "name" => "KG",
            "description" => "Kilogram",
            "is_active" => true
        ]);
        Uom::created([
            "name" => "GR",
            "description" => "Gram",
            "is_active" => true
        ]);
        Uom::created([
            "name" => "PCS",
            "description" => "Pieces",
            "is_active" => true
        ]);
        Uom::created([
            "name" => "Box",
            "description" => "Box",
            "is_active" => true
        ]);
        Uom::created([
            "name" => "Dus",
            "description" => "Karton",
            "is_active" => true
        ]);

        Category::created([
            "name" => "Makanan dan Minuman",
            "description" => "Katagori untuk makanan dan minuman",
            "is_active" => true
        ]);
        Category::created([
            "name" => "Susu Formula",
            "description" => "Katagori untuk susu formula",
            "is_active" => true
        ]);
        Category::created([
            "name" => "Ibu dan Bayi",
            "description" => "Katagori untuk Ibu dan Bayi",
            "is_active" => true
        ]);
        Category::created([
            "name" => "Perawatan Tubuh",
            "description" => "Katagori untuk perawatan tubuh",
            "is_active" => true
        ]);

        Category::created([
            "name" => "Perawatan Rumah",
            "description" => "Katagori untuk perawatan rumah",
            "is_active" => true
        ]);

        Product::factory(30)->create();
    }
}
