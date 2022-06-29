<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->contrained('categories');
            $table->foreignId('brand_id')->contrained('brands');
            $table->foreignId('variant_id')->contrained('variants')->nullable();
            $table->foreignId('user_id')->contrained('users')->comment('usuario que creó al usuario');
            $table->string('sku')->nullable();
            $table->integer('bar_code')->nullable();
            $table->string('name');
            $table->text('description');
            $table->string('image');
            $table->integer('stock')->nullable();
            $table->integer('price')->nullable();
            $table->integer('measure');
            $table->integer('unit_measure');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_discontinued')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
