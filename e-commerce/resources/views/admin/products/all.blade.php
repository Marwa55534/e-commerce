@extends('admin.layout')

@section('title')
    All product
@endsection

@section('content')

@include('errors')
@include('success')

<table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Desc</th>
        <th scope="col">price</th>
        <th scope="col">Quantity</th>
        <th scope="col">image</th>
        <th scope="col">Aciton</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($products as $product )
      <tr>
          <th scope="row">{{$loop->iteration}}</th>
        <td>{{$product->name}}</td>
        <td>{{Str::limit($product->desc, 50)}}</td>
        <td>{{$product->price}}</td>
        <td>{{$product->quantity}}</td>
        <td><img src="{{asset("storage/$product->image")}}" width="100px" alt="" srcset=""></td>
        <td>
            <h1>
                <a class="btn btn-primary" href="{{url("products/show/$product->id")}}" >show</a>
            </h1>

            <form action="{{url("products/delete/$product->id")}}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">delete</button>
            </form>

            <h1>
                <a class="btn btn-info" href="{{url("products/edit/$product->id")}}" >edit</a>
            </h1>
        </td>
    </tr>
    @endforeach

    </tbody>
  </table>

  {{-- {{$products->links}} --}}
  
@endsection
