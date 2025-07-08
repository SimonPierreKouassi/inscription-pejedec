@extends('layouts.app')

@section('title', 'Gestion des Créneaux Horaires')

@section('content')
<div class="space-y-6" x-data="timeSlotsManager()">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Créneaux Horaires</h1>
            <p class="text-gray-600 mt-1">Gérez les créneaux disponibles pour les rendez-vous</p>
        </div>
        <div class="flex space-x-2">
            <x-button @click="showGenerateModal = true" variant="primary" class="flex items-center">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Générer des créneaux
            </x-button>
            <x-button @click="showCreateModal = true" variant="success" class="flex items-center">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Nouveau créneau
            </x-button>
        </div>
    </div>

    <div x-show="message" x-transition>
        <x-alert 
            x-bind:type="message && message.type ? message.type : 'info'" 
            dismissible
            @dismiss="message = null">
            <span x-text="message && message.text ? message.text : ''"></span> {{-- Content goes in the slot --}}
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
                        @change="applyFilters()"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select 
                        x-model="filters.status" 
                        @change="applyFilters()"
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
                        @change="applyFilters()"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option value="">Toutes</option>
                        <option value="available">Disponible</option>
                        <option value="unavailable">Non disponible</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 flex justify-end">
                <x-button @click="clearFilters()" variant="secondary" size="sm">
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
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">
                Liste des créneaux horaires
            </h2>
        </div>
        
        <template x-if="filteredTimeSlots.length === 0">
            <div class="p-6 text-center text-gray-500">
                <svg class="h-12 w-12 mx-auto mb-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p>Aucun créneau trouvé</p>
            </div>
        </template>

        <div x-show="filteredTimeSlots.length > 0" class="overflow-x-auto">
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
                        <tr class="hover:bg-gray-50">
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
                                        @click="editTimeSlot(slot)"
                                        class="text-blue-600 hover:text-blue-900"
                                        title="Modifier"
                                    >
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    
                                    <button
                                        @click="toggleTimeSlotStatus(slot)"
                                        :class="slot.is_active ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900'"
                                        :title="slot.is_active ? 'Désactiver' : 'Activer'"
                                    >
                                        <svg x-show="slot.is_active" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <svg x-show="!slot.is_active" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                    
                                    <button
                                        @click="deleteTimeSlot(slot)"
                                        class="text-red-600 hover:text-red-900"
                                        title="Supprimer"
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
        </div>
    </x-card>

    <div x-show="showGenerateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" x-transition>
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Générer des créneaux</h3>
                
                <form @submit.prevent="generateTimeSlots()">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date de début</label>
                            <input 
                                type="date" 
                                x-model="generateForm.startDate" 
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date de fin</label>
                            <input 
                                type="date" 
                                x-model="generateForm.endDate" 
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Capacité par créneau</label>
                            <input 
                                type="number" 
                                x-model="generateForm.capacity" 
                                min="1" 
                                max="50" 
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-2 mt-6">
                        <x-button type="button" @click="showGenerateModal = false" variant="secondary">
                            Annuler
                        </x-button>
                        <x-button type="submit" variant="primary">
                            Générer
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div x-show="showCreateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" x-transition>
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4" x-text="editingSlot ? 'Modifier le créneau' : 'Nouveau créneau'"></h3>
                
                <form @submit.prevent="saveTimeSlot()">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date</label>
                            <input 
                                type="date" 
                                x-model="slotForm.date" 
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Heure de début</label>
                            <input 
                                type="time" 
                                x-model="slotForm.startTime" 
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Heure de fin</label>
                            <input 
                                type="time" 
                                x-model="slotForm.endTime" 
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Capacité maximale</label>
                            <input 
                                type="number" 
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
                        <x-button type="button" @click="closeModal()" variant="secondary">
                            Annuler
                        </x-button>
                        <x-button type="submit" variant="primary">
                            <span x-text="editingSlot ? 'Modifier' : 'Créer'"></span>
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
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
        message: null, // Initializing as null, it will be an object { text, type } when set
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
            try {
                const response = await fetch('/api/time-slots/available');
                this.timeSlots = await response.json();
                this.applyFilters();
                this.updateStats();
            } catch (error) {
                console.error('Erreur lors du chargement des créneaux:', error);
                this.showMessage('Erreur lors du chargement des créneaux', 'error');
            }
        },
        
        applyFilters() {
            let filtered = [...this.timeSlots];
            
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
            this.applyFilters();
        },
        
        updateStats() {
            this.stats = {
                total: this.timeSlots.length,
                available: this.timeSlots.filter(slot => slot.current_bookings < slot.max_capacity && slot.is_active).length,
                full: this.timeSlots.filter(slot => slot.current_bookings >= slot.max_capacity).length,
                inactive: this.timeSlots.filter(slot => !slot.is_active).length
            };
        },
        
        async generateTimeSlots() {
            try {
                const response = await fetch('/api/time-slots/generate', {
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
                    this.showMessage(result.message, 'success');
                    this.showGenerateModal = false;
                    this.loadTimeSlots();
                } else {
                    this.showMessage(result.message || 'Erreur lors de la génération', 'error');
                }
            } catch (error) {
                console.error('Erreur lors de la génération des créneaux:', error);
                this.showMessage('Erreur lors de la génération des créneaux', 'error');
            }
        },
        
        editTimeSlot(slot) {
            this.editingSlot = slot;
            this.slotForm = {
                date: slot.date,
                startTime: slot.start_time,
                endTime: slot.end_time,
                maxCapacity: slot.max_capacity,
                isActive: slot.is_active
            };
            this.showCreateModal = true;
        },
        
        async saveTimeSlot() {
            try {
                const url = this.editingSlot 
                    ? `/api/time-slots/${this.editingSlot.id}`
                    : '/api/time-slots';
                
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
                    this.showMessage(result.message, 'success');
                    this.closeModal();
                    this.loadTimeSlots();
                } else {
                    this.showMessage(result.message || 'Erreur lors de la sauvegarde', 'error');
                }
            } catch (error) {
                console.error('Erreur lors de la sauvegarde du créneau:', error);
                this.showMessage('Erreur lors de la sauvegarde du créneau', 'error');
            }
        },
        
        async toggleTimeSlotStatus(slot) {
            try {
                const response = await fetch(`/api/time-slots/${slot.id}/toggle`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                const result = await response.json();
                
                if (response.ok) {
                    this.showMessage(result.message, 'success');
                    this.loadTimeSlots();
                } else {
                    this.showMessage(result.message || 'Erreur lors de la modification', 'error');
                }
            } catch (error) {
                console.error('Erreur lors de la modification du statut:', error);
                this.showMessage('Erreur lors de la modification du statut', 'error');
            }
        },
        
        async deleteTimeSlot(slot) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer ce créneau ?')) return;
            
            try {
                const response = await fetch(`/api/time-slots/${slot.id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                const result = await response.json();
                
                if (response.ok) {
                    this.showMessage(result.message, 'success');
                    this.loadTimeSlots();
                } else {
                    this.showMessage(result.message || 'Erreur lors de la suppression', 'error');
                }
            } catch (error) {
                console.error('Erreur lors de la suppression du créneau:', error);
                this.showMessage('Erreur lors de la suppression du créneau', 'error');
            }
        },
        
        closeModal() {
            this.showCreateModal = false;
            this.editingSlot = null;
            this.slotForm = {
                date: '',
                startTime: '',
                endTime: '',
                maxCapacity: 10,
                isActive: true
            };
        },
        
        formatDate(date) {
            // Ensure date is a valid Date object
            const d = new Date(date);
            if (isNaN(d.getTime())) {
                return date; // Return original if invalid date
            }
            return d.toLocaleDateString('fr-FR', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        },
        
        getStatusLabel(slot) {
            if (!slot.is_active) return 'Inactif';
            if (slot.current_bookings >= slot.max_capacity) return 'Complet';
            return 'Disponible';
        },
        
        showMessage(text, type) {
            this.message = { text, type };
            setTimeout(() => {
                this.message = null;
            }, 5000);
        }
    }
}
</script>
@endpush
@endsection