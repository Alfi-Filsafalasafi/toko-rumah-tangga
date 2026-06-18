@extends('layouts.admin')

@section('title', 'Edit Kategori - RumahTanggaKu')
@section('page-title', 'Edit Kategori')

@section('content')
<div class="max-w-xl">
    <div class="bg-white rounded-xl border border-etsy-border p-6">

        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-etsy-dark mb-1.5">
                    Nama Kategori
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                    placeholder="Contoh: Peralatan Dapur" autofocus
                    class="w-full rounded-lg border @error('name') border-red-400 @else border-etsy-border @enderror px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-etsy-orange/30 focus:border-etsy-orange">
                @error('name')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
                <p class="mt-1.5 text-xs text-etsy-gray">
                    Slug saat ini:
                    <span class="font-medium text-etsy-dark">{{ $category->slug }}</span>
                    — akan diperbarui otomatis jika nama diubah.
                </p>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-etsy-orange text-white text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-etsy-orange/90 transition">
                    <i class="fa-solid fa-check"></i>
                    <span>Simpan Perubahan</span>
                </button>
                <a href="{{ route('admin.categories.index') }}"
                    class="inline-flex items-center gap-2 text-etsy-gray text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-etsy-light transition">
                    <span>Batal</span>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
