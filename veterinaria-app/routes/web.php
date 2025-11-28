<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\ServicioController;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/services', [ServicioController::class, 'index'])->name('services');

Route::get('/tienda', function () {
    return view('tienda');
})->name('tienda');

// Rutas de Expediente
Route::get('/expediente', [ExpedienteController::class, 'mostrar'])->name('expediente')->middleware('auth');
Route::post('/expediente', [ExpedienteController::class, 'guardar'])->name('expediente.guardar')->middleware('auth');

// Rutas de Login y Registro
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('procesar.login');
Route::post('/registro', [AuthController::class, 'register'])->name('procesar.registro');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
