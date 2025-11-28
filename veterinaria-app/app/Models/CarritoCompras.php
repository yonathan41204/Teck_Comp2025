<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarritoCompras extends Model
{
    protected $table = 'carritocompras';
    protected $primaryKey = 'id_carrito';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_producto',
        'cantidad'
    ];

    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    // Relación con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }
}
