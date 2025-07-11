@extends('layouts.app')

@section('title', 'Gestion des Créneaux Horaires')

@section('content')
<div class="space-y-6" x-data="timeSlotsManager()" x-init="init()"> {{-- Added x-init here to initialize data on page load --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Créneaux Horaires</h1>
            <p class="text-gray-600 mt-1">Gérez les créneaux disponibles pour les rendez-vous</p>
        </div>
        <div class="flex space-x-2">
            <x-button x-on:click="openGenerateModal()" variant="primary" class="flex items-center" x-bind:disabled="isLoading">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Générer des créneaux
            </x-button>
            <x-button x-on:click="openCreateModal()" variant="success" class="flex items-center" x-bind:disabled="isLoading">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Nouveau créneau
            </x-button>
        </div>
    </div>

    {{-- Alert / Message Display Component --}}
    {{-- Using `message.text` for `x-show` for direct control over visibility --}}
    <div x-show="message.text" x-transition.opacity.duration.300ms>
        <x-alert 
            x-bind:type="message.type" 
            dismissible
            x-on:dismiss="message.text = ''"> {{-- Clear only text to dismiss --}}
            <span x-text="message.text"></span>
        </x-alert>
    </div>

    <x-card>
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center space-x-2 mb-4">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                <h2 class="text-lg font-semibold text-gray-900">Filtres</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input 
                        type="date" 
                        x-model="filters.date" 
                        x-on:change="applyFilters()" {{-- Changed to @change for consistency --}}
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select 
                        x-model="filters.status" 
                        x-on:change="applyFilters()" {{-- Changed to @change for consistency --}}
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option value="">Tous les statuts</option>
                        <option value="active">Actif</option>
                        <option value="inactive">Inactif</option>
                        <option value="full">Complet</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Disponibilité</label>
                    <select 
                        x-model="filters.availability" 
                        x-on:change="applyFilters()" {{-- Changed to @change for consistency --}}
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option value="">Toutes</option>
                        <option value="available">Disponible</option>
                        <option value="unavailable">Non disponible</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 flex justify-end">
                <x-button x-on:click="clearFilters()" variant="secondary" size="sm" x-bind:disabled="isLoading"> {{-- Disable button --}}
                    Réinitialiser les filtres
                </x-button>
            </div>
        </div>
    </x-card>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <x-card class="p-4">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Total créneaux</p>
                    <p class="text-xl font-bold text-gray-900" x-text="stats.total"></p>
                </div>
            </div>
        </x-card>

        <x-card class="p-4">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Disponibles</p>
                    <p class="text-xl font-bold text-gray-900" x-text="stats.available"></p>
                </div>
            </div>
        </x-card>

        <x-card class="p-4">
            <div class="flex items-center">
                <div class="p-2 bg-red-100 rounded-lg">
                    <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Complets</p>
                    <p class="text-xl font-bold text-gray-900" x-text="stats.full"></p>
                </div>
            </div>
        </x-card>

        <x-card class="p-4">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <svg class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Inactifs</p>
                    <p class="text-xl font-bold text-gray-900" x-text="stats.inactive"></p>
                </div>
            </div>
        </x-card>
    </div>

    <x-card>
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-900">
                Liste des créneaux horaires
            </h2>
            {{-- Loading spinner for the table header --}}
            <div x-show="isLoading" class="flex items-center text-gray-500">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Chargement...
            </div>
        </div>
        
        {{-- Displayed ONLY if filteredTimeSlots are empty AND NOT loading --}}
        <template x-if="filteredTimeSlots.length === 0 && !isLoading">
            <div class="p-6 text-center text-gray-500">
                <svg class="h-12 w-12 mx-auto mb-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p>Aucun créneau trouvé</p>
            </div>
        </template>

        {{-- The table is shown if there are filteredTimeSlots OR if it's currently loading --}}
        {{-- The loading overlay will then cover the table content during load --}}
        <div x-show="filteredTimeSlots.length > 0 || isLoading" class="overflow-x-auto relative"> {{-- Added 'relative' for absolute positioning of overlay --}}
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Heure
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Capacité
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Réservations
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <template x-for="slot in filteredTimeSlots" :key="slot.id">
                        <tr class="hover:bg-gray-50" :class="isLoading ? 'opacity-50' : ''"> {{-- Add opacity when loading --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900" x-text="formatDate(slot.date)"></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900" x-text="`${slot.start_time} - ${slot.end_time}`"></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900" x-text="slot.max_capacity"></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <span x-text="slot.current_bookings"></span> / <span x-text="slot.max_capacity"></span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                    <div 
                                        class="bg-blue-600 h-2 rounded-full" 
                                        :style="`width: ${(slot.current_bookings / slot.max_capacity) * 100}%`"
                                    ></div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span 
                                    class="px-2 py-1 rounded-full text-xs font-medium"
                                    :class="{
                                        'bg-green-100 text-green-800': slot.is_active && slot.current_bookings < slot.max_capacity,
                                        'bg-red-100 text-red-800': slot.current_bookings >= slot.max_capacity,
                                        'bg-gray-100 text-gray-800': !slot.is_active
                                    }"
                                    x-text="getStatusLabel(slot)"
                                >
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button
                                        x-on:click="editTimeSlot(slot)"
                                        class="text-blue-600 hover:text-blue-900"
                                        title="Modifier"
                                        x-bind:disabled="isLoading" {{-- Disable during loading --}}
                                    >
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    
                                    <button
                                        x-on:click="toggleTimeSlotStatus(slot)"
                                        :class="slot.is_active ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900'"
                                        :title="slot.is_active ? 'Désactiver' : 'Activer'"
                                        x-bind:disabled="isLoading" {{-- Disable during loading --}}
                                    >
                                        <svg x-show="slot.is_active" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <svg x-show="!slot.is_active" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                    
                                    <button
                                        x-on:click="await deleteTimeSlot(slot)"
                                        class="text-red-600 hover:text-red-900"
                                        title="Supprimer"
                                        x-bind:disabled="isLoading" {{-- Disable during loading --}}
                                    >
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
            {{-- Loading overlay for table --}}
            <div x-show="isLoading" class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center rounded-lg">
                <svg class="animate-spin h-10 w-10 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>
    </x-card>

    {{-- Generate Time Slots Modal --}}
    <div x-show="showGenerateModal" 
         class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex justify-center items-center p-4" 
         x-transition.opacity
         x-on:click.outside="showGenerateModal = false" {{-- Close when clicking outside --}}
         x-on:keydown.escape.window="showGenerateModal = false" {{-- Close with escape key --}}
    >
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full p-6" x-on:click.stop> {{-- Prevent clicks inside from closing modal --}}
            <h3 class="text-lg font-medium text-gray-900 mb-4">Générer des créneaux</h3>
            
            <form x-on:submit.prevent="await generateTimeSlots()">
                <div class="space-y-4">
                    <div>
                        <label for="generateStartDate" class="block text-sm font-medium text-gray-700">Date de début</label>
                        <input 
                            type="date" 
                            id="generateStartDate"
                            x-model="generateForm.startDate" 
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>
                    
                    <div>
                        <label for="generateEndDate" class="block text-sm font-medium text-gray-700">Date de fin</label>
                        <input 
                            type="date" 
                            id="generateEndDate"
                            x-model="generateForm.endDate" 
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>
                    
                    <div>
                        <label for="generateCapacity" class="block text-sm font-medium text-gray-700">Capacité par créneau</label>
                        <input 
                            type="number" 
                            id="generateCapacity"
                            x-model="generateForm.capacity" 
                            min="1" 
                            max="50" 
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>
                </div>
                
                <div class="flex justify-end space-x-2 mt-6">
                    <x-button type="button" x-on:click="showGenerateModal = false" variant="secondary" x-bind:disabled="isLoading">
                        Annuler
                    </x-button>
                    <x-button type="submit" variant="primary" x-bind:disabled="isLoading">
                        Générer
                    </x-button>
                </div>
            </form>
        </div>
    </div>

    {{-- Create/Edit Time Slot Modal --}}
    <div x-show="showCreateModal" 
         class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex justify-center items-center p-4" 
         x-transition.opacity
         x-on:click.outside="closeModal()" {{-- Call the dedicated close function --}}
         x-on:keydown.escape.window="closeModal()" {{-- Call the dedicated close function --}}
    >
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full p-6" x-on:click.stop> {{-- Prevent clicks inside from closing modal --}}
            <h3 class="text-lg font-medium text-gray-900 mb-4" x-text="editingSlot ? 'Modifier le créneau' : 'Nouveau créneau'"></h3>
            
            <form x-on:submit.prevent="await saveTimeSlot()">
                <div class="space-y-4">
                    <div>
                        <label for="slotDate" class="block text-sm font-medium text-gray-700">Date</label>
                        <input 
                            type="date" 
                            id="slotDate"
                            x-model="slotForm.date" 
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>
                    
                    <div>
                        <label for="startTime" class="block text-sm font-medium text-gray-700">Heure de début</label>
                        <input 
                            type="time" 
                            id="startTime"
                            x-model="slotForm.startTime" 
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>
                    
                    <div>
                        <label for="endTime" class="block text-sm font-medium text-gray-700">Heure de fin</label>
                        <input 
                            type="time" 
                            id="endTime"
                            x-model="slotForm.endTime" 
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>
                    
                    <div>
                        <label for="maxCapacity" class="block text-sm font-medium text-gray-700">Capacité maximale</label>
                        <input 
                            type="number" 
                            id="maxCapacity"
                            x-model="slotForm.maxCapacity" 
                            min="1" 
                            max="50" 
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>
                    
                    <div>
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                x-model="slotForm.isActive"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            >
                            <span class="ml-2 text-sm text-gray-700">Créneau actif</span>
                        </label>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-2 mt-6">
                    <x-button type="button" x-on:click="closeModal()" variant="secondary" x-bind:disabled="isLoading">
                        Annuler
                    </x-button>
                    <x-button type="submit" variant="primary" x-bind:disabled="isLoading">
                        <span x-text="editingSlot ? 'Modifier' : 'Créer'"></span>
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    console.log(Alpine.data())
})
document.addEventListener('alpine:initialized', () => {
    console.log(Alpine.data())
})

function timeSlotsManager() {
    return {
        timeSlots: [],
        filteredTimeSlots: [],
        filters: {
            date: '',
            status: '',
            availability: ''
        },
        stats: {
            total: 0,
            available: 0,
            full: 0,
            inactive: 0
        },
        isLoading: false, // <-- Added isLoading property
        message: {        // <-- Modified message to be an object always
            text: '',
            type: 'info'
        }, 
        showGenerateModal: false,
        showCreateModal: false,
        editingSlot: null,
        generateForm: {
            startDate: '',
            endDate: '',
            capacity: 10
        },
        slotForm: {
            date: '',
            startTime: '',
            endTime: '',
            maxCapacity: 10,
            isActive: true
        },
        
        init() {
            this.loadTimeSlots();
        },
        
        async loadTimeSlots() {
            this.isLoading = true; // Start loading
            this.message.text = ''; // Clear previous messages
            try {
                const response = await fetch('/api/timeslots'); // Changed to base API for full list, if that's what's intended
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                this.timeSlots = await response.json();
                this.applyFilters(); // Apply filters after loading initial data
                this.updateStats();
            } catch (error) {
                console.error('Erreur lors du chargement des créneaux:', error);
                this.showMessage('Erreur lors du chargement des créneaux: ' + error.message, 'error');
                this.timeSlots = []; // Clear data on error
                this.filteredTimeSlots = [];
                this.updateStats(); // Update stats based on empty data
            } finally {
                this.isLoading = false; // End loading
            }
        },
        
        applyFilters() {
            let filtered = [...this.timeSlots]; // Start with all slots

            if (this.filters.date) {
                filtered = filtered.filter(slot => slot.date === this.filters.date);
            }
            
            if (this.filters.status) {
                if (this.filters.status === 'active') {
                    filtered = filtered.filter(slot => slot.is_active);
                } else if (this.filters.status === 'inactive') {
                    filtered = filtered.filter(slot => !slot.is_active);
                } else if (this.filters.status === 'full') {
                    filtered = filtered.filter(slot => slot.current_bookings >= slot.max_capacity);
                }
            }
            
            if (this.filters.availability) {
                if (this.filters.availability === 'available') {
                    filtered = filtered.filter(slot => slot.current_bookings < slot.max_capacity && slot.is_active);
                } else if (this.filters.availability === 'unavailable') {
                    filtered = filtered.filter(slot => slot.current_bookings >= slot.max_capacity || !slot.is_active);
                }
            }
            
            this.filteredTimeSlots = filtered;
        },
        
        clearFilters() {
            this.filters = {
                date: '',
                status: '',
                availability: ''
            };
            this.applyFilters(); // Re-apply filters to show all slots
            this.showMessage('Filtres réinitialisés', 'info');
        },
        
        updateStats() {
            this.stats = {
                total: this.timeSlots.length,
                available: this.timeSlots.filter(slot => slot.current_bookings < slot.max_capacity && slot.is_active).length,
                full: this.timeSlots.filter(slot => slot.current_bookings >= slot.max_capacity).length,
                inactive: this.timeSlots.filter(slot => !slot.is_active).length
            };
        },

        // --- Modal Control Functions ---
        openGenerateModal() {
            this.showGenerateModal = true;
            // Optionally, reset form fields here if needed every time it opens
            this.generateForm = { startDate: '', endDate: '', capacity: 10 }; 
            this.message.text = ''; // Clear messages when opening a new modal
        },

        openCreateModal() {
            this.showCreateModal = true;
            this.editingSlot = null; // Ensure no slot is being edited initially
            this.resetSlotForm();
            this.message.text = ''; // Clear messages
        },
        
        closeModal() {
            this.showCreateModal = false;
            this.showGenerateModal = false; // Also ensure generate modal can be closed by this
            this.editingSlot = null;
            this.resetSlotForm();
            this.message.text = ''; // Clear messages
        },

        resetSlotForm() {
            this.slotForm = {
                date: '',
                startTime: '',
                endTime: '',
                maxCapacity: 10,
                isActive: true
            };
        },
        // --- End Modal Control Functions ---
        
        async generateTimeSlots() {
            this.isLoading = true;
            this.message.text = '';
            try {
                const response = await fetch('/api/timeslots/generate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        start_date: this.generateForm.startDate,
                        end_date: this.generateForm.endDate,
                        capacity: this.generateForm.capacity
                    })
                });
                
                const result = await response.json();
                
                if (response.ok) {
                    this.showMessage(result.message || 'Créneaux générés avec succès.', 'success');
                    this.closeModal(); // Use the close modal function
                    this.loadTimeSlots(); // Reload data
                } else {
                    // Check for validation errors from Laravel
                    if (response.status === 422 && result.errors) {
                        let errorMessages = Object.values(result.errors).flat().join('<br>');
                        this.showMessage(`Erreur de validation: <br>${errorMessages}`, 'error');
                    } else {
                        this.showMessage(result.message || 'Erreur lors de la génération.', 'error');
                    }
                }
            } catch (error) {
                console.error('Erreur lors de la génération des créneaux:', error);
                this.showMessage('Erreur de connexion lors de la génération des créneaux.', 'error');
            } finally {
                this.isLoading = false;
            }
        },
        
        editTimeSlot(slot) {
            this.editingSlot = slot;
            // Ensure date is formatted for input type="date" (YYYY-MM-DD)
            const slotDate = new Date(slot.date);
            const formattedDate = slotDate.toISOString().split('T')[0];

            this.slotForm = {
                date: formattedDate,
                startTime: slot.start_time,
                endTime: slot.end_time,
                maxCapacity: slot.max_capacity,
                isActive: slot.is_active
            };
            this.showCreateModal = true;
        },
        
        async saveTimeSlot() {
            this.isLoading = true;
            this.message.text = '';
            try {
                const url = this.editingSlot 
                    ? `/api/timeslots/${this.editingSlot.id}`
                    : '/api/timeslots';
                
                const method = this.editingSlot ? 'PUT' : 'POST';
                
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        date: this.slotForm.date,
                        start_time: this.slotForm.startTime,
                        end_time: this.slotForm.endTime,
                        max_capacity: this.slotForm.maxCapacity,
                        is_active: this.slotForm.isActive
                    })
                });
                
                const result = await response.json();
                
                if (response.ok) {
                    this.showMessage(result.message || 'Créneau enregistré avec succès.', 'success');
                    this.closeModal(); // Use the close modal function
                    this.loadTimeSlots(); // Reload data
                } else {
                     if (response.status === 422 && result.errors) {
                        let errorMessages = Object.values(result.errors).flat().join('<br>');
                        this.showMessage(`Erreur de validation: <br>${errorMessages}`, 'error');
                    } else {
                        this.showMessage(result.message || 'Erreur lors de la sauvegarde du créneau.', 'error');
                    }
                }
            } catch (error) {
                console.error('Erreur lors de la sauvegarde du créneau:', error);
                this.showMessage('Erreur de connexion lors de la sauvegarde du créneau.', 'error');
            } finally {
                this.isLoading = false;
            }
        },
        
        async toggleTimeSlotStatus(slot) {
            this.isLoading = true;
            this.message.text = '';
            try {
                const response = await fetch(`/api/timeslots/${slot.id}/toggle`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                const result = await response.json();
                
                if (response.ok) {
                    this.showMessage(result.message || 'Statut du créneau mis à jour.', 'success');
                    this.loadTimeSlots();
                } else {
                    this.showMessage(result.message || 'Erreur lors de la modification du statut.', 'error');
                }
            } catch (error) {
                console.error('Erreur lors de la modification du statut:', error);
                this.showMessage('Erreur de connexion lors de la modification du statut.', 'error');
            } finally {
                this.isLoading = false;
            }
        },
        
        async deleteTimeSlot(slot) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer ce créneau ? Cette action est irréversible.')) return;
            
            this.isLoading = true;
            this.message.text = '';
            try {
                const response = await fetch(`/api/timeslots/${slot.id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                const result = await response.json();
                
                if (response.ok) {
                    this.showMessage(result.message || 'Créneau supprimé avec succès.', 'success');
                    this.loadTimeSlots();
                } else {
                    this.showMessage(result.message || 'Erreur lors de la suppression du créneau.', 'error');
                }
            } catch (error) {
                console.error('Erreur lors de la suppression du créneau:', error);
                this.showMessage('Erreur de connexion lors de la suppression du créneau.', 'error');
            } finally {
                this.isLoading = false;
            }
        },
        
        formatDate(dateString) {
            const options = { year: 'numeric', month: 'long', day: 'numeric', weekday: 'long' };
            try {
                const date = new Date(dateString);
                // Check if date is valid
                if (isNaN(date.getTime())) {
                    return dateString; // Return original string if it's not a valid date
                }
                return date.toLocaleDateString('fr-FR', options);
            } catch (e) {
                console.error("Error formatting date:", e);
                return dateString; // Fallback
            }
        },
        
        getStatusLabel(slot) {
            if (!slot.is_active) return 'Inactif';
            if (slot.current_bookings >= slot.max_capacity) return 'Complet';
            return 'Disponible';
        },
        
        showMessage(text, type = 'info') {
            this.message = { text, type };
            setTimeout(() => {
                this.message.text = ''; // Only clear the text to allow the alert component to fade out
            }, 5000);
        }
    }
}
</script>
@endpush
@endsection