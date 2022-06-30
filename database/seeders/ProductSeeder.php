<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Product;
use App\Models\ProductVariant;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
