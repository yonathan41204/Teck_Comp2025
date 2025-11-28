<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitaController extends Controller
{
    // Mostrar formulario de agendamiento
    public function mostrarFormulario($id_servicio)
    {
        $servicio = Servicio::findOrFail($id_servicio);
        return view('agendar-cita', compact('servicio'));
    }

    // Guardar la cita
    public function guardar(Request $request)
    {
        // Validar que el usuario esté autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para agendar una cita.');
        }

        // Validar datos
        $request->validate([
            'id_servicio' => 'required|exists:servicio,id_servicio',
            'fecha_cita' => 'required|date|after:now',
            'metodo_pago' => 'required|in:efectivo,tarjeta,transferencia'
        ]);

        // Crear la cita
        $cita = Cita::create([
            'id_usuario' => Auth::id(),
            'id_servicio' => $request->id_servicio,
            'fecha_cita' => $request->fecha_cita,
            'recordatorio_enviado' => 0
        ]);

        // Obtener el servicio para el monto
        $servicio = Servicio::find($request->id_servicio);

        // Crear el pago
        \App\Models\Pago::create([
            'id_cita' => $cita->id_cita,
            'id_carrito' => null,
            'monto' => $servicio->precio,
            'metodo_pago' => $request->metodo_pago,
            'fecha_pago' => now(),
            'estado' => 'completado'
        ]);

        return redirect()->route('mis-citas')->with('success', 'Cita agendada y pago completado exitosamente.');
    }

    // Ver mis citas
    public function misCitas()
    {
        $citas = Cita::where('id_usuario', Auth::id())
            ->with(['servicio', 'pago'])
            ->orderBy('fecha_cita', 'desc')
            ->get();
        
        return view('mis-citas', compact('citas'));
    }
}
