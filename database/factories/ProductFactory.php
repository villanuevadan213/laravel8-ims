<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'sku' => $this->faker->unique()->word,
            'category_id' => Category::inRandomOrder()->first()->id,
            'quantity' => $this->faker->numberBetween(1, 100),
            'unit' => $this->faker->word,
            'reorder_level' => $this->faker->numberBetween(1, 10),
        ];
    }
}

