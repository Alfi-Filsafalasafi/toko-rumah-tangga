<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RumahTanggaKu')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        etsy: {
                            orange: '#F1641E',
                            dark: '#222222',
                            gray: '#595959',
                            light: '#F4F4F4',
                            border: '#EAEAEA',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-white text-etsy-dark antialiased">

    <nav class="border-b border-etsy-border bg-white sticky top-0 z-40">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="{{ route('home') }}" class="text-3xl font-bold text-etsy-orange tracking-tight">
                    RumahTanggaKu
                </a>

                <form action="{{ route('home') }}" method="GET" class="hidden md:flex flex-1 max-w-2xl mx-8 relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari perabotan rumah modern..." class="w-full border-2 border-etsy-dark rounded-full py-2.5 pl-5 pr-12 text-sm focus:outline-none focus:bg-gray-50 transition">
                    <button type="submit" class="absolute right-0 top-0 h-full px-4 rounded-r-full bg-etsy-dark text-white hover:bg-black transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>

                <div class="flex items-center space-x-6">
                    @auth
                    {{-- Sesuaikan pengecekan role berikut dengan kolom/role di model User kamu (mis. role, is_admin, dll) --}}
                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-etsy-dark hover:text-etsy-orange transition">Dashboard</a>
                    @else
                    <a href="{{ route('order.history') }}" class="text-sm font-medium text-etsy-dark hover:text-etsy-orange transition">Riwayat</a>
                    <a href="{{ route('profile.edit') }}" class="text-sm font-medium text-etsy-dark hover:text-etsy-orange transition">Profile</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-etsy-dark hover:text-etsy-orange transition">Logout</button>
                    </form>
                    @endif
                    @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-etsy-dark hover:underline">Sign in</a>
                    @endauth

                    <a href="/cart" class="text-etsy-dark hover:bg-etsy-light p-2 rounded-full relative transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        @php $cartCount = collect(session('cart', []))->sum('quantity'); @endphp
                        <span class="absolute top-0 right-0 bg-etsy-orange text-white text-[10px] font-bold rounded-full h-4 w-4 flex items-center justify-center">{{ $cartCount }}</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    @stack('scripts')
</body>

</html>