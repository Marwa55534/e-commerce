<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\User\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('redirect',[AuthController::class,'redirect']);

// CategoryController
Route::controller(CategoryController::class)->group(function (){
    Route::middleware("auth","is_admin")->group(function (){

    Route::get('categories',"all");

    Route::get('categories/create',"create");
    Route::post('categories',"store");

    Route::get("categories/edit/{id}","edit"); // بيوديني ع الفورم بتاعت الايديت
    Route::put("categories/{id}","update"); // handel

    Route::delete("categories/delete/{id}","delete"); 
});

});

// ProductController
Route::controller(ProductController::class)->group(function (){

    Route::middleware("auth","is_admin")->group(function (){

   Route::get('products',"all");

    Route::get("products/show/{id}","show"); // select one 

    Route::get('products/create',"create");
    Route::post('products',"store");

    Route::get("products/edit/{id}","edit"); // بيوديني ع الفورم بتاعت الايديت
    Route::put("products/{id}","update"); // handel

    Route::delete("products/delete/{id}","delete"); 
});
});


// });

// localization
// nav ar , en
// route ----> session , return back()
//--------------------------
// data lang message file
// هاتلي من session
//middleware has , get session
// read
 
Route::get("change/{lang}" , function($lang){

    if($lang == "en"){
        session()->put("lang","en");
    }else{
        session()->put("lang","ar");
    }
    return redirect()->back(); 
});


Route::controller(UserController::class )->group(function(){

    Route::get("","all");
    Route::get("products/{id}","show"); // select one 
    Route::get("search","search");

    Route::post("addToWishlist/{id}","addToWishlist"); // form
    Route::get("viewWishlist","viewWishlist");  

Route::middleware("auth")->group(function(){
    Route::post("addToCard/{id}","addToCard"); 
    Route::get("myCart","myCart"); 
    Route::post("makeOrder","makeOrder"); 
});

});
