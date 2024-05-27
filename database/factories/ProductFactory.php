<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
   protected $model = Product::class;

   public function definition()
   {
      return [
         'sub_category_id' => $this->faker->numberBetween(1, 18),
         'category' => $this->faker->randomElement(['men', 'women', 'kid']),
         'name' => $this->faker->words(3, true),
         'slug' => function (array $attributes) {
            return Str::slug($attributes['name']);
         },
         'small_description' => $this->faker->sentence(),
         'description' => $this->faker->paragraph(),
         'original_price' => $this->faker->randomFloat(2, 50, 200),
         'selling_price' => $this->faker->randomFloat(2, 40, 180),
         'image' => "default-shoe-image.png",
         'quantity' => $this->faker->numberBetween(10, 100),
         'status' => 1,
         'featured' => $this->faker->boolean(30),
         'trending' => $this->faker->boolean(20),
         'meta_title' => $this->faker->sentence(),
         'meta_keywords' => $this->faker->words(5, true),
         'meta_description' => $this->faker->paragraph(),
      ];
   }
}
