@extends('layouts.app')

@section('title', 'Edit Profile - RumahTanggaKu')

@section('content')
<div class="bg-etsy-light min-h-screen py-10">
    <div class="container mx-auto px-4 max-w-5xl">
        <h1 class="text-2xl font-bold text-etsy-dark mb-6">Edit Profile</h1>

        @if (session('status') === 'profile-updated')
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 text-sm font-medium px-4 py-3 rounded-lg">
            Profil berhasil diperbarui.
        </div>
        @endif

        @if (session('status') === 'password-updated')
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 text-sm font-medium px-4 py-3 rounded-lg">
            Password berhasil diperbarui.
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
            <!-- Update Informasi Profil -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-etsy-border">
                <h2 class="text-lg font-bold text-etsy-dark mb-1">Informasi Profil</h2>
                <p class="text-sm text-etsy-gray mb-6">Perbarui data akun dan informasi kontak Anda.</p>

                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Update Password -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-etsy-border">
                <h2 class="text-lg font-bold text-etsy-dark mb-1">Ubah Password</h2>
                <p class="text-sm text-etsy-gray mb-6">Pastikan akun Anda menggunakan password yang kuat dan tidak digunakan di tempat lain.</p>

                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>
</div>
@endsection