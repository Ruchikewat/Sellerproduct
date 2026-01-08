<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
</head>
<body>
<h2>Admin Login</h2>

@if($errors->any())
    <div style="color:red;">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('admin.login') }}">
    @csrf
    <label>Email:</label><br>
    <input type="email" name="email" value="{{ old('email','admin@test.com') }}"><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" value="password"><br><br>

    <button type="submit">Login</button>
</form>
</body>
</html>
