@extends('layouts.admin')

@section('title', 'Tambah Pelanggan - RumahTanggaKu')
@section('page-title', 'Tambah Pelanggan')

@section('content')
<div class="max-w-xl">
    <div class="bg-white rounded-xl border border-etsy-border p-6">

        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-etsy-dark mb-1.5">
                    Nama Lengkap
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    placeholder="Masukkan nama lengkap" autofocus
                    class="w-full rounded-lg border @error('name') border-red-400 @else border-etsy-border @enderror px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-etsy-orange/30 focus:border-etsy-orange">
                @error('name')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-etsy-dark mb-1.5">
                    Alamat Email
                </label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    placeholder="contoh@email.com"
                    class="w-full rounded-lg border @error('email') border-red-400 @else border-etsy-border @enderror px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-etsy-orange/30 focus:border-etsy-orange">
                @error('email')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-etsy-dark mb-1.5">
                    Password
                </label>
                <input type="password" name="password" id="password"
                    placeholder="Minimal 8 karakter"
                    class="w-full rounded-lg border @error('password') border-red-400 @else border-etsy-border @enderror px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-etsy-orange/30 focus:border-etsy-orange">
                @error('password')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-etsy-dark mb-1.5">
                    Konfirmasi Password
                </label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    placeholder="Ulangi password"
                    class="w-full rounded-lg border border-etsy-border px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-etsy-orange/30 focus:border-etsy-orange">
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-etsy-orange text-white text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-etsy-orange/90 transition">
                    <i class="fa-solid fa-check"></i>
                    <span>Simpan</span>
                </button>
                <a href="{{ route('admin.users.index') }}"
                    class="inline-flex items-center gap-2 text-etsy-gray text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-etsy-light transition">
                    <span>Batal</span>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection