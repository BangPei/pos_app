<?php

namespace Database\Seeders;

use App\Models\Reduce;
use Illuminate\Database\Seeder;

class ReduceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Reduce::create([
            "name" => "Debit",
            "is_active" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
            "reduce" => 1,
        ]);
        Reduce::create([
            "name" => "Kartu Kredit",
            "is_active" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
            "reduce" => 2,
        ]);
    }
}
