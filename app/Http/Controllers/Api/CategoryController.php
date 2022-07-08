<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
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
        $category = Category::create($request->only('name'));

        return response()->json(
            [
                'data' => $category
            ]
            , 201);
    }

}
