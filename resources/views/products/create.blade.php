@extends('layouts.master')
@section('title', 'Create Product')

@section('content')
<h1>Create Products</h1>

<a href="{{ route('products.index') }}" class="btn btn-success">Back</a>

<form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="" class="form-label">Name</label>
        <input type="text" class="form-control" name="name" />
        @error('name')
        <span class="fst-italic text-danger">
            {{ $message }}
        </span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="" class="form-label">Description</label>
        <input type="text" class="form-control" name="description" />
        @error('description')
        <span class="fst-italic text-danger">
            {{ $message }}
        </span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="" class="form-label">Price</label>
        <input type="number" class="form-control" name="price" />
        @error('price')
        <span class="fst-italic text-danger">
            {{ $message }}
        </span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="" class="form-label">Quantity</label>
        <input type="number" class="form-control" name="quantity" />
        @error('quantity')
        <span class="fst-italic text-danger">
            {{ $message }}
        </span>
        @enderror
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="1" name="is_active" checked />
        <label class="form-check-label" for=""> Default checkbox </label>
        @error('is_active')
        <span class="fst-italic text-danger">
            {{ $message }}
        </span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="" class="form-label">Image</label>
        <input type="file" class="form-control" name="image" />
    </div>


    <div class="mb-3">
        <button type="submit" class="btn btn-info">submit</button>
    </div>



</form>

@endsection
