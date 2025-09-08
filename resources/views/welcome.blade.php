<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>UtangDong</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    @vite('resources/css/app.css')
</head>
<body class="antialiased bg-gray-50 text-gray-800">

    <!-- Navbar -->
    <header class="w-full bg-white shadow-sm fixed top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-green-600">UtangDong</h1>
            <nav class="flex gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="px-4 py-2 rounded-lg bg-green-600 text-white font-medium hover:bg-green-700 transition">
                           Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 font-medium hover:bg-gray-200 transition">
                           Login
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="px-4 py-2 rounded-lg bg-green-600 text-white font-medium hover:bg-green-700 transition">
                               Register
                            </a>
                        @endif
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <main class="flex flex-col items-center justify-center min-h-screen px-6 pt-24">
        <div class="text-center max-w-2xl">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Marketplace Pinjaman Online <span class="text-green-600">UtangDong</span>
            </h2>
            <p class="text-lg text-gray-600 mb-8">
                Solusi untuk mempermudah Borrower dan Lender dalam mengajukan serta memberikan pinjaman, 
                dengan sistem yang aman, transparan, dan terpercaya.
            </p>
            <div class="flex justify-center gap-4">
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow hover:bg-green-700 transition">
                       Mulai Sekarang
                    </a>
                @endif
                <a href="{{ route('login') }}"
                   class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg shadow hover:bg-gray-200 transition">
                   Sudah Punya Akun
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full py-6 bg-white border-t mt-12 text-center text-sm text-gray-500">
        © {{ date('Y') }} UtangDong. All rights reserved.
    </footer>

</body>
</html>
