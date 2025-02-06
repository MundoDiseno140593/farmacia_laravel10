<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->unsignedBigInteger('sexo_id')->nullable();

            // Definir la clave foránea que relaciona la tabla sexos con clientes
            $table->foreign('sexo_id')->references('id')->on('sexos')->onDelete('set null');
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
           // Eliminar la clave foránea y la columna sexo_id
        $table->dropForeign(['sexo_id']);
        $table->dropColumn('sexo_id');
        });
    }
};
