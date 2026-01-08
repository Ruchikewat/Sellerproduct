@extends('admin.layout')
@section('content')
<div class="container mt-5">
    <h1>Admin Dashboard</h1>
    <div class="row mt-4">
        <div class="col-md-6">
            <a href="{{ route('admin.seller.create.form') }}" class="btn btn-primary btn-lg mb-3">Create Seller</a>
            <a href="{{ route('admin.sellers') }}" class="btn btn-success btn-lg mb-3">Sellers List</a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('seller.login') }}" class="btn btn-info btn-lg mb-3">Seller Login Panel</a>
        </div>
    </div>
</div>
@endsection
