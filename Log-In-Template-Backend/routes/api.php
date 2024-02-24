<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\Maintenance\CategoryController;
use App\Http\Controllers\Api\Maintenance\ProductController;
use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\SaleItemController;
use App\Http\Controllers\Api\TransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::group(['prefix' => '/category'], function () {
    Route::get('/dropdown', [CategoryController::class, 'dropdown']);
    // Route::get('/deleted', [ProductController::class, 'deleted']);
});

Route::group(['prefix' => '/product'], function () {
    Route::get('/dropdown', [ProductController::class, 'dropdown']);
    Route::get('/getProductStock', [ProductController::class, 'getProductStock']);
    // Route::get('/deleted', [ProductController::class, 'deleted']);
});

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);

Route::group(['prefix' => '/pos'], function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/createuser', [UserController::class, 'create']);
        Route::post('/logout', [UserController::class, 'logout']);
        Route::group(['prefix' => '/maintenance'], function () {
            Route::apiResource('category',CategoryController::class);
            Route::apiResource('product',ProductController::class);
        });
        Route::apiResource('sale',SaleController::class);
        Route::apiResource('transaction',TransactionController::class);
        Route::apiResource('items',SaleItemController::class);

    });
});
