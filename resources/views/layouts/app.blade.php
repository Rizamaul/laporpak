<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapor Pak! - Sistem Pengaduan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <nav class="bg-blue-900 p-4 shadow-lg text-white mb-6">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('tickets.index') }}" class="font-bold text-xl flex items-center gap-2">
                📢 Lapor Pak!
            </a>
            <div class="flex items-center gap-4">
                @auth
                    <span>Halo, <strong>{{ Auth::user()->name }}</strong></span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-600 px-3 py-1 rounded text-sm hover:bg-red-700 transition">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:underline">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 pb-12">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @yield('content')
    </div>

</body>
</html>