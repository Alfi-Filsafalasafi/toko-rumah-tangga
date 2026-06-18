<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil semua produk terbaru beserta relasi kategorinya
        $query = Product::with('category')->latest();

        // Filter berdasarkan kata kunci pencarian dari navbar, kalau ada
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->get();

        return view('home', compact('products'));
    }
}
