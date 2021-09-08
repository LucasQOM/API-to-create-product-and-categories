<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LogsReportController;

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

Route::post('registrar', 'App\Http\Controllers\UserController@register')->name('register');
Route::post('login', 'App\Http\Controllers\UserController@login')->name('login');



Route::middleware('auth:api')->group( function () {
    // route::apiResource('produtos', ProductsController::class);
    // route::apiResource('categorias', CategoriesController::class);
    // route::apiResource('logs', LogsReportController::class);
   Route::resource('produtos', ProductsController::class);
   Route::resource('categorias', CategoriesController::class);
   Route::resource('logs', LogsReportController::class);
});
