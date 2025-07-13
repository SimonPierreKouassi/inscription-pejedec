<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            
            // Informations personnelles
            $table->string('nom');
            $table->string('prise_en_charge');
            $table->string('prenom');
            $table->enum('civilite', ['MR', 'Mme']);
            $table->enum('sexe', ['homme', 'femme']);
            $table->date('date_naissance');
            $table->string('lieu_naissance');
            $table->string('numero_cmu');
            $table->enum('nationalite', ['ivoirienne', 'etrangere']);
            $table->string('situation_matrimoniale');
            $table->integer('nombre_enfants')->default(0);
            $table->string('chez_qui');
            
            // Pièces d'identité
            $table->string('type_piece');
            $table->string('numero_piece');
            
            // Informations physiques
            $table->string('pointure');
            $table->string('taille_vetement');
            
            // Formations
            $table->string('premier_choix_formation');
            $table->string('deuxieme_choix_formation');
            $table->string('troisieme_choix_formation');
            
            // Informations académiques/professionnelles
            $table->string('occupation_actuelle');
            $table->string('niveau_actuel');
            
            // Contact
            $table->string('numero_phone');
            $table->string('adresse_email');
            
            // Personne à contacter
            $table->string('nom_personne_contact');
            $table->string('prenom_personne_contact');
            $table->string('lien_parente');
            $table->string('numero_personne_contact');
            
            // Rendez-vous
            $table->date('date_rdv');
            $table->string('creneau_horaire')->nullable();
            $table->foreignId('time_slot_id')->constrained()->onDelete('cascade');
            
            // Statut et métadonnées
            $table->string('status')->default('pending');
            $table->text('notes')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
            
            // Index pour optimiser les requêtes
            $table->index(['date_rdv', 'status']);
            $table->index(['status', 'created_at']);
            $table->index(['adresse_email']);
            $table->index(['numero_phone']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};