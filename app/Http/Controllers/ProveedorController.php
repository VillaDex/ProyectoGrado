<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::all();
        return view('proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        return view('proveedores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email|unique:proveedores,email',
            'telefono' => 'required',
        ]);

        Proveedor::create($request->all());
        return redirect()->route('proveedores.index')->with('success', 'Proveedor creado exitosamente.');
    }

    public function edit($id) // Cambiado para recibir el ID directamente
    {
        $proveedor = Proveedor::findOrFail($id); // Busca el proveedor por ID
        return view('proveedores.edit', compact('proveedor'));
    }

    public function update(Request $request, $id) // Cambiado para recibir el ID directamente
    {
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email|unique:proveedores,email,' . $id,
            'telefono' => 'required',
        ]);

        $proveedor = Proveedor::findOrFail($id); // Busca el proveedor por ID
        $proveedor->update($request->all());
        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado exitosamente.');
    }

    public function destroy($id) // Cambiado para recibir el ID directamente
    {
        $proveedor = Proveedor::findOrFail($id); // Busca el proveedor por ID
        $proveedor->delete();
        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado exitosamente.');
    }
}
