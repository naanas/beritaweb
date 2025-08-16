<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Berita Web Dinamis')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header class="header">
        <div class="container">
            <h1 class="logo"><a href="{{ route('home') }}">BeritaWeb</a></h1>
            <nav class="nav">
                <ul>
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    {{-- Bagian Kategori Navbar --}}
                    <li class="dropdown">
                        <a href="#" class="dropbtn">Kategori <span class="arrow-down"></span></a>
                        <div class="dropdown-content">
                            @forelse ($categories as $category)
                                <a href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a>
                            @empty
                                <a href="#">Tidak ada kategori</a>
                            @endforelse
                        </div>
                    </li>
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Kontak</a></li>

                    {{-- --- Tambahan Link Login/Dashboard Admin --- --}}
                    @auth {{-- Jika pengguna sudah login --}}
                        {{-- Mengarahkan ke dashboard admin --}}
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                            </form>
                        </li>
                    @else {{-- Jika pengguna belum login --}}
                        <li><a href="{{ route('login') }}">Login</a></li>
                        {{-- Link register opsional jika Anda ingin mengizinkan publik mendaftar --}}
                        {{-- <li><a href="{{ route('register') }}">Register</a></li> --}}
                    @endauth
                    {{-- --- Akhir Tambahan --- --}}
                </ul>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            {{-- PERBAIKAN PENTING DI SINI: Mengubah {{ $slot }} menjadi @yield('content') --}}
            @yield('content')
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} BeritaWeb. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>