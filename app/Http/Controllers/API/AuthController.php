<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use DB;
use Auth;
class AuthController extends Controller
{
    public function login(Request $request){
        $admin = User::where('email','admin@admin.com')
                      ->where('role','admin')
                      ->first();
        if($admin->email == $request->email){
            $credentials = $request->validate([
                 'email' => 'required',
                 'password' => 'required'
            ]);
            if(!auth()->attempt($credentials)){
                return response()->json(['error' => 'Invalid Admin Credentials']);
            }
            $accessToken = auth()->user()->createToken('authToken')->accessToken;
            return response()->json(['user' => auth()->user(),'access_token' => $accessToken,'user_role' => 'admin','user_id' => auth()->user()->id]);
        }
        else{
            $credentials = $validated = $request->validate([
                'email' => 'required',
                'password' => 'required'
            ]);
                if(!auth()->attempt($credentials)){
                        return response()->json(['error' => 'Invalid credentials']);
                }
                $accessToken = auth()->user()->createToken('authToken')->accessToken;
                return response()->json(['user' => auth()->user(),'access_token' => $accessToken,'user_role' => 'customer','user_id' => auth()->user()->id]);
        }
    }
    public function register(Request $request){
        if($request->email != 'admin@gmail.com'){
            $checkEmail = User::where('email',$request->email)->first();
            if($checkEmail){
                return response()->json(["error" => "Email is already taken."]);
            }
            else{
                $validData = $request->validate([
                    'name' => 'required',
                    'email' => 'required|email',
                    'password' => 'required',
                    'address' => 'required',
                    'contact' => 'required|integer'
                ],
                [
                    'name.required' => 'Name is required',
                    'email.required' => 'Email is required',
                    'email.email' => 'Invalid email format',
                    'password.required' => 'Password is required',
                    'address.required' => 'Address is required',
                    'contact.required' => 'Contact is required',
                ]);
                $validData['role'] = 'customer';
                $validData['password'] = Hash::make($request->password);
                $user =  User::create($validData);
                $accessToken = $user->createToken('authToken')->accessToken;
                return response()->json(['user' => $user, 'access_token' => $accessToken]);
            } 
        }           
       else{
           return response()->json(['error' => 'Email Invalid']);
       }
    }
    public function logout(Request $request){
           return auth()->user();
    }
}
