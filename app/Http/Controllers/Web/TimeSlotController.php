<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\TimeSlot;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * Contrôleur administrateur pour la gestion des créneaux horaires
 */
class TimeSlotController extends Controller
{
    /**
     * Afficher la page de gestion des créneaux
     */
    public function index()
    {
        return view('admin.timeslots.index');
    }
}