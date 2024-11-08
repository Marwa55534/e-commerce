<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetails;

class UserController extends Controller
{
    public function all(){
        $products = Product::all();
        // $cart = session()->get("cart");
        // dd($cart);
        return view("user.home",['products'=>$products]);

    }

    public function show($id){
        $product = Product::findOrFail($id);
        $category_id = $product->category_id;
        $category = Category::findOrFail($category_id);

        return view("user.products.show",["product"=>$product , "category"=>$category]); // view
   }

   public function search(Request $request){
       $key = $request->key;

       $products = Product::where("name","like","%$key%")->get();
       return view("user.home",['products'=>$products]);

   }

   // addToCard هخزنها ف ال سيشن
   // بخزن الحاجه دي مؤقته مش هتروح لداتا بيز 
   //makeOrder هتروح لداتا بيز لما اعمله اوردر
   public function addToCard(Request $request , $id){

    // همسك ال Quantity لازم اعرف العدد عندي قد ايه 
    $quantity = $request->quantity;

    // همسك ال id
    $product = Product::findOrFail($id);
    //

    //cart - session لازم يكون عندي في ال 
    $cart = session()->get("cart");

    // لو مش عندي سيشن فيها كارد . هكريت الكارد . وهخزن ف السيشن
    if(! $cart){ // لو مش موجوده يعني اول ضغطه
        // هكريت الكارد . وهخزن ف السيش
        $cart = [
            $id =>[
                "name"=>$product->name,
                "price"=>$product->price,
                "image"=>$product->image,
                "quantity"=>$quantity,
            ],
        ];
        // هخزن ف السيشن
        session()->put("cart",$cart);
        return redirect()->back()->with("success","product add to cart success");


    }else{
        // طب لو هو عندي الكارد قبل كده هعمل ايهadd
        //اللي جواها Quantityهمسك الكارد القديمه وهعمل بلس ع ال 
        // هخزن ف السيشن
        if(isset($cart[$id])){  // يعني دي مش اول مره ادخل وضغطت عليها قبل كده تاني ضغطه ع نفس الحاجه
            //
            $cart[$id]["quantity"] += $quantity;
            session()->put("cart",$cart);
            return redirect()->back()->with("success","product add to cart success");
        }
        // لو هضيف كارد ع الكارد 
       $cart[$id] = [
            "name"=>$product->name,
            "price"=>$product->price,
            "image"=>$product->image,
            "quantity"=>$quantity,
       ];

        // هخزن ف السيشن
       session()->put("cart",$cart);
       return redirect()->back()->with("success","product add to cart success");
        
    }

   }

   public function myCart(){
        // user
        $user = auth()->user();
        //هقرا او هجيب الكارد من السيشن 
        $cart = session()->get("cart");
        return view("user.myCart",compact("cart","user"));

   }

   public function makeOrder(Request $request){
    // هجيب requiredDate من request
    $requiredDate = $request->requiredDate;
    //هقرا او هجيب الكارد من السيشن 
    $cart = session()->get("cart");

    // create order
    $order = Order::create([
        "requiredDate"=>$requiredDate,
        "orderDate"=>now(),
        "user_id"=>auth()->user()->id,
        
    ]);
    // create orderDetails جوه ال foreach
    foreach ($cart as $id=>$product) {

        OrderDetails::create([
            "order_id"=>$order->id,
            "product_id"=>$id,
            "price"=>$product['price'],
            "quantity"=>$product['quantity'],

        ]);
    }
    return redirect()->back()->with("success","product add to order success");
    }


    // public function addToWishlist($id){

    // // همسك ال Product
    //     $product = Product::findOrFail($id);

    //     //هقرا او هجيب الكارد من السيشن 
    //     $wishlist = session()->get("wishlist");

    //     // لو في هنعمل ادد
    //     // لو مفيش هنكريت

    //     if(isset($wishlist[$id])){ // لو عندي
    //         return redirect()->back()->with("error","product already in wishlist");
    //     }

    //     // لو هو مش موجود
    //     $wishlist[$id]=[
    //         "name"=>$product->name,
    //         "image"=>$product->image,
    //         "price"=>$product->price,

    //     ];

    //     session()->put("wishlist");
    //     return redirect()->back()->with("success","product add to wishlist");
    // }

    
    public function addToWishlist($id){
        // همسك ال Product
        $product = Product::findOrFail($id);

        //هقرا او هجيب الكارد من السيشن 
        $wishlist = session()->get("wishlist");

        if(! $wishlist){
            $wishlist = [
                $id=[
                    "name"=>$product->name,
                    "image"=>$product->image,
                    "price"=>$product->price,
                ],
            ];
            session()->put("wishlist",$wishlist);
            return redirect()->back()->with("success","product add to wishlist");
        }else{ // لو انا عندي
            if(isset($wishlist[$id])){ // لو عندي
                return redirect()->back()->with("error","product already in wishlist");
            }
            $wishlist[$id] = [
                "name"=>$product->name,
                "image"=>$product->image,
                "price"=>$product->price,
           ];
    
            // هخزن ف السيشن
           session()->put("wishlist",$wishlist);
           return redirect()->back();
        }
    }
    
    // بتقرا
    public function viewWishlist(){
        $wishlist = session()->get("wishlist");

        return view("user.products.viewWishlist",compact("wishlist"));
    }


}
