@extends('admin.layout')

@section('title')
    all Categroy
@endsection

@section('content')

@include('errors')
@include('success')

<div class="col-md-12 my-4">
    <div class="card shadow">
        <div class="card-body">
            <h5 class="card-title">Categories</h5>

            {{-- <x-success-alert key='success'></x-success-alert> --}}

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category title</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @if (count($categories) > 0) --}}
                        @foreach ($categories as $category)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{ $category->title }}</td>
                                <td>{{ $category->created_at->format('d M Y') }}</td>

                                <td>
                                    
                                    <form action="{{url("categories/delete/$category->id")}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">delete</button>
                                    </form>
                        
                                    <h1>
                                        <a class="btn btn-info" href="{{url("categories/edit/$category->id")}}" >edit</a>
                                    </h1>
                                </td>
                            </tr>
                        @endforeach
                    {{-- @else
                        <x-empty-alert></x-empty-alert>
                    @endif --}}

                </tbody>
            </table>
            {{-- {{ $categories->render('pagination::bootstrap-4') }} --}}

        </div>
    </div>
</div> <!-- simple table -->
@endsection
