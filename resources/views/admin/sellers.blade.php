@extends('admin.layout')
@section('content')
<div class="container mt-5">
    <h1>Sellers List</h1>
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sellers as $seller)
            <tr>
                <td>{{ $seller['id'] }}</td>
                <td>{{ $seller['seller_name'] }}</td>
                <td>{{ $seller['email'] }}</td>
                <td>{{ $seller['mobile'] }}</td>
                <td>
                    <a href="#" class="btn btn-sm btn-warning">Edit</a>
                    <a href="#" class="btn btn-sm btn-danger">Delete</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center">No sellers found</td></tr>
            @endforelse
        </tbody>
    </table>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
</div>
@endsection
