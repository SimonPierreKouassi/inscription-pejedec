<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

/**
 * Contrôleur pour la page d'accueil
 */
class HomeController extends Controller
{
    /**
     * Afficher la page d'accueil
     */
    public function index()
    {
        return view('pages.home');
    }
}