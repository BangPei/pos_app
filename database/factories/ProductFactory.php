<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'barcode' => $this->faker->isbn10(),
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(mt_rand(3, 10)),
            'uom_id' => mt_rand(1, 5),
            'category_id' => mt_rand(1, 5),
            'price' => $this->faker->numberBetween(1000, 100000),
            'is_active' => true

        ];
    }
}
