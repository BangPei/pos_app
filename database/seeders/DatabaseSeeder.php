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
            "slug" => "kg",
            "description" => "Kilogram",
            "is_active" => true
        ]);
        Uom::create([
            "name" => "GR",
            "slug" => "gr",
            "description" => "Gram",
            "is_active" => true
        ]);
        Uom::create([
            "name" => "PCS",
            "slug" => "pcs",
            "description" => "Pieces",
            "is_active" => true
        ]);
        Uom::create([
            "name" => "Box",
            "slug" => "box",
            "description" => "Box",
            "is_active" => true
        ]);
        Uom::create([
            "name" => "Dus",
            "slug" => "dus",
            "description" => "Karton",
            "is_active" => true
        ]);

        Category::create([
            "name" => "Makanan dan Minuman",
            "slug" => "makanan-dan-minuman",
            "description" => "Katagori untuk makanan dan minuman",
            "is_active" => true
        ]);
        Category::create([
            "name" => "Susu Formula",
            "slug" => "susu-formula",
            "description" => "Katagori untuk susu formula",
            "is_active" => true
        ]);
        Category::create([
            "name" => "Ibu dan Bayi",
            "slug" => "ibu-dan-bayi",
            "description" => "Katagori untuk Ibu dan Bayi",
            "is_active" => true
        ]);
        Category::create([
            "name" => "Perawatan Tubuh",
            "slug" => "perawatan-tubuh",
            "description" => "Katagori untuk perawatan tubuh",
            "is_active" => true
        ]);

        Category::create([
            "name" => "Perawatan Rumah",
            "slug" => "perawatan-rumah",
            "description" => "Katagori untuk perawatan rumah",
            "is_active" => true
        ]);
        Category::create([
            "name" => "Rokok",
            "slug" => "rokok",
            "description" => "Katagori untuk rokok",
            "is_active" => true
        ]);

        // Product::factory(30)->create();
    }
}
