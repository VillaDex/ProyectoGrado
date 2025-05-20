<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        \App\Models\Role::where('name', 'usuario-normal')
                        ->update(['name' => 'funcionario-normal']);
    }
    
    public function down() {
        \App\Models\Role::where('name', 'funcionario-normal')
                        ->update(['name' => 'usuario-normal']);
    }
};
