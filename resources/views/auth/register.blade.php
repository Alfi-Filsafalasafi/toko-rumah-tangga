<x-guest-layout>
    @section('title', 'Daftar - RumahTanggaKu')

    <div class="w-full max-w-md">

        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-etsy-dark">Buat akun baru</h1>
            <p class="text-etsy-gray text-sm mt-1">Bergabung dan mulai belanja di RumahTanggaKu</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-etsy-border p-8">
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                {{-- Nama --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-etsy-dark mb-1.5">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                        class="w-full border-2 rounded-xl py-2.5 px-4 text-sm focus:outline-none transition
                               {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-etsy-border focus:border-etsy-dark' }}">
                    @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-etsy-dark mb-1.5">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                        class="w-full border-2 rounded-xl py-2.5 px-4 text-sm focus:outline-none transition
                               {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-etsy-border focus:border-etsy-dark' }}">
                    @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- No. HP --}}
                <div>
                    <label for="phone" class="block text-sm font-medium text-etsy-dark mb-1.5">
                        No. HP <span class="text-etsy-gray font-normal">(opsional)</span>
                    </label>
                    <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel"
                        placeholder="08xxxxxxxxxx"
                        class="w-full border-2 rounded-xl py-2.5 px-4 text-sm focus:outline-none transition
                               {{ $errors->has('phone') ? 'border-red-400 bg-red-50' : 'border-etsy-border focus:border-etsy-dark' }}">
                    @error('phone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Alamat --}}
                <div>
                    <label for="address" class="block text-sm font-medium text-etsy-dark mb-1.5">
                        Alamat <span class="text-etsy-gray font-normal">(opsional)</span>
                    </label>
                    <textarea id="address" name="address" rows="2" autocomplete="street-address"
                        placeholder="Jl. Contoh No. 1, Kota..."
                        class="w-full border-2 rounded-xl py-2.5 px-4 text-sm focus:outline-none transition resize-none
                               {{ $errors->has('address') ? 'border-red-400 bg-red-50' : 'border-etsy-border focus:border-etsy-dark' }}">{{ old('address') }}</textarea>
                    @error('address')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-etsy-dark mb-1.5">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="w-full border-2 rounded-xl py-2.5 px-4 text-sm focus:outline-none transition
                               {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-etsy-border focus:border-etsy-dark' }}">
                    @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-etsy-dark mb-1.5">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="w-full border-2 rounded-xl py-2.5 px-4 text-sm focus:outline-none transition
                               {{ $errors->has('password_confirmation') ? 'border-red-400 bg-red-50' : 'border-etsy-border focus:border-etsy-dark' }}">
                    @error('password_confirmation')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full bg-etsy-dark text-white font-bold py-3 rounded-full hover:bg-black transition text-sm mt-2">
                    Buat Akun
                </button>
            </form>

            {{-- Login link --}}
            <p class="text-center text-sm text-etsy-gray mt-6">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-etsy-orange font-semibold hover:underline">Masuk di sini</a>
            </p>
        </div>
    </div>
</x-guest-layout>