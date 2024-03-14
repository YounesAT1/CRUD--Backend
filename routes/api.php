<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//? Category Routes

Route::get('/categories',[CategoryController::class, 'index']);
Route::post('/categories',[CategoryController::class, 'store']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit']);
Route::put('/categories/{category}/edit', [CategoryController::class, 'update']);
Route::delete('/categories/{category}/delete', [CategoryController::class, 'destroy']);


//? Product Routes

Route::get('/products',[ProductController::class, 'index']);
Route::post('/products',[ProductController::class, 'store']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::get('/products/{product}/edit', [ProductController::class, 'edit']);
Route::put('/products/{product}/edit', [ProductController::class, 'update']);
Route::delete('/products/{product}/delete', [ProductController::class, 'destroy']);






Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
