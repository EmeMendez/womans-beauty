<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandCollection;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Http\Resources\BrandResource;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * @return BrandCollection
     */
    public function index()
    {
        return new BrandCollection(Brand::all());
    }

    public function show(Brand $brand)
    {
        return new BrandResource(Brand::findOrFail($brand->id));
    }
}
