<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orden_de_pago_electronicos', function (Blueprint $table) {
            $table->foreignId('id_proceso')
                ->constrained('proceso_orden_de_pagos');
            $table->bigInteger('numero_orden_de_pago')->nullable()->change();            
        });
    }

    public function down(): void
    {
        Schema::table('orden_de_pago_electronicos', function (Blueprint $table) {
            $table->dropColumn('id_proceso');
        });
    }
};
