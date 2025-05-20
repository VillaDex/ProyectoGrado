<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $users = User::with('roles')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%'.$search.'%');
            })
            ->get(); // Mantenemos get() como en tu versión original

        $roles = Role::all();
        
        return view('roles.index', compact('users', 'roles'));
    }
    
    public function assignRole(Request $request, User $user)
    {
        $user->roles()->sync($request->roles);
        return redirect()->back()->with('success', 'Roles asignados correctamente.');
    }
}