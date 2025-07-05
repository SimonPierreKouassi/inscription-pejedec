<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Appointment;

/**
 * Contrôleur web pour les exports
 */
class ExportWebController extends Controller
{
    /**
     * Afficher la page d'exports
     */
    public function index()
    {
        $appointments = Appointment::with('timeSlot')
                                 ->orderBy('date_rdv', 'desc')
                                 ->get();

        return view('exports.index', compact('appointments'));
    }
}