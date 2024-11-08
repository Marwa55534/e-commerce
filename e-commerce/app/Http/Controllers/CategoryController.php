<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function all(){
        
        $categories = Category::all();
        return view("admin.categories.all",["categories"=>$categories]); // view 

    }

    public function create(){ // بيوديني ع الفورم
        return view("admin.categories.create");
    }

    public function store(Request $request){
        // جاي من الفورم @csrf
        // catch Request $request

        // validation [] key -> اسم ال input / value -> rules
        $data = $request->validate([

            "title"=>"required|string|max:100",
            
        ]);
        Category::create($data);
        
        // $categories = Category::paginate(3);
        // return view("categories.all",["categories"=>$categories]);

        return redirect(url("products"))->with('success','Category inserted successfuly'); // products.all

    }

    public function edit($id){
        $category = Category::findOrFail($id);
        return view("admin.categories.edit",compact("category")); // view
   }

   public function update(Request $request , $id){

    // valid
    $data = $request->validate([
        "title"=>"required|string|max:100",
       
    ]);
    // check
    $category = Category::findOrFail($id);
    

    // update
    $category->update($data);
    //Session::flash("success","data updated successfuly");

    return redirect(url("categories"))->with('success','category updated successfuly'); // products.all
    // return redirect(url("admin/products/show/$id"))->with('success','data updated successfuly'); // products.all

   }

    public function delete($id){
        $category = Category::findOrFail($id);
        $category->delete();

        // success هخزن ف السيشن ف طريقتين
        // Session::flash("success","data delete successfuly");
        // session()->flash("success","data delete successfuly");

       return redirect(url("categories"))->with('success','categories delete successfuly');

        // $product = product::findOrFail($id);
        // $product->delete();
        // return redirect(url("products"));
    }

}
