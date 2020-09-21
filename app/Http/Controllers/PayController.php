<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cartalyst\Stripe\Stripe;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\User;
use App\Notifications\InvoicePaid;
class PayController extends Controller
{
    //
    public function pay(Request $request){  
        $user = User::where('role','admin')->first();
        $product = Product::findOrfail($request->product_id);
        $customer = User::findOrfail($request->user_id);
        $data = new \stdClass();
        $data->product_id = $product->id;
        $data->product_name = $product->product;
        $data->customer_id = $customer->id;
        $data->customer_name =  $customer->name;
        $data->quantity = $request->number_purchase;
        $data->amount = $request->amount;
        $user->notify(new InvoicePaid($data));
        $newQuantity = $product->quantity - $request->number_purchase;
        if($newQuantity == 0){
            $product->delete();
        }
        else{
            $product->quantity = $newQuantity;
            $product->save();
        }
        Purchase::create([
            "user_id" => $request->user_id,
            "product_id"  => $request->product_id,
            "number_purchase"  => $request->number_purchase,
            "amount"  => $request->amount
        ]);
        $stripe = Stripe::make('sk_test_51HTQZqGxwQufiUoYvUc236iQOKqNcDgEdIP3087G1E7zK3zlb2cLle8RagTPqXfRTuwTg1mUOi1ktFwIwpBtk4GE00iMrbeSB5');
       try{
            $charge = $stripe->charges()->create([
                'amount' => $request->amount,
                'currency' => 'php',
                'source' => $request->stripeToken,
                'receipt_email' => $request->email,
            ]);
            return redirect('/home');
        }catch(Exception $e){

        }
        
    }
}
