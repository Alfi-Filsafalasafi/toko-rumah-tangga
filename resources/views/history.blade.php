@extends('layouts.app')

@section('title', 'Riwayat Pesanan - RumahTanggaKu')

@section('content')
<div class="bg-etsy-light min-h-screen py-10">
    <div class="container mx-auto px-4 max-w-4xl">
        <h1 class="text-3xl font-bold text-etsy-dark mb-8">Riwayat Pesanan Saya</h1>

        @if($orders->isEmpty())
        <div class="bg-white p-8 rounded-2xl text-center border border-etsy-border">
            <p class="text-etsy-gray">Belum ada pesanan yang dibuat.</p>
            <a href="{{ route('home') }}" class="text-etsy-orange underline mt-4 block">Mulai Belanja</a>
        </div>
        @else
        <div class="space-y-6">
            @foreach($orders as $order)
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-etsy-border">
                <div class="flex justify-between items-center mb-4 pb-4 border-b border-etsy-border">
                    <div>
                        <p class="text-sm text-etsy-gray">ID Pesanan: #{{ $order->id }}</p>
                        <p class="font-bold text-lg text-etsy-dark">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <!-- Badge Status -->
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase
                                    {{ $order->status == 'menunggu_konfirmasi' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $order->status == 'diproses' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $order->status == 'selesai' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $order->status == 'belum_bayar' ? 'bg-gray-100 text-gray-600' : '' }}
                                    {{ $order->status == 'dibatalkan' ? 'bg-red-100 text-red-600' : '' }}">
                            {{ str_replace('_', ' ', $order->status) }}
                        </span>
                    </div>
                </div>

                <!-- Daftar Barang -->
                <div class="mb-4 pb-4 border-b border-etsy-border">
                    <p class="text-xs font-semibold text-etsy-gray uppercase tracking-wide mb-2">Barang dibeli</p>
                    <ul class="text-sm text-etsy-dark space-y-1">
                        @foreach($order->orderItems as $item)
                        <li class="flex justify-between">
                            <span>{{ $item->product->name ?? 'Produk telah dihapus' }} <span class="text-etsy-gray">x{{ $item->quantity }}</span></span>
                            <span class="text-etsy-gray">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="text-sm">
                    <p class="text-etsy-gray">Tanggal: {{ $order->created_at->format('d M Y, H:i') }}</p>
                    <button type="button" onclick="openModal('proof-{{ $order->id }}')" class="text-etsy-orange underline mt-2 block text-left">Lihat Bukti Transfer</button>
                </div>
            </div>

            @php
            $proofExt = strtolower(pathinfo($order->payment_proof, PATHINFO_EXTENSION));
            $isImage = in_array($proofExt, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
            @endphp

            <div id="proof-{{ $order->id }}" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
                <div class="absolute inset-0 bg-black/50 transition-opacity" onclick="closeModal('proof-{{ $order->id }}')"></div>

                <div class="bg-white rounded-2xl shadow-xl z-10 w-full max-w-2xl overflow-hidden transform transition-transform scale-95" id="proof-content-{{ $order->id }}">
                    <div class="flex justify-between items-center p-4 border-b border-etsy-border">
                        <h3 class="font-bold text-etsy-dark">Bukti Transfer - Pesanan #{{ $order->id }}</h3>
                        <button onclick="closeModal('proof-{{ $order->id }}')" class="text-etsy-dark hover:bg-etsy-light rounded-full p-2 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="p-4 max-h-[75vh] overflow-auto flex items-center justify-center bg-etsy-light">
                        @if($isImage)
                        <img src="{{ asset('storage/' . $order->payment_proof) }}" alt="Bukti Transfer #{{ $order->id }}" class="max-w-full max-h-[70vh] object-contain rounded-lg">
                        @else
                        <iframe src="{{ asset('storage/' . $order->payment_proof) }}" class="w-full h-[70vh] bg-white rounded-lg"></iframe>
                        @endif
                    </div>

                    <div class="p-4 border-t border-etsy-border text-right">
                        <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="text-sm text-etsy-orange underline">Buka di tab baru</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <div class="mt-8">
            <a href="{{ route('home') }}" class="text-etsy-gray hover:text-etsy-dark transition">&larr; Kembali Belanja</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        const content = document.getElementById(modalId.replace('proof-', 'proof-content-'));
        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        }, 10);
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        const content = document.getElementById(modalId.replace('proof-', 'proof-content-'));
        content.classList.remove('scale-100');
        content.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 150);
    }
</script>
@endpush