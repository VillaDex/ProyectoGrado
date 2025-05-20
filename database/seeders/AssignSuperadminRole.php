<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role; // Importa el modelo Role
use App\Models\User; // Importa el modelo User

class AssignSuperadminRole extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Crea el rol de superadmin
        $superadminRole = Role::create(['name' => 'superadmin']);

        // Asigna el rol de superadmin al usuario con ID 1
        $user = User::find(1);
        if ($user) {
            $user->roles()->attach($superadminRole->id);
            $this->command->info('Rol de superadmin asignado al usuario con ID 1.');
        } else {
            $this->command->error('No se encontró el usuario con ID 1.');
        }
    }
}