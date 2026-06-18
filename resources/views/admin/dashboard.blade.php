@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Ringkasan')

@section('content')
<div class="space-y-6">

    {{-- Statistik Cards --}}
    {{-- Statistik Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
        <!-- Card Total Pelanggan -->
        <div class="bg-white p-6 rounded-xl border border-etsy-border shadow-sm">
            <p class="text-etsy-gray text-sm font-medium">Total Pelanggan</p>
            <h3 class="text-3xl font-bold mt-2 text-blue-600">{{ $stats['total_users'] }}</h3>
        </div>

        <div class="bg-white p-6 rounded-xl border border-etsy-border shadow-sm">
            <p class="text-etsy-gray text-sm font-medium">Total Pesanan</p>
            <h3 class="text-3xl font-bold mt-2">{{ $stats['total_orders'] }}</h3>
        </div>

        <div class="bg-white p-6 rounded-xl border border-etsy-border shadow-sm">
            <p class="text-etsy-gray text-sm font-medium">Total Produk</p>
            <h3 class="text-3xl font-bold mt-2">{{ $stats['total_products'] }}</h3>
        </div>

        <div class="bg-white p-6 rounded-xl border border-etsy-border shadow-sm">
            <p class="text-etsy-gray text-sm font-medium">Pendapatan (Bulan Ini)</p>
            <h3 class="text-2xl font-bold mt-2 text-etsy-orange">Rp {{ number_format($stats['revenue_this_month'], 0, ',', '.') }}</h3>
        </div>

        <div class="bg-white p-6 rounded-xl border border-etsy-border shadow-sm">
            <p class="text-etsy-gray text-sm font-medium">Stok Menipis</p>
            <h3 class="text-3xl font-bold mt-2 text-red-600">{{ $stats['low_stock_products'] }}</h3>
        </div>
    </div>

    {{-- Tabel Pesanan Terbaru --}}
    <div class="bg-white rounded-xl border border-etsy-border shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-etsy-border flex justify-between items-center">
            <h2 class="font-semibold text-lg">Pesanan Terbaru</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-etsy-orange hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-etsy-light text-etsy-gray uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">User</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-etsy-border">
                    @forelse($recent_orders as $order)
                    <tr>
                        <td class="px-6 py-4 font-medium">{{ $order->user->name ?? 'User Tidak Dikenal' }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-[10px] font-bold uppercase bg-gray-100">{{ $order->status }}</span>
                        </td>
                        <td class="px-6 py-4 text-etsy-gray">{{ $order->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-etsy-gray">Tidak ada pesanan terbaru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Produk Stok Rendah --}}
    @if($low_stock_products->count() > 0)
    <div class="bg-white p-6 rounded-xl border border-etsy-border shadow-sm">
        <h2 class="font-semibold text-lg mb-4">Peringatan Stok Rendah</h2>
        <div class="space-y-4">
            @foreach($low_stock_products as $product)
            <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg">
                <div>
                    <p class="font-medium text-sm">{{ $product->name }}</p>
                    <p class="text-[10px] text-red-700 font-bold uppercase">Stok: {{ $product->stock }}</p>
                </div>
                <a href="{{ route('admin.products.edit', $product->id) }}" class="text-xs bg-red-200 text-red-800 px-3 py-1 rounded hover:bg-red-300 transition">Update Stok</a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection