<form method="POST" action="{{ route('password.update') }}" class="space-y-5">
    @csrf
    @method('PUT')

    <div>
        <label for="current_password" class="block text-sm font-medium text-etsy-dark mb-2">Password Saat Ini</label>
        <input id="current_password" name="current_password" type="password" autocomplete="current-password"
            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-etsy-orange focus:ring-1 focus:ring-etsy-orange transition">
        @error('current_password', 'updatePassword')
        <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-etsy-dark mb-2">Password Baru</label>
        <input id="password" name="password" type="password" autocomplete="new-password"
            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-etsy-orange focus:ring-1 focus:ring-etsy-orange transition">
        @error('password', 'updatePassword')
        <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-etsy-dark mb-2">Konfirmasi Password Baru</label>
        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-etsy-orange focus:ring-1 focus:ring-etsy-orange transition">
        @error('password_confirmation', 'updatePassword')
        <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center gap-4 pt-2">
        <button type="submit" class="bg-etsy-dark text-white font-bold px-6 py-2.5 rounded-full hover:bg-black transition text-sm">
            Simpan Password
        </button>

        @if (session('status') === 'password-updated')
        <p class="text-sm text-green-600 font-medium">Tersimpan.</p>
        @endif
    </div>
</form>