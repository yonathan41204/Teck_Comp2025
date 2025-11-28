<?php

namespace App\Http\Controllers;

use App\Models\RegistroMascota;
use App\Models\HistorialMedico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpedienteController extends Controller
{
    // Mostrar formulario de expediente
    public function mostrar()
    {
        // Obtener todas las mascotas del usuario autenticado con su historial médico
        $mascotas = RegistroMascota::where('id_usuario', Auth::id())
            ->with('historialMedico')
            ->get();
        
        return view('expediente', compact('mascotas'));
    }

    // Guardar expediente
    public function guardar(Request $request)
    {
        // Validar que el usuario esté autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para crear un expediente.');
        }

        // Validar datos
        $request->validate([
            'nombre_mascota' => 'required|string|max:255',
            'especie' => 'required|string|max:50',
            'raza' => 'nullable|string|max:50',
            'edad' => 'nullable|integer'
        ]);

        // Crear registro de mascota
        $registroMascota = RegistroMascota::create([
            'id_usuario' => Auth::id(),
            'nombre_mascota' => $request->nombre_mascota,
            'especie' => $request->especie,
            'raza' => $request->raza,
            'edad' => $request->edad
        ]);

        // Preparar las vacunas seleccionadas
        $vacunas = [];
        if ($request->has('vac_rabia')) {
            $vacunas[] = 'Rabia';
        }
        if ($request->has('vac_parvovirus')) {
            $vacunas[] = 'Parvovirus';
        }
        if ($request->has('vac_triple')) {
            $vacunas[] = 'Triple';
        }
        if ($request->vac_otras) {
            $vacunas[] = $request->vac_otras;
        }
        $vacunasTexto = implode(', ', $vacunas);

        // Crear historial médico
        HistorialMedico::create([
            'id_registro' => $registroMascota->id_registro,
            'alergias' => $request->alergias == 'si' ? ($request->detalle_alergias ?? 'Sí') : 'No',
            'condiciones_cronicas' => $request->condiciones_cronicas,
            'vacunas' => $vacunasTexto,
            'notas' => $request->notas_adicionales
        ]);

        return redirect()->route('expediente')->with('success', 'Expediente guardado correctamente.');
    }
}
