<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }

    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
