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
            $table->string('autorizacion')->nullable()->change();
            $table->float('retencion_islr')->nullable()->change();
            $table->float('comision_bancaria')->nullable()->change();
            $table->integer('factura')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orden_de_pago_electronicos', function (Blueprint $table) {
            //$table->string('numero_personas')
        });
    }
};