<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CategoryResource;

class ApiCategoryController extends Controller
{
    public function all(){
        $categories = Category::all();
        // return response()->json($categories);
        return CategoryResource::collection($categories);

    }

    public function store(Request $request){
        // validator 
        $validator = Validator::make($request->all(),[
            "title"=>"required|string|max:100",

        ]);

        // errors ع الفالديشين
        if($validator->fails()){
            return response()->json([
                "errors"=>$validator->errors(),
            ]);
        }
        // create
        Category::create([
            "title"=> $request->title,
        ]);
        // لو تمام هنعمل msg
        return response()->json([
            "msg"=>"Category inserted successfuly",
        ],201);

    }

    public function update(Request $request , $id){
        $category = Category::find($id);
        if($category == null){
            return response()->json([
                "msg"=>"category not found",
            ],404);
        }
        // valida
        $validator = Validator::make($request->all(),[
            "title"=>"required|string|max:100",
        ]);

         //check errors ع الفالديشين
        if($validator->fails()){
            return response()->json([
                "errors"=>$validator->errors(),
            ],301);
        } 

        // update
        $category->update([
            "title"=>$request->title,
        ]);

        return response()->json([
            "msg"=>"category updated successfuly"
        ],201);
    }

    public function delete($id){
         // find
         $category = Category::find($id);
         if($category == null){
             return response()->json([
                 "msg"=>"category not found",
             ],404);
         }
        $category->delete();
        // msg
        return response()->json([
            "msg"=> "category deleted successfuly",
        ],201);
    }
}
