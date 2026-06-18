<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - RumahTanggaKu')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
        /* Scrollbar tipis khusus sidebar admin */
        #adminSidebar nav::-webkit-scrollbar {
            width: 4px;
        }

        #adminSidebar nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 4px;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-etsy-light text-etsy-dark antialiased">

    <div class="min-h-screen flex">

        {{-- Sidebar --}}
        <aside id="adminSidebar"
            class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-etsy-dark text-white flex flex-col -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">

            <div class="h-20 flex items-center justify-between px-6 border-b border-white/10 shrink-0">
                <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold text-etsy-orange tracking-tight">
                    RumahTanggaKu
                </a>
                <button id="sidebarClose" class="lg:hidden text-white/60 hover:text-white">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <div class="px-6 pt-5 pb-2 text-xs font-semibold uppercase tracking-wider text-white/40 shrink-0">
                Menu Admin
            </div>

            <nav class="flex-1 px-3 pb-4 space-y-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                        {{ request()->routeIs('admin.dashboard') ? 'bg-etsy-orange text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid fa-gauge-high w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.categories.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                        {{ request()->routeIs('admin.categories.*') ? 'bg-etsy-orange text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid fa-tags w-5 text-center"></i>
                    <span>Kategori</span>
                </a>

                <a href="{{ route('admin.products.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                        {{ request()->routeIs('admin.products.*') ? 'bg-etsy-orange text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid fa-box-open w-5 text-center"></i>
                    <span>Produk</span>
                </a>

                <a href="{{ route('admin.orders.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                        {{ request()->routeIs('admin.orders.*') ? 'bg-etsy-orange text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid fa-receipt w-5 text-center"></i>
                    <span>Pesanan</span>
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                        {{ request()->routeIs('admin.users.*') ? 'bg-etsy-orange text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid fa-users w-5 text-center"></i>
                    <span>Pelanggan</span>
                </a>
            </nav>

            <div class="px-3 py-4 border-t border-white/10 shrink-0">
                <a href="{{ route('home') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/70 hover:bg-white/5 hover:text-white transition">
                    <i class="fa-solid fa-arrow-left w-5 text-center"></i>
                    <span>Lihat Toko</span>
                </a>
            </div>
        </aside>

        {{-- Overlay untuk mobile --}}
        <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-40 hidden"></div>

        {{-- Main content --}}
        <div class="flex-1 flex flex-col min-w-0">

            {{-- Topbar --}}
            <header class="h-20 bg-white border-b border-etsy-border flex items-center justify-between px-4 lg:px-8 sticky top-0 z-30">
                <div class="flex items-center gap-4 min-w-0">
                    <button id="sidebarOpen" class="lg:hidden text-etsy-dark p-2 -ml-2 shrink-0">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-lg lg:text-xl font-semibold truncate">@yield('page-title', 'Dashboard')</h1>
                </div>

                <div class="flex items-center gap-4 shrink-0">
                    <div class="relative">
                        <button id="profileMenuBtn" class="flex items-center gap-2">
                            <div class="h-9 w-9 rounded-full bg-etsy-orange text-white flex items-center justify-center font-semibold text-sm">
                                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                            </div>
                            <span class="hidden sm:block text-sm font-medium">{{ auth()->user()->name ?? 'Admin' }}</span>
                            <i class="fa-solid fa-chevron-down text-xs text-etsy-gray hidden sm:block"></i>
                        </button>

                        <div id="profileMenuDropdown"
                            class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-etsy-border py-1 z-40">
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-2 px-4 py-2 text-sm text-etsy-dark hover:bg-etsy-light transition">
                                <i class="fa-solid fa-user w-4 text-center"></i>
                                <span>Profile</span>
                            </a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-2 px-4 py-2 text-sm text-etsy-dark hover:bg-etsy-light transition">
                                    <i class="fa-solid fa-arrow-right-from-bracket w-4 text-center"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Page content --}}
            <main class="flex-1 p-4 lg:p-8">

                @if (session('success'))
                <div class="mb-4 flex items-center gap-3 rounded-lg bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-sm">
                    <i class="fa-solid fa-circle-check"></i>
                    <span class="flex-1">{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                @endif

                @if (session('error'))
                <div class="mb-4 flex items-center gap-3 rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span class="flex-1">{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')

    <script>
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const openBtn = document.getElementById('sidebarOpen');
        const closeBtn = document.getElementById('sidebarClose');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }

        openBtn?.addEventListener('click', openSidebar);
        closeBtn?.addEventListener('click', closeSidebar);
        overlay?.addEventListener('click', closeSidebar);

        // Dropdown profile
        const profileBtn = document.getElementById('profileMenuBtn');
        const profileDropdown = document.getElementById('profileMenuDropdown');

        profileBtn?.addEventListener('click', function(e) {
            e.stopPropagation();
            profileDropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', function() {
            profileDropdown?.classList.add('hidden');
        });
    </script>

</body>

</html>