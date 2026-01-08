<!DOCTYPE html>
<html>
<head>
    <title>Seller Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('seller.dashboard') }}">Seller Panel</a>
        </div>
    </nav>
    @yield('content')
</body>
</html>
