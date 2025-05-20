<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PerfilController extends Controller
{
    public function index()
    {
        return view('perfil', ['user' => Auth::user()]);
    }

    public function actualizar(Request $request)
    {
        $request->validate([
            'foto' => 'nullable|image|max:2048' // Máximo 2MB
        ]);

        $user = Auth::user();

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::delete('public/' . $user->foto);
            }

            $ruta = $request->file('foto')->store('perfiles', 'public');
            $user->foto = $ruta;
            $user->save();

            return response()->json(['success' => true, 'foto' => asset('storage/' . $ruta)]);
        }

        return response()->json(['success' => false]);
    }
    public function actualizarNombre(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255'
    ]);

    $user = Auth::user();
    $user->name = $request->nombre;
    $user->save();

    return redirect()->route('perfil')->with('success', 'Nombre actualizado correctamente.');
}
public function eliminarFoto()
{
    $user = Auth::user();

    if ($user->foto) {
        Storage::delete('public/' . $user->foto);
        $user->foto = null;
        $user->save();
    }

    return response()->json([
        'success' => true,
        'foto' => asset('https://cdn-icons-png.flaticon.com/512/6326/6326055.png')
    ]);
}

}
