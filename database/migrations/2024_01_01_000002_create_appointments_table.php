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
            $table->string('prenom');
            $table->enum('civilite', ['MR', 'Mme']);
            $table->enum('sexe', ['homme', 'femme']);
            $table->date('date_naissance');
            $table->string('lieu_naissance');
            $table->string('numero_cmu');
            $table->enum('nationalite', ['ivoirienne', 'etrangere']);
            $table->enum('situation_matrimoniale', ['celibataire', 'marie']);
            $table->integer('nombre_enfants')->default(0);
            $table->enum('chez_qui', ['pere', 'mere', 'grand-mere']);
            
            // Pièces d'identité
            $table->enum('type_piece', ['CNI', 'passeport']);
            $table->string('numero_piece');
            
            // Informations physiques
            $table->string('pointure');
            $table->string('taille_vetement');
            
            // Formations
            $table->enum('premier_choix_formation', ['formation A', 'formation B']);
            $table->enum('deuxieme_choix_formation', ['formation A', 'formation B']);
            $table->enum('troisieme_choix_formation', ['formation A', 'formation B']);
            
            // Informations académiques/professionnelles
            $table->string('occupation_actuelle');
            $table->enum('niveau_actuel', ['primaire', 'college', 'lycee']);
            
            // Contact
            $table->string('numero_phone');
            $table->string('adresse_email');
            
            // Personne à contacter
            $table->string('nom_personne_contact');
            $table->string('prenom_personne_contact');
            $table->enum('lien_parente', ['pere', 'simple']);
            $table->string('numero_personne_contact');
            
            // Rendez-vous
            $table->date('date_rdv');
            $table->string('creneau_horaire');
            $table->foreignId('time_slot_id')->constrained()->onDelete('cascade');
            
            // Statut et métadonnées
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
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