@extends('layouts.admin')

@section('title', 'Detail Kategori - RumahTanggaKu')
@section('page-title', 'Detail Kategori')

@section('content')
<div class="space-y-6">

    <div class="bg-white rounded-xl border border-etsy-border p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-xs text-etsy-gray uppercase tracking-wide mb-1">Kategori</p>
            <h2 class="text-xl font-semibold text-etsy-dark">{{ $category->name }}</h2>
            <div class="flex items-center gap-4 mt-2 text-sm text-etsy-gray">
                <span class="inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-link text-xs"></i> {{ $category->slug }}
                </span>
                <span class="inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-box-open text-xs"></i> {{ $products->total() }} produk
                </span>
            </div>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('admin.categories.edit', $category) }}"
                class="inline-flex items-center gap-2 border border-etsy-border text-etsy-dark text-sm font-medium px-4 py-2.5 rounded-lg hover:bg-etsy-light transition">
                <i class="fa-solid fa-pen"></i>
                <span>Edit</span>
            </a>
            <a href="{{ route('admin.categories.index') }}"
                class="inline-flex items-center gap-2 text-etsy-gray text-sm font-medium px-4 py-2.5 rounded-lg hover:bg-etsy-light transition">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-etsy-border">
        <div class="p-5 border-b border-etsy-border">
            <h3 class="font-semibold text-etsy-dark">Produk dalam Kategori Ini</h3>
        </div>

        @if ($products->isEmpty())
        <div class="p-10 text-center text-etsy-gray">
            <i class="fa-solid fa-box-open text-3xl mb-3 opacity-40"></i>
            <p class="text-sm">Belum ada produk di kategori ini.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-etsy-light text-etsy-gray text-xs uppercase tracking-wide">
                        <th class="px-5 py-3">Produk</th>
                        <th class="px-5 py-3">Harga</th>
                        <th class="px-5 py-3">Stok</th>
                        <th class="px-5 py-3">Ditambahkan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-etsy-border">
                    @foreach ($products as $product)
                    <tr>
                        <td class="px-5 py-3 font-medium text-etsy-dark">{{ $product->name }}</td>
                        <td class="px-5 py-3">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="px-5 py-3">{{ $product->stock }}</td>
                        <td class="px-5 py-3">{{ $product->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-5 border-t border-etsy-border">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>
@endsection