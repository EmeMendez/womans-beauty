<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandCollection;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Http\Resources\BrandResource;
use App\Http\Requests\BrandStoreRequest;
use App\Http\Requests\BrandUpdateRequest;

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

    public function store(BrandStoreRequest $request)
    {
        $brand = Brand::create([
            'name'      => $request->name,
            'status'    => 1
        ]);
        return new BrandResource($brand);
    }

    public function update(BrandUpdateRequest $request, Brand $brand)
    {
        $brand->name = $request->name;
        $brand->save();
        return new BrandResource($brand);
    }

    public function delete(Brand $brand)
    {
        $brand->status = 0;
        $brand->save();
        return response()->json([], 204);
    }
}
