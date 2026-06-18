@extends('layouts.admin')

@section('title', 'Tambah Produk - RumahTanggaKu')
@section('page-title', 'Tambah Produk')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-xl border border-etsy-border p-6">

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-etsy-dark mb-1.5">Nama Produk</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Contoh: Wajan Teflon Anti Lengket" autofocus
                    class="w-full rounded-lg border @error('name') border-red-400 @else border-etsy-border @enderror px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-etsy-orange/30 focus:border-etsy-orange">
                @error('name')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="category_id" class="block text-sm font-medium text-etsy-dark mb-1.5">Kategori</label>
                    <select name="category_id" id="category_id" class="w-full rounded-lg border @error('category_id') border-red-400 @else border-etsy-border @enderror px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-etsy-orange/30 focus:border-etsy-orange bg-white">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="image" class="block text-sm font-medium text-etsy-dark mb-1.5">Foto Produk <span class="text-xs text-etsy-gray font-normal">(Opsional, max: 2MB)</span></label>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="w-full rounded-lg border @error('image') border-red-400 @else border-etsy-border @enderror px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-etsy-orange/30 focus:border-etsy-orange file:mr-4 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:bg-etsy-light file:text-etsy-dark hover:file:bg-gray-200 cursor-pointer">
                    @error('image')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="price" class="block text-sm font-medium text-etsy-dark mb-1.5">Harga (Rp)</label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" min="0" placeholder="Contoh: 125000"
                        class="w-full rounded-lg border @error('price') border-red-400 @else border-etsy-border @enderror px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-etsy-orange/30 focus:border-etsy-orange">
                    @error('price')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="stock" class="block text-sm font-medium text-etsy-dark mb-1.5">Stok Produk</label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock') }}" min="0" placeholder="Contoh: 15"
                        class="w-full rounded-lg border @error('stock') border-red-400 @else border-etsy-border @enderror px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-etsy-orange/30 focus:border-etsy-orange">
                    @error('stock')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-etsy-dark mb-1.5">Deskripsi Produk</label>
                <textarea name="description" id="description" rows="4" placeholder="Jelaskan detail dan keunggulan produk..."
                    class="w-full rounded-lg border @error('description') border-red-400 @else border-etsy-border @enderror px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-etsy-orange/30 focus:border-etsy-orange">{{ old('description') }}</textarea>
                @error('description')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-etsy-border">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-etsy-orange text-white text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-etsy-orange/90 transition">
                    <i class="fa-solid fa-check"></i>
                    <span>Simpan Produk</span>
                </button>
                <a href="{{ route('admin.products.index') }}"
                    class="inline-flex items-center gap-2 text-etsy-gray text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-etsy-light transition">
                    <span>Batal</span>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection