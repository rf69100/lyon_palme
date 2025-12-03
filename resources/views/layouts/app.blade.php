<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Lyon Palme</title>
    @vite(['resources/css/app.css'])
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
</head>
<body class="font-sans text-slate-900 antialiased">
    <!-- Navigation Bar -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center gap-2">
                    <span class="text-2xl">🏊</span>
                    <h1 class="font-bold text-xl text-slate-900">Lyon Palme</h1>
                </div>

                <!-- Nav Actions -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 text-slate-700 hover:text-slate-900 font-medium transition duration-200 rounded-lg hover:bg-slate-50">
                        Dashboard
                    </a>
                    <a href="/" class="px-4 py-2 text-slate-700 hover:text-slate-900 font-medium transition duration-200 rounded-lg hover:bg-slate-50">
                        Accueil
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition duration-200">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100">
        @yield('content')
    </main>
</body>
</html>
