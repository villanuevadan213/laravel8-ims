<?php

namespace Database\Factories;

use App\Models\StockMovement;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockMovementFactory extends Factory
{
    protected $model = StockMovement::class;

    public function definition()
    {
        return [
            'product_id' => Product::inRandomOrder()->first()->id, // Random product
            'type' => $this->faker->randomElement(['in', 'out']), // Ensure correct values ('in' or 'out')
            'quantity' => $this->faker->numberBetween(1, 100), // Random quantity
            'price' => $this->faker->randomFloat(2, 1, 100), // Random price between 1 and 100
            'reference' => $this->faker->sentence(), // Random reference note
        ];
    }
}
