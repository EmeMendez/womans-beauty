<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Variant;
use App\Models\User;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'category_id'       => Category::get()->random()->value('id'),
            'brand_id'          => Brand::get()->random()->value('id'),
            'user_id'           => User::get()->random()->value('id'),
            'variant_id'        => null,
            'sku'               => Str::random(7),
            'bar_code'          => $this->faker->ean13,
            'name'              => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'description'       => $this->faker->text,
            'image'             => 'https://placekitten.com/300/300',
            'stock'             => rand(1,50),
            'price'             => rand(1000,15000),
            'measure'           => rand(5,100),
            'unit_measure'      => $this->faker->randomElement($array = ['gr', 'ml']),
            'is_active'         => rand(0,1),
            'is_discontinued'   => rand(0,1),
        ];
    }
    
    public function hasVariants()
    {
        return $this->state(function (array $attributes) {
            return [
                'variant_id'        => Variant::get()->random()->value('id'),
                'sku'               => null,
                'bar_code'          => null, 
                'stock'             => null,
                'is_active'         => rand(0,1),
                'is_discontinued'   => rand(0,1),
            ];
        });
    }
}
