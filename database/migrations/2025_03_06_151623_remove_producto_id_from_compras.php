<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
        Schema::table('compras', function (Blueprint $table) {
            // Solo agregar la columna si no existe
            if (!Schema::hasColumn('compras', 'producto_id')) {
                $table->foreignId('producto_id')->constrained()->onDelete('cascade');
            }
        });
    }

    public function down() {
        Schema::table('compras', function (Blueprint $table) {
            // Solo eliminar la clave foránea si existe
            if (Schema::hasColumn('compras', 'producto_id')) {
                // Eliminar la clave foránea solo si existe
                try {
                    $table->dropForeign(['producto_id']);
                } catch (\Exception $e) {
                    // Si la clave foránea no existe, ignorar el error
                }
                $table->dropColumn('producto_id');
            }
        });
    }
};
