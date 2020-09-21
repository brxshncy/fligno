<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class LandingPageController extends Controller
{
    //
    public function index(){
        $products = Product::orderBy('created_at','DESC')->get();
        return $products;
    }
}
