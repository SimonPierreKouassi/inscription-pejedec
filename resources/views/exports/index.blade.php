@extends('layouts.app')

@section('title', 'Exports')

@section('content')
<div class="space-y-6" x-data="exports()">
    <!-- En-tête -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Exports</h1>
        <div class="flex items-center space-x-2">
            <span class="text-sm text-gray-600" x-text="`${filteredCount} rendez-vous`"></span>
            <x-button x-on:click="await exportExcel()" variant="success" x-data="{filteredCount}" x-bind:disabled="filteredAppointments.length === 0">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Exporter Excel
            </x-button>
        </div>
    </div>

    <!-- Filtres -->
    <x-card>
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center space-x-2 mb-4">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                <h2 class="text-lg font-semibold text-gray-900">Filtres</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Filtre par statut -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Statut
                    </label>
                    <select x-model="filters.status" x-on:change="applyFilters()"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                        <option value="">Tous les statuts</option>
                        <option value="pending">En attente</option>
                        <option value="confirmed">Confirmé</option>
                        <option value="cancelled">Annulé</option>
                    </select>
                </div>

                <!-- Filtre par date de début -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Date de début
                    </label>
                    <input type="date" x-model="filters.dateFrom" x-on:change="applyFilters()"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                </div>

                <!-- Filtre par date de fin -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Date de fin
                    </label>
                    <input type="date" x-model="filters.dateTo" x-on:change="applyFilters()"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                </div>

                <!-- Filtre par formation -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Formation
                    </label>
                    <select x-model="filters.formation" x-on:change="applyFilters()"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                        <option value="">Toutes les formations</option>
                        <option value="Mecanique auto">Mecanique auto</option>
                        <option value="Peinture auto">Peinture auto</option>
                        <option value="Carrossier">Carrossier</option>
                        <option value="Chaudronnerie/Feronnerie">Chaudronnerie/Feronnerie</option>
                        <option value="Menuiserie alu">Menuiserie alu</option>
                        <option value="Maçonnerie">Maçonnerie</option>
                        <option value="Carrelage">Carrelage</option>
                        <option value="Plomberie sanitaire">Plomberie sanitaire</option>
                        <option value="Peinture bat">Peinture bâtiment</option>
                        <option value="Électricité automobile">Électricité automobile</option>
                        <option value="Électricité batiment">Électricité batiment</option>
                        <option value="Froid climatisation">Froid climatisation</option>
                        <option value="Électronique">Électronique</option>
                        <option value="Cuisine">Cuisine</option>
                        <option value="Pâtisserie">Pâtisserie</option>
                        <option value="Réception">Réception</option>
                        <option value="Serveur/Barman">Serveur/Barman</option>
                        <option value="Valet de chambre">Valet de chambre</option>                
                        <option value="Menuiserie/Ébenisterie">Menuiserie/Ébenisterie</option>
                        <option value="Tapisserie">Tapisserie</option>
                        <option value="Charpentier">Charpentier</option>
                        <option value="Vernissage">Vernissage</option>
                        <option value="Infographie">Infographie</option>
                        <option value="Serigraphie/Calligraphie">Serigraphie/Calligraphie</option>
                        <option value="Brodeur">Brodeur</option>
                        <option value="Piqueur">Piqueur</option>
                        <option value="Coiffure">Coiffure</option>
                        <option value="Esthétique">Esthétique</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 flex justify-end">
                <x-button x-on:click="clearFilters()" variant="secondary" size="sm">
                    Réinitialiser les filtres
                </x-button>
            </div>
        </div>
    </x-card>

    <!-- Résumé des données -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <x-card class="p-4">
            <div class="flex items-center">
                <div class="p-2 bg-orange-100 rounded-lg">
                    <svg class="h-5 w-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Total</p>
                    {{-- This Alpine.js usage is correct --}}
                    <p class="text-xl font-bold text-gray-900" x-text="filteredCount"></p>
                </div>
            </div>
        </x-card>

        <x-card class="p-4">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 8a4 4 0 11-8 0V7a4 4 0 118 0v4z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Confirmés</p>
                    <p class="text-xl font-bold text-gray-900" x-text="confirmedCount"></p>
                </div>
            </div>
        </x-card>

        <x-card class="p-4">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <svg class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 8a4 4 0 11-8 0V7a4 4 0 118 0v4z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">En attente</p>
                    <p class="text-xl font-bold text-gray-900" x-text="pendingCount"></p>
                </div>
            </div>
        </x-card>

        <x-card class="p-4">
            <div class="flex items-center">
                <div class="p-2 bg-red-100 rounded-lg">
                    <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 8a4 4 0 11-8 0V7a4 4 0 118 0v4z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Annulés</p>
                    <p class="text-xl font-bold text-gray-900" x-text="cancelledCount"></p>
                </div>
            </div>
        </x-card>
    </div>

    <!-- Aperçu des données -->
    <x-card>
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">
                Aperçu des données
            </h2>
        </div>
        
        <template x-if="filteredAppointments.length === 0">
            <div class="p-6 text-center text-gray-500">
                <svg class="h-12 w-12 mx-auto mb-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p>Aucun rendez-vous ne correspond aux filtres sélectionnés</p>
            </div>
        </template>

        <div x-show="filteredAppointments.length > 0" class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Client
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date/Heure
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Formation
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Contact
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <template x-for="appointment in filteredAppointments.slice(0, 10)" :key="appointment.id">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900" 
                                     x-text="`${appointment.civilite} ${appointment.nom} ${appointment.prenom}`"></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900" x-text="appointment.date_rdv"></div>
                                <div class="text-sm text-gray-500" x-text="appointment.creneau_horaire"></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900" x-text="appointment.premier_choix_formation"></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 rounded-full text-xs font-medium"
                                      :class="{
                                          'bg-green-100 text-green-800': appointment.status === 'confirmed',
                                          'bg-yellow-100 text-yellow-800': appointment.status === 'pending',
                                          'bg-red-100 text-red-800': appointment.status === 'cancelled'
                                      }"
                                      x-text="getStatusLabel(appointment.status)">
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900" x-text="appointment.numero_phone"></div>
                                <div class="text-sm text-gray-500" x-text="appointment.adresse_email"></div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
            
            <div x-show="filteredAppointments.length > 10" class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <p class="text-sm text-gray-500" x-text="`... et ${filteredAppointments.length - 10} autres rendez-vous`"></p>
            </div>
        </div>
    </x-card>
