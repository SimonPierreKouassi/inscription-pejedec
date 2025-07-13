<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Rendez-vous - {{ $appointment->nom }} {{ $appointment->prenom }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif; /* Recommended for PDF to support wide range of characters */
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
            font-size: 10pt;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            border: 1px solid #eee;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            background-color: #fff;
        }
        h1, h2 {
            color: #0056b3;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .section-title {
            background-color: #f8f8f8;
            padding: 8px 15px;
            margin-top: 25px;
            margin-bottom: 15px;
            border-left: 5px solid #0056b3;
            font-weight: bold;
        }
        .detail-row {
            display: flex; /* Flexbox is tricky in some PDF libraries, but simple ones often work */
            margin-bottom: 8px;
            page-break-inside: avoid; /* Keep rows together */
        }
        .detail-row strong {
            width: 150px; /* Fixed width for labels */
            min-width: 150px;
            display: inline-block;
            color: #555;
        }
        .detail-row span {
            flex-grow: 1;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.9em;
            font-weight: bold;
            color: #fff;
            text-align: center;
        }
        .status-confirmed { background-color: #28a745; } /* Green */
        .status-pending { background-color: #ffc107; } /* Yellow */
        .status-cancelled { background-color: #dc3545; } /* Red */
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 0.8em;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Détails du Rendez-vous</h1>
        <p style="text-align: right; font-size: 0.9em; color: #666;">
            Généré le: {{ now()->format('d/m/Y H:i:s') }}
        </p>

        <div class="section-title">Informations sur le Rendez-vous</div>
        <div class="detail-row">
            <strong>Date du RDV:</strong> <span>{{ $appointment->date_rdv->format('d/m/Y') }}</span>
        </div>
        <div class="detail-row">
            <strong>Créneau Horaire:</strong> <span>{{ $appointment->creneau_horaire }}</span>
        </div>
        <div class="detail-row">
            <strong>Statut:</strong>
            <span>
                <span class="status-badge status-{{ strtolower($appointment->status) }}">
                    {{ $appointment->status_label }}
                </span>
            </span>
        </div>
        @if ($appointment->notes)
        <div class="detail-row">
            <strong>Notes:</strong> <span>{{ $appointment->notes }}</span>
        </div>
        @endif
        <div class="detail-row">
            <strong>Prise en charge:</strong> <span>{{ $appointment->prise_en_charge == 'yop' ? 'Lycée professionnel de Yopougon' : ( $appointment->prise_en_charge == 'zone_4c' ? 'Siège Marcory zone 4C' : 'Bouaké')}}</span>
        </div>
        <div class="detail-row">
            <strong>Date de création:</strong> <span>{{ $appointment->created_at->format('d/m/Y H:i') }}</span>
        </div>

        <div class="section-title">Informations Personnelles</div>
        <div class="detail-row">
            <strong>Nom & Prénom:</strong> <span>{{ $appointment->nom }} {{ $appointment->prenom }}</span>
        </div>
        <div class="detail-row">
            <strong>Civilité & Sexe:</strong> <span>{{ $appointment->civilite }} / {{ $appointment->sexe }}</span>
        </div>
        <div class="detail-row">
            <strong>Date & Lieu de Naissance:</strong> <span>{{ $appointment->date_naissance->format('d/m/Y') }} à {{ $appointment->lieu_naissance }}</span>
        </div>
        <div class="detail-row">
            <strong>Nationalité:</strong> <span>{{ $appointment->nationalite }}</span>
        </div>
        <div class="detail-row">
            <strong>Situation matrimoniale:</strong> <span>{{ $appointment->situation_matrimoniale }}</span>
        </div>
        <div class="detail-row">
            <strong>Nombre d'enfants:</strong> <span>{{ $appointment->nombre_enfants }}</span>
        </div>
        <div class="detail-row">
            <strong>Chez qui:</strong> <span>{{ $appointment->chez_qui }}</span>
        </div>
        <div class="detail-row">
            <strong>Type & Numéro de pièce:</strong> <span>{{ $appointment->type_piece }} - {{ $appointment->numero_piece }}</span>
        </div>
        <div class="detail-row">
            <strong>Numéro CMU:</strong> <span>{{ $appointment->numero_cmu ?: 'N/A' }}</span>
        </div>

        <div class="section-title">Coordonnées</div>
        <div class="detail-row">
            <strong>Téléphone:</strong> <span>{{ $appointment->numero_phone }}</span>
        </div>
        <div class="detail-row">
            <strong>Email:</strong> <span>{{ $appointment->adresse_email ?: 'N/A' }}</span>
        </div>

        <div class="section-title">Informations Professionnelles / Académiques</div>
        <div class="detail-row">
            <strong>Occupation actuelle:</strong> <span>{{ $appointment->occupation_actuelle }}</span>
        </div>
        <div class="detail-row">
            <strong>Niveau actuel:</strong> <span>{{ $appointment->niveau_actuel }}</span>
        </div>
        <div class="detail-row">
            <strong>Pointure:</strong> <span>{{ $appointment->pointure }}</span>
        </div>
        <div class="detail-row">
            <strong>Taille vêtement:</strong> <span>{{ $appointment->taille_vetement }}</span>
        </div>
        <div class="detail-row">
            <strong>1er choix formation:</strong> <span>{{ $appointment->premier_choix_formation }}</span>
        </div>
        @if ($appointment->deuxieme_choix_formation)
        <div class="detail-row">
            <strong>2ème choix formation:</strong> <span>{{ $appointment->deuxieme_choix_formation }}</span>
        </div>
        @endif
        @if ($appointment->troisieme_choix_formation)
        <div class="detail-row">
            <strong>3ème choix formation:</strong> <span>{{ $appointment->troisieme_choix_formation }}</span>
        </div>
        @endif

        <div class="section-title">Personne à Contacter en Cas d'Urgence</div>
        <div class="detail-row">
            <strong>Nom & Prénom:</strong> <span>{{ $appointment->nom_personne_contact }} {{ $appointment->prenom_personne_contact }}</span>
        </div>
        <div class="detail-row">
            <strong>Lien de Parenté:</strong> <span>{{ $appointment->lien_parente }}</span>
        </div>
        <div class="detail-row">
            <strong>Téléphone:</strong> <span>{{ $appointment->numero_personne_contact }}</span>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Votre Organisation. Tous droits réservés.</p>
            <p>Ce document est généré automatiquement et ne nécessite pas de signature.</p>
        </div>
    </div>
</body>
</html>