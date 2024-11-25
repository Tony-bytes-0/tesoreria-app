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
        Schema::dropIfExists('proceso_orden_de_pagos');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('proceso_orden_de_pago', function (Blueprint $table) {
            $table->id();
            $table->foreignId('numero_orden_de_pago')
            ->constrained('orden_de_pago_electronicos');
            $table->string('concepto')->nullable();
            $table->float('total')->nullable();
            $table->timestamps();
        });
    }
};
