@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6" x-data="dashboard()">
    <!-- En-tête -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        <div class="flex space-x-2">
            <x-button onclick="exportExcel()" variant="success" class="flex items-center">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export Excel
            </x-button>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-card class="p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-500 bg-opacity-20">
                    <svg class="h-6 w-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total des RDV</p>
                    <p class="text-2xl font-bold text-gray-900" x-text="stats.total_appointments">{{ $stats['total_appointments'] ?? 0 }}</p>
                </div>
            </div>
        </x-card>

        <x-card class="p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-500 bg-opacity-20">
                    <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Confirmés</p>
                    <p class="text-2xl font-bold text-gray-900" x-text="stats.confirmed_appointments">{{ $stats['confirmed_appointments'] ?? 0 }}</p>
                </div>
            </div>
        </x-card>

        <x-card class="p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-500 bg-opacity-20">
                    <svg class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">En attente</p>
                    <p class="text-2xl font-bold text-gray-900" x-text="stats.pending_appointments">{{ $stats['pending_appointments'] ?? 0 }}</p>
                </div>
            </div>
        </x-card>

        <x-card class="p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-500 bg-opacity-20">
                    <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Annulés</p>
                    <p class="text-2xl font-bold text-gray-900" x-text="stats.cancelled_appointments">{{ $stats['cancelled_appointments'] ?? 0 }}</p>
                </div>
            </div>
        </x-card>
    </div>

    <!-- Actions en masse -->
    <div x-show="selectedAppointments.length > 0" x-transition>
        <x-card class="p-4">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600" x-text="`${selectedAppointments.length} rendez-vous sélectionné(s)`"></span>
                <div class="flex space-x-2">
                    <x-button onclick="bulkAction('confirm')" variant="success" size="sm">
                        Confirmer
                    </x-button>
                    <x-button onclick="bulkAction('cancel')" variant="secondary" size="sm">
                        Annuler
                    </x-button>
                    <x-button onclick="bulkAction('delete')" variant="danger" size="sm">
                        Supprimer
                    </x-button>
                </div>
            </div>
        </x-card>
    </div>

    <!-- Liste des rendez-vous -->
    <x-card>
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">
                Liste des rendez-vous
            </h2>
        </div>
        
        <template x-if="appointments.length === 0">
            <div class="p-6 text-center text-gray-500">
                <svg class="h-12 w-12 mx-auto mb-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 8a4 4 0 11-8 0V7a4 4 0 118 0v4z" />
                </svg>
                <p>Aucun rendez-vous trouvé</p>
            </div>
        </template>

        <div x-show="appointments.length > 0" class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" 
                                   x-model="selectAll"
                                   @change="toggleSelectAll()"
                                   class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Client
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date/Heure
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Contact
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
                    <template x-for="appointment in appointments" :key="appointment.id">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" 
                                       :value="appointment.id"
                                       x-model="selectedAppointments"
                                       class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900" 
                                             x-text="`${appointment.civilite} ${appointment.nom} ${appointment.prenom}`"></div>
                                        <div class="text-sm text-gray-500" x-text="appointment.numero_phone"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900" x-text="appointment.date_rdv"></div>
                                <div class="text-sm text-gray-500" x-text="appointment.creneau_horaire"></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900" x-text="appointment.adresse_email"></div>
                                <div class="text-sm text-gray-500" x-text="`Formation: ${appointment.premier_choix_formation}`"></div>
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button @click="downloadPDF(appointment.id)" 
                                            class="text-orange-600 hover:text-orange-900" 
                                            title="Télécharger PDF">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </button>
                                    
                                    <template x-if="appointment.status === 'pending'">
                                        <button @click="updateStatus(appointment.id, 'confirmed')" 
                                                class="text-green-600 hover:text-green-900" 
                                                title="Confirmer">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                    </template>
                                    
                                    <template x-if="appointment.status !== 'cancelled'">
                                        <button @click="updateStatus(appointment.id, 'cancelled')" 
                                                class="text-red-600 hover:text-red-900" 
                                                title="Annuler">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                    </template>
                                    
                                    <button @click="deleteAppointment(appointment.id)" 
                                            class="text-red-600 hover:text-red-900" 
                                            title="Supprimer">
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
</div>

@push('scripts')
<script>
function dashboard() {
    return {
        appointments: @json($appointments ?? []),
        stats: @json($stats ?? []),
        selectedAppointments: [],
        selectAll: false,
        
        init() {
            this.loadData();
        },
        
        async loadData() {
            try {
                const [appointmentsResponse, statsResponse] = await Promise.all([
                    fetch('/api/appointments'),
                    fetch('/api/appointments/stats/dashboard')
                ]);
                
                this.appointments = await appointmentsResponse.json();
                this.stats = await statsResponse.json();
            } catch (error) {
                console.error('Erreur lors du chargement des données:', error);
            }
        },
        
        toggleSelectAll() {
            if (this.selectAll) {
                this.selectedAppointments = this.appointments.map(app => app.id);
            } else {
                this.selectedAppointments = [];
            }
        },
        
        async updateStatus(id, status) {
            try {
                const response = await fetch(`/api/appointments/${id}/${status}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                if (response.ok) {
                    this.loadData();
                    this.showMessage('Statut mis à jour avec succès', 'success');
                }
            } catch (error) {
                this.showMessage('Erreur lors de la mise à jour', 'error');
            }
        },
        
        async deleteAppointment(id) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer ce rendez-vous ?')) return;
            
            try {
                const response = await fetch(`/api/appointments/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                if (response.ok) {
                    this.loadData();
                    this.showMessage('Rendez-vous supprimé avec succès', 'success');
                }
            } catch (error) {
                this.showMessage('Erreur lors de la suppression', 'error');
            }
        },
        
        async bulkAction(action) {
            if (this.selectedAppointments.length === 0) {
                this.showMessage('Veuillez sélectionner au moins un rendez-vous', 'error');
                return;
            }
            
            const confirmMessage = action === 'delete' 
                ? 'Êtes-vous sûr de vouloir supprimer les rendez-vous sélectionnés ?'
                : `Êtes-vous sûr de vouloir ${action === 'confirm' ? 'confirmer' : 'annuler'} les rendez-vous sélectionnés ?`;
            
            if (!confirm(confirmMessage)) return;
            
            try {
                const response = await fetch('/api/appointments/bulk-action', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        action: action,
                        appointment_ids: this.selectedAppointments
                    })
                });
                
                if (response.ok) {
                    this.selectedAppointments = [];
                    this.selectAll = false;
                    this.loadData();
                    this.showMessage('Action effectuée avec succès', 'success');
                }
            } catch (error) {
                this.showMessage('Erreur lors de l\'action', 'error');
            }
        },
        
        async downloadPDF(id) {
            window.open(`/api/exports/appointments/${id}/pdf`, '_blank');
        },
        
        async exportExcel() {
            window.open('/api/exports/excel', '_blank');
        },
        
        getStatusLabel(status) {
            const labels = {
                'pending': 'En attente',
                'confirmed': 'Confirmé',
                'cancelled': 'Annulé'
            };
            return labels[status] || 'Inconnu';
        },
        
        showMessage(message, type) {
            // Implémentation simple d'affichage de message
            // En production, utiliser un système de notifications plus sophistiqué
            alert(message);
        }
    }
}
</script>
@endpush
@endsection