<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductController extends Controller
{
    public function addProduct(Request $request){
        if($request->img !=null){
            $exploded = explode(",",$request->img);
            $decoded = base64_decode($exploded[1]);
            if(str_contains($exploded[0],'jpeg')){
                $extension = 'jpg';
            }else{
                $extension = 'png';
            }
            $fileName = Str::random(40).'.'.$extension;
            $path = public_path().'/uploads/'.$fileName;
            file_put_contents($path,$decoded);
        }
        else{
            $fileName=null;
        }
        $data = $request->validate(
            [
                'product' => 'required',
                'price' => 'required|integer',
                'quantity' => 'required|integer'
            ]
        );
        $data['image'] = $fileName;
        $data['description'] = $request->description;
        Product::create($data);
        return response()->json(['message' => 'Product Added'],200);
    }
    public function getProducts(){
        $products = Product::orderBy('created_at','DESC')->get();
        return $products;
    }
    public function viewProduct($id){
        return $id;
    }
    public function deleteProduct($id){
        $product = Product::where('id',$id);
        $product->delete();
        return response()->json(['message' => 'Product delete successfully!'],200);
    }
}
