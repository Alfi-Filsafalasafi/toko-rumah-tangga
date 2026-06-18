<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Menampilkan halaman checkout
    public function checkout()
    {
        return view('checkout'); // Kita akan buat view ini nanti
    }

    // Proses menyimpan order ke database
    public function process(Request $request)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        // Upload file
        $fileName = time() . '.' . $request->payment_proof->extension();
        $path = $request->payment_proof->storeAs('payments', $fileName, 'public');

        // Simpan ke tabel orders
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], session('cart'))),
            'payment_proof' => $path,
            'status' => 'menunggu_konfirmasi',
        ]);

        // Simpan detail produk ke order_items
        foreach (session('cart') as $id => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $details['quantity'],
                'price' => $details['price'],
            ]);
        }

        session()->forget('cart'); // Kosongkan keranjang
        return redirect()->route('order.history')->with('success', 'Pesanan berhasil dibuat!');
    }

    // Riwayat pesanan user
    public function history()
    {
        // FIX: tambahkan with('orderItems.product') supaya nama barang per order
        // bisa ditampilkan di view tanpa N+1 query
        $orders = Order::where('user_id', Auth::id())
            ->with('orderItems.product')
            ->latest()
            ->get();

        return view('history', compact('orders'));
    }
}
