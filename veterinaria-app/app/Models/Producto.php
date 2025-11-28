<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'producto';
    protected $primaryKey = 'id_producto';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'inventario'
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'inventario' => 'integer'
    ];
}
