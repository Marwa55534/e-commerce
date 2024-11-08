<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ApiProductController extends Controller
{
    public function all()
    {
        $products = Product::with('category')->get();
        return ProductResource::collection($products);
    }

    public function show($id){
        $product = Product::find($id);
        if($product !== null){
            return new ProductResource($product);

        }else{
            return response()->json([
                "msg"=>"product not found",
            ],404);
        }
    }

    public function store(Request $request){
        // validator 
        $validator = Validator::make($request->all(),[
            "name"=>"required|string|max:100",
            "desc"=>"required|string",
            "price"=>"required|numeric",
            "quantity"=>"required|numeric",
            "image"=>"required|image|mimes:png,jpeg,jpg|max:1024",
            "category_id"=>"required|exists:categories,id",
        ]);
        // errors ع الفالديشين
        if($validator->fails()){
            return response()->json([
                "errors"=>$validator->errors(),
            ],301);
        }

        // image
        $image = Storage::putFile("products",$request->image);
        
        // create
        Product::create([
            "name"=>$request->name,
            "desc"=>$request->desc,
            "price"=>$request->price,
            "quantity"=>$request->quantity,
            "image"=>$image,
            "category_id"=>$request->category_id,
        ]);
        // لو تمام هنعمل msg
        return response()->json([
            "msg"=>"Product inserted successfuly",
        ],201);
    }

    public function update(Request $request , $id){
          // select one
        $product = Product::find($id);
          if($product == null){
            return response()->json([
                "msg"=>"product not found",
            ],404);
        }
        // validate
        $validator = Validator::make($request->all(),[
            "name"=>"required|string|max:100",
            "desc"=>"required|string",
            "price"=>"required|numeric",
            "quantity"=>"required|numeric",
            "image"=>"image|mimes:png,jpeg,jpg|max:1024",
            "category_id"=>"required|exists:categories,id",
        ]);

        // errors ع الفالديشين
        if($validator->fails()){
            return response()->json([
                "errors"=>$validator->errors(),
            ],301);
        } 
        // image
        $image = $product->image;
        if($request->hasFile("image")){ //check ان ف صوره 
            Storage::delete($product->image); // unlink
            $image = Storage::putFile("products",$request->image); // new image

        }
        // update
        $product->update([
            "name"=>$request->name,
            "desc"=>$request->desc,
            "price"=>$request->price,
            "quantity"=>$request->quantity,
            "image"=>$image,
            "category_id"=>$request->category_id,
        ]);

          // لو تمام هنعمل msg
        return response()->json([
            "msg"=> "Product updated successfuly",
            "product"=> new ProductResource($product),
        ],201);
    }

    public function delete($id){
        // find
        $product = Product::find($id);
        if($product == null){
            return response()->json([
                "msg"=>"product not found",
            ],404);
        }

        // delete image
        // if($product->image !== null){
        //     Storage::delete($product->image);
        // }

        if ($product->image && Storage::exists($product->image)) {
            Storage::delete($product->image);
        }
       
        // delete row
        $product->delete();
        // msg
        return response()->json([
            "msg"=> "Product deleted successfuly",
        ],201);
    }

}
