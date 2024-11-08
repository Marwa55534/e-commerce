<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiProductController;
use App\Http\Controllers\Api\ApiCategoryController;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Middleware\ApiAuth;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::controller(ApiProductController::class)->group(function (){

    Route::middleware("api_auth")->group(function(){
        Route::get('products',"all");

        Route::get("products/show/{id}","show"); // select one 

        Route::post('products',"store");

        Route::put("products/{id}","update"); // handel

        Route::delete("products/delete/{id}","delete"); 
    });
});


Route::controller(ApiCategoryController::class)->group(function (){
    Route::middleware("api_auth")->group(function(){

        Route::get('categories',"all");

        Route::post('categories',"store");

        Route::put("categories/{id}","update"); 

        Route::delete("categories/delete/{id}","delete"); 
    });
});

Route::controller(ApiAuthController::class)->group(function (){
    Route::post('register',"register");

    Route::post('login',"login");

    Route::post("logout","logout");
});
