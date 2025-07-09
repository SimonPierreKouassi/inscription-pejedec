<footer class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Logo et description -->
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center mb-4">
                    <svg class="h-8 w-8 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 8a4 4 0 11-8 0V7a4 4 0 118 0v4z" />
                    </svg>
                    <span class="ml-2 text-xl font-bold">Gestionnaire de RDV</span>
                </div>
                <p class="text-gray-400 mb-4">
                    Système de gestion de rendez-vous moderne et efficace.
                </p>
            </div>

            <!-- Liens rapides -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Liens rapides</h3>
                <ul class="space-y-2 text-gray-400">
                    <li>
                        <a href="{{ route('appointment.form') }}" class="hover:text-white transition-colors">
                            Nouveau rendez-vous
                        </a>
                    </li>
                    @auth
                    <li>
                        <a href="{{ route('dashboard') }}" class="hover:text-white transition-colors">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('exports.index') }}" class="hover:text-white transition-colors">
                            Exports
                        </a>
                    </li>
                    @endauth
                    <li>
                        <a href="#" class="hover:text-white transition-colors">
                            Aide
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Contact</h3>
                <div class="space-y-3 text-gray-400">
                    <div class="flex items-center">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span>07 15 96 96 96 - 07 15 88 88 88 - 07 16 88 88 88</span>
                    </div>
                   <!-- <div class="flex items-center">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span></span>
                    </div> --> 
                    <div class="flex items-center">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Abidjan, Côte d'Ivoire</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; {{ date('Y') }} Agefop ©. Tous droits réservés.</p>
        </div>
    </div>
</footer>