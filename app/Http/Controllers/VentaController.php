<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    /**
     * Mostrar una lista de ventas.
     */
    public function index(Request $request)
    {
        $cliente = $request->input('cliente');
        $fecha = $request->input('fecha');

        $ventasQuery = Venta::with('cliente', 'producto');

        if ($cliente) {
            $ventasQuery->whereHas('cliente', function ($query) use ($cliente) {
                $query->where('nombre', 'LIKE', "%{$cliente}%");
            });
        }

        if ($fecha) {
            $ventasQuery->whereDate('fecha_hora', $fecha);
        }

        $ventas = $ventasQuery->get();

        return view('ventas.index', compact('ventas'));
    }

    /**
     * Mostrar el formulario para crear una nueva venta.
     */
    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        return view('ventas.create', compact('clientes', 'productos'));
    }

    /**
     * Almacenar una nueva venta en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'precio_unitario' => 'required|numeric|min:0',
            'fecha_hora' => 'required|date',
        ]);
    
        $producto = Producto::findOrFail($request->producto_id);
    
        if ($producto->stock < $request->cantidad) {
            return back()->withErrors(['cantidad' => 'No hay suficiente stock disponible.'])->withInput();
        }
    
        $precioTotal = $request->precio_unitario * $request->cantidad;
        $stockRestante = $producto->stock - $request->cantidad;
    
        // Crear la venta
        $venta = Venta::create([
            'cliente_id' => $request->cliente_id,
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad,
            'precio' => $precioTotal,
            'fecha_hora' => $request->fecha_hora,
        ]);
    
        $producto->stock = $stockRestante;
        $producto->save();
    
        return redirect()->route('ventas.index')
            ->with('success', 'Venta registrada exitosamente.')
            ->with('stock_restante', $stockRestante)
            ->with('producto_nombre', $producto->nombre);
    }

    /**
     * Mostrar el formulario para editar una venta.
     */
    public function edit(Venta $venta)
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        return view('ventas.edit', compact('venta', 'clientes', 'productos'));
    }

    /**
     * Actualizar una venta en la base de datos.
     */
    public function update(Request $request, Venta $venta)
{
    $request->validate([
        'cliente_id' => 'required|exists:clientes,id',
        'producto_id' => 'required|exists:productos,id',
        'cantidad' => 'required|integer|min:1',
        'precio' => 'required|numeric|min:0', // Cambiado de 'precio_unitario' a 'precio'
        'fecha_hora' => 'required|date',
    ]);

    $producto = Producto::findOrFail($venta->producto_id);

    // Restaurar stock anterior antes de actualizar la venta
    $producto->stock += $venta->cantidad;
    $producto->save();

    // Obtener el nuevo producto
    $nuevoProducto = Producto::findOrFail($request->producto_id);

    // Verificar si hay suficiente stock para la actualización
    if ($nuevoProducto->stock < $request->cantidad) {
        return back()->withErrors(['cantidad' => 'No hay suficiente stock disponible para la actualización.'])->withInput();
    }

    // Verificar si el nuevo producto tiene stock bajo (igual a 1)
    $mensajeStock = null;
    if ($nuevoProducto->stock - $request->cantidad === 1) {
        $mensajeStock = "¡Alerta! El producto '{$nuevoProducto->nombre}' tendrá solo 1 unidad en stock después de esta venta.";
    }

    // Ajustar stock
    $nuevoProducto->stock -= $request->cantidad;
    $nuevoProducto->save();

    // Actualizar la venta
    $venta->update([
        'cliente_id' => $request->cliente_id,
        'producto_id' => $request->producto_id,
        'cantidad' => $request->cantidad,
        'precio' => $request->precio, // Corregido el nombre del campo
        'fecha_hora' => $request->fecha_hora,
    ]);

    return redirect()->route('ventas.index')
                     ->with('success', 'Venta actualizada correctamente.')
                     ->with('warning', $mensajeStock);
}

    /**
     * Eliminar una venta de la base de datos.
     */
    public function destroy(Venta $venta)
    {
        $producto = Producto::findOrFail($venta->producto_id);
        $producto->stock += $venta->cantidad; // Restaurar la cantidad al stock
        $producto->save();

        $venta->delete();

        return redirect()->route('ventas.index')->with('success', 'Venta eliminada y stock restaurado correctamente.');
    }
}