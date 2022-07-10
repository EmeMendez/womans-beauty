<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryCollection;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * @return CategoryCollection
     */
    public function index()
    {
        return new CategoryCollection(Category::all());
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(CategoryStoreRequest $request)
    {
        $category = Category::create([
            'name'      => $request->name,
            'status'    => 1
        ]);
        return new CategoryResource($category);
    }

    public function show(Category $category)
    {
        return new CategoryResource(Category::findOrFail($category->id));
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->name = $request->name;
        $category->save();
        return new CategoryResource($category);
    }

    public function delete(Category $category)
    {
        $category->status = 0;
        $category->save();
        return response()->json([], 204);
    }

}
