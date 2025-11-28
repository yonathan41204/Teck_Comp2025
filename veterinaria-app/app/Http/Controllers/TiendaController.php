<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class TiendaController extends Controller
{
    // Mostrar página de tienda
    public function index()
    {
        $productos = Producto::where('inventario', '>', 0)->get();
        return view('tienda', compact('productos'));
    }
}
