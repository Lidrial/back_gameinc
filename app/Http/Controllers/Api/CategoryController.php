<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryRequest;
use App\Models\Category;
use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Category $category)
    {
        //
        try {
            $categories = $category::all();
            return response()->json($categories, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Categories not found!'], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $categoryRequest)
    {
        //
        try {
            $validatedData = $categoryRequest->validated();
            $category = Category::create($validatedData);
            return response()->json(['message' => 'Category created successfully', 'category' => $category], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Category not created!'], 404);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        try {
            $category = Category::findOrFail($id);
            return response()->json($category, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Category not found!'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $categoryRequest, string $id)
    {
        //
        try {
            $category = Category::findOrFail($id);
            $category->update($categoryRequest->all());
            return response()->json(['message' => 'Category updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Category not updated!'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            $category = Category::destroy($id);
            return response()->json(['message' => 'Category deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Category not deleted!'], 404);
        }
    }

}
