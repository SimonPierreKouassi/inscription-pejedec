@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<div class="space-y-12">
    <!-- Section Hero -->
    <section class="text-center py-12">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-center mb-6">
                <div class="p-4 bg-orange-100 rounded-full">
                    <svg class="h-16 w-16 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 8a4 4 0 11-8 0V7a4 4 0 118 0v4z" />
                    </svg>
                </div>
            </div>
            
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                Système de Gestion de Rendez-vous
            </h1>
            
            <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                Une solution moderne et complète pour gérer vos rendez-vous, 
                optimiser votre organisation et améliorer l'expérience de vos clients.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <x-button href="{{ route('appointment.form') }}" variant="primary" size="lg" class="flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 8a4 4 0 11-8 0V7a4 4 0 118 0v4z" />
                    </svg>
                    Prendre un rendez-vous
                </x-button>
                
                @auth
                <x-button href="{{ route('dashboard') }}" variant="secondary" size="lg" class="flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                    Accéder au dashboard
                </x-button>
                @endauth
            </div>
        </div>
    </section>

    <!-- Section Statistiques -->
    <section class="bg-gray-50 py-12 rounded-lg">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                Nos performances
            </h2>
            <p class="text-gray-600">
                Des chiffres qui témoignent de notre efficacité
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
            $stats = [
                ['label' => 'Rendez-vous créés', 'value' => '500+', 'icon' => 'M8 7V3a4 4 0 118 0v4m-4 8a4 4 0 11-8 0V7a4 4 0 118 0v4z'],
                ['label' => 'Taux de satisfaction', 'value' => '98%', 'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
                ['label' => 'Temps de traitement', 'value' => '< 2min', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Clients satisfaits', 'value' => '450+', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z']
            ];
            @endphp
            
            @foreach($stats as $stat)
            <x-card class="text-center">
                <div class="flex justify-center mb-4">
                    <div class="p-3 bg-orange-100 rounded-full">
                        <svg class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-900 mb-2">{{ $stat['value'] }}</p>
                <p class="text-gray-600">{{ $stat['label'] }}</p>
            </x-card>
            @endforeach
        </div>
    </section>

    <!-- Section Statistiques -->
    <section class="bg-gray-50 py-12 rounded-lg">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                Nos Partenaires
            </h2>
            <p class="text-gray-600">
                Ils nous font confiances
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
            $logos = [
                ['path' => 'resources/images/logos/logo_bcp-emploi.png'],
                ['path' => 'resources/images/logos/logo-agefop.png'],
                ['path' => 'resources/images/logos/logo-BM.png'],
                ['path' => 'resources/images/logos/logo-pejedec.png']
            ];
            @endphp

            @foreach($logos as $logo)
                <x-card class="text-center">
                    <div class="flex items-center justify-center h-full">
                        <img src="{{ Vite::asset($logo['path']) }}" alt="Partner Logo" height="100">
                    </div>
                </x-card>
            @endforeach
        </div>
    </section>

    <!-- Section Fonctionnalités -->
    <section>
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                Fonctionnalités principales
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Découvrez les fonctionnalités qui font de notre système 
                la solution idéale pour votre gestion de rendez-vous.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @php
            $features = [
                [
                    'icon' => 'M8 7V3a4 4 0 118 0v4m-4 8a4 4 0 11-8 0V7a4 4 0 118 0v4z',
                    'title' => 'Prise de rendez-vous simplifiée',
                    'description' => 'Interface intuitive pour créer rapidement vos rendez-vous avec validation en temps réel.'
                ],
                [
                    'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z',
                    'title' => 'Gestion centralisée',
                    'description' => 'Dashboard complet pour gérer tous vos rendez-vous depuis une seule interface.'
                ],
                [
                    'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                    'title' => 'Exports automatisés',
                    'description' => 'Génération de PDF et export Excel pour vos rapports et analyses.'
                ],
                [
                    'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                    'title' => 'Suivi en temps réel',
                    'description' => 'Notifications et confirmations automatiques pour un suivi optimal.'
                ]
            ];
            @endphp
            
            @foreach($features as $feature)
            <x-card>
                <div class="flex items-start space-x-4">
                    <div class="p-3 bg-orange-100 rounded-lg">
                        <svg class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $feature['icon'] }}" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            {{ $feature['title'] }}
                        </h3>
                        <p class="text-gray-600">
                            {{ $feature['description'] }}
                        </p>
                    </div>
                </div>
            </x-card>
            @endforeach
        </div>
    </section>

    <!-- Section Call to Action -->
    <section class="bg-orange-600 text-white py-12 rounded-lg">
        <div class="text-center">
            <h2 class="text-3xl font-bold mb-4">
                Prêt à commencer ?
            </h2>
            <p class="text-xl mb-8 text-orange-100">
                Créez votre premier rendez-vous en moins de 5 minutes
            </p>
            <x-button href="{{ route('appointment.form') }}" variant="secondary" size="lg" class="bg-white text-orange-600 hover:bg-gray-50">
                Commencer maintenant
            </x-button>
        </div>
    </section>
</div>
@endsection