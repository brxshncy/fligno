<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use DB;
class CheckoutController extends Controller
{
    public function item($id)
    {
        $product = Product::where('id',$id)->first();
        return $product;
    }
    public function user($user_id)
    {
       $user = User::findOrFail($user_id);
       return $user;
    }
}
