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
        $this->call([
          BrandSeeder::class,
          CategorySeeder::class,
          VariantSeeder::class,
          UserSeeder::class,
          ProductSeeder::class,
      ]);

    }
}