</div>

@push('scripts')
<script>
function exports() {
    return {
        filteredCount: 0,
        cancelledCount: 0,
        pendingCount: 0,
        appointments: [],
        filteredAppointments: [],
        filters: {
            status: '',
            dateFrom: '',
            dateTo: '',
            formation: ''
        },
        
        init() {
            this.loadAppointments();
        },
        
        async loadAppointments() {
            try {
                const response = await fetch('/api/appointments');
                this.appointments = (await response.json()).data;
                this.applyFilters();
            } catch (error) {
                console.error('Erreur lors du chargement des rendez-vous:', error);
            }
        },
        
        applyFilters() {
            let filtered = [...this.appointments];
            
            // Filter by status
            if (this.filters.status) {
                filtered = filtered.filter(app => app.status === this.filters.status);
            }
            
            // Filter by start date
            if (this.filters.dateFrom) {
                filtered = filtered.filter(app => app.date_rdv >= this.filters.dateFrom);
            }
            
            // Filter by end date
            if (this.filters.dateTo) {
                filtered = filtered.filter(app => app.date_rdv <= this.filters.dateTo);
            }
            
            // Filter by formation
            if (this.filters.formation) {
                filtered = filtered.filter(app => 
                    app.premier_choix_formation === this.filters.formation ||
                    app.deuxieme_choix_formation === this.filters.formation ||
                    app.troisieme_choix_formation === this.filters.formation
                );
            }
            
            this.filteredAppointments = filtered;
        },
        
        clearFilters() {
            this.filters = {
                status: '',
                dateFrom: '',
                dateTo: '',
                formation: ''
            };
            this.applyFilters();
        },
        
        async exportExcel() {
            if (this.filteredCount === 0) return; 
            
            const params = new URLSearchParams();
            Object.entries(this.filters).forEach(([key, value]) => {
                if (value) {
                    params.append(key, value);
                }
            });
            
            window.open(`/exports/excel?${params.toString()}`, '_blank');
        },
        
        getStatusLabel(status) {
            const labels = {
                'pending': 'En attente',
                'confirmed': 'Confirmé',
                'cancelled': 'Annulé'
            };
            return labels[status] || 'Inconnu';
        },
        
        // Getter for filteredCount
        get filteredCount() {
            return this.filteredAppointments.length;
        },
        
        // Getters for other counts
        get confirmedCount() {
            return this.filteredAppointments.filter(app => app.status === 'confirmed').length;
        },
        
        get pendingCount() {
            return this.filteredAppointments.filter(app => app.status === 'pending').length;
        },
        
        get cancelledCount() {
            return this.filteredAppointments.filter(app => app.status === 'cancelled').length;
        }
    }
}
</script>
@endpush
@endsection