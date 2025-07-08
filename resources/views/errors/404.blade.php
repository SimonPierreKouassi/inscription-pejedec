@extends('layouts.app')

@section('title', 'Page non trouvée')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center px-4">
    <x-card class="max-w-md w-full text-center">
        <div class="p-6 rounded-full bg-yellow-50 w-24 h-24 mx-auto mb-6 flex items-center justify-center">
            <svg class="h-12 w-12 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
            </svg>
        </div>
        
        <h1 class="text-2xl font-bold text-gray-900 mb-4">
            Page introuvable
        </h1>
        
        <p class="text-gray-600 mb-8">
            La page que vous recherchez n'existe pas ou a été déplacée.
        </p>
        
        <div class="space-y-4">
            <x-button href="{{ route('home') }}" variant="primary" class="w-full flex items-center justify-center">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Retour à l'accueil
            </x-button>
        </div>
        
        <div class="mt-8 pt-6 border-t border-gray-200">
            <p class="text-sm text-gray-500">
                Code d'erreur: 404
            </p>
        </div>
    </x-card>
</div>
@endsection