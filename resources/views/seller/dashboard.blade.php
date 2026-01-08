@extends('seller.layout')
@section('content')
<div class="container mt-5">
    <h1>Seller Dashboard</h1>
    <div class="row">
        <div class="col-md-4">
            <a href="{{ route('seller.add-product') }}" class="btn btn-primary btn-lg w-100 mb-3">Add Product</a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('seller.products') }}" class="btn btn-success btn-lg w-100 mb-3">My Products</a>
        </div>
        <div class="col-md-4">
            <form method="POST" action="{{ route('seller.logout') }}" class="w-100">
                @csrf
                <button type="submit" class="btn btn-danger btn-lg w-100">Logout</button>
            </form>
        </div>
    </div>
</div>
@endsection
