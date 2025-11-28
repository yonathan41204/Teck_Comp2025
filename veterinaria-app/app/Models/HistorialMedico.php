<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialMedico extends Model
{
    protected $table = 'historialmedico';
    protected $primaryKey = 'id_historial';
    public $timestamps = false;

    protected $fillable = [
        'id_registro',
        'alergias',
        'condiciones_cronicas',
        'vacunas',
        'notas'
    ];

    // Relación con RegistroMascota
    public function registroMascota()
    {
        return $this->belongsTo(RegistroMascota::class, 'id_registro', 'id_registro');
    }
}
