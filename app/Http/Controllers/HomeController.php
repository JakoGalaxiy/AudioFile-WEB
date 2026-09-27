<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cancion; // Esta es la línea que le dice a Laravel dónde encontrar el modelo

class HomeController extends Controller
{
    public function index()
    {
        // Variable en plural y minúscula
        $canciones = Cancion::all();

        // El texto dentro de compact coincide exactamente con la variable $canciones
        return view('home', compact('canciones'));
    }
}