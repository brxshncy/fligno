<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
class SalesController extends Controller
{
    public function sales(){
        $sales = DB::table('purchases as p')
                    ->select('i.product as item','u.name as name','p.number_purchase as total_purchase', 'p.amount as total_amount','p.created_at as date_purchase')
                    ->leftJoin('products as i','i.id','=','p.product_id')
                    ->leftJoin('users as u','u.id','=','p.user_id')
                    ->orderBy('p.created_at')
                    ->get();
        $totalsale = DB::table('purchases')
                    ->selectRaw('SUM(amount) as total_sales')
                    ->where('created_at','>=',Carbon::today())
                    ->first();
        return response()->json(['sales' => $sales,'total_sales' => $totalsale]);
    }
}
