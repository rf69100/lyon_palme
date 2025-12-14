    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="font-bold text-white mb-4">Lyon Palme</h3>
                    <p class="text-sm text-slate-400">
                        Club de palmage et plongée - FFESSM AURA<br>
                        16 Avenue du Docteur Georges Lévy, 69200 Vénissieux<br>
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4">Produit</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ url('/') }}#features" class="hover:text-white">Fonctionnalités</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-white">À Propos</a></li>
                        <li><a href="{{ route('support') }}" class="hover:text-white">Support</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4">Sécurité</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('rgpd') }}" class="hover:text-white">RGPD</a></li>
                        <li><a href="{{ route('cnil') }}" class="hover:text-white">Politique CNIL</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4">Légal</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('confidentialite') }}" class="hover:text-white">Politique de confidentialité</a></li>
                        <li><a href="{{ route('conditions') }}" class="hover:text-white">Conditions d'utilisation</a></li>
                        <li><a href="{{ route('cookies') }}" class="hover:text-white">Cookies</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-800 pt-8">
                <div class="flex flex-col sm:flex-row justify-between items-center">
                    <p class="text-sm text-slate-400">
                        © 2024 Lyon Palme. Tous droits réservés.
                    </p>
                    <p class="text-sm text-slate-400 mt-4 sm:mt-0">
                        Développé avec Laravel 12 & MariaDB
                    </p>
                </div>
            </div>
        </div>
    </footer>