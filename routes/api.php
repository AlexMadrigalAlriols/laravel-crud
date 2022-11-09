<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    Route::post('insert-category', [CategoryController::class, 'insert']);
    Route::get('get-categories', [CategoryController::class, 'read']);
    Route::delete('delete-category', [CategoryController::class, 'delete']);
    Route::post('update-category', [CategoryController::class, 'update']);

    Route::post('insert-product', [ProductController::class, 'insert']);
    Route::get('get-products', [ProductController::class, 'read']);
    Route::delete('delete-product', [ProductController::class, 'delete']);
    Route::post('update-product', [ProductController::class, 'update']);
    return $request->user();
});
