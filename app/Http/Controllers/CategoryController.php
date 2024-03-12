<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Category::all());
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validatedData->errors()->toArray(),
            ], 422);
        }

        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if ($category) {
            return response()->json([
                'status' => 201,
                'message' => 'Category created successfully',
            ], 201);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong',
            ]);
        }
    }

    public function show (Category $category) {
        $foundCategory = Category::find($category->id);

        if ($foundCategory){

            return response()->json([
                'status' => 200,
                'category' => $foundCategory,
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Category not found',
            ]);
        }
    }

    public function edit (Category $category) {
        $foundCategory = Category::find($category->id);

        if ($foundCategory){

            return response()->json([
                'status' => 200,
                'category' => $foundCategory,
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Category not found',
            ]);
        }
    }

    public function update(Request $request, Category $category) {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validatedData->errors()->toArray(),
            ], 422);
        }

        $foundCategory = Category::find($category->id);

        if ($foundCategory) {
            $foundCategory->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            return response()->json([
                'status' => 201,
                'message' => 'Category updated successfully',
            ], 201);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong',
            ],500);
        }
    }
  
    public function destroy(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Category deleted successfully'
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Cannot delete a category with existing products.'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error deleting category'
            ], 500);
        }
    }
}
