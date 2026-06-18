@extends('layouts.app')

@section('title', 'Keranjang Belanja - RumahTanggaKu')

@section('content')
<div class="container mx-auto px-4 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-etsy-dark mb-8">Keranjang Belanja Anda</h1>

    @if(session('cart'))
    <div class="grid md:grid-cols-3 gap-12">
        <div class="md:col-span-2 space-y-6">
            @foreach(session('cart') as $id => $details)
            <div class="flex gap-4 border-b border-etsy-border pb-6">
                <div class="w-24 h-24 bg-etsy-light rounded-lg overflow-hidden shrink-0">
                    <img
                        src="{{ $details['image'] ? asset('storage/' . $details['image']) : asset('images/no-image.png') }}"
                        alt="{{ $details['name'] }}"
                        class="w-full h-full object-cover"
                        onerror="this.src='{{ asset('images/no-image.png') }}'">
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-etsy-dark">{{ $details['name'] }}</h3>
                    <p class="text-sm text-etsy-gray">{{ $details['category'] }}</p>
                    <p class="text-sm text-etsy-gray mt-1">Rp {{ number_format($details['price'], 0, ',', '.') }} / pcs</p>

                    <div class="flex items-center justify-between mt-3 flex-wrap gap-3">
                        {{-- Form edit qty: submit otomatis ke route cart.update saat tombol +/- ditekan atau input diubah --}}
                        <form action="{{ route('cart.update') }}" method="POST" class="flex items-center border border-gray-300 rounded-lg overflow-hidden w-fit">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $id }}">
                            <button type="button" onclick="decrementCartQty('{{ $id }}')" class="w-9 h-9 bg-gray-50 hover:bg-gray-100 text-etsy-dark flex items-center justify-center font-bold transition border-r border-gray-300">-</button>
                            <input type="number" id="cart-qty-{{ $id }}" name="quantity" value="{{ $details['quantity'] }}" min="1" class="w-12 h-9 text-center text-sm font-semibold focus:outline-none" onchange="this.form.submit()">
                            <button type="button" onclick="incrementCartQty('{{ $id }}')" class="w-9 h-9 bg-gray-50 hover:bg-gray-100 text-etsy-dark flex items-center justify-center font-bold transition border-l border-gray-300">+</button>
                        </form>

                        <p class="font-bold text-etsy-orange">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</p>
                    </div>
                </div>
                <form action="{{ route('cart.remove') }}" method="POST" class="shrink-0">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $id }}">
                    <button type="submit" class="text-red-500 text-sm hover:underline">Hapus</button>
                </form>
            </div>
            @endforeach
        </div>

        <div class="bg-etsy-light p-6 rounded-2xl h-fit">
            <h2 class="text-xl font-bold text-etsy-dark mb-4">Ringkasan Pesanan</h2>
            <div class="flex justify-between mb-4">
                <span class="text-etsy-gray">Total Harga</span>
                <span class="font-bold text-etsy-dark">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            <a href="{{ route('checkout') }}" class="block w-full bg-etsy-dark text-white text-center py-3 rounded-full font-bold hover:bg-black transition">
                Lanjut ke Pembayaran
            </a>
        </div>
    </div>
    @else
    <p class="text-etsy-gray">Keranjang Anda masih kosong. <a href="{{ route('home') }}" class="text-etsy-orange underline">Belanja sekarang</a></p>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function incrementCartQty(id) {
        const input = document.getElementById('cart-qty-' + id);
        input.value = parseInt(input.value) + 1;
        input.form.submit();
    }

    function decrementCartQty(id) {
        const input = document.getElementById('cart-qty-' + id);
        const current = parseInt(input.value);
        if (current > 1) {
            input.value = current - 1;
            input.form.submit();
        }
    }
</script>
@endpush