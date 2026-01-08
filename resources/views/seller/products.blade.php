@extends('seller.layout')
@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between mb-4">
        <h2>My Products</h2>
        <a href="{{ route('seller.add-product') }}" class="btn btn-primary">Add Product</a>
    </div>
    <table class="table">
        <thead>
            <tr><th>ID</th><th>Name</th><th>Description</th><th>Brands Count</th><th>Total Price</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse($products['data'] ?? [] as $product)
            <tr>
                <td>{{ $product['id'] }}</td>
                <td>{{ $product['name'] }}</td>
                <td>{{ Str::limit($product['description'], 50) }}</td>
                <td>{{ count($product['brands'] ?? []) }}</td>
                <td>₹{{ array_sum(array_column($product['brands'] ?? [], 'price')) }}</td>
                <td>
                    <a href="#" class="btn btn-sm btn-info">View PDF</a>
                    <a href="#" class="btn btn-sm btn-warning">Edit</a>
                    <a href="#" class="btn btn-sm btn-danger">Delete</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center">No products found</td></tr>
            @endforelse
        </tbody>
    </table>
    {!! $products['links'] ?? '' !!}
</div>
@endsection
