@extends('layouts.admin')

@section('title', 'Produk - RumahTanggaKu')
@section('page-title', 'Produk')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<style>
    #productsTable_wrapper .dataTables_length select,
    #productsTable_wrapper .dataTables_filter input {
        border: 1px solid #EAEAEA;
        border-radius: 0.5rem;
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        outline: none;
    }

    #productsTable_wrapper .dataTables_filter input:focus,
    #productsTable_wrapper .dataTables_length select:focus {
        border-color: #F1641E;
    }

    #productsTable_wrapper .dataTables_length,
    #productsTable_wrapper .dataTables_filter,
    #productsTable_wrapper .dataTables_info,
    #productsTable_wrapper .dataTables_paginate {
        font-size: 0.8rem;
        color: #595959;
    }

    #productsTable thead th {
        background-color: #F4F4F4;
        color: #595959;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-weight: 600;
        padding: 0.875rem 1rem !important;
        border-bottom: none !important;
    }

    #productsTable tbody td {
        padding: 0.875rem 1rem;
        font-size: 0.875rem;
        vertical-align: middle;
        border-top: 1px solid #EAEAEA;
    }

    #productsTable.dataTable {
        border-collapse: collapse !important;
    }
</style>
@endpush

@section('content')
<div class="bg-white rounded-xl border border-etsy-border mb-6">
    <div class="p-5 border-b border-etsy-border flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold">Filter Produk</h2>
            <p class="text-sm text-etsy-gray mt-0.5">Gunakan filter ini untuk pencarian spesifik.</p>
        </div>
    </div>
    <div class="p-5">
        <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk..." class="w-full sm:w-1/3 rounded-lg border border-etsy-border px-4 py-2 text-sm focus:ring-1 focus:ring-etsy-orange focus:outline-none">

            <select name="category_id" class="w-full sm:w-1/4 rounded-lg border border-etsy-border px-4 py-2 text-sm focus:ring-1 focus:ring-etsy-orange focus:outline-none bg-white">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>

            <select name="stock" class="w-full sm:w-1/4 rounded-lg border border-etsy-border px-4 py-2 text-sm focus:ring-1 focus:ring-etsy-orange focus:outline-none bg-white">
                <option value="">Semua Stok</option>
                <option value="low" {{ request('stock') == 'low' ? 'selected' : '' }}>Stok Menipis (<= 5)</option>
                <option value="out" {{ request('stock') == 'out' ? 'selected' : '' }}>Stok Habis (0)</option>
            </select>

            <button type="submit" class="bg-etsy-dark text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-black transition">Filter</button>
            <a href="{{ route('admin.products.index') }}" class="px-5 py-2 border border-etsy-border rounded-lg text-sm font-medium text-etsy-dark text-center hover:bg-etsy-light transition">Reset</a>
        </form>
    </div>
</div>

<div class="bg-white rounded-xl border border-etsy-border">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-5 border-b border-etsy-border">
        <div>
            <h2 class="text-lg font-semibold">Daftar Produk</h2>
            <p class="text-sm text-etsy-gray mt-0.5">Kelola katalog produk toko Anda.</p>
        </div>
        <a href="{{ route('admin.products.create') }}"
            class="inline-flex items-center gap-2 bg-etsy-orange text-white text-sm font-medium px-4 py-2.5 rounded-lg hover:bg-etsy-orange/90 transition shrink-0">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Produk</span>
        </a>
    </div>

    <div class="p-5 overflow-x-auto">
        <table id="productsTable" class="w-full text-left">
            <thead>
                <tr>
                    <th class="w-16">Foto</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td>
                        @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded-md border border-etsy-border">
                        @else
                        <div class="w-12 h-12 bg-etsy-light flex items-center justify-center rounded-md border border-etsy-border text-gray-400">
                            <i class="fa-solid fa-image"></i>
                        </div>
                        @endif
                    </td>
                    <td class="font-medium text-etsy-dark">
                        <span class="line-clamp-1">{{ $product->name }}</span>
                    </td>
                    <td class="text-etsy-gray">{{ $product->category->name }}</td>
                    <td class="font-medium">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>
                        <span class="inline-block px-2 py-1 rounded-md text-xs font-bold
                            {{ $product->stock == 0 ? 'bg-red-100 text-red-700' : ($product->stock <= 5 ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.products.show', $product) }}" title="Lihat"
                                class="h-8 w-8 flex items-center justify-center rounded-lg text-etsy-gray hover:bg-etsy-light hover:text-etsy-dark transition">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.products.edit', $product) }}" title="Edit"
                                class="h-8 w-8 flex items-center justify-center rounded-lg text-blue-500 hover:bg-blue-50 transition">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                onsubmit="return confirm('Hapus produk \'{{ $product->name }}\'? Tindakan ini tidak dapat dibatalkan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Hapus"
                                    class="h-8 w-8 flex items-center justify-center rounded-lg text-red-500 hover:bg-red-50 transition">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#productsTable').DataTable({
            paging: false,
            info: false,
            searching: false, // Dimatikan karena kita punya form filter khusus
            columnDefs: [{
                orderable: false,
                targets: [0, 5]
            }],
            order: [
                [1, 'asc']
            ]
        });
    });
</script>
@endpush