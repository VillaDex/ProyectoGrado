<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    // Mostrar lista de compras
    public function index()
    {
        $compras = Compra::with(['proveedor', 'producto'])->latest()->get();
        return view('compras.index', compact('compras'));
    }

    // Mostrar formulario para crear una compra
    public function create()
    {
        $proveedores = Proveedor::orderBy('nombre')->get();
        $productos = Producto::orderBy('nombre')->get();
        return view('compras.create', compact('proveedores', 'productos'));
    }

    // Guardar una nueva compra
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'tipo_compra' => 'required|in:existente,nuevo',
            'proveedor_id' => 'required|exists:proveedores,id',
            'producto_id' => 'required_if:tipo_compra,existente|nullable|exists:productos,id',
            'nombre_producto' => 'required_if:tipo_compra,nuevo|nullable|string|max:255',
            'precio_producto' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:1',
            'precio_total' => 'required|numeric|min:0',
            'fecha_compra' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            // Manejar producto existente o nuevo
            if ($request->tipo_compra === 'existente') {
                $producto = Producto::findOrFail($request->producto_id);
                $producto->increment('stock', $request->cantidad);
            } else {
                $producto = Producto::create([
                    'nombre' => $request->nombre_producto,
                    'precio' => $request->precio_producto,
                    'stock' => $request->cantidad,
                    'estado' => 'disponible',
                    'url_imagen' => 'placeholder.jpg',
                ]);
            }

            // Crear el registro de compra
            Compra::create([
                'proveedor_id' => $request->proveedor_id,
                'producto_id' => $producto->id,
                'cantidad' => $request->cantidad,
                'precio_unitario' => $request->precio_producto, // Campo añadido
                'precio' => $request->precio_total,
                'fecha_compra' => $request->fecha_compra,
            ]);

            DB::commit();
            return redirect()->route('compras.index')
                            ->with('success', 'Compra registrada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                            ->with('error', 'Error al registrar la compra: '.$e->getMessage())
                            ->withInput();
        }
    }

    // Mostrar formulario para editar una compra
    public function edit(Compra $compra)
    {
        $proveedores = Proveedor::orderBy('nombre')->get();
        $productos = Producto::orderBy('nombre')->get();
        return view('compras.edit', compact('compra', 'proveedores', 'productos'));
    }

    // Actualizar una compra existente
    public function update(Request $request, Compra $compra)
    {
        $validatedData = $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'precio_unitario' => 'required|numeric|min:0',
            'precio' => 'required|numeric|min:0',
            'fecha_compra' => 'required|date',
        ]);

        try {
            $compra->update($validatedData);
            return redirect()->route('compras.index')
                            ->with('success', 'Compra actualizada correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                            ->with('error', 'Error al actualizar: '.$e->getMessage())
                            ->withInput();
        }
    }

    // Eliminar una compra
    public function destroy(Compra $compra)
    {
        DB::beginTransaction();
        try {
            // Revertir stock si es necesario
            if ($compra->producto) {
                $compra->producto->decrement('stock', $compra->cantidad);
            }
            
            $compra->delete();
            DB::commit();
            
            return redirect()->route('compras.index')
                            ->with('success', 'Compra eliminada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                            ->with('error', 'Error al eliminar: '.$e->getMessage());
        }
    }
}