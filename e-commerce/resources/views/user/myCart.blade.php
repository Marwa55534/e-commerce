@extends("user.layout")

@section('latest')
<div class="latest-products">
    <div class="container">
        <div class="row">

            @if(session()->has("cart"))
            @foreach ($cart as $id=>$product)
            <div class="col-md-4">
                <div class="product-item">
                    <img class="card-img-top" src="{{asset("storage/{$product["image"]}")}}" alt="">
                    <div class="card-body">
                    <h5 class="card-title">{{$product["name"]}}</h5>
            {{-- <p class="card-text">{{$product["desc"]}}</p> --}}
            {{-- <h6>category : {{$category["title"]}}</h6> --}}
                    <h6>price : {{$product["price"]}}</h6>
                    <h6>quantity : {{$product["quantity"]}}</h6>

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
