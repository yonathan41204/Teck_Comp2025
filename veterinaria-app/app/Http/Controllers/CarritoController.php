<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarritoCompras;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    // Agregar producto al carrito
    public function agregar(Request $request)
    {
        $request->validate([
            'id_producto' => 'required|exists:producto,id_producto',
            'cantidad' => 'required|integer|min:1'
        ]);

        $producto = Producto::find($request->id_producto);

        if ($producto->inventario < $request->cantidad) {
            return response()->json([
                'success' => false,
                'message' => 'No hay suficiente inventario disponible'
            ], 400);
        }

        $itemCarrito = CarritoCompras::where('id_usuario', Auth::user()->id_usuario)
            ->where('id_producto', $request->id_producto)
            ->first();

        if ($itemCarrito) {
            $itemCarrito->cantidad += $request->cantidad;
            $itemCarrito->save();
        } else {
            CarritoCompras::create([
                'id_usuario' => Auth::user()->id_usuario,
                'id_producto' => $request->id_producto,
                'cantidad' => $request->cantidad
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Producto agregado al carrito',
            'total_items' => $this->getTotalItems()
        ]);
    }

    // Ver carrito
    public function ver()
    {
        $items = CarritoCompras::where('id_usuario', Auth::user()->id_usuario)
            ->with('producto')
            ->get();

        $total = 0;
        foreach ($items as $item) {
            $total += $item->producto->precio * $item->cantidad;
        }

        return view('carrito', compact('items', 'total'));
    }

    // Actualizar cantidad
    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1'
        ]);

        $item = CarritoCompras::where('id_carrito', $id)
            ->where('id_usuario', Auth::user()->id_usuario)
            ->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado en el carrito'
            ], 404);
        }

        if ($item->producto->inventario < $request->cantidad) {
            return response()->json([
                'success' => false,
                'message' => 'No hay suficiente inventario disponible'
            ], 400);
        }

        $item->cantidad = $request->cantidad;
        $item->save();

        return response()->json([
            'success' => true,
            'message' => 'Cantidad actualizada',
            'subtotal' => $item->producto->precio * $item->cantidad
        ]);
    }

    // Eliminar producto del carrito
    public function eliminar($id)
    {
        $item = CarritoCompras::where('id_carrito', $id)
            ->where('id_usuario', Auth::user()->id_usuario)
            ->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado en el carrito'
            ], 404);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado del carrito',
            'total_items' => $this->getTotalItems()
        ]);
    }

    // Vaciar carrito
    public function vaciar()
    {
        CarritoCompras::where('id_usuario', Auth::user()->id_usuario)->delete();

        return redirect()->route('carrito.ver')->with('success', 'Carrito vaciado');
    }

    // Procesar pago
    public function procesarPago(Request $request)
    {
        $request->validate([
            'metodo_pago' => 'required|in:efectivo,tarjeta,transferencia'
        ]);

        $items = CarritoCompras::where('id_usuario', Auth::user()->id_usuario)
            ->with('producto')
            ->get();

        if ($items->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'El carrito está vacío'
            ], 400);
        }

        $total = 0;
        foreach ($items as $item) {
            // Verificar inventario
            if ($item->producto->inventario < $item->cantidad) {
                return response()->json([
                    'success' => false,
                    'message' => "No hay suficiente inventario para {$item->producto->nombre}"
                ], 400);
            }
            $total += $item->producto->precio * $item->cantidad;
        }

        // Reducir inventario
        foreach ($items as $item) {
            $producto = Producto::find($item->id_producto);
            $producto->inventario -= $item->cantidad;
            $producto->save();
        }

        // Vaciar carrito
        CarritoCompras::where('id_usuario', Auth::user()->id_usuario)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Compra realizada exitosamente',
            'total' => $total
        ]);
    }

    // Obtener total de items
    private function getTotalItems()
    {
        return CarritoCompras::where('id_usuario', Auth::user()->id_usuario)->sum('cantidad');
    }

    // API para obtener total de items (para el badge)
    public function totalItems()
    {
        return response()->json([
            'total' => $this->getTotalItems()
        ]);
    }
}
