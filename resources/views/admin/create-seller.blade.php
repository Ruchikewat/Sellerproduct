<!DOCTYPE html>
<html>
<head>
    <title>Create Seller</title>
</head>
<body>
<h2>Create Seller</h2>

@if($errors->any())
    <div style="color:red;">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('admin.seller.create') }}">
    @csrf
    <label>Name:</label><br>
    <input type="text" name="name" value="{{ old('name') }}"><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="{{ old('email') }}"><br><br>

    <label>Mobile:</label><br>
    <input type="text" name="mobile" value="{{ old('mobile') }}"><br><br>

    <label>Country:</label><br>
    <input type="text" name="country" value="{{ old('country','India') }}"><br><br>

    <label>State:</label><br>
    <input type="text" name="state" value="{{ old('state','CG') }}"><br><br>

    <label>Skills (comma separated):</label><br>
    <input type="text" name="skills" value="{{ old('skills','php,laravel') }}"><br><br>

    <label>Password:</label><br>
    <input type="password" name="password"><br><br>

    <button type="submit">Create Seller</button>
</form>
</body>
</html>
