 {{-- @extends("user.layout")

@section('latest')
@if(session()->has("wishlist"))

<div class="row">
    @foreach($wishlist as $id=>$product)
    <div class="col-md-4">
        <div class="product-item">
            <img class="card-img-top" src="{{asset("storage/{$product["image"]}")}}" alt="">
            <div class="card-body">
            <h5 class="card-title">{{$product["name"]}}</h5>
            <h6>price : {{$product["price"]}}</h6>

            {{-- login after add to cart a make order --}}
            {{-- <form action="{{url("addToCard/$id")}}" method="post">
                @csrf
                <button type="submit" class="btn btn-primary">Add Card</button>
            </form>
    @endforeach

</div>


@else
<p>
    no product 
</p>
@endif

@endsection   --}}






@extends("user.layout")

@section('latest')
<div class="latest-products">
    <div class="container">
        <div class="row">

            @if(session()->has("wishlist"))
            @foreach ($wishlist as $id=>$product)
            <div class="col-md-4">
                <div class="product-item">
                    <img class="card-img-top" src="{{asset("storage/{$product["image"]}")}}" alt="">
                    <div class="card-body">
                    <h5 class="card-title">{{$product["name"]}}</h5>
                    <h6>price : {{$product["price"]}}</h6>

                    {{-- make order --}}
                     <form action="{{ url("makeOrder")}}" method="post">
                        @csrf
                        <input type="date" name="requiredDate" placeholder="Required Date">
                        <button type="submit" class="btn btn-info">make Order</button>
                    </form>
                    </div>
                </div>
            </div> 
         
            @endforeach

        </div>
        
    </div>
    @else
    <p>
        no product in your cart
    </p>
    @endif
</div>

@endsection 

