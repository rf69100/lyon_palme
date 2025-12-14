<nav class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}" class="flex items-center">
                    <img src="/LyonPalme.png" alt="Lyon Palme" class="h-12">
                </a>
            </div>
            <div class="flex gap-3">
                @auth
                <a href="{{ route('dashboard') }}" class="px-6 py-2 bg-gradient-to-r from-purple-600 to-cyan-500 text-white rounded-lg hover:from-purple-700 hover:to-cyan-600 font-medium">
                    Mon Compte
                </a>
                @else
                <a href="{{ route('login') }}" class="px-6 py-2 text-slate-700 hover:text-purple-600 font-medium">
                    Connexion
                </a>
                <a href="{{ route('register') }}" class="px-6 py-2 bg-gradient-to-r from-purple-600 to-cyan-500 text-white rounded-lg hover:from-purple-700 hover:to-cyan-600 font-medium">
                    S'inscrire
                </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
