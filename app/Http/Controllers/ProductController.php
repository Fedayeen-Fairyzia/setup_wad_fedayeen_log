<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Tampilkan semua products
    public function index()
    {
        // Ambil semua data dari tabel products
        $products = Product::orderBy('created_at', 'desc')->get();
        // Kirim ke view resources/views/products/index.blade.php
        return view('products.index', compact('products'));
    }
}
