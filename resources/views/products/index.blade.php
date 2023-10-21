@extends('layouts.app')

@section('main')
    <div class="container">
        <div class="text-right">
            <a href="products/create" class="btn btn-dark mt-3">New Product</a>
        </div>
        <div class="row  mt-3">
            <div class="col-md-6">
                <h1>Products</h1>
            </div>
            {{-- <div class="col-md-6">
                <div class="form-group">
                    <form action="products/search" method="get">
                        <div class="input-group">
                            <input type="text" name="search" id="search" placeholder="Search..."
                                class="form-control" value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>
                </div>
            </div> --}}
        </div>

        <table class="table table-hover mt-3">
            <thead>
                <tr>
                    <th>SrNo.</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td><a href="products/{{ $product->id }}/show" class="text-dark">{{ $product->name }}</a></td>
                        <td>
                            <img src="products/{{ $product->image }}" class="rounded-circle" width="30" height="30"
                                alt="">
                        </td>
                        <td>
                            <a href="products/{{ $product->id }}/edit" class="btn btn-dark btn-sm">Edit</a>
                            {{-- <a href="products/{{$product->id}}/delete" class="btn btn-danger btn-sm">Delete</a> --}}

                            <form action="products/{{ $product->id }}/delete" class="d-inline" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $products->links() }}
    </div>
@endsection
