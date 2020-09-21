<?php

use Illuminate\Support\Facades\Route;
use App\Notifications\InvoicePaid;
use App\Models\User;
use App\Models\Purchase;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('x',function(){
   $totalsale = DB::table('purchases')
            ->selectRaw('SUM(amount) as total_sales_day')
            ->where('created_at','>=',Carbon\Carbon::today())
            ->get();
   return $totalsale;
});
Route::post('/charge','App\Http\Controllers\PayController@pay');
Route::get('/{any}', 'App\Http\Controllers\AppController@index')->where('any', '^(?!api).*$');
