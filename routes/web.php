<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Http\Controllers\ProductController; 

// Menampilkan form login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Memproses login user
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    // Cari user berdasarkan email
    $user = User::where('email', $credentials['email'])->first();

    // Cek apakah password cocok
    if ($user && password_verify($credentials['password'], $user->password)) {
        // Simpan data user ke session
        session(['user' => $user->only('id', 'name', 'email')]);

        // Arahkan ke dashboard
        return redirect('/dashboard');
    }

    // Gagal login
    return back()->with('error', 'Email atau password salah!');
});

// Halaman dashboard (hanya bisa diakses jika sudah login)
Route::get('/dashboard', function () {
    if (!session()->has('user')) {
        return redirect('/login');
    }

    return view('dashboard');
})->name('dashboard');

// Logout user
Route::post('/logout', function () {
    session()->forget('user');
    return redirect('/login');
})->name('logout');

// Form tambah produk
Route::get('/products/create', function () {
    if (!session()->has('user')) return redirect('/login');
    return view('products.create');
})->name('products.create');

// Simpan produk baru
Route::post('/products', function (Request $request) {
    if (!session()->has('user')) return redirect('/login');

    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0'
    ]);

    \App\Models\Product::create($request->only('name', 'price'));
    return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
})->name('products.store');

// Hapus produk
Route::delete('/products/{id}', function ($id) {
    if (!session()->has('user')) return redirect('/login');

    $product = \App\Models\Product::findOrFail($id);
    $product->delete();
    return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
})->name('products.destroy');

// Tambahkan route untuk menampilkan daftar produk (products.index)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');