<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductoController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $estado = $request->input('estado');

        $productosQuery = Producto::query();

        if ($search) {
            $productosQuery->where('nombre', 'LIKE', "%{$search}%");
        }

        if ($estado) {
            $productosQuery->where('estado', $estado);
        }

        $productos = $productosQuery->get();

        return view('productos.index', compact('productos'));
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.edit', compact('producto'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        Log::info('Datos recibidos:', $request->all());

        $producto = Producto::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'imagen' => 'nullable|url',
        ]);

        $producto->nombre = $request->input('nombre');
        $producto->imagen = $request->input('imagen');

        Log::info('Datos a guardar:', $producto->toArray());

        $producto->save();

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }
    public function destroy($id)
    {
        // Encontrar el producto por su ID
        $producto = Producto::findOrFail($id);
    
        // Eliminar el producto
        $producto->delete();
    
        // Redirigir con un mensaje de éxito
        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
    
}
