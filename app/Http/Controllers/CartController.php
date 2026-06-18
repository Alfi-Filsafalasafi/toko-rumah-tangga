<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Fungsi untuk menampilkan halaman keranjang
    public function index()
    {
        // Ambil data keranjang dari session, jika kosong kembalikan array kosong
        $cart = session()->get('cart', []);
        $total = 0;

        // Hitung total harga semua barang di keranjang
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Return ke view cart.blade.php (yang akan kita buat setelah ini)
        return view('cart', compact('cart', 'total'));
    }

    // Fungsi untuk memasukkan barang ke keranjang
    public function add(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        // Cek apakah kuantitas yang diminta melebihi stok database
        if ($request->quantity > $product->stock) {
            return redirect()->back()->with('error', 'Gagal! Kuantitas melebihi sisa stok.');
        }

        // Cek apakah produk sudah ada di keranjang sebelumnya
        if (isset($cart[$request->product_id])) {
            $newQuantity = $cart[$request->product_id]['quantity'] + $request->quantity;

            // Validasi lagi, pastikan gabungan kuantitas lama + baru tidak melebihi stok
            if ($newQuantity > $product->stock) {
                return redirect()->back()->with('error', 'Total kuantitas di keranjang melebihi stok!');
            }

            $cart[$request->product_id]['quantity'] = $newQuantity;
        } else {
            // Jika belum ada, buat item baru di array cart
            $cart[$request->product_id] = [
                "name" => $product->name,
                "quantity" => $request->quantity,
                "price" => $product->price,
                "category" => $product->category->name,
                "stock" => $product->stock // Menyimpan info stok untuk validasi di halaman cart nanti
            ];
        }

        // Simpan kembali array ke session
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // Fungsi untuk mengubah kuantitas barang di keranjang
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);

        if (!isset($cart[$request->product_id])) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan di keranjang.');
        }

        // Validasi kuantitas baru tidak melebihi stok yang tersimpan di item cart
        $maxStock = $cart[$request->product_id]['stock'] ?? null;

        if ($maxStock !== null && $request->quantity > $maxStock) {
            return redirect()->back()->with('error', 'Kuantitas melebihi sisa stok (' . $maxStock . ').');
        }

        $cart[$request->product_id]['quantity'] = $request->quantity;
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Kuantitas produk berhasil diperbarui.');
    }

    // Fungsi untuk menghapus barang dari keranjang
    public function remove(Request $request)
    {
        if ($request->product_id) {
            $cart = session()->get('cart');

            if (isset($cart[$request->product_id])) {
                unset($cart[$request->product_id]);
                session()->put('cart', $cart);
            }

            return redirect()->back()->with('success', 'Produk dihapus dari keranjang.');
        }
    }
}
