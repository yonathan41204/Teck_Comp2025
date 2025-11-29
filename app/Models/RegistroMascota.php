<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroMascota extends Model
{
    protected $table = 'registromascota';
    protected $primaryKey = 'id_registro';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'nombre_mascota',
        'especie',
        'raza',
        'edad'
    ];

    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }

    // Relación con HistorialMedico
    public function historialMedico()
    {
        return $this->hasOne(HistorialMedico::class, 'id_registro', 'id_registro');
    }
}
