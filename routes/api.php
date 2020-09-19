<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login','App\Http\Controllers\API\AuthController@login');
Route::post('register','App\Http\Controllers\API\AuthController@register');
Route::post('add-product','App\Http\Controllers\API\ProductController@addProduct');
Route::get('get-product','App\Http\Controllers\API\ProductController@getProducts');
Route::get('view-product/{id}','App\Http\Controllers\API\ProductController@viewProduct');
Route::delete('delete-product/{id}','App\Http\Controllers\API\ProductController@deleteProduct');
Route::post('logout','App\Http\Controllers\API\AuthController@logout');