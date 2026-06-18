@extends('layouts.app')

@section('title', 'Toko Peralatan Rumah Tangga')

@section('content')
<div class="container mx-auto px-4 lg:px-8 pt-10 pb-6">
    @if(request('search'))
    <h1 class="text-3xl font-bold text-etsy-dark mb-2">Hasil pencarian: "{{ request('search') }}"</h1>
    <p class="text-etsy-gray text-sm">{{ $products->count() }} produk ditemukan.</p>
    @else
    <h1 class="text-3xl font-bold text-etsy-dark mb-2">Modern Living Room Furniture</h1>
    <p class="text-etsy-gray text-sm">Temukan perabotan unik dan berkualitas untuk melengkapi hunian Anda.</p>
    @endif
</div>

<div class="container mx-auto px-4 lg:px-8 pb-16">
    @if($products->isEmpty())
    <div class="bg-etsy-light p-10 rounded-2xl text-center">
        <p class="text-etsy-gray">Produk tidak ditemukan untuk pencarian "{{ request('search') }}".</p>
        <a href="{{ route('home') }}" class="text-etsy-orange underline mt-2 inline-block">Lihat semua produk</a>
    </div>
    @else
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-y-10 gap-x-6">
        @foreach($products as $product)
        <div class="group flex flex-col relative cursor-pointer" onclick="openModal('modal-{{ $product->id }}')">
            <div class="relative w-full aspect-square bg-etsy-light rounded-lg overflow-hidden mb-2">
                <span class="absolute top-2 left-2 z-10 bg-white/95 backdrop-blur-sm text-etsy-dark text-[10px] font-bold px-2.5 py-1 rounded-md shadow-sm uppercase tracking-wide">
                    {{ $product->category->name }}
                </span>
                <img
                    src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/no-image.png') }}"
                    alt="{{ $product->name }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                    onerror="this.src='{{ asset('images/no-image.png') }}'">
            </div>

            <div class="flex-1 mt-1">
                <h3 class="text-sm text-etsy-dark font-medium line-clamp-1 group-hover:underline">{{ $product->name }}</h3>
                <p class="text-base font-bold text-etsy-dark mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <p class="text-xs text-etsy-gray mt-1">Sisa stok: {{ $product->stock }}</p>
            </div>
        </div>

        <div id="modal-{{ $product->id }}" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50 transition-opacity" id="backdrop-{{ $product->id }}" onclick="closeModal('modal-{{ $product->id }}')"></div>

            <div class="bg-white rounded-2xl shadow-xl z-10 w-full max-w-4xl overflow-hidden flex flex-col md:flex-row transform transition-transform scale-95" id="modal-content-{{ $product->id }}">
                <div class="md:w-1/2 bg-etsy-light relative min-h-[400px] flex items-center justify-center border-r border-etsy-border overflow-hidden">
                    <img
                        src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/no-image.png') }}"
                        alt="{{ $product->name }}"
                        class="w-full h-full object-cover absolute inset-0"
                        onerror="this.src='{{ asset('images/no-image.png') }}'">
                </div>

                <div class="md:w-1/2 p-8 relative bg-white flex flex-col h-full">
                    <button onclick="closeModal('modal-{{ $product->id }}')" class="absolute top-4 right-4 text-etsy-dark hover:bg-etsy-light rounded-full p-2 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <form action="/cart/add" method="POST" class="flex flex-col h-full">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        {{-- FIX: input ini sebelumnya tidak ada, sehingga updatePriceDisplay() gagal membaca harga satuan --}}
                        <input type="hidden" id="base-price-{{ $product->id }}" value="{{ $product->price }}">

                        <div class="overflow-y-auto pr-2">
                            <span class="text-sm text-etsy-gray font-medium underline mb-2 block">{{ $product->category->name }}</span>
                            <h2 class="text-2xl font-medium text-etsy-dark mb-2">{{ $product->name }}</h2>

                            <p class="text-lg text-etsy-gray mb-1">Harga satuan: Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                            <p class="text-sm text-etsy-gray mb-4">Sisa stok: {{ $product->stock }}</p>

                            <p class="text-sm text-etsy-dark mb-6 leading-relaxed">{{ $product->description }}</p>

                            <div class="mb-6">
                                <label class="block text-sm font-medium text-etsy-dark mb-2">Kuantitas</label>
                                <div class="flex items-center border border-gray-300 rounded-lg w-32 overflow-hidden bg-white">
                                    <button type="button" onclick="decrementQty({{ $product->id }})" class="w-10 h-10 bg-gray-50 hover:bg-gray-100 text-etsy-dark flex items-center justify-center font-bold text-lg transition border-r border-gray-300">-</button>
                                    <input type="number" id="qty-{{ $product->id }}" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-12 h-10 text-center text-sm font-semibold focus:outline-none bg-white" readonly>
                                    <button type="button" onclick="incrementQty({{ $product->id }}, {{ $product->stock }})" class="w-10 h-10 bg-gray-50 hover:bg-gray-100 text-etsy-dark flex items-center justify-center font-bold text-lg transition border-l border-gray-300">+</button>
                                </div>
                            </div>

                            <div class="flex justify-between items-center border-t pt-4 mt-4">
                                <span class="text-sm font-bold text-etsy-dark">Subtotal:</span>
                                <span id="display-price-{{ $product->id }}" class="text-xl font-bold text-etsy-orange">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="mt-auto pt-6 space-y-3">
                            <button type="submit" class="w-full bg-etsy-dark text-white font-bold py-3.5 rounded-full hover:bg-black transition flex items-center justify-center">
                                Add to cart
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        const content = document.getElementById(modalId.replace('modal-', 'modal-content-'));
        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        }, 10);
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        const content = document.getElementById(modalId.replace('modal-', 'modal-content-'));
        content.classList.remove('scale-100');
        content.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            // Reset qty ke 1 dan harga ke harga asli saat modal ditutup
            const productId = modalId.split('-')[1];
            document.getElementById('qty-' + productId).value = 1;
            updatePriceDisplay(productId);
        }, 150);
    }

    // Fungsi Hitung Total Harga Dinamis
    function updatePriceDisplay(productId) {
        const qty = parseInt(document.getElementById('qty-' + productId).value);
        const basePrice = parseInt(document.getElementById('base-price-' + productId).value);
        const total = qty * basePrice;

        // Format angka ke format Rupiah
        const formattedTotal = total.toLocaleString('id-ID');
        document.getElementById('display-price-' + productId).innerText = 'Rp ' + formattedTotal;
    }

    function incrementQty(productId, maxStock) {
        const input = document.getElementById('qty-' + productId);
        let currentValue = parseInt(input.value);
        if (currentValue < maxStock) {
            input.value = currentValue + 1;
            updatePriceDisplay(productId); // Panggil fungsi update!
        } else {
            alert('Maksimal pembelian sesuai dengan sisa stok (' + maxStock + ')');
        }
    }

    function decrementQty(productId) {
        const input = document.getElementById('qty-' + productId);
        let currentValue = parseInt(input.value);
        if (currentValue > 1) {
            input.value = currentValue - 1;
            updatePriceDisplay(productId); // Panggil fungsi update!
        }
    }
</script>
@endpush