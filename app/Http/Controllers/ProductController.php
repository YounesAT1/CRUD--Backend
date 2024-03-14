<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::with('category')->get());
    }

    public function store(Request $request) {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'availableQuantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ],[
            'category_id.required' => 'The category field is required',
            'availableQuantity.integer' => 'The available quantity field must be a number.'
        ]);

        if($validatedData->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validatedData->errors()->toArray(),
            ], 422);
        }

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'availableQuantity' => $request->availableQuantity,
            'category_id' => $request->category_id,
        ]);

        if($product) {
            return response()->json([
                'status' => 201,
                'message' => 'Product created successfully',
            ], 201);
        }else {
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong',
            ]);
        }
        
    }

    public function show (Product $product) {
        $foundProduct = Product::with('category')->find($product->id);

        if ($foundProduct) {
            return response()->json([
                'status' => 200,
                'product' => $foundProduct,
            ], 200);
        }else {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found',
            ]);
        }
    }

    public function edit (Product $product) {
        $foundProduct = Product::find($product->id);

        if ($foundProduct) {
            return response()->json([
                'status' => 200,
                'product' => $foundProduct,
            ], 200);
        }else {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found',
            ]);
        }
    }

    public function update (Request $request, Product $product) {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'availableQuantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ],[
            'category_id.required' => 'The category field is required',
            'availableQuantity.integer' => 'The available quantity field must be a number.'
        ]);

        if($validatedData->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validatedData->errors()->toArray(),
            ], 422);
        }

        $foundProduct = Product::find($product->id);

        if ($foundProduct) {
            $foundProduct->update([
                'name' => $request->name,
                'price' => $request->price,
                'availableQuantity' => $request->availableQuantity,
                'category_id' => $request->category_id,
            ]);

            return response()->json([
                'status' => 201,
                'message' => 'Product updated successfully',
            ], 201);
        }else {
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong',
            ],500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Product deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error deleting Product'
            ], 500);
        }
    }





    
}
