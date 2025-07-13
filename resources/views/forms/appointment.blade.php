@extends('layouts.app')

@section('title', 'Formulaire de Rendez-vous')

@section('content')
<x-card class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">
            Formulaire de Rendez-vous
        </h2>
        <p class="text-gray-600">
            Veuillez remplir tous les champs requis pour prendre votre rendez-vous.
        </p>
    </div>

    <form action="{{ route('appointment.store') }}" method="POST" class="space-y-6" x-data="appointmentForm()">
        @csrf
        
        <!-- Informations personnelles -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                Informations personnelles
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                 <div>
                    <label for="prise_en_charge" class="block text-sm font-medium text-gray-700">
                        Prise en charge <span class="text-red-500">*</span>
                    </label>
                    <select name="prise_en_charge" id="prise_en_charge" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('prise_en_charge') border-red-300 @enderror">
                        <option value="">Sélectionnez une zone de prise en charge</option>
                        <option value="zone_4c" >Siège Marcory zone 4C</option>
                        <option value="yop" >Lycée professionnel de Yopougon</option>
                        <option value="bouake" >Bouaké</option>

                    </select>
                    @error('prise_en_charge')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="sexe" class="block text-sm font-medium text-gray-700">
                         <span class="text-red-500"></span>
                    </label>
                    
                    @error('sexe')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="civilite" class="block text-sm font-medium text-gray-700">
                        Civilité <span class="text-red-500">*</span>
                    </label>
                    <select name="civilite" id="civilite" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('civilite') border-red-300 @enderror">
                        <option value="">Sélectionnez une civilité</option>
                        <option value="MR" {{ old('civilite') == 'MR' ? 'selected' : '' }}>Monsieur</option>
                        <option value="Mme" {{ old('civilite') == 'Mme' ? 'selected' : '' }}>Madame</option>
                    </select>
                    @error('civilite')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="sexe" class="block text-sm font-medium text-gray-700">
                        Sexe <span class="text-red-500">*</span>
                    </label>
                    <select name="sexe" id="sexe" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('sexe') border-red-300 @enderror">
                        <option value="">Sélectionnez un sexe</option>
                        <option value="homme" {{ old('sexe') == 'homme' ? 'selected' : '' }}>Homme</option>
                        <option value="femme" {{ old('sexe') == 'femme' ? 'selected' : '' }}>Femme</option>
                    </select>
                    @error('sexe')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700">
                        Nom <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('nom') border-red-300 @enderror">
                    @error('nom')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="prenom" class="block text-sm font-medium text-gray-700">
                        Prénom <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}" required 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('prenom') border-red-300 @enderror">
                    @error('prenom')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="date_naissance" class="block text-sm font-medium text-gray-700">
                        Date de naissance <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="date_naissance" id="date_naissance" value="{{ old('date_naissance') }}" required 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('date_naissance') border-red-300 @enderror">
                    @error('date_naissance')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="lieu_naissance" class="block text-sm font-medium text-gray-700">
                        Lieu de naissance <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="lieu_naissance" id="lieu_naissance" value="{{ old('lieu_naissance') }}" required 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('lieu_naissance') border-red-300 @enderror">
                    @error('lieu_naissance')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="numero_cmu" class="block text-sm font-medium text-gray-700">
                        Numéro CMU <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="numero_cmu" id="numero_cmu" value="{{ old('numero_cmu') }}" required 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('numero_cmu') border-red-300 @enderror">
                    @error('numero_cmu')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="nationalite" class="block text-sm font-medium text-gray-700">
                        Nationalité <span class="text-red-500">*</span>
                    </label>
                    <select name="nationalite" id="nationalite" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('nationalite') border-red-300 @enderror">
                        <option value="ivoirienne" {{ old('nationalite') == 'ivoirienne' ? 'selected' : '' }}>Ivoirienne</option>
                        <option value="ivoirienne" {{ old('etrangere') == 'etrangere' ? 'selected' : '' }}>Etrangère</option>
                    </select>
                    @error('nationalite')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="situation_matrimoniale" class="block text-sm font-medium text-gray-700">
                        Situation matrimoniale <span class="text-red-500">*</span>
                    </label>
                    <select name="situation_matrimoniale" id="situation_matrimoniale" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('situation_matrimoniale') border-red-300 @enderror">
                        <option value="">Sélectionnez une situation</option>
                        <option value="celibataire" {{ old('situation_matrimoniale') == 'celibataire' ? 'selected' : '' }}>Célibataire</option>
                        <option value="marie" {{ old('situation_matrimoniale') == 'marie' ? 'selected' : '' }}>Marié(e)</option>
                        <option value="veuf(ve)" {{ old('situation_matrimoniale') == 'veuf(ve)' ? 'selected' : '' }}>Veuf(ve)</option>
                    </select>
                    @error('situation_matrimoniale')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="nombre_enfants" class="block text-sm font-medium text-gray-700">
                        Nombre d'enfants <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="nombre_enfants" id="nombre_enfants" value="{{ old('nombre_enfants', 0) }}" min="0" required 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('nombre_enfants') border-red-300 @enderror">
                    @error('nombre_enfants')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="chez_qui" class="block text-sm font-medium text-gray-700">
                        Chez qui résidez-vous <span class="text-red-500">*</span>
                    </label>
                    <select name="chez_qui" id="chez_qui" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('chez_qui') border-red-300 @enderror">
                        <option value="">Sélectionnez une option</option>
                        <option value="pere" {{ old('chez_qui') == 'pere' ? 'selected' : '' }}>Père</option>
                        <option value="mere" {{ old('chez_qui') == 'mere' ? 'selected' : '' }}>Mère</option>
                        <option value="oncle" {{ old('chez_qui') == 'oncle' ? 'selected' : '' }}>Oncle</option>
                        <option value="tante" {{ old('chez_qui') == 'tante' ? 'selected' : '' }}>Tante</option>
                        <option value="grand-mere" {{ old('chez_qui') == 'grand-mere' ? 'selected' : '' }}>Grand-mère</option>
                        <option value="grand-pere" {{ old('chez_qui') == 'grand-pere' ? 'selected' : '' }}>Grand-père</option>
                    </select>
                    @error('chez_qui')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Pièces d'identité -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                Pièces d'identité
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="type_piece" class="block text-sm font-medium text-gray-700">
                        Type de pièce d'identité <span class="text-red-500">*</span>
                    </label>
                    <select name="type_piece" id="type_piece" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('type_piece') border-red-300 @enderror">
                        <option value="">Sélectionnez un type</option>
                        <option value="CNI" {{ old('type_piece') == 'CNI' ? 'selected' : '' }}>Carte Nationale d'Identité</option>
                        <option value="passeport" {{ old('type_piece') == 'passeport' ? 'selected' : '' }}>Passeport</option>
                        <option value="extrait de naissance" {{ old('type_piece') == 'extrait de naissance' ? 'selected' : '' }}>Extrait de naissance</option>
                    </select>
                    @error('type_piece')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="numero_piece" class="block text-sm font-medium text-gray-700">
                        Numéro de la pièce <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="numero_piece" id="numero_piece" value="{{ old('numero_piece') }}" required 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('numero_piece') border-red-300 @enderror">
                    @error('numero_piece')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Informations physiques -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                Informations physiques
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="pointure" class="block text-sm font-medium text-gray-700">
                        Pointure <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="pointure" id="pointure" value="{{ old('pointure') }}" required 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('pointure') border-red-300 @enderror">
                    @error('pointure')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="taille_vetement" class="block text-sm font-medium text-gray-700">
                        Taille de vêtement <span class="text-red-500">*</span>
                    </label>
                    <select name="taille_vetement" id="taille_vetement" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('taille_vetement') border-red-300 @enderror">
                        <option value="">Sélectionnez une taille</option>
                        <option value="M" {{ old('taille_vetement') == 'M' ? 'selected' : '' }}>M</option>
                        <option value="L" {{ old('taille_vetement') == 'L' ? 'selected' : '' }}>L</option>
                        <option value="XL" {{ old('taille_vetement') == 'XL' ? 'selected' : '' }}>XL</option>
                    </select>
                    
                    @error('taille_vetement')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Choix de formations -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                Choix de formations
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="premier_choix_formation" class="block text-sm font-medium text-gray-700">
                        1er choix de formation <span class="text-red-500">*</span>
                    </label>
                    <select name="premier_choix_formation" id="premier_choix_formation" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('premier_choix_formation') border-red-300 @enderror">
                        <option value="">Sélectionnez une formation</option>     
                        <option value="Mecanique auto" {{ old('premier_choix_formation') == 'Mecanique auto' ? 'selected' : '' }}>Mecanique auto</option>
                        <option value="Peinture auto" {{ old('premier_choix_formation') == 'Peinture auto' ? 'selected' : '' }}>Peinture auto</option>
                        <option value="Carrossier" {{ old('premier_choix_formation') == 'Carrossier' ? 'selected' : '' }}>Carrossier</option>
                        <option value="Chaudronnerie/Feronnerie" {{ old('premier_choix_formation') == 'Chaudronnerie/Feronnerie' ? 'selected' : '' }}>Chaudronnerie/Feronnerie</option>
                        <option value="Menuiserie alu" {{ old('premier_choix_formation') == 'Menuiserie alu' ? 'selected' : '' }}>Menuiserie alu</option>
                        <option value="Maçonnerie" {{ old('premier_choix_formation') == 'Maçonnerie' ? 'selected' : '' }}>Maçonnerie</option>
                        <option value="Carrelage" {{ old('premier_choix_formation') == 'Carrelage' ? 'selected' : '' }}>Carrelage</option>
                        <option value="Plomberie sanitaire" {{ old('premier_choix_formation') == 'Plomberie sanitaire' ? 'selected' : '' }}>Plomberie sanitaire</option>
                        <option value="Peinture bat" {{ old('premier_choix_formation') == 'Peinture bat' ? 'selected' : '' }}>Peinture bâtiment</option>
                        <option value="Électricité auto" {{ old('premier_choix_formation') == 'Électricité auto' ? 'selected' : '' }}>Électricité automobile</option>
                        <option value="Électricité bat" {{ old('premier_choix_formation') == 'Électricité bat' ? 'selected' : '' }}>Électricité batiment</option>
                        <option value="Froid climatisation" {{ old('premier_choix_formation') == 'Froid clim' ? 'selected' : '' }}>Froid climatisation</option>
                        <option value="Électronique" {{ old('premier_choix_formation') == 'Électronique' ? 'selected' : '' }}>Électronique</option>
                        <option value="Cuisine" {{ old('premier_choix_formation') == 'Cuisine' ? 'selected' : '' }}>Cuisine</option>
                        <option value="Pâtisserie" {{ old('premier_choix_formation') == 'Pâtisserie' ? 'selected' : '' }}>Pâtisserie</option>
                        <option value="Réception" {{ old('premier_choix_formation') == 'Réception' ? 'selected' : '' }}>Réception</option>
                        <option value="Serveur/Barman" {{ old('premier_choix_formation') == 'Serveur/Barman' ? 'selected' : '' }}>Serveur/Barman</option>
                        <option value="Valet de chambre" {{ old('premier_choix_formation') == 'Valet de chambre' ? 'selected' : '' }}>Valet de chambre</option>                
                        <option value="Menuiserie/Ébenisterie" {{ old('premier_choix_formation') == 'Menuiserie/Ébenisterie' ? 'selected' : '' }}>Menuiserie/Ébenisterie</option>
                        <option value="Tapisserie" {{ old('premier_choix_formation') == 'Tapisserie' ? 'selected' : '' }}>Tapisserie</option>
                        <option value="Charpentier" {{ old('premier_choix_formation') == 'Charpentier' ? 'selected' : '' }}>Charpentier</option>
                        <option value="Vernissage" {{ old('premier_choix_formation') == 'Vernissage' ? 'selected' : '' }}>Vernissage</option>
                        <option value="Infographie" {{ old('premier_choix_formation') == 'Infographie' ? 'selected' : '' }}>Infographie</option>
                        <option value="Serigraphie/Calligraphie" {{ old('premier_choix_formation') == 'Serigraphie/Calligraphie' ? 'selected' : '' }}>Serigraphie/Calligraphie</option>
                        <option value="Brodeur" {{ old('premier_choix_formation') == 'Brodeur' ? 'selected' : '' }}>Brodeur</option>
                        <option value="Piqueur" {{ old('premier_choix_formation') == 'Piqueur' ? 'selected' : '' }}>Piqueur</option>
                        <option value="Coiffure" {{ old('premier_choix_formation') == 'Coiffure' ? 'selected' : '' }}>Coiffure</option>
                        <option value="Esthétique" {{ old('premier_choix_formation') == 'Esthétique' ? 'selected' : '' }}>Esthétique</option>
                    </select>
                    @error('premier_choix_formation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="deuxieme_choix_formation" class="block text-sm font-medium text-gray-700">
                        2ème choix de formation <span class="text-red-500">*</span>
                    </label>
                    <select name="deuxieme_choix_formation" id="deuxieme_choix_formation" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('deuxieme_choix_formation') border-red-300 @enderror">
                        <option value="">Sélectionnez une formation</option>
                        <option value="Mecanique auto" {{ old('deuxieme_choix_formation') == 'Mecanique auto' ? 'selected' : '' }}>Mecanique auto</option>
                        <option value="Peinture auto" {{ old('deuxieme_choix_formation') == 'Peinture auto' ? 'selected' : '' }}>Peinture auto</option>
                        <option value="Carrossier" {{ old('deuxieme_choix_formation') == 'Carrossier' ? 'selected' : '' }}>Carrossier</option>
                        <option value="Chaudronnerie/Feronnerie" {{ old('deuxieme_choix_formation') == 'Chaudronnerie/Feronnerie' ? 'selected' : '' }}>Chaudronnerie/Feronnerie</option>
                        <option value="Menuiserie alu" {{ old('deuxieme_choix_formation') == 'Menuiserie alu' ? 'selected' : '' }}>Menuiserie alu</option>
                        <option value="Maçonnerie" {{ old('deuxieme_choix_formation') == 'Maçonnerie' ? 'selected' : '' }}>Maçonnerie</option>
                        <option value="Carrelage" {{ old('deuxieme_choix_formation') == 'Carrelage' ? 'selected' : '' }}>Carrelage</option>
                        <option value="Plomberie sanitaire" {{ old('deuxieme_choix_formation') == 'Plomberie sanitaire' ? 'selected' : '' }}>Plomberie sanitaire</option>
                        <option value="Peinture bat" {{ old('deuxieme_choix_formation') == 'Peinture bat' ? 'selected' : '' }}>Peinture bâtiment</option>
                        <option value="Électricité auto" {{ old('deuxieme_choix_formation') == 'Électricité auto' ? 'selected' : '' }}>Électricité automobile</option>
                        <option value="Électricité bat" {{ old('deuxieme_choix_formation') == 'Électricité bat' ? 'selected' : '' }}>Électricité batiment</option>
                        <option value="Froid climatisation" {{ old('deuxieme_choix_formation') == 'Froid clim' ? 'selected' : '' }}>Froid climatisation</option>
                        <option value="Électronique" {{ old('deuxieme_choix_formation') == 'Électronique' ? 'selected' : '' }}>Électronique</option>
                        <option value="Cuisine" {{ old('deuxieme_choix_formation') == 'Cuisine' ? 'selected' : '' }}>Cuisine</option>
                        <option value="Pâtisserie" {{ old('deuxieme_choix_formation') == 'Pâtisserie' ? 'selected' : '' }}>Pâtisserie</option>
                        <option value="Réception" {{ old('deuxieme_choix_formation') == 'Réception' ? 'selected' : '' }}>Réception</option>
                        <option value="Serveur/Barman" {{ old('deuxieme_choix_formation') == 'Serveur/Barman' ? 'selected' : '' }}>Serveur/Barman</option>
                        <option value="Valet de chambre" {{ old('deuxieme_choix_formation') == 'Valet de chambre' ? 'selected' : '' }}>Valet de chambre</option>                
                        <option value="Menuiserie/Ébenisterie" {{ old('deuxieme_choix_formation') == 'Menuiserie/Ébenisterie' ? 'selected' : '' }}>Menuiserie/Ébenisterie</option>
                        <option value="Tapisserie" {{ old('deuxieme_choix_formation') == 'Tapisserie' ? 'selected' : '' }}>Tapisserie</option>
                        <option value="Charpentier" {{ old('deuxieme_choix_formation') == 'Charpentier' ? 'selected' : '' }}>Charpentier</option>
                        <option value="Vernissage" {{ old('deuxieme_choix_formation') == 'Vernissage' ? 'selected' : '' }}>Vernissage</option>
                        <option value="Infographie" {{ old('deuxieme_choix_formation') == 'Infographie' ? 'selected' : '' }}>Infographie</option>
                        <option value="Serigraphie/Calligraphie" {{ old('deuxieme_choix_formation') == 'Serigraphie/Calligraphie' ? 'selected' : '' }}>Serigraphie/Calligraphie</option>
                        <option value="Brodeur" {{ old('deuxieme_choix_formation') == 'Brodeur' ? 'selected' : '' }}>Brodeur</option>
                        <option value="Piqueur" {{ old('deuxieme_choix_formation') == 'Piqueur' ? 'selected' : '' }}>Piqueur</option>
                        <option value="Coiffure" {{ old('deuxieme_choix_formation') == 'Coiffure' ? 'selected' : '' }}>Coiffure</option>
                        <option value="Esthétique" {{ old('deuxieme_choix_formation') == 'Esthétique' ? 'selected' : '' }}>Esthétique</option>
                    </select>
                    @error('deuxieme_choix_formation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="troisieme_choix_formation" class="block text-sm font-medium text-gray-700">
                        3ème choix de formation <span class="text-red-500">*</span>
                    </label>
                    <select name="troisieme_choix_formation" id="troisieme_choix_formation" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('troisieme_choix_formation') border-red-300 @enderror">
                        <option value="">Sélectionnez une formation</option>
                        <option value="Mecanique auto" {{ old('troisieme_choix_formation') == 'Mecanique auto' ? 'selected' : '' }}>Mecanique auto</option>
                        <option value="Peinture auto" {{ old('troisieme_choix_formation') == 'Peinture auto' ? 'selected' : '' }}>Peinture auto</option>
                        <option value="Carrossier" {{ old('troisieme_choix_formation') == 'Carrossier' ? 'selected' : '' }}>Carrossier</option>
                        <option value="Chaudronnerie/Feronnerie" {{ old('troisieme_choix_formation') == 'Chaudronnerie/Feronnerie' ? 'selected' : '' }}>Chaudronnerie/Feronnerie</option>
                        <option value="Menuiserie alu" {{ old('troisieme_choix_formation') == 'Menuiserie alu' ? 'selected' : '' }}>Menuiserie alu</option>
                        <option value="Maçonnerie" {{ old('troisieme_choix_formation') == 'Maçonnerie' ? 'selected' : '' }}>Maçonnerie</option>
                        <option value="Carrelage" {{ old('troisieme_choix_formation') == 'Carrelage' ? 'selected' : '' }}>Carrelage</option>
                        <option value="Plomberie sanitaire" {{ old('troisieme_choix_formation') == 'Plomberie sanitaire' ? 'selected' : '' }}>Plomberie sanitaire</option>
                        <option value="Peinture bat" {{ old('troisieme_choix_formation') == 'Peinture bat' ? 'selected' : '' }}>Peinture bâtiment</option>
                        <option value="Électricité auto" {{ old('troisieme_choix_formation') == 'Électricité auto' ? 'selected' : '' }}>Électricité automobile</option>
                        <option value="Électricité bat" {{ old('troisieme_choix_formation') == 'Électricité bat' ? 'selected' : '' }}>Électricité batiment</option>
                        <option value="Froid climatisation" {{ old('troisieme_choix_formation') == 'Froid clim' ? 'selected' : '' }}>Froid climatisation</option>
                        <option value="Électronique" {{ old('troisieme_choix_formation') == 'Électronique' ? 'selected' : '' }}>Électronique</option>
                        <option value="Cuisine" {{ old('troisieme_choix_formation') == 'Cuisine' ? 'selected' : '' }}>Cuisine</option>
                        <option value="Pâtisserie" {{ old('troisieme_choix_formation') == 'Pâtisserie' ? 'selected' : '' }}>Pâtisserie</option>
                        <option value="Réception" {{ old('troisieme_choix_formation') == 'Réception' ? 'selected' : '' }}>Réception</option>
                        <option value="Serveur/Barman" {{ old('troisieme_choix_formation') == 'Serveur/Barman' ? 'selected' : '' }}>Serveur/Barman</option>
                        <option value="Valet de chambre" {{ old('troisieme_choix_formation') == 'Valet de chambre' ? 'selected' : '' }}>Valet de chambre</option>                
                        <option value="Menuiserie/Ébenisterie" {{ old('troisieme_choix_formation') == 'Menuiserie/Ébenisterie' ? 'selected' : '' }}>Menuiserie/Ébenisterie</option>
                        <option value="Tapisserie" {{ old('troisieme_choix_formation') == 'Tapisserie' ? 'selected' : '' }}>Tapisserie</option>
                        <option value="Charpentier" {{ old('troisieme_choix_formation') == 'Charpentier' ? 'selected' : '' }}>Charpentier</option>
                        <option value="Vernissage" {{ old('troisieme_choix_formation') == 'Vernissage' ? 'selected' : '' }}>Vernissage</option>
                        <option value="Infographie" {{ old('troisieme_choix_formation') == 'Infographie' ? 'selected' : '' }}>Infographie</option>
                        <option value="Serigraphie/Calligraphie" {{ old('troisieme_choix_formation') == 'Serigraphie/Calligraphie' ? 'selected' : '' }}>Serigraphie/Calligraphie</option>
                        <option value="Brodeur" {{ old('troisieme_choix_formation') == 'Brodeur' ? 'selected' : '' }}>Brodeur</option>
                        <option value="Piqueur" {{ old('troisieme_choix_formation') == 'Piqueur' ? 'selected' : '' }}>Piqueur</option>
                        <option value="Coiffure" {{ old('troisieme_choix_formation') == 'Coiffure' ? 'selected' : '' }}>Coiffure</option>
                        <option value="Esthétique" {{ old('troisieme_choix_formation') == 'Esthétique' ? 'selected' : '' }}>Esthétique</option>
                    </select>
                    @error('troisieme_choix_formation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Informations académiques/professionnelles -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                Informations académiques et professionnelles
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="occupation_actuelle" class="block text-sm font-medium text-gray-700">
                        Occupation actuelle <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="occupation_actuelle" id="occupation_actuelle" value="{{ old('occupation_actuelle') }}" required 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('occupation_actuelle') border-red-300 @enderror">
                    @error('occupation_actuelle')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="niveau_actuel" class="block text-sm font-medium text-gray-700">
                        Niveau actuel <span class="text-red-500">*</span>
                    </label>
                    <select name="niveau_actuel" id="niveau_actuel" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('niveau_actuel') border-red-300 @enderror">
                        <option value="">Sélectionnez un niveau</option>
                        <option value="primaire" {{ old('niveau_actuel') == 'primaire' ? 'selected' : '' }}>Primaire</option>
                        <option value="college" {{ old('niveau_actuel') == 'college' ? 'selected' : '' }}>Collège</option>
                        <option value="lycee" {{ old('niveau_actuel') == 'lycee' ? 'selected' : '' }}>Lycée</option>
                    </select>
                    @error('niveau_actuel')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Informations de contact -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                Informations de contact
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="numero_phone" class="block text-sm font-medium text-gray-700">
                        Numéro de téléphone <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" name="numero_phone" id="numero_phone" value="{{ old('numero_phone') }}" required 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('numero_phone') border-red-300 @enderror">
                    @error('numero_phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="adresse_email" class="block text-sm font-medium text-gray-700">
                        Adresse email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="adresse_email" id="adresse_email" value="{{ old('adresse_email') }}" required 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('adresse_email') border-red-300 @enderror">
                    @error('adresse_email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Personne à contacter -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                Personne à contacter
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="nom_personne_contact" class="block text-sm font-medium text-gray-700">
                        Nom de la personne à contacter <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nom_personne_contact" id="nom_personne_contact" value="{{ old('nom_personne_contact') }}" required 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('nom_personne_contact') border-red-300 @enderror">
                    @error('nom_personne_contact')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="prenom_personne_contact" class="block text-sm font-medium text-gray-700">
                        Prénom de la personne à contacter <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="prenom_personne_contact" id="prenom_personne_contact" value="{{ old('prenom_personne_contact') }}" required 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('prenom_personne_contact') border-red-300 @enderror">
                    @error('prenom_personne_contact')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="lien_parente" class="block text-sm font-medium text-gray-700">
                        Lien de parenté <span class="text-red-500">*</span>
                    </label>
                    <select name="lien_parente" id="lien_parente" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('lien_parente') border-red-300 @enderror">
                        <option value="">Sélectionnez un lien</option>
                        <option value="pere" {{ old('lien_parente') == 'pere' ? 'selected' : '' }}>Père</option>
                        <option value="mere" {{ old('lien_parente') == 'mere' ? 'selected' : '' }}>Mère</option>
                        <option value="oncle" {{ old('lien_parente') == 'oncle' ? 'selected' : '' }}>Oncle</option>
                        <option value="tante" {{ old('lien_parente') == 'tante' ? 'selected' : '' }}>Tante</option>
                        <option value="grand-mere" {{ old('lien_parente') == 'grand-mere' ? 'selected' : '' }}>Grand-Mère</option>
                        <option value="grand-pere" {{ old('lien_parente') == 'grand-pere' ? 'selected' : '' }}>Grand-Père</option>
                    </select>
                    @error('lien_parente')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="numero_personne_contact" class="block text-sm font-medium text-gray-700">
                        Numéro de la personne à contacter <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" name="numero_personne_contact" id="numero_personne_contact" value="{{ old('numero_personne_contact') }}" required 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('numero_personne_contact') border-red-300 @enderror">
                    @error('numero_personne_contact')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Rendez-vous -->
        <div class="bg-orange-50 p-4 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                Rendez-vous
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="date_rdv" class="block text-sm font-medium text-gray-700">
                        Date du rendez-vous <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="date_rdv" id="date_rdv" value="{{ old('date_rdv') }}" 
                           min="2024-07-07" required 
                           x-on:change="loadTimeSlots($event.target.value)"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('date_rdv') border-red-300 @enderror">
                    @error('date_rdv')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="time_slot_id" class="block text-sm font-medium text-gray-700">
                        Créneau horaire <span class="text-red-500">*</span>
                    </label>
                    <select name="time_slot_id" id="time_slot_id" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('time_slot_id') border-red-300 @enderror">
                        <option value="">Sélectionnez d'abord une date</option>
                    </select>
                    @error('time_slot_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div x-show="noSlotsAvailable" class="mt-4 p-3 bg-yellow-100 border border-yellow-300 rounded-md">
                <p class="text-sm text-yellow-800">
                    Aucun créneau disponible pour cette date. Veuillez choisir une autre date.
                </p>
            </div>
        </div>

        <!-- Boutons -->
        <div class="flex justify-end space-x-4">
            <x-button type="button" variant="secondary" onclick="document.querySelector('form').reset()">
                Réinitialiser
            </x-button>
            
            <x-button type="submit" variant="primary">
                Créer le rendez-vous
            </x-button>
        </div>
    </form>
</x-card>

@push('scripts')
<script>
function appointmentForm() {
    return {
        noSlotsAvailable: false,
        
        async loadTimeSlots(date) {
            if (!date) return;
            
            try {
                const response = await fetch(`/api/timeslots/for-date?date=${date}`);
                const timeSlots = await response.json();
                const select = document.getElementById('time_slot_id');
                select.innerHTML = '';
                
                if (timeSlots.length === 0) {
                    select.innerHTML = '<option value="">Aucun créneau disponible</option>';
                    this.noSlotsAvailable = true;
                } else {
                    this.noSlotsAvailable = false;
                    select.innerHTML = '<option value="">Sélectionnez un créneau</option>';
                    
                    timeSlots.forEach(slot => {
                        if (slot.is_available) {
                            const option = document.createElement('option');
                            option.value = slot.id;
                            // option.textContent = `${slot.formatted_time} (${slot.remaining_capacity} places disponibles)`;
                            option.textContent = `(${slot.remaining_capacity} places disponibles)`;
                            select.appendChild(option);
                        }
                    });
                }
            } catch (error) {
                console.error('Erreur lors du chargement des créneaux:', error);
                this.noSlotsAvailable = true;
            }
        }
    }
}
</script>
@endpush
@endsection