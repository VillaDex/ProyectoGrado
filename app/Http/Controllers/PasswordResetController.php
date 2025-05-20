<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    /**
     * Muestra el formulario de verificación de correo electrónico y nombre.
     *
     * @return \Illuminate\View\View
     */
    public function showVerifyForm()
    {
        return view('auth.passwords.verify');
    }

    /**
     * Verifica el correo electrónico y el nombre del usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function verify(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'name' => 'required',
    ]);

    $user = User::where('email', $request->email)
                ->where('name', $request->name)
                ->first();

    if ($user) {
        // Si el usuario existe, mostrar el formulario de restablecimiento de contraseña
        return view('auth.passwords.reset', compact('user'));
    }

    // Si el usuario no existe, redirigir con un mensaje de error
    return back()->withErrors(['verify' => 'Los datos ingresados no coinciden.'])->withInput();
}


    /**
     * Maneja la solicitud de restablecimiento de contraseña.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::find($request->user_id);
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('status', 'Contraseña actualizada con éxito.');
    }
}
