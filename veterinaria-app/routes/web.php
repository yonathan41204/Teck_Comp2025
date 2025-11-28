<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\CarritoController;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/services', [ServicioController::class, 'index'])->name('services');

Route::get('/tienda', [TiendaController::class, 'index'])->name('tienda');

// Rutas de Expediente
Route::get('/expediente', [ExpedienteController::class, 'mostrar'])->name('expediente')->middleware('auth');
Route::post('/expediente', [ExpedienteController::class, 'guardar'])->name('expediente.guardar')->middleware('auth');

// Rutas de Citas
Route::get('/agendar-cita/{id_servicio}', [CitaController::class, 'mostrarFormulario'])->name('agendar.cita')->middleware('auth');
Route::post('/agendar-cita', [CitaController::class, 'guardar'])->name('cita.guardar')->middleware('auth');
Route::get('/mis-citas', [CitaController::class, 'misCitas'])->name('mis-citas')->middleware('auth');

// Carrito de compras
Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar')->middleware('auth');
Route::get('/carrito', [CarritoController::class, 'ver'])->name('carrito.ver')->middleware('auth');
Route::put('/carrito/{id}/actualizar', [CarritoController::class, 'actualizar'])->name('carrito.actualizar')->middleware('auth');
Route::delete('/carrito/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar')->middleware('auth');
Route::delete('/carrito', [CarritoController::class, 'vaciar'])->name('carrito.vaciar')->middleware('auth');
Route::post('/carrito/pagar', [CarritoController::class, 'procesarPago'])->name('carrito.pagar')->middleware('auth');
Route::get('/carrito/total', [CarritoController::class, 'totalItems'])->name('carrito.total')->middleware('auth');

// Rutas de Login y Registro
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('procesar.login');
Route::post('/registro', [AuthController::class, 'register'])->name('procesar.registro');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
