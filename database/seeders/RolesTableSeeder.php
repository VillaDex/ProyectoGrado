<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;


class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
       
        Role::create(['name' => 'funcionario-compra']);
        Role::create(['name' => 'funcionario-venta']);
        Role::create(['name' => 'funcionario-normal']);
    }
}
