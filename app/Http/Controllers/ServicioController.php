<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    // Mostrar página de servicios
    public function index()
    {
        $servicios = Servicio::all();
        return view('services', compact('servicios'));
    }
}
