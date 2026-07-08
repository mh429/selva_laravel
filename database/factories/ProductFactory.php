<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\ProductSubcategory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subcategory = ProductSubcategory::inRandomOrder()->first();

        return [
            'member_id' => User::inRandomOrder()->value('id'),
            'product_category_id' => $subcategory->product_category_id,
            'product_subcategory_id' => $subcategory->id,
            'name' => fake()->bothify('Product-###'),
            'product_content' => fake()->sentence(3),
        ];
    }
}
