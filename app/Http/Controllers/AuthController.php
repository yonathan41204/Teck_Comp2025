<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Mostrar formulario de login
    public function showLogin() {
        return view('login'); // Asegúrate que tu vista se llame login.blade.php
    }

    // Procesar Registro
    public function register(Request $request) {
        // 1. Validamos el apellido también
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'nullable|string|max:255', // Lo puse opcional, cámbialo a 'required' si es obligatorio
            'email' => 'required|email|unique:Usuario,email',
            'telefono' => 'required',
            'password' => 'required|min:6',
        ]);

        // 2. Creamos el usuario incluyendo el apellido
        User::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido, // <--- Agregado aquí
            'email' => $request->email,
            'telefono' => $request->telefono,
            'contrasena' => Hash::make($request->password),
            'tipo_rol' => 'cliente' // Esto asegura que sea CLIENTE por defecto
        ]);

        // Intentar login inmediato tras registro
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->route('home'); // Redirige al inicio (asegúrate de tener esta ruta)
        }

        return redirect()->route('login');
    }

    // Procesar Login
    public function login(Request $request) {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Redirige al home en lugar de welcome para ver que ya entraste
            return redirect()->route('home'); 
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas']);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}