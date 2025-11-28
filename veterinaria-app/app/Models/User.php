<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // CONFIGURACIÓN PARA TU BASE DE DATOS PERSONALIZADA
    protected $table = 'usuario';         // Nombre de tu tabla en SQL
    protected $primaryKey = 'id_usuario'; // Tu ID personalizado
    public $timestamps = false;            // Desactivar columnas created_at/updated_at

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'telefono',
        'contrasena',
        'tipo_rol',
    ];

    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

    // Indicarle a Laravel que la contraseña está en la columna 'contrasena'
    public function getAuthPassword()
    {
        return $this->contrasena;
    }
}