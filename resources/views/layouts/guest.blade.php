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
                        sans: ['Inter', 'sans-serif']
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
</head>

<body class="bg-etsy-light text-etsy-dark antialiased min-h-screen flex flex-col">

    {{-- Navbar minimalis: hanya logo --}}
    <nav class="border-b border-etsy-border bg-white">
        <div class="container mx-auto px-4 lg:px-8 h-16 flex items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-etsy-orange tracking-tight">
                RumahTanggaKu
            </a>
        </div>
    </nav>

    <main class="flex-1 flex items-center justify-center px-4 py-12">
        {{ $slot }}
    </main>

</body>

</html>