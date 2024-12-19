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
        Schema::table('proceso_orden_de_pagos', function (Blueprint $table) {
            $table->float('tasa')->nullable();
            $table->date('fecha')->nullable();
            $table->string('tipo')->nullable();
        });
        Schema::table('orden_de_pago_electronicos', function (Blueprint $table) {
            $table->dropColumn('tasa');
            $table->dropColumn('fecha');
            $table->dropColumn('tipo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proceso_orden_de_pagos', function (Blueprint $table) {
            $table->dropColumn('tasa');
            $table->dropColumn('fecha');
            $table->dropColumn('tipo');
        });
        Schema::table('orden_de_pago_electronicos', function (Blueprint $table) {
            $table->float('tasa')->nullable();
            $table->date('fecha')->nullable();
            $table->string('tipo')->nullable();
        });
    }
};
