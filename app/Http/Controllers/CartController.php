<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart    = session()->get('cart', []);

        if ($request->quantity > $product->stock) {
            return redirect()->back()->with('error', 'Gagal! Kuantitas melebihi sisa stok.');
        }

        if (isset($cart[$request->product_id])) {
            $newQuantity = $cart[$request->product_id]['quantity'] + $request->quantity;

            if ($newQuantity > $product->stock) {
                return redirect()->back()->with('error', 'Total kuantitas di keranjang melebihi stok!');
            }

            $cart[$request->product_id]['quantity'] = $newQuantity;
        } else {
            $cart[$request->product_id] = [
                'name'     => $product->name,
                'quantity' => $request->quantity,
                'price'    => $product->price,
                'category' => $product->category->name,
                'stock'    => $product->stock,
                'image'    => $product->image, // ← tambahan: simpan path gambar ke session
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity'   => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);

        if (!isset($cart[$request->product_id])) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan di keranjang.');
        }

        $maxStock = $cart[$request->product_id]['stock'] ?? null;

        if ($maxStock !== null && $request->quantity > $maxStock) {
            return redirect()->back()->with('error', 'Kuantitas melebihi sisa stok (' . $maxStock . ').');
        }

        $cart[$request->product_id]['quantity'] = $request->quantity;
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Kuantitas produk berhasil diperbarui.');
    }

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
