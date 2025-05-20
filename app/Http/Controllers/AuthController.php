<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Método para mostrar el formulario de registro
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'terms' => 'required|accepted',
        'data-processing' => 'required|accepted'
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    try {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $role = Role::where('name', 'usuario-normal')->first();
        if ($role) {
            $user->roles()->attach($role->id);
        }

        // Redirección corregida (usa la misma ruta que tu formulario)
        return redirect('/')->with('success', 'Registro exitoso. Por favor inicia sesión.');

    } catch (\Exception $e) {
        return back()->with('error', 'Error al registrar: ' . $e->getMessage());
    }
}

    // Método para mostrar el formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Método para procesar el login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'Ingresa un correo electrónico válido',
            'password.required' => 'La contraseña es obligatoria'
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended('welcome');
        }

        return back()
            ->withErrors([
                'email' => 'Las credenciales no coinciden con nuestros registros.',
            ])
            ->onlyInput('email');
    }

    // Método para cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}