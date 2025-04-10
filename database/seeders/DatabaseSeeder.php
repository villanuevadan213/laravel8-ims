<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
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
        User::factory()->create([
            'name' => 'John Doe',
            'role' => 'owner',
            'email' => 'test@example.com',
        ]);

        // Create 10 categories
        Category::factory(10)->create();

        // Create 50 products
        Product::factory(20)->create();

        // Create 100 stock movements
        StockMovement::factory(40)->create();
    }
}
