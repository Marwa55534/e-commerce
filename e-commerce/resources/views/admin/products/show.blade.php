@extends('admin.layout')

@section('title')
    Show product
@endsection

@section('content')
product Name : {{$product->name}}<br>
product desc : {{$product->desc}}<br>
product Price : {{$product->price}}<br>
product quantity : {{$product->quantity}}<br>
category Name : {{$product->category->title}}<br>
product image : <img src="{{asset("storage/$product->image")}}" alt="" srcset=""><br>

@endsection
