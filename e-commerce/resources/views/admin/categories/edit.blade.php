@extends('admin.layout')

@section('title')
    all Categroy
@endsection

@section('content')

@include('errors')
@include('success')

<div class="card shadow mb-4">
    <div class="card-header">
        <strong class="card-title">Edit Category</strong>
    </div>
    <div class="card-body">
        <form action="{{url("categories/$category->id")}}" method="POST">
            @csrf
            @method("PUT")
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label for="name">title</label>
                        <input type="text" id="title" name="title" class="form-control"
                            placeholder="Enter Category Name" value="{{ $category->title }}">
                    </div>


                </div>

            </div> <!-- /.col -->

            <div class="text-center">
                <button type="submit" class="btn btn-primary">submit</button>
            </div>
        </form>
    </div>
</div> <!-- / .card -->

@endsection
