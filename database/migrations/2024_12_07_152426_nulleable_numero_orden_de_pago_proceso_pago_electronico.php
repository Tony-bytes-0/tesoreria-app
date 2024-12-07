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
            $table->dropColumn('numero_orden_de_pago');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proceso_orden_de_pagos', function (Blueprint $table) {
            $table->string('numero_orden_de_pago');
        });
    }
};
