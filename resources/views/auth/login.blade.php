<x-guest-layout>
    @section('title', 'Masuk - RumahTanggaKu')

    <div class="w-full max-w-md">

        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-etsy-dark">Selamat datang kembali</h1>
            <p class="text-etsy-gray text-sm mt-1">Masuk ke akun RumahTanggaKu kamu</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-etsy-border p-8">

            {{-- Session Status (mis. setelah reset password) --}}
            @if (session('status'))
            <div class="mb-4 text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg px-4 py-3">
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-etsy-dark mb-1.5">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                        class="w-full border-2 rounded-xl py-2.5 px-4 text-sm focus:outline-none transition
                               {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-etsy-border focus:border-etsy-dark' }}">
                    @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <label for="password" class="block text-sm font-medium text-etsy-dark">Password</label>

                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="w-full border-2 rounded-xl py-2.5 px-4 text-sm focus:outline-none transition
                               {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-etsy-border focus:border-etsy-dark' }}">
                    @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center gap-2">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="w-4 h-4 rounded border-etsy-border text-etsy-orange focus:ring-etsy-orange cursor-pointer">
                    <label for="remember_me" class="text-sm text-etsy-gray cursor-pointer select-none">Ingat saya</label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full bg-etsy-dark text-white font-bold py-3 rounded-full hover:bg-black transition text-sm mt-2">
                    Masuk
                </button>
            </form>

            {{-- Register link --}}
            @if (Route::has('register'))
            <p class="text-center text-sm text-etsy-gray mt-6">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-etsy-orange font-semibold hover:underline">Daftar sekarang</a>
            </p>
            @endif

        </div>
    </div>
</x-guest-layout>