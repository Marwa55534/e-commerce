<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function all(){
        // $products = Product::paginate(9);
        $products = Product::all();
        return view("admin.products.all",['products'=>$products]);
    }

    public function show($id){
        // select * from categories where id = $id
        $product = Product::findOrFail($id);
        // return view("Categories.show")->with("category",$category); // view
        return view("admin.products.show",["product"=>$product]); // view
   }

    public function create(){
        $categories = Category::all();
        return view('admin.products.create',['categories'=>$categories]);
    }

    public function store(Request $request){
        // vali
        $data = $request->validate([
            "name"=>"required|string|max:100",
            "desc"=>"required|string",
            "price"=>"required|numeric",
            "quantity"=>"required|numeric",
            "image"=>"required|image|mimes:png,jpeg,jpg|max:1024",
            "category_id"=>"required|exists:categories,id",
        ]);
        // storage
        $data['image'] = Storage::putFile("products",$request->image);

        Product::create($data);
        //Session::flash("success","data inserted successfuly");


        return redirect(url("products"))->with('success','products inserted successfuly'); // products.all

    //    return redirect(url("admin/products.create"))->with('success','data inserted successfuly'); // products.all

    }

    public function edit($id){
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view("admin.products.edit",compact("product","categories")); // view
   }

   public function update(Request $request , $id){

    // valid
    $data = $request->validate([
        "name"=>"required|string|max:100",
        "desc"=>"required|string",
        "price"=>"required|numeric",
        "quantity"=>"required|numeric",
        "image"=>"image|mimes:png,jpeg,jpg|max:1024",
        "category_id"=>"required|exists:categories,id",
    ]);
    // check
    $product = Product::findOrFail($id);
    $oldImage = $product->image;
    if($request->has("image")) {  //check ان ف صوره 
        // unlinl لو هغير الصوره
        // move 
        Storage::delete($oldImage); // unlink

        // storage
        $data['image'] = Storage::putFile("products",$request->image); // new image
    }else{
        $data["image"] = $oldImage;
    }

    // update
    $product->update($data);
    //Session::flash("success","data updated successfuly");

    return redirect(url("products"))->with('success','products updated successfuly'); // products.all
    // return redirect(url("admin/products/show/$id"))->with('success','data updated successfuly'); // products.all

   }
    public function delete($id){
        $product = Product::findOrFail($id);
        Storage::delete($product->image);
        $product->delete();

        // success هخزن ف السيشن ف طريقتين
        // Session::flash("success","data delete successfuly");
        // session()->flash("success","data delete successfuly");

       return redirect(url("products"))->with('success','products delete successfuly');

        // $product = product::findOrFail($id);
        // $product->delete();
        // return redirect(url("products"));
    }

}
