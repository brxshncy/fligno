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

// PRODUCT
Route::middleware(['auth:api'])->group(function () {
    Route::post('add-product','App\Http\Controllers\API\ProductController@addProduct');
    Route::put('edit-product','App\Http\Controllers\API\ProductController@editProduct');
    Route::get('get-product','App\Http\Controllers\API\ProductController@getProducts');
    Route::delete('delete-product/{id}','App\Http\Controllers\API\ProductController@deleteProduct');
    Route::get('view-product/{id}','App\Http\Controllers\API\ProductController@viewProduct');
    Route::get('unreadnotification','App\Http\Controllers\API\NotificationController@notification');
    Route::get('unreadnotification/{user_id}','App\Http\Controllers\API\NotificationController@notifList');
    Route::get('sales','App\Http\Controllers\API\SalesController@sales');
});

Route::get('products','App\Http\Controllers\LandingPageController@index');
Route::get('item/{id}','App\Http\Controllers\API\CheckoutController@item');
Route::get('user/{id}','App\Http\Controllers\API\CheckoutController@user');

// Route::post('get-product/{category}','App\Http\Controllers\API\GetProductByCategoryController');
// Route::post('get-product','App\Http\Controllers\API\GetProductByCategoryController@index');
//Route::get('get-product','App\Http\Controllers\API\ProductController@getProducts');

Route::post('logout','App\Http\Controllers\API\AuthController@logout');