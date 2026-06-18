<form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
    @csrf
    @method('PATCH')

    <div>
        <label for="name" class="block text-sm font-medium text-etsy-dark mb-2">Nama Lengkap</label>
        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus
            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-etsy-orange focus:ring-1 focus:ring-etsy-orange transition">
        @error('name')
        <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-etsy-dark mb-2">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-etsy-orange focus:ring-1 focus:ring-etsy-orange transition">
        @error('email')
        <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
        @enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
        <p class="text-xs text-etsy-gray mt-2">
            Email Anda belum terverifikasi.
            <button form="send-verification" class="text-etsy-orange font-semibold underline hover:no-underline">
                Klik untuk kirim ulang email verifikasi.
            </button>
        </p>

        @if (session('status') === 'verification-link-sent')
        <p class="text-xs font-medium text-green-600 mt-2">
            Link verifikasi baru telah dikirim ke email Anda.
        </p>
        @endif
        @endif
    </div>

    <div>
        <label for="phone" class="block text-sm font-medium text-etsy-dark mb-2">Nomor Telepon</label>
        <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx"
            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-etsy-orange focus:ring-1 focus:ring-etsy-orange transition">
        @error('phone')
        <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="address" class="block text-sm font-medium text-etsy-dark mb-2">Alamat</label>
        <textarea id="address" name="address" rows="3" placeholder="Alamat lengkap pengiriman"
            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-etsy-orange focus:ring-1 focus:ring-etsy-orange transition">{{ old('address', $user->address) }}</textarea>
        @error('address')
        <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center gap-4 pt-2">
        <button type="submit" class="bg-etsy-dark text-white font-bold px-6 py-2.5 rounded-full hover:bg-black transition text-sm">
            Simpan
        </button>

        @if (session('status') === 'profile-updated')
        <p class="text-sm text-green-600 font-medium">Tersimpan.</p>
        @endif
    </div>
</form>

@if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
<form id="send-verification" method="POST" action="{{ route('verification.send') }}">
    @csrf
</form>
@endif