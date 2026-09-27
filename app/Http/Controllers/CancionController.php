<?php

namespace App\Http\Controllers;

use App\Models\Cancion;
use Illuminate\Http\Request;

class CancionController extends Controller
{
    public function index()
    {
        $Canciones = Cancion::all();

        return view('home', compact('Canciones'));
    }
}