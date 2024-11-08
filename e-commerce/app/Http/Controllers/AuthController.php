<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class AuthController extends Controller
{
    public function redirect(){
        if(Auth::user()->role == 'admin'){
            // $products = Product::paginate(9);
        $products = Product::all();
            return view('admin.home',['products'=>$products]); 
        }else{
        
            return view('user.home');
            
        }
    }
} 
