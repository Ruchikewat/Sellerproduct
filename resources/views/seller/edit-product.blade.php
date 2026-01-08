@extends('seller.layout')  {{-- ya admin.layout --}}
@section('content')
<div class="container mt-5">
    <h1>Edit Product</h1>
    <form method="POST" action="{{ route('seller.product.update', $product['id']) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Product Name</label>
            <input type="text" name="product_name" value="{{ $product['product_name'] }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="product_description" class="form-control">{{ $product['product_description'] }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Product</button>
        <a href="{{ route('seller.product.edit', $product['id']) }}" class="btn btn-sm btn-warning">Edit</a>
    <form method="POST" action="{{ route('seller.product.delete', $product['id']) }}" style="display:inline;">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
        <a href="{{ route('seller.products') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
