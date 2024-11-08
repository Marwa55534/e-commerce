<div class="latest-products">

    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="section-heading">
            <h2>Latest Products</h2>
            <a href="products.html">view all products <i class="fa fa-angle-right"></i></a>

            <form action="{{url("search")}}" method="get">
              @csrf
              <input type="text" name="key" id="" value="{{old("key")}}" class="form-control">
              <button type="submit" class="btn btn-info mt-2">search</button>
            </form>
          </div>
        </div> 

        @foreach ($products as $product)

        <div class="col-md-4">
          <div class="product-item">
            <a href="#"><img src="{{asset("storage/$product->image")}}" alt=""></a>
            <div class="down-content">
              <a href="{{url("products/$product->id")}}"><h4>{{$product->name}}</h4></a>
              <h6>{{$product->price}}</h6>
              <p>{{Str::limit($product->desc, 50)}}</p>
              {{-- <ul class="stars">
                <li><i class="fa fa-star"></i></li>
                <li><i class="fa fa-star"></i></li>
                <li><i class="fa fa-star"></i></li>
                <li><i class="fa fa-star"></i></li>
                <li><i class="fa fa-star"></i></li>
              </ul> --}}
              <span>Quantity : {{$product->quantity}}</span>
            </div>

            {{-- addToCard --}}
            @auth
            <form action="{{url("addToCard/$product->id")}}" method="post">
              @csrf
              <input type="number" class="form-input" name="quantity" id="">
              <button type="submit" class="btn btn-primary">Add Card</button>
            </form>
            @endauth


            {{-- addToWishlist --}}
            <form action="{{url("addToWishlist/$product->id")}}" method="post">
              @csrf
              <button type="submit" class="btn btn-secondary">Add To Wishlist</button>
            </form>
          </div>
          
      </div>
      @endforeach

    </div>

  </div>