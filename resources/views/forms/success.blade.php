@extends('layouts.app')

@section('title', 'Rendez-vous créé avec succès')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center px-4">
    <x-card class="max-w-md w-full text-center">
        <div class="p-6 rounded-full bg-green-50 w-24 h-24 mx-auto mb-6 flex items-center justify-center">
            <svg class="h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        
        <h1 class="text-2xl font-bold text-gray-900 mb-4">
            Rendez-vous créé avec succès !
        </h1>
        
        <p class="text-gray-600 mb-8">
            Votre rendez-vous a été enregistré. Un email de confirmation vous a été envoyé avec tous les détails.
        </p>
        
        <div class="space-y-4">
            <x-button href="{{ route('home') }}" variant="primary" class="w-full flex items-center justify-center">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Retour à l'accueil
            </x-button>
            
            <x-button href="{{ route('appointment.form') }}" variant="secondary" class="w-full flex items-center justify-center">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 8a4 4 0 11-8 0V7a4 4 0 118 0v4z" />
                </svg>
                Prendre un autre rendez-vous
            </x-button>
        </div>
        
        <div class="mt-8 pt-6 border-t border-gray-200">
            <p class="text-sm text-gray-500">
                Vous recevrez un rappel 24h avant votre rendez-vous.
            </p>
        </div>
    </x-card>
</div>
@endsection