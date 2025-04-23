<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">

    <div class="container">
        <h2 class="mb-4">Selamat datang, {{ session('user.name') }}</h2>

        <!-- Tombol ke halaman produk -->
        <a href="{{ route('products.index') }}" class="btn btn-primary mb-3">Lihat Data Produk</a>

        <!-- Tombol logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>

</body>
</html>
