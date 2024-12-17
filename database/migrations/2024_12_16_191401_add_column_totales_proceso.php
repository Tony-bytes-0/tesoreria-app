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
        Schema::table( 'proceso_orden_de_pagos', function (Blueprint $table) {
            $table->dropColumn('total');
            $table->float('monto_total')->nullable();
            $table->float('retencion_islr')->nullable();
            $table->float('transferencia')->nullable();
            $table->float('comision_bancaria')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proceso_orden_de_pagos', function (Blueprint $table) {
            $table->dropColumn('monto_total');
            $table->dropColumn('retencion_islr');
            $table->dropColumn('transferencia');
            $table->dropColumn('comision_bancaria');
        });
    }
};
