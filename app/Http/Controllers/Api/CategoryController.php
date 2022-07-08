<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
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
        return new CategoryResource(Category::create($request->only('name')));
    }

    public function show(Category $category)
    {
        return new CategoryResource(Category::findOrFail($category->id));
    }

}
