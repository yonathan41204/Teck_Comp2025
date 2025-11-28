<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicio';
    protected $primaryKey = 'id_servicio';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'id_empleado'
    ];

    // Relación con Empleado (si existe el modelo)
    public function empleado()
    {
        return $this->belongsTo(User::class, 'id_empleado', 'id');
    }
}
