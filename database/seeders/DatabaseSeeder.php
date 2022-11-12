<?php

namespace Database\Seeders;

use App\Models\Atm;
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
        $this->call([ProductSeeder::class]);
        $this->call([ReduceSeeder::class]);
        $this->call([AtmSeeder::class]);
        $this->call([PaymentTypeSeeder::class]);
        $this->call([CategorySeeder::class]);
        $this->call([UomSeeder::class]);
        $this->call([ItemConvertionSeeder::class]);
        $this->call([ExpeditionSeeder::class]);
        $this->call([OnlineShopSeeder::class]);

        User::create([
            "name" => "Administrator",
            "password" => "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi",
            "username" => "admin",
            "remember_token" => "s8NzT1lWhV",
        ]);

        User::factory(5)->create();
    }
}
