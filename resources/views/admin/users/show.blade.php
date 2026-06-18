@extends('layouts.admin')

@section('title', 'Detail Pelanggan - RumahTanggaKu')
@section('page-title', 'Detail Pelanggan')

@section('content')
<div class="space-y-6">

    <!-- Kartu Informasi Pelanggan -->
    <div class="bg-white rounded-xl border border-etsy-border p-6 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-6">
        <div class="w-full">
            <p class="text-xs text-etsy-gray uppercase tracking-wide mb-1">Profil Pelanggan</p>
            <div class="flex items-center gap-3 mb-4">
                <h2 class="text-2xl font-semibold text-etsy-dark">{{ $user->name }}</h2>
                <!-- Badge Role -->
                <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider
                    {{ $user->role === 'admin' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-etsy-gray' }}">
                    {{ $user->role }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2 border-t border-etsy-border/50">
                <!-- Kolom 1: Info Kontak & Akun -->
                <div class="space-y-3 text-sm text-etsy-gray">
                    <p class="flex items-center gap-2.5">
                        <i class="fa-solid fa-envelope w-4 text-center text-gray-400"></i>
                        <span class="text-etsy-dark">{{ $user->email }}</span>
                    </p>
                    <p class="flex items-center gap-2.5">
                        <i class="fa-solid fa-phone w-4 text-center text-gray-400"></i>
                        <span class="{{ $user->phone ? 'text-etsy-dark' : 'italic text-gray-400' }}">
                            {{ $user->phone ?? 'Nomor telepon belum ditambahkan' }}
                        </span>
                    </p>
                    <p class="flex items-center gap-2.5">
                        <i class="fa-solid fa-calendar w-4 text-center text-gray-400"></i>
                        <span>Terdaftar pada {{ $user->created_at->format('d M Y') }}</span>
                    </p>
                    <p class="flex items-center gap-2.5 text-etsy-orange font-medium mt-2">
                        <i class="fa-solid fa-wallet w-4 text-center"></i>
                        Total Belanja: Rp {{ number_format($total_spent, 0, ',', '.') }}
                    </p>
                </div>

                <!-- Kolom 2: Info Alamat -->
                <div class="text-sm text-etsy-gray">
                    <p class="flex items-start gap-2.5">
                        <i class="fa-solid fa-location-dot w-4 text-center text-gray-400 mt-1"></i>
                        <span class="flex-1 leading-relaxed {{ $user->address ? 'text-etsy-dark' : 'italic text-gray-400' }}">
                            {!! nl2br(e($user->address ?? 'Alamat pengiriman belum ditambahkan.')) !!}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex items-center gap-2 shrink-0 sm:pt-6">
            <a href="{{ route('admin.users.edit', $user) }}"
                class="inline-flex items-center gap-2 border border-etsy-border text-etsy-dark text-sm font-medium px-4 py-2.5 rounded-lg hover:bg-etsy-light transition">
                <i class="fa-solid fa-pen"></i>
                <span>Edit</span>
            </a>
            <a href="{{ route('admin.users.index') }}"
                class="inline-flex items-center gap-2 text-etsy-gray text-sm font-medium px-4 py-2.5 rounded-lg hover:bg-etsy-light transition">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Kartu Pesanan Terbaru -->
    <div class="bg-white rounded-xl border border-etsy-border">
        <div class="p-5 border-b border-etsy-border flex justify-between items-center">
            <h3 class="font-semibold text-etsy-dark">Pesanan Terbaru ({{ $user->orders_count }} total pesanan)</h3>
            <a href="{{ route('admin.orders.index', ['search' => $user->email]) }}" class="text-sm text-etsy-orange hover:underline">Lihat Semua Pesanan</a>
        </div>

        @if ($user->orders->isEmpty())
        <div class="p-10 text-center text-etsy-gray">
            <i class="fa-solid fa-receipt text-3xl mb-3 opacity-40"></i>
            <p class="text-sm">Belum ada pesanan dari pelanggan ini.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-etsy-light text-etsy-gray text-xs uppercase tracking-wide">
                        <th class="px-5 py-3">ID Pesanan</th>
                        <th class="px-5 py-3">Total Harga</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Tanggal Pesan</th>
                        <th class="px-5 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-etsy-border">
                    @foreach ($user->orders as $order)
                    <tr>
                        <td class="px-5 py-3 font-medium text-etsy-dark">#{{ $order->id }}</td>
                        <td class="px-5 py-3">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-1 rounded text-[10px] font-bold uppercase bg-gray-100">
                                {{ str_replace('_', ' ', $order->status) }}
                            </span>
                        </td>
                        <td class="px-5 py-3">{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-5 py-3 text-center">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-500 hover:text-blue-700 transition" title="Lihat Pesanan">
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection