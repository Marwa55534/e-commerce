@extends('admin.layout')

@section('title')
    Add Categroy
@endsection

@section('content')

@include('errors')

<div class="card shadow mb-6">
    <div class="card-header">
        <strong class="card-title">Add New Category</strong>
    </div>
    <div class="card-body">
        <form action="{{url('categories')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label for="name">title</label>
                        <input type="text" id="title" name="title" class="form-control"
                            placeholder="Enter Category Name">
                    </div>

                
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Add Category</button>
                    </div>
                </div> <!-- /.col -->



        </form>
    </div>
</div> <!-- / .card -->
@endsection
