@extends('seller.layout') {{-- ya admin.layout --}}
@section('content')
<div class="container mt-5">
    <h2>Add Product</h2>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first('form') }}</div>
    @endif
    <form method="POST" action="{{ route('seller.add-product') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Product Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        
        <h5>Brands (Add multiple)</h5>
        <div id="brands-container">
            <div class="brand-row row mb-3 border p-3">
                <div class="col-md-3">
                    <input type="text" name="brands[0][name]" placeholder="Brand Name" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="brands[0][detail]" placeholder="Detail" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <input type="file" name="brands[0][image]" class="form-control" accept="image/*" required>
                </div>
                <div class="col-md-2">
                    <input type="number" name="brands[0][price]" placeholder="Price" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-brand">Remove</button>
                </div>
            </div>
        </div>
        <button type="button" id="add-brand" class="btn btn-secondary mb-3">Add Brand</button>
        <button type="submit" class="btn btn-primary">Add Product</button>
    </form>
</div>

<script>
let brandIndex = 1;
document.getElementById('add-brand').onclick = () => {
    document.getElementById('brands-container').innerHTML += `
        <div class="brand-row row mb-3 border p-3">
            <div class="col-md-3"><input type="text" name="brands[${brandIndex}][name]" class="form-control" required></div>
            <div class="col-md-3"><input type="text" name="brands[${brandIndex}][detail]" class="form-control" required></div>
            <div class="col-md-2"><input type="file" name="brands[${brandIndex}][image]" class="form-control" accept="image/*" required></div>
            <div class="col-md-2"><input type="number" name="brands[${brandIndex}][price]" class="form-control" required></div>
            <div class="col-md-2"><button type="button" class="btn btn-danger remove-brand">Remove</button></div>
        </div>`;
    brandIndex++;
};
document.addEventListener('click', e => {
    if(e.target.classList.contains('remove-brand')) e.target.closest('.brand-row').remove();
});
</script>
@endsection
