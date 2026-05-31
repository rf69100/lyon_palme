<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Lyon Palme</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    @stack('styles')
</head>
<body class="font-sans text-slate-900 antialiased">
    <!-- Navigation Bar -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center gap-2">
                    <a href="{{ url('/') }}">
                        <img src="/LyonPalme.png" alt="Lyon Palme" class="h-12">
                    </a>
                </div>

                <!-- Nav Actions -->
                <div class="flex items-center gap-2 sm:gap-4">
                    <a href="{{ route('dashboard') }}" class="hidden sm:inline px-3 py-2 text-slate-700 hover:text-purple-600 font-medium">Tableau de bord</a>
                    <a href="{{ route('trombinoscope') }}" class="hidden sm:inline px-3 py-2 text-slate-700 hover:text-purple-600 font-medium">Trombinoscope</a>
                    <a href="{{ route('annuaire') }}" class="hidden sm:inline px-3 py-2 text-slate-700 hover:text-purple-600 font-medium">Annuaire</a>
                    <a href="{{ route('mon-profil.edit') }}" class="hidden sm:inline px-3 py-2 text-slate-700 hover:text-purple-600 font-medium">Mon profil</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-cyan-500 text-white rounded-lg hover:from-purple-700 hover:to-cyan-600 font-medium transition duration-200">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
