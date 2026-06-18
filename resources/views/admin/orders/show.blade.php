@extends('layouts.admin')

@section('title', 'Detail Pesanan - RumahTanggaKu')
@section('page-title', 'Detail Pesanan #' . $order->id)

@section('content')
@php
$statusLabels = [
'belum_bayar' => 'Belum Bayar',
'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
'diproses' => 'Diproses',
'selesai' => 'Selesai',
'dibatalkan' => 'Dibatalkan',
];
@endphp

<div class="mb-6">
    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-etsy-gray hover:text-etsy-orange transition">
        <i class="fa-solid fa-arrow-left"></i>
        <span>Kembali ke Daftar Pesanan</span>
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <div class="lg:col-span-2 space-y-6">

        <div class="bg-white rounded-xl border border-etsy-border p-6">
            <h3 class="font-semibold text-etsy-dark border-b border-etsy-border pb-3 mb-4">Informasi Pelanggan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-etsy-gray mb-1">Nama Lengkap</p>
                    <p class="font-medium text-etsy-dark">{{ $order->user->name ?? 'User Terhapus' }}</p>
                </div>
                <div>
                    <p class="text-xs text-etsy-gray mb-1">Email</p>
                    <p class="font-medium text-etsy-dark">{{ $order->user->email ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-etsy-gray mb-1">No. Handphone</p>
                    <p class="font-medium text-etsy-dark">{{ $order->user->phone ?? 'Belum diatur' }}</p>
                </div>
                <div>
                    <p class="text-xs text-etsy-gray mb-1">Alamat Pengiriman</p>
                    <p class="font-medium text-etsy-dark text-sm leading-relaxed">
                        {!! nl2br(e($order->user->address ?? 'Belum diatur')) !!}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-etsy-border overflow-hidden">
            <h3 class="font-semibold text-etsy-dark p-6 border-b border-etsy-border">Item Pesanan</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-etsy-light text-etsy-gray text-xs uppercase">
                        <tr>
                            <th class="px-6 py-3">Produk</th>
                            <th class="px-6 py-3 text-center">Harga</th>
                            <th class="px-6 py-3 text-center">Qty</th>
                            <th class="px-6 py-3 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-etsy-border">
                        @foreach($order->orderItems as $item)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-etsy-light rounded-lg overflow-hidden shrink-0">
                                        <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : asset('images/no-image.png') }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover" onerror="this.src='{{ asset('images/no-image.png') }}'">
                                    </div>
                                    <div>
                                        <p class="font-medium text-etsy-dark">{{ $item->product->name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center font-bold">{{ $item->quantity }}</td>
                            <td class="px-6 py-4 text-right font-medium text-etsy-dark">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 border-t border-etsy-border">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right font-bold text-etsy-dark uppercase text-xs tracking-wider">Total Pembayaran</td>
                            <td class="px-6 py-4 text-right font-bold text-lg text-etsy-orange">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="space-y-6">

        <div class="bg-white rounded-xl border border-etsy-border p-6 shadow-sm">
            <h3 class="font-semibold text-etsy-dark mb-4">Status Pesanan</h3>

            @php
            $badgeColor = match($order->status) {
            'belum_bayar' => 'bg-gray-100 text-gray-700',
            'menunggu_konfirmasi' => 'bg-yellow-100 text-yellow-700',
            'diproses' => 'bg-blue-100 text-blue-700',
            'selesai' => 'bg-green-100 text-green-700',
            'dibatalkan' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-700'
            };
            @endphp
            <div class="mb-5 flex items-center justify-between bg-gray-50 p-3 rounded-lg border border-etsy-border">
                <span class="text-xs font-medium text-etsy-gray">Status Saat Ini:</span>
                <span class="px-3 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider {{ $badgeColor }}">
                    {{ $statusLabels[$order->status] }}
                </span>
            </div>

            @if(!in_array($order->status, ['selesai', 'dibatalkan']))
            <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                @csrf
                @method('PUT')
                <label class="block text-xs font-medium text-etsy-dark mb-2">Ubah Status</label>
                <select name="status" class="w-full rounded-lg border border-etsy-border px-4 py-2.5 text-sm focus:ring-1 focus:ring-etsy-orange focus:outline-none mb-3">
                    @foreach($statuses as $status)
                    <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>
                        {{ $statusLabels[$status] }}
                    </option>
                    @endforeach
                </select>
                <button type="submit" class="w-full bg-etsy-dark text-white font-medium py-2.5 rounded-lg text-sm hover:bg-black transition">
                    Update Status
                </button>
            </form>
            @else
            <div class="bg-red-50 text-red-600 text-xs p-3 rounded-lg text-center border border-red-100">
                Pesanan yang sudah <strong>{{ strtoupper($statusLabels[$order->status]) }}</strong> tidak dapat diubah lagi.
            </div>
            @endif
        </div>

        <div class="bg-white rounded-xl border border-etsy-border p-6">
            <h3 class="font-semibold text-etsy-dark mb-4 border-b border-etsy-border pb-3">Bukti Pembayaran</h3>

            @if($order->payment_proof)
            <p class="text-xs text-etsy-gray mb-3">Dilampirkan pada: {{ $order->created_at->format('d M Y, H:i') }}</p>
            <div class="w-full aspect-auto bg-gray-50 rounded-lg border border-etsy-border overflow-hidden flex items-center justify-center p-2">
                @if(Str::endsWith($order->payment_proof, '.pdf'))
                <div class="text-center py-8">
                    <i class="fa-solid fa-file-pdf text-4xl text-red-500 mb-2"></i>
                    <p class="text-sm text-etsy-dark font-medium">Dokumen PDF</p>
                </div>
                @else
                <img src="{{ asset('storage/' . $order->payment_proof) }}" class="w-full h-auto rounded cursor-pointer hover:opacity-90 transition" alt="Bukti Pembayaran" onclick="window.open(this.src, '_blank')">
                @endif
            </div>
            <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="mt-4 w-full flex items-center justify-center gap-2 bg-etsy-light text-etsy-dark border border-etsy-border font-medium py-2 rounded-lg text-sm hover:bg-gray-100 transition">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat Ukuran Penuh
            </a>
            @else
            <div class="py-8 text-center text-etsy-gray border-2 border-dashed border-etsy-border rounded-lg">
                <i class="fa-solid fa-receipt text-3xl mb-2 opacity-30"></i>
                <p class="text-sm">Bukti pembayaran belum diunggah.</p>
            </div>
            @endif
        </div>

    </div>
</div>
@endsection