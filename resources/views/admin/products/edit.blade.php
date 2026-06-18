@extends('layouts.admin')

@section('title', 'Edit Produk - RumahTanggaKu')
@section('page-title', 'Edit Produk')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-xl border border-etsy-border p-6">

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-etsy-dark mb-1.5">Nama Produk</label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                    class="w-full rounded-lg border @error('name') border-red-400 @else border-etsy-border @enderror px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-etsy-orange/30 focus:border-etsy-orange">
                @error('name')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="category_id" class="block text-sm font-medium text-etsy-dark mb-1.5">Kategori</label>
                    <select name="category_id" id="category_id" class="w-full rounded-lg border border-etsy-border px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-etsy-orange/30 focus:border-etsy-orange bg-white">
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <div class="min-w-0">
                        <label class="block text-sm font-medium text-etsy-dark mb-1.5">Foto Produk Saat Ini</label>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 w-full">
                            <div class="w-16 h-16 bg-etsy-light rounded-lg overflow-hidden shrink-0">
                                <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/no-image.png') }}" alt="{{ $product->name }}" class="w-full h-full object-cover" onerror="this.src='{{ asset('images/no-image.png') }}'">
                            </div>

                            <div class="w-full flex-1 min-w-0">
                                <input type="file" name="image" id="image" accept="image/*"
                                    class="w-full rounded-lg border border-etsy-border px-3 py-2 text-sm focus:outline-none file:mr-3 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:bg-etsy-light file:text-etsy-dark hover:file:bg-gray-200 cursor-pointer overflow-hidden text-ellipsis">
                            </div>
                        </div>
                        <p class="mt-1.5 text-xs text-etsy-gray">Abaikan kolom file jika tidak ingin mengubah foto.</p>
                        @error('image')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="price" class="block text-sm font-medium text-etsy-dark mb-1.5">Harga (Rp)</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" min="0"
                        class="w-full rounded-lg border @error('price') border-red-400 @else border-etsy-border @enderror px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-etsy-orange/30 focus:border-etsy-orange">
                    @error('price')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="stock" class="block text-sm font-medium text-etsy-dark mb-1.5">Stok Produk</label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" min="0"
                        class="w-full rounded-lg border @error('stock') border-red-400 @else border-etsy-border @enderror px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-etsy-orange/30 focus:border-etsy-orange">
                    @error('stock')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-etsy-dark mb-1.5">Deskripsi Produk</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full rounded-lg border @error('description') border-red-400 @else border-etsy-border @enderror px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-etsy-orange/30 focus:border-etsy-orange">{{ old('description', $product->description) }}</textarea>
                @error('description')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-etsy-border">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-etsy-orange text-white text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-etsy-orange/90 transition">
                    <i class="fa-solid fa-check"></i>
                    <span>Simpan Perubahan</span>
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