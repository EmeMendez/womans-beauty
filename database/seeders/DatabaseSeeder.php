<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Variant;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductVariant;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Brand::factory(10)->create();
        Category::factory(5)->create();
        Variant::factory(2)->create();
        User::factory(3)->create();
        Product::factory(20)->create();
        
        Product::factory(5)
                ->hasVariants()
                ->create()
                ->each(function ($product, $key) {
                    ProductVariant::factory(3)->create(
                        ['product_id' => $product->id]
                    );
                });

    }
}
