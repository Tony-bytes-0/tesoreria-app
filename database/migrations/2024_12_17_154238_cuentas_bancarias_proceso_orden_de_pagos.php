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
            $table->foreignId('cuenta_bancaria_id')->nullable();
            $table->foreign('cuenta_bancaria_id')->references('id')->on('cuentas_bancarias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proceso_orden_de_pagos', function (Blueprint $table) {
            $table->dropForeign(['cuenta_bancaria_id']);
            $table->dropColumn('cuenta_bancaria_id');
        });
    }
};
