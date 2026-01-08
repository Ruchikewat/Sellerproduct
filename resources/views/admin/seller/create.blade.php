@extends('layouts.admin')  {{-- ya jo layout use kar rahe ho --}}

@section('content')
<div class="container">
    <h2>Create Seller</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.seller.create') }}">
        @csrf
        <div class="mb-3">
            <label>Seller Name</label>
            <input type="text" name="seller_name" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>Mobile</label>
            <input type="text" name="mobile" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>Country</label>
            <input type="text" name="country" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>State</label>
            <input type="text" name="state" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>CG (comma separated)</label>
            <input type="text" name="cg" class="form-control">
        </div>
        
        <div class="mb-3">
            <label>Skills (php,laravel)</label>
            <input type="text" name="skills" class="form-control">
        </div>
        
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Create Seller</button>
    </form>
</div>
@endsection
