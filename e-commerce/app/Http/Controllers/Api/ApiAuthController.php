<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    public function register(Request $request){
        // vali
        $validator = Validator::make($request->all(),[
            "name"=>"required|string|max:100",
            "email"=>"required|email|max:150|unique:users,email",
            "password"=>"required|string|min:6|confirmed",
        ]);
        // check error
        if($validator->fails()){
            return response()->json([
                "errors"=>$validator->errors(),
            ],301);
        }
        // password hash
        $password = bcrypt($request->password);
        // access
        $access_token = Str::random(64);
        // create
        User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>$password,
            "access_token"=>$access_token,
        ]);
        // msg , access 
        return response()->json([
            "msg"=>"account created succefuly",
            "access_token"=>$access_token
        ],201);
    }

    public function login(Request $request){
        // valid
        $validator = Validator::make($request->all(),[
            "email"=>"required|email|max:150",
            "password"=>"required|string|min:6",
        ]);

        // check error vali
        if($validator->fails()){
            return response()->json([
                "error"=>$validator->errors(),
            ],301);
        }

        // check email
        $user = User::where("email", $request->email)->first();
        if($user){ // لو الايميل موجود 
            // check passwoe
            $isValid = Hash::check($request->password , $user->password);
            $access_token = Str::random(64);
            if($isValid){ // لو الباسورد موجود 
                // update access_token
                $user->update([
                    "access_token"=>$access_token,
                ]);
                // msg successfuly with access_token
                return response()->json([
                    "msg"=>"you login successfuly",
                    "access_token"=>$access_token,
                ],201);

            }else{
                return response()->json([
                    "msg"=>"password not correct",
                ],404);
            }
        }else{
            return response()->json([
                "msg"=>"email not correct",
            ],404);
        }

    }


    public function logout(Request $request){
        $access_token = $request->header("access_token");

        // هنتشيك ان الاكسس توكن موجود ف الداتا بيز ولا لا,
        if($access_token !== null){
            $user = User::where("access_token",$access_token)->first();

            if($user){ // لو اليوزر موجود هنعمل 
                $user->update([
                    "access_token"=>null,
                ]);
                // msg successfuly
                return response()->json([
                "msg"=>"you logout successfuly",
                ],201);
            }else{ // لو اليوزر موجود وغلط 
                return response()->json([
                "msg"=>"access token not correct",
                ],404);
            }
        }else{ // لو مش موجود 
            return response()->json([
            "msg"=>"access token not found",
            ],404);
        }
    }
}

// login
//valid
// error check valid
// check email , else
// check pass , access token ,updat access token , لو صح هيدخل msg with access token , else


// logout
// access_token = $request->header()
// هنتشيك ان الاكسس توكن موجود ف الداتا بيز ولا لا, else
//mssg وهنبعت  update=null  لو اليوزر موجود وصح هنعم, else