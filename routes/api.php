<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;





Route::prefix('auth')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('jwt.verify')->group(function () {
        // profile and logout routes
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);

        // pruducts routes
        Route::get('/products', [ProductController::class, 'index']);
        Route::get('/products/{id}', [ProductController::class, 'show']);
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{id}', [ProductController::class, 'update']);
        Route::delete('/products/{id}', [ProductController::class, 'destroy']);


        // oredres routes
        Route::post('/orders', [OrderController::class, 'store']);



        // cart routes
        Route::get('/cart', [CartController::class, 'viewCart']);
        Route::post('/cart', [CartController::class, 'addToCart']);
        Route::put('/cart/{product_id}', [CartController::class, 'updateCart']);
        Route::delete('/cart/{product_id}', [CartController::class, 'removeFromCart']);

    });
});

