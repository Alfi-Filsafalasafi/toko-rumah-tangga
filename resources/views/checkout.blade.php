@extends('layouts.app')

@section('title', 'Checkout - RumahTanggaKu')

@section('content')
<div class="bg-etsy-light min-h-screen py-10">
    <div class="container mx-auto px-4 max-w-2xl">
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-etsy-border">
            <h1 class="text-2xl font-bold text-etsy-dark mb-6">Checkout Pesanan</h1>

            <!-- Ringkasan Total -->
            <div class="bg-etsy-light p-4 rounded-lg mb-6">
                <p class="text-sm text-etsy-gray">Total yang harus dibayar:</p>
                <p class="text-2xl font-bold text-etsy-orange">Rp {{ number_format(array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], session('cart', []))), 0, ',', '.') }}</p>
            </div>

            <!-- Form Checkout -->
            <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-6">
                    <label class="block text-sm font-medium text-etsy-dark mb-2">Upload Bukti Transfer (JPG, PNG, PDF)</label>
                    <input type="file" name="payment_proof" accept="image/*,application/pdf" required
                        class="w-full text-sm text-etsy-gray file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-etsy-orange hover:file:bg-orange-100">
                </div>

                <div class="mt-8">
                    <button type="submit" class="w-full bg-etsy-dark text-white py-3 rounded-full font-bold hover:bg-black transition">
                        Konfirmasi Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection