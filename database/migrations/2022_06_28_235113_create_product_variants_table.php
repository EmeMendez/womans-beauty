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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->string('sku');
            $table->bigInteger('bar_code');
            $table->string('image');
            $table->integer('stock');
            $table->string('attribute')->comment('nombre del atributo(color-aroma), [rojo, blanco, manzana, frutilla]');
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
        Schema::dropIfExists('product_variants');
    }
};
