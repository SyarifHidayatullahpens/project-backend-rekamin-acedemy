<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\{CategoryController,ProfileController,PostController};


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return response()->json([
        'message' => 'Authenticated.',
        'data'    => $request->user(),
    ], 200);
});

Route::post('/login', [AuthController::class, 'login']);
Route::get('/category/{name}', [CategoryController::class, 'category'])->name('backend.category');

Route::middleware('auth:api')->group(function (){
    //auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::prefix('/v1')->group(function (){
        Route::resource('/categories',   CategoryController::class);
        Route::post('/get-categories',       [PostController::class, 'getCategories'])->name('get-categories');
        Route::post('/get-users',       [PostController::class, 'getUsers'])->name('get-users');
        Route::resource('/posts',   PostController::class);
    });
});

