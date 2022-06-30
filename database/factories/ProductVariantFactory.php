<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductVariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'product_id'        => null,
            'sku'               => Str::random(5),
            'bar_code'          => $this->faker->ean13,
            'image'             => 'https://placekitten.com/300/300',
            'stock'             => rand(1,50),
            'attribute'         => $this->faker->word,
            'is_active'         => $is_active = rand(1,0),
            'is_discontinued'   => $is_active == 0 ? rand(1,0) : 0,
        ];
    }
}
