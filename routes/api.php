<?php

use App\Http\Controllers\Api as Api;
use App\Http\Controllers\Auth as Auth;
use Illuminate\Support\Facades\Route;

/** Auth */
Route::post('register', [Auth\RegisterController::class, 'store']);
Route::post('login', [Auth\LoginController::class, 'store']);
/** User info */
Route::group(['prefix' => 'user', 'middleware' => 'auth:sanctum'], function () {
    Route::get('posts', [Api\UserController::class, 'posts']);
    Route::get('packages', [Api\UserController::class, 'packages']);
});
/** Admin packages */
Route::apiResource('admin/packages', Api\AdminPackageController::class)
    ->middleware(['auth:sanctum', 'admin']);
/** Posts */
Route::get('posts', [Api\PostController::class, 'index']);
Route::post('posts', [Api\PostController::class, 'store'])
    ->middleware('auth:sanctum');
Route::put('posts/{post}/activate', [Api\PostController::class, 'activate'])
    ->middleware('auth:sanctum');
/** User packages */
Route::get('packages', [Api\PackageController::class, 'index']);
Route::post('packages/{id}/buy', [Api\PackageController::class, 'buy'])
    ->middleware('auth:sanctum');
